<?php

namespace App\View\Components;

use App\Enums\UserGender;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectUserGender extends Component
{
    /** @var array<int, UserGender> */
    public $userGenders;

    public function __construct(
        public ?string $value
    ) {
        $this->userGenders = UserGender::cases();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-user-gender');
    }
}
