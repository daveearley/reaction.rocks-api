<?php

namespace App\Service\Handler\Reaction;

use App\DomainObjects\CampaignDomainObject;
use App\DomainObjects\Enums\CampaignTypeEnum;
use App\DomainObjects\ReactionDomainObject;
use App\Http\Actions\BaseAction;
use App\Queue\Jobs\ReactionCreatedJob;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use App\Service\Common\GeoIp\IpToCountryServiceInterface;
use App\Service\Common\Session\SessionIdentifierService;
use donatj\UserAgent\UserAgentParser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @todo rate limiting / 1 req per page ?
 */
class CreateReactionHandler extends BaseAction
{
    private ReactionRepositoryInterface $reactionRepository;
    private CampaignRepositoryInterface $campaignRepository;
    private UserAgentParser $userAgentParser;
    private IpToCountryServiceInterface $ipToCountryService;
    private SessionIdentifierService $sessionIdentifierService;
    private Request $request;

    public function __construct(
        ReactionRepositoryInterface $reactionRepository,
        CampaignRepositoryInterface $campaignRepository,
        UserAgentParser $userAgentParser,
        IpToCountryServiceInterface $ipToCountryService,
        SessionIdentifierService $sessionIdentifierService,
        Request $request
    )
    {
        $this->reactionRepository = $reactionRepository;
        $this->campaignRepository = $campaignRepository;
        $this->userAgentParser = $userAgentParser;
        $this->ipToCountryService = $ipToCountryService;
        $this->sessionIdentifierService = $sessionIdentifierService;
        $this->ipToCountryService->setIpAddress($request->getClientIp());
        $this->request = $request;
    }

    public function execute(int $campaignId, array $reactionData): ReactionDomainObject
    {
        /** @var CampaignDomainObject $campaign */
        $campaign = $this->campaignRepository->findFirst($campaignId);
        $emojis = $campaign->getEmojisArray();
        $emoji = $reactionData[ReactionDomainObject::EMOJI];

        if (!in_array($emoji, $emojis, true)) {
            throw ValidationException::withMessages(
                [ReactionDomainObject::EMOJI => sprintf('%s is not a valid reaction', $emoji)]
            );
        }

        $reactionData[ReactionDomainObject::CLIENT_IP] = $this->request->getClientIp();
        $reactionData[ReactionDomainObject::SCORE] = $this->getScore($emoji, $campaign);
        $reactionData[ReactionDomainObject::CAMPAIGN_ID] = $campaignId;
        $reactionData[ReactionDomainObject::COUNTRY_CODE] = $this->ipToCountryService->getCountryCode();
        $reactionData[ReactionDomainObject::CLIENT_IDENTIFIER] = $this->sessionIdentifierService->getIdentifier();
        $reactionData[ReactionDomainObject::CITY] = $this->ipToCountryService->getCity();
        $reactionData[ReactionDomainObject::REFERER] = $this->getReferer($reactionData);

        $reaction = $this->reactionRepository->create($this->addUserAgentDataToReaction($reactionData));

        // if this is the first reaction update the 'has_reactions` flag on the campaign
        if (!$campaign->getHasReactions()) {
            $campaign->setHasReactions(true);
            $this->campaignRepository->updateFromDomainObject($campaignId, $campaign);
        }

        $this->dispatch(new ReactionCreatedJob($reaction));

        return $reaction;
    }

    private function getScore(string $selectedEmoji, CampaignDomainObject $campaign): int
    {
        $score = array_search($selectedEmoji, $campaign->getEmojisArray(), true);
        if ($campaign->getType() === CampaignTypeEnum::NPS) {
            return $score;
        }

        return ++$score;
    }

    private function getReferer(array $reactionData)
    {
        return $reactionData[ReactionDomainObject::REFERER] ?? $this->request->server->get('referer');
    }

    private function addUserAgentDataToReaction(array $reactionData): array
    {
        try {
            $userAgentInfo = $this->userAgentParser->parse();
            $reactionData[ReactionDomainObject::BROWSER] = $userAgentInfo->browser();
            $reactionData[ReactionDomainObject::BROWSER_VERSION] = $userAgentInfo->browserVersion();
            $reactionData[ReactionDomainObject::PLATFORM] = $userAgentInfo->platform();
        } catch (Exception $exception) {
            // Unable to parse UA data. Should be OK to continue
        }
        return $reactionData;
    }
}