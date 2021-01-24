<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Repository\ActivityRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterEventListener
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
     * @param UserRegisterEvent $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $this->repository->store(
            sprintf('user:%d:activity', $event->user->id),
            serialize(['created_at' => Carbon::now(), 'activity' => 'Register']),
            (int)Carbon::now()->timestamp
        );
    }
}
