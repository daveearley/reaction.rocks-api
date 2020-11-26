<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use App\Service\Common\Session\SessionIdentifierService;

class GetCampaignByPublicIdAction extends BaseAction
{
    private CampaignRepositoryInterface $campaignRepository;
    private ReactionRepositoryInterface $reactionRepository;
    private SessionIdentifierService $sessionIdentifierService;

    public function __construct(
        CampaignRepositoryInterface $campaignRepository,
        ReactionRepositoryInterface $reactionRepository,
        SessionIdentifierService $sessionIdentifierService
    )
    {
        $this->campaignRepository = $campaignRepository;
        $this->reactionRepository = $reactionRepository;
        $this->sessionIdentifierService = $sessionIdentifierService;
    }

    public function __invoke(string $campaignId)
    {
        $campaign = $this->campaignRepository->findWhere([
            'public_id' => $campaignId
        ]);

        if ($campaign->isEmpty()) {
            return $this->getResponseBuilder()->notFoundResponse();
        }

        $reactions = $this->reactionRepository->findWhere([
            'client_identifier' => $this->sessionIdentifierService->getIdentifier()
        ]);

        if ($reactions->isNotEmpty()) {
            // return $this
            //   ->getResponseBuilder()
            // ->noContentResponse();
        }

        // todo - transform for public
        return $this
            ->getResponseBuilder()
            ->withData($campaign->get(0))
            ->response();
    }
}