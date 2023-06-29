<?php

declare(strict_types=1);

namespace App\Domain\Trips\Jobs;

use App\Domain\Trips\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteExpiredTripAndContentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Trip $trip)
    {
        //@todo add this to a default queue here
    }

    public function handle(): void
    {
        //@todo build this up over time so when things are built up like locations, images etc we will need to delete them
        $this->trip->forceDelete();
    }
}
