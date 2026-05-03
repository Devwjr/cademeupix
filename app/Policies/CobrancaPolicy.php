<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cobranca;
use App\Models\Divida;
use Illuminate\Auth\Access\HandlesAuthorization;

class CobrancaPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cobranca $cobranca): bool
    {
        return $user->id === $cobranca->user_id;
    }

    public function create(User $user, ?Divida $divida = null): bool
    {
        if ($divida) {
            return $user->id === $divida->user_id;
        }
        return true;
    }

    public function update(User $user, Cobranca $cobranca): bool
    {
        return $user->id === $cobranca->user_id;
    }

    public function delete(User $user, Cobranca $cobranca): bool
    {
        return $user->id === $cobranca->user_id;
    }
}
