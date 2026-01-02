<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attachment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }

    public function delete(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }
}
