<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reference;

class ReferencePolicy
{
    public function view(User $user, Reference $reference)
    {
        return $user->id === $reference->user_id;
    }

    public function update(User $user, Reference $reference)
    {
        return $user->id === $reference->user_id;
    }

    public function delete(User $user, Reference $reference)
    {
        return $user->id === $reference->user_id;
    }

    public function create(User $user)
    {
        return true; // any logged-in user can create
    }
}
