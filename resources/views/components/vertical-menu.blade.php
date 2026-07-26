@can('update', App\Models\School::class)
<a href="{{ route('school.edit') }}" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
    @if(request()->routeIs('school.edit'))
    <strong><i class="bi bi-buildings me-2"></i>Modifier école</strong>
    @else
    <i class="bi bi-buildings me-2"></i>Modifier école
    @endif
</a>
@endcan

<a href="" class="list-group-item list-group-item-action custom-sidebar text-dark border-0 py-2">
    @if(request()->routeIs('option2'))
    <strong><i class="bi bi-house me-2"></i>Option2</strong>
    @else
    <i class="bi bi-house me-2"></i>Option 2
    @endif
</a>


<div class="mt-auto p-3 border-bottom bg-light-subtle text-center">
    <div class="d-flex flex-column align-items-center">


        <div class="avatar-initials bg-primary text-white mb-2 flex-shrink-0">
            {{ Auth::user()->initials }}
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