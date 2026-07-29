<?php

namespace App\View\Components;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectUserStatus extends Component
{
    /** @var array<int, UserStatus> $userStatuses */
    public $userStatuses;

    public function __construct(
        public string $value
    ) {
        $this->userStatuses = UserStatus::cases();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-user-status');
    }
}
