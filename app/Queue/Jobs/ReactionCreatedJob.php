<?php

namespace App\Queue\Jobs;

use App\DomainObjects\ReactionDomainObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReactionCreatedJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private ReactionDomainObject $reaction;

    public function __construct(ReactionDomainObject $reaction)
    {
        $this->reaction = $reaction;
    }

    public function handle()
    {
        Log::alert('hello: ' . $this->reaction->getFeedbackMessage());
    }
}
