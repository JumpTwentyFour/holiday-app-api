<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Trips;

use App\Domain\Trips\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group("Trips")]
class DeleteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_doesnt_delete_a_trip_when_not_authenticated(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->deleteJson(route('api.trips.delete', $trip->id));

        $response->assertUnauthorized();
    }

    #[Test]
    public function it_doesnt_delete_a_trip_for_a_user_that_is_authenticated_but_they_dont_own(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $trip = Trip::factory()->create();

        $response = $this->deleteJson(route('api.trips.delete', $trip->id));

        $response->assertForbidden();
    }

    #[Test]
    public function it_does_delete_a_trip_that_the_user_owns(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $trip = Trip::factory()->create(
            [
                'owner_id' => $user->id,
            ]
        );

        $response = $this->deleteJson(route('api.trips.delete', $trip->id));

        $response->assertNoContent();

        $this->assertSoftDeleted(
            Trip::class,
            [
                'id' => $trip->id,
                'owner_id' => $user->id,
            ]
        );
    }
}
