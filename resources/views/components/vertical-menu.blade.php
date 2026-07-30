@can('update', App\Models\School::class)
<a href="{{ route('school.edit') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
    @if(request()->routeIs('school.edit'))
    <strong><i class="bi bi-buildings me-2"></i>Modifier école</strong>
    @else
    <i class="bi bi-buildings me-2"></i>Modifier école
    @endif
</a>
@endcan

@can('viewAny', App\Models\User::class)
<a href="{{ route('users.index') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
    @if(request()->routeIs('users.index'))
    <strong><i class="bi bi-people me-2"></i>Utilisateurs</strong>
    @else
    <i class="bi bi-people me-2"></i>Utilisateurs
    @endif
</a>
@endcan




<div class="mt-auto p-3 border-bottom bg-light-subtle text-center">
    <div class="d-flex flex-column align-items-center">

        {{--
        <div class="avatar-initials bg-primary text-white mb-2 flex-shrink-0">
            {{ Auth::user()->initials }}
        </div>
        --}}

        <div class="rounded-circle border shadow-sm overflow-hidden flex-shrink-0" style="width: 50px; height: 50px;">
                                <img id="photo" src="{{ Auth::user()->avatar_path ? Storage::url(Auth::user()->avatar_path) : asset('img/default-avatar.svg') }}"
                                    alt=""
                                    class="w-100 h-100"
                                    style="object-fit: cover;">
                            </div>

        <div class="min-w-0 w-100">
            <p class="mb-0 fw-bold text-dark text-truncate">
                {{ Auth::user()->full_name }}
            </p>

            <span class="text-secondary d-block text-truncate">
                {{ Auth::user()->role->label() }}
            </span>
        </div>


        <a href="{{ route('logout') }}"
            class="mt-2 text-secondary hover-primary text-decoration-none"
            title="Déconnexion">
            <i class="bi bi-box-arrow-right text-danger"></i>
            <span class="text-danger">Déconnexion</span>
        </a>

    </div>
</div>