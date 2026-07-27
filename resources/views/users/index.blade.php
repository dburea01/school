@extends('layout')

@section('title', 'Liste des utilisateurs')

@section('content')

@include('errors.session-values')

<div class="row g-4">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold">Liste des utilisateurs <span class="badge bg-secondary-subtle text-secondary-emphasis fs-6 fw-normal align-middle ms-2">
                    {{ $users->total() }} sur {{ $total_users }}
                </span></h1>
        </div>

        <div class="d-flex gap-2">
            @can('create', App\Mdels\User::class)
            <a href="{{ route('users.create') }}"
                class="btn btn-primary btn-sm">
                + Créer
            </a>
            @endcan

            {{--
                        <a href="{{ route('users.export', array_merge(request()->query())) }}"
            class="btn btn-outline-success btn-sm">
            Exporter
            </a>--}}
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="col-12 col-lg-3">

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h2>Filtres</h2>

                <form action="{{ route('users.index') }}">

                    {{-- search --}}
                    <div class="mb-3">
                        <input type="text"
                            class="form-control form-control-sm"
                            name="search"
                            placeholder="nom, prénom, email ..."
                            value="{{ $search }}">
                    </div>

                    {{-- role --}}
                    <div class="mb-3">
                        <x-select-user-role name="role"
                            id="role"
                            class="form-select form-select-sm"
                            :value="$role" />
                    </div>

                    {{-- submit --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            Appliquer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ===== --}}
    {{-- TABLE --}}
    {{-- ===== --}}
    <div class="col-12 col-lg-9">

        <div class="card border-0 shadow-sm">



            {{-- TABLE --}}
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Utilisateur</th>
                                <th>Rôle</th>
                                <th>Adresse</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($users as $user)
                            <tr>

                                {{-- USER --}}

                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-3">

                                        {{-- AVATAR or INITIALES --}}
                                        @if ($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}"
                                            alt="{{ $user->name }}"
                                            class="rounded-circle object-fit-cover flex-shrink-0"
                                            width="44"
                                            height="44">
                                        @else
                                        <div class="avatar-initials bg-secondary-subtle text-secondary-emphasis">
                                            {{ $user->initials }}
                                        </div>
                                        @endif

                                        {{-- NOM + EMAIL --}}
                                        <div class="lh-sm min-w-0">
                                            <a href="{{ route('users.show', $user) }}" class="fw-bold text-primary text-decoration-none d-block text-truncate">
                                                {{ $user->full_name }}
                                            </a>
                                            <small class="text-muted text-truncate d-block">
                                                {{ $user->email }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                {{-- ROLE --}}
                                <td>
                                    <span class="badge {{ $user->role->badgeClass() }}">
                                        {{ $user->role->label() }}
                                    </span>
                                </td>


                                {{-- ADDRESS --}}
                                <td class="text-muted small">
                                    {{ $user->postal_code }} {{ $user->city }}
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-end">

                                    @can('delete', $user)
                                    <button class="btn btn-sm  btn-link btn-delete-user"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        data-id="{{ $user->id }}"
                                        data-role="{{ $user->role->label() }}"
                                        data-user-name="{{ $user->full_name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endcan

                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PAGINATION --}}
            <div class="card-body">
                {{ $users->withQueryString()->onEachSide(2)->links() }}
            </div>

        </div>

    </div>

</div>

{{-- ============ --}}
{{-- MODAL DELETE --}}
{{-- ============ --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <p class="modal-title">
                    Supprimer <span id="user-name-to-delete"></span> (<span id="user-role-to-delete"></span>)
                </p>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-danger fw-bold">
                    Cette action est définitive.
                </p>
                <p class="text-muted small">
                    Les données liées (affectations, resultats, etc.. ) seront également supprimées.
                </p>
            </div>

            <div class="modal-footer">

                <form id="form-delete-user" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button"
                        class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit"
                        class="btn btn-danger btn-sm">
                        Supprimer
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>



@endsection

@section('extra_js')
<script>
    $(document).ready(function() {

        $('.btn-delete-user').click(function() {
            let userId = $(this).attr('data-id')
            let role = $(this).attr('data-role')
            let userName = $(this).attr('data-user-name')

            $('#user-name-to-delete').text(userName)
            $('#user-role-to-delete').text(role)
            $('#form-delete-user').attr('action', '/users/' + userId)
        })

    });
</script>
@endsection