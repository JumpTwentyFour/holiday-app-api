<?php

declare(strict_types=1);

namespace App\Policies;

use App\Domain\Trips\Models\Trip;
use App\Models\User;

class TripPolicy
{
    public function delete(User $user, Trip $trip): bool
    {
        return $user->id === $trip->owner_id;
    }
}
