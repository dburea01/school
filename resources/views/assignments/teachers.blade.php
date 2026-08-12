@extends('layout')

@section('title', 'Liste des enseignants')

@section('content')

@include('errors.session-values')

<div class="row g-2">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold">Année : {{ $academicYear->name }} - Classe : {{ $classroom->name }}</h1>

            <h1 class="fw-bold">
                Liste des enseignants
                <span class="badge bg-secondary-subtle text-secondary-emphasis fs-6 fw-normal align-middle ms-2">
                    {{ $assignments->count() }}
                </span>
            </h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('assignments.index', ['classroom' => $classroom, 'role' => 'STUDENT']) }}" class="btn btn-light btn-sm border">
                Liste des élèves
            </a>
            @can('create', App\Models\Assignment::class)
            <a href="{{ route('assignments.create', $classroom) }}"
                class="btn btn-primary btn-sm">
                + Créer
            </a>
            @endcan
        </div>
    </div>


    {{-- ===== --}}
    {{-- TABLE --}}
    {{-- ===== --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            {{-- TABLE --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            @foreach ($assignments as $assignment)
                            <tr>

                                {{-- USER --}}

                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-3">

                                        <x-avatar :user="$assignment->user" dimension="44" />

                                        {{-- NOM + EMAIL --}}
                                        <div class="lh-sm min-w-0">
                                            <span class="fw-bold text-dark d-block text-truncate">
                                                {{ $assignment->user->full_name }}
                                            </span>

                                            <small class="text-muted text-truncate d-block">
                                                {{ $assignment->user->email }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                {{-- SUBJECT --}}
                                <td>
                                    

                                    @if($assignment->subject)
                                    <span class="badge border text-dark" style="background-color: {{ $assignment->subject->color }}">
                                        {{ $assignment->subject->short_name }}
                                    </span>
                                    @endif
                                </td>


                                {{-- ACTIONS --}}
                                <td class="text-end">

                                    @can('delete', $assignment)
                                    <button class="btn btn-sm  btn-link btn-delete-assignment"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        data-id="{{ $assignment->id }}"
                                        data-classroom="{{ $classroom->name }}"
                                        data-user-name="{{ $assignment->user->full_name }}">
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
                    Supprimer cette affectation ?
                </p>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-danger fw-bold">Voulez vous vraiment supprimer cette affectation ?</p>
                <ul>
                    <li>Nom : <span id="user-name-to-delete"></span></li>
                    <li>Classe : <span id="classroom-to-delete"></span></li>
                </ul>
                <p class="text-muted small">
                    Cette action est définitive. Vous pouvez également mettre une date de fin d'affectation à cet élève au lieu de supprimer son affectation.
                </p>
            </div>

            <div class="modal-footer">

                <form id="form-delete-assignment" method="POST">
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

        $('.btn-delete-assignment').click(function() {
            let assignmentId = $(this).attr('data-id')
            let classroom = $(this).attr('data-classroom')
            let userName = $(this).attr('data-user-name')

            $('#user-name-to-delete').text(userName)
            $('#classroom-to-delete').text(classroom)
            $('#form-delete-assignment').attr('action', '/classrooms/{{$classroom->id}}/assignments/' + assignmentId)
        })

    });
</script>
@endsection