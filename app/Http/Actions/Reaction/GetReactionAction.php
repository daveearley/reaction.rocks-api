<?php

namespace App\Http\Actions\Reaction;

use App\DomainObjects\CampaignDomainObject;
use App\DomainObjects\ReactionDomainObject;
use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;

class GetReactionAction extends BaseAction
{
    private CampaignRepositoryInterface $campaignRepository;
    private ReactionRepositoryInterface $reactionRepository;

    public function __construct(
        CampaignRepositoryInterface $campaignRepository,
        ReactionRepositoryInterface $reactionRepository
    )
    {
        $this->campaignRepository = $campaignRepository;
        $this->reactionRepository = $reactionRepository;
    }

    public function __invoke(int $campaignId, int $reactionId)
    {
        /** @var CampaignDomainObject $campaign */
        $campaign = $this->campaignRepository->findById($campaignId);

        return $this
            ->getResponseBuilder()
            ->withData($this->reactionRepository->findFirstWhere([
                ReactionDomainObject::CAMPAIGN_ID => $campaign->getId(),
                ReactionDomainObject::ID => $reactionId,
            ]))
            ->response();
    }
}