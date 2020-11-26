<?php

namespace App\Http\Actions\Reaction;

use App\DomainObjects\CampaignDomainObject;
use App\DomainObjects\ReactionDomainObject;
use App\Http\Actions\BaseAction;
use App\Http\Request\Reaction\GetReactionsRequest;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use Illuminate\Http\Request;

class GetReactionsByCampaignId extends BaseAction
{
    private Request $request;
    private CampaignRepositoryInterface $campaignRepository;
    private ReactionRepositoryInterface $reactionRepository;

    public function __construct(
        Request $request,
        CampaignRepositoryInterface $campaignRepository,
        ReactionRepositoryInterface $reactionRepository
    )
    {
        $this->request = $request;
        $this->campaignRepository = $campaignRepository;
        $this->reactionRepository = $reactionRepository;
    }

    public function __invoke(GetReactionsRequest $request, int $campaignId)
    {
        /** @var CampaignDomainObject $campaign */
        $campaign = $this->campaignRepository->findById($campaignId);
        $where = [
            ReactionDomainObject::CAMPAIGN_ID => $campaign->getId()
        ];

        if ($orderBy = $this->request->get('order_by')) {
            $this->reactionRepository->orderBy($orderBy);
        }

        if ($searchTerm = $this->request->get('search_query')) {
            $where[ReactionDomainObject::FEEDBACK_MESSAGE] = [
                'whereMethod' => 'where',
                'parameters' => [
                    ReactionDomainObject::FEEDBACK_MESSAGE,
                    'like',
                    '%' . $searchTerm . '%'
                ]
            ];
        }

        if ($emojis = $this->request->get('emojis')) {
            $emojis = array_intersect($campaign->getEmojisArray(), $emojis);
            $where[ReactionDomainObject::EMOJI] = [
                'whereMethod' => 'whereIn',
                'parameters' => [
                    ReactionDomainObject::EMOJI,
                    $emojis,
                ]
            ];
        }

        return $this
            ->getResponseBuilder()
            ->withData($this->reactionRepository->paginateWhere($where))
            ->response();
    }

}