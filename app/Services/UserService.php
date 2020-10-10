<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function get(int $userId): ?User
    {
        return $this->user->firstWhere('user_id', $userId);
    }
}
