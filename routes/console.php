<?php

use App\Service\Common\DomainObjectGenerator\Generator;
use Illuminate\Support\Facades\Artisan;

Artisan::command('generate-domain-objects',
    fn() => app()->make(Generator::class)->run()
)->describe('Generate domain objects from db');
