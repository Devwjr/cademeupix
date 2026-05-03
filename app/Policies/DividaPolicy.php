<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Divida;
use Illuminate\Auth\Access\HandlesAuthorization;

class DividaPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Divida $divida): bool
    {
        return $user->id === $divida->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Divida $divida): bool
    {
        return $user->id === $divida->user_id;
    }

    public function delete(User $user, Divida $divida): bool
    {
        return $user->id === $divida->user_id;
    }
}
