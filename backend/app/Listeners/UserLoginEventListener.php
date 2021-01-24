<?php

namespace App\Listeners;

use App\Events\UserLoginEvent;
use App\Repository\ActivityRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginEventListener
{
    private $repository;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        $this->repository = new ActivityRepository(app('redisCache'));
    }

    /**
     * Handle the event.
     *
     * @param UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $this->repository->store(
            sprintf('user:%d:activity', $event->user->id),
            serialize(['created_at' => Carbon::now(), 'activity' => 'Login']),
            (int)Carbon::now()->timestamp
        );
    }
}
