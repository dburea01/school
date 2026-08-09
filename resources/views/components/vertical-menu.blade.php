@can('update', App\Models\School::class)
<a href="{{ route('school.edit') }}"
    class="nav-link d-flex align-items-center rounded-3 px-1 py-1 {{ request()->routeIs('school.edit') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-secondary' }}">
    <i class="bi bi-buildings me-3 fs-5"></i>
    <span>Modifier école</span>
</a>
@endcan

@can('viewAny', App\Models\AcedemicYear::class)
<a href="{{ route('academic-years.index') }}"
    class="nav-link d-flex align-items-center rounded-3 px-1 py-1 {{ request()->routeIs('academic-years.*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-secondary' }}">
    <i class="bi bi-calendar-range me-3 fs-5"></i>
    <span>Années scolaires</span>
</a>
@endcan

@can('viewAny', App\Models\Classroom::class)
<a href="{{ route('structure.index') }}"
    class="nav-link d-flex align-items-center rounded-3 px-1 py-1 {{ request()->routeIs('structure.index') || request()->routeIs('academic-years.classrooms.*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-secondary' }}">
    <i class="bi bi-diagram-3 me-3 fs-5"></i>
    <span>Classes</span>
</a>
@endcan

@can('viewAny', App\Models\Subject::class)
<a href="{{ route('subjects.index') }}"
    class="nav-link d-flex align-items-center rounded-3 px-1 py-1 {{ request()->routeIs('subjects.*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-secondary' }}">
    <i class="bi bi-bookshelf me-3 fs-5"></i>
    <span>Matières</span>
</a>
@endcan

@can('viewAny', App\Models\User::class)
<a href="{{ route('users.index') }}"
    class="nav-link d-flex align-items-center rounded-3 px-1 py-1 {{ request()->routeIs('users.*') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-secondary' }}">
    <i class="bi bi-people me-3 fs-5"></i>
    <span>Utilisateurs</span>
</a>
@endcan


<div class="mt-auto p-3 border-bottom bg-light-subtle text-center">
    <div class="d-flex flex-column align-items-center">

        <x-avatar :user="Auth::user()" dimension="50" />

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