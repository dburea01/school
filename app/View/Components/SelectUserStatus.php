<?php

namespace App\View\Components;

use App\Models\UserStatus;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectUserStatus extends Component
{
    /** @var Collection<int,UserStatus> */
    public $userStatuses;

    public function __construct(
        public string $value
    ) {
        $this->userStatuses = UserStatus::orderBy('position')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-user-status');
    }
}
