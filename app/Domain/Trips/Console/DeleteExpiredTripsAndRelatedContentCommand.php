<?php

declare(strict_types=1);

namespace App\Domain\Trips\Console;

use App\Domain\Trips\Jobs\DeleteExpiredTripAndContentJob;
use App\Domain\Trips\Models\Trip;
use Illuminate\Console\Command;

class DeleteExpiredTripsAndRelatedContentCommand extends Command
{
    protected $signature = 'trips:delete-expired-trips {dayToGoBack}';

    protected $description = 'This command will delete any trips that are soft deleted and have been deleted for more than the days requested';

    public function handle(): void
    {
        $daysInThePast = (int)$this->argument('dayToGoBack');

        $trips = Trip::query()->withTrashed()
            ->where('deleted_at', '<=', now()->subDays($daysInThePast))
            ->get();

        if ($trips->isEmpty()) {
            return;
        }

        $trips->each(function (Trip $trip) {
            DeleteExpiredTripAndContentJob::dispatch($trip);
        });
    }
}
