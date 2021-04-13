<?php

namespace App\Http\Actions\Reaction;

use App\Http\Actions\BaseAction;
use App\Http\Request\Reaction\CreateReactionRequest;
use App\Service\Handler\Reaction\CreateReactionHandler;

class CreateReactionAction extends BaseAction
{
    public function __invoke(int $campaignId, CreateReactionRequest $request, CreateReactionHandler $handler)
    {
        return $this
            ->getResponseBuilder()
            ->withData($handler->execute($campaignId, $request->all()))
            ->createdResponse();
    }
}