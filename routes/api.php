<?php

use App\Http\Actions\Account\CreateAccountAction;
use App\Http\Actions\Account\GetAccountAction;
use App\Http\Actions\Account\UpdateAccountAction;
use App\Http\Actions\Auth\LoginAction;
use App\Http\Actions\Auth\LogoutAction;
use App\Http\Actions\Auth\MeAction;
use App\Http\Actions\Auth\RefreshTokenAction;
use App\Http\Actions\Campaign\CreateCampaignAction;
use App\Http\Actions\Campaign\DeleteCampaignAction;
use App\Http\Actions\Campaign\GetCampaignAction;
use App\Http\Actions\Campaign\GetCampaignByPublicIdAction;
use App\Http\Actions\Campaign\GetCampaignsAction;
use App\Http\Actions\Campaign\GetCampaignStatisticsAction;
use App\Http\Actions\Campaign\UpdateCampaignAction;
use App\Http\Actions\Reaction\CreateReactionAction;
use App\Http\Actions\Reaction\GetReactionAction;
use App\Http\Actions\Reaction\GetReactionsByCampaignId;
use Illuminate\Routing\Router;

/** @var Router|Router $router */
$router = app()->get('router');

/**
 * Auth routes
 */
$router->post('/login', LoginAction::class)->name('login');
$router->post('/accounts', CreateAccountAction::class);

/**
 * Public routes
 */
$router->get('/public/campaigns/{campaign_id}', GetCampaignByPublicIdAction::class);
$router->post('/campaigns/{campaign_id}/reactions', CreateReactionAction::class);

/**
 * Logged In Routes
 */
$router->middleware(['auth:api'])->group(
    static function (Router $router) {
        $router->get('/logout', LogoutAction::class);
        $router->get('/refresh', RefreshTokenAction::class);
        $router->get('/me', MeAction::class);

        $router->put('/accounts', UpdateAccountAction::class);
        $router->get('/accounts/{account_id}', GetAccountAction::class);

        $router->post('/campaigns', CreateCampaignAction::class);
        $router->delete('/campaigns/{campaign_id}', DeleteCampaignAction::class);
        $router->put('/campaigns/{campaign_id}', UpdateCampaignAction::class);
        $router->get('/campaigns/{campaign_id}', GetCampaignAction::class);
        $router->get('/campaigns', GetCampaignsAction::class);
        $router->get('/campaigns/{campaign_id}/statistics', GetCampaignStatisticsAction::class);

        $router->get('/campaigns/{campaign_id}/verify_widget', GetCampaignAction::class);

        $router->get('/campaigns/{campaign_id}/reactions', GetReactionsByCampaignId::class);
        $router->get('/campaigns/{campaign_id}/reactions/{reaction_id}', GetReactionAction::class);
        $router->delete('/reactions/{reaction_id}', CreateCampaignAction::class);
        $router->get('/reactions/{reaction_id}', GetCampaignAction::class);
    }
);
