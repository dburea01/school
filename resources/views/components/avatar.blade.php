<div class="rounded-circle border shadow-sm overflow-hidden flex-shrink-0" style="width: {{$dimension}}px; height: {{$dimension}}px;">
    <img {{ $attributes }} src="{{ $user->avatar_path ? Storage::url($user->avatar_path) : asset('img/default-avatar.svg') }}"
        alt=""
        class="w-100 h-100"
        style="object-fit: cover;">
</div>