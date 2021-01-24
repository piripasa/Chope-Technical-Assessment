<?php

namespace App\Events;

use App\Models\User;

class UserRegisterEvent extends Event
{
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
