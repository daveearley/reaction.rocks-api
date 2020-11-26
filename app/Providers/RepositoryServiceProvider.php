<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repository\Eloquent\AccountRepository;
use App\Repository\Eloquent\CampaignRepository;
use App\Repository\Eloquent\ReactionRepository;
use App\Repository\Interfaces\AccountRepositoryInterface;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private static array $interfaceToConcreteMap = [
        AccountRepositoryInterface::class => AccountRepository::class,
        ReactionRepositoryInterface::class => ReactionRepository::class,
        CampaignRepositoryInterface::class => CampaignRepository::class
    ];

    public function register()
    {
        foreach (self::$interfaceToConcreteMap as $interface => $concrete) {
            $this->app->bind($interface, $concrete);
        }
    }
}
