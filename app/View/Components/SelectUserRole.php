<?php

namespace App\View\Components;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectUserRole extends Component
{
    /** @var array<int, UserRole> $userRoles */
    public $userRoles;

    public function __construct(
        public string $value
    ) {
        $this->userRoles = UserRole::cases();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-user-role');
    }
}
