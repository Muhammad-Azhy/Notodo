<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Problem;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Problem $problem)
    {
        return $user->id === $problem->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Problem $problem)
    {
        return $user->id === $problem->user_id;
    }

    public function delete(User $user, Problem $problem)
    {
        return $user->id === $problem->user_id;
    }
}
