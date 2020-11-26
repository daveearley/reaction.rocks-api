<?php

declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Response\ResponseBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

abstract class BaseAction extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function getResponseBuilder(): ResponseBuilder
    {
        return app(ResponseBuilder::class);
    }
}
