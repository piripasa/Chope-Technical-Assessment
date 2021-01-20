<?php

namespace App\Listeners;

use App\Events\UserLogoutEvent;
use App\Repository\ActivityRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogoutEventListener
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
     * @param UserLogoutEvent $event
     * @return void
     */
    public function handle(UserLogoutEvent $event)
    {
        $this->repository->store(
            sprintf('user:%d:activity', $event->user->id),
            serialize(['created_at' => Carbon::now(), 'activity' => 'Logout']),
            (int)Carbon::now()->timestamp
        );
    }
}
