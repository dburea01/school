<?php

namespace App\View\Components;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectUser extends Component
{
    public UserRole|string $role;

    public ?string $value;

    /** @var Collection<int,User> $users */
    public Collection $users;

    public function __construct(
        UserRole|string $role,
        ?string $value = null,
    ) {
        $this->role = $role;
        $this->value = $value;

        // Supporte aussi bien une String ("TEACHER") qu'un Enum (UserRole::TEACHER)
        $roleValue = $role instanceof UserRole ? $role->value : $role;

        $this->users = User::where('role', $roleValue)
            ->where('status', UserStatus::ACTIVE)
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-user');
    }
}
