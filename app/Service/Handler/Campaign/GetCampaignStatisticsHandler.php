<?php

namespace App\Service\Handler\Campaign;

use App\DomainObjects\CampaignDomainObject;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\ValidationException;

class GetCampaignStatisticsHandler
{
    private const MAXIMUM_DAYS_RANGE = 90;

    private CampaignRepositoryInterface $campaignRepository;

    private ReactionRepositoryInterface $reactionRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository, ReactionRepositoryInterface $reactionRepository)
    {
        $this->campaignRepository = $campaignRepository;
        $this->reactionRepository = $reactionRepository;
    }

    public function execute(int $campaignId, ?string $startDate, ?string $endDate): array
    {
        $period = ($startDate && $endDate) ? new CarbonPeriod($startDate, $endDate) : $this->getDefaultPeriod();
        if ($period->count() > self::MAXIMUM_DAYS_RANGE) {
            throw ValidationException::withMessages(
                ['end_date' => 'maximum date range is 45 days']
            );
        }

        return [
            'date_range' => [
                'start' => $period->getStartDate()->format('d-m-Y'),
                'end' => $period->getEndDate()->format('d-m-Y'),
            ],
            'stats' => $this->getStats($campaignId),
            'daily_counts_and_averages' => $this->reactionRepository->getAverageAndCountForDateRange($campaignId, $period),
            'emoji_counts' => $this->getTotalReactionPerEmoji($campaignId, $period),
        ];
    }

    private function getDefaultPeriod(): CarbonPeriod
    {
        return new CarbonPeriod(Carbon::today()->subDays(30), Carbon::today());
    }

    private function getStats(int $campaignId): array
    {
        $stats = $this->reactionRepository->getCountForLastXDaysAndAverageScore($campaignId);
        return [
            'reactions_last_30_days' => $stats->reactions_last_30_days ?? 0,
            'reactions_last_7_days' => $stats->reactions_last_7_days ?? 0,
            'reactions_last_day' => $stats->reactions_last_day ?? 0,
            'average_score' => $stats->average_score ?? 0,
        ];
    }

    private function getTotalReactionPerEmoji(int $campaignId, CarbonPeriod $period): array
    {
        /** @var CampaignDomainObject $campaign */
        $campaign = $this->campaignRepository->findById($campaignId);
        $emojiCounts = $this->reactionRepository->getTotalReactionPerEmoji($campaignId, $period->getStartDate(), $period->getEndDate());
        $emojis = $campaign->getEmojisArray();

        $response = [];
        foreach ($emojiCounts as $emojiCount) {
            $response[$emojiCount->emoji] = [
                'count' => $emojiCount->count,
                'percentage' => $emojiCount->percentage
            ];
        }

        foreach ($emojis as $emoji) {
            $response[$emoji] = $response[$emoji] ?? [
                    'count' => 0,
                    'percentage' => 0
                ];
        }

        return $response;
    }
}