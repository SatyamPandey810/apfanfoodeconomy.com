<?php
namespace App\Observers;

use App\Models\User;
use App\Services\MLMService;

class UserObserver
{
    protected $mlmService;

    public function __construct(MLMService $mlmService)
    {
        $this->mlmService = $mlmService;
    }

    public function created(User $user)
    {
        $this->mlmService->calculateMatchingBonus($user);
    }

    public function updated(User $user)
    {
        $this->mlmService->calculateMatchingBonus($user);
    }
}
