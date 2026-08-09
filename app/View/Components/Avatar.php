<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public ?User $user;

    public ?int $dimension;

    /**
     * Create a new component instance.
     */
    public function __construct(?User $user, ?int $dimension = 50)
    {
        $this->user = $user;
        $this->dimension = $dimension;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.avatar');
    }
}
