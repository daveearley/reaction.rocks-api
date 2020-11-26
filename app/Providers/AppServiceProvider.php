<?php

namespace App\Providers;

use App\Service\Common\GeoIp\IpToCountryService;
use App\Service\Common\GeoIp\IpToCountryServiceInterface;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindDoctrineConnection();
        $this->app->bind(IpToCountryServiceInterface::class, IpToCountryService::class);
    }

    private function bindDoctrineConnection(): void
    {
        $this->app->bind(
            AbstractSchemaManager::class,
            function () {
                $config = new Configuration();

                $connectionParams = [
                    'dbname' => config('database.connections.pgsql.database'),
                    'user' => config('database.connections.pgsql.username'),
                    'password' => config('database.connections.pgsql.password'),
                    'host' => config('database.connections.pgsql.host'),
                    'driver' => 'pdo_pgsql',
                ];

                return DriverManager::getConnection($connectionParams, $config)->getSchemaManager();
            }
        );
    }

    public function boot()
    {
        //  if(env('APP_DEBUG')) {
        DB::listen(
            function ($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            }
        );
        //   }
    }
}
