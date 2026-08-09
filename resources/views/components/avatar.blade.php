@use('App\Enums\UserStatus')

<div class="position-relative d-inline-block flex-shrink-0">

    {{-- 1. Image de l'avatar --}}
    <div class="rounded-circle border shadow-sm overflow-hidden" style="width: {{ $dimension }}px; height: {{ $dimension }}px;">
        <img {{ $attributes }} src="{{ $user?->avatar_path ? Storage::url($user->avatar_path) : asset('img/default-avatar.svg') }}"
            alt="{{ $user->name ?? '' }}"
            class="w-100 h-100"
            style="object-fit: cover;">
    </div>

    {{-- 2. Pastille de statut (Masquée si le statut est ACTIVE) --}}
    @if ($user?->status !== UserStatus::ACTIVE && $user?->status->icon())
    <span class="position-absolute bottom-0 end-0 rounded-circle bg-{{ $user->status->color() }} text-white d-flex align-items-center justify-content-center shadow-sm"
        title="{{ $user->status->label() }}"
        style="
                width: {{ round($dimension * 0.4) }}px; 
                height: {{ round($dimension * 0.4) }}px; 
                font-size: {{ round($dimension * 0.25) }}px; 
                transform: translate(10%, 10%);
              ">
        <i class="bi {{ $user->status->icon() }}"></i>
    </span>
    @endif

</div>