<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Trips\Jobs;

use App\Domain\Trips\Console\DeleteExpiredTripsAndRelatedContentCommand;
use App\Domain\Trips\Models\Trip;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group("Trips")]
class DeleteExpiredTripAndContentJobTest extends TestCase
{
    #[Test]
    public function it_doesnt_deleted_a_trip_that_isnt_marked_as_deleted(): void
    {
        $trip = Trip::factory()->create();

        $this->artisan(DeleteExpiredTripsAndRelatedContentCommand::class, [
            'dayToGoBack' => 30,
        ]);
        $this->assertDatabaseHas(
            Trip::class,
            [
                'id' => $trip->id,
                'deleted_at' => null,
            ]
        );
    }

    #[Test]
    public function it_doesnt_delete_a_trip_that_is_marked_as_deleted_but_is_less_than_the_alloted_days(): void
    {
        $trip = Trip::factory()->create(
            [
                'deleted_at' => now()->subDays(10),
            ]
        );

        $this->artisan(DeleteExpiredTripsAndRelatedContentCommand::class, [
            'dayToGoBack' => 30,
        ]);
        $this->assertSoftDeleted(
            Trip::class,
            [
                'id' => $trip->id,
            ]
        );
    }

    #[Test]
    public function it_does_delete_a_trip_that_is_marked_as_deleted_and_is_in_the_window(): void
    {
        $trip = Trip::factory()->create(
            [
                'deleted_at' => now()->subDays(31),
            ]
        );

        $this->artisan(DeleteExpiredTripsAndRelatedContentCommand::class, [
            'dayToGoBack' => 30,
        ]);
        $this->assertDatabaseMissing(
            Trip::class,
            [
                'id' => $trip->id,
            ]
        );
    }
}
