<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cliente $cliente): bool
    {
        return $user->id === $cliente->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Cliente $cliente): bool
    {
        return $user->id === $cliente->user_id;
    }

    public function delete(User $user, Cliente $cliente): bool
    {
        return $user->id === $cliente->user_id;
    }
}
