<?php

namespace App\Repository\Interfaces;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

interface ReactionRepositoryInterface extends RepositoryInterface
{
    /**
     * Return a map of 'emoji' => 'number of reaction' for a given date range
     *
     * @param int $campaignId
     * @param Carbon|null $fromDate
     * @param Carbon|null $toDate
     * @return array
     */
    public function getTotalReactionPerEmoji(int $campaignId, Carbon $fromDate = null, Carbon $toDate = null): array;

    /**
     * Return average and number of reaction per day for an interval
     *
     * @param int $campaignId
     * @param CarbonPeriod $period
     * @return array
     */
    public function getAverageAndCountForDateRange(int $campaignId, CarbonPeriod $period): array;

    public function getCountForLastXDaysAndAverageScore(int $campaignId): ?object;
}