@extends('layout')

@section('title', 'Liste des classes')

@section('content')

@include('errors.session-values')

<div class="col-12 col-xl-10 mx-auto">
    <h1 class="fw-bold mb-0">Année scolaire : {{ $academicYear->name }}</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="fw-bold mb-0">Les classes ({{ $classrooms->count() }})</h1>
        @if($academicYear->status !== App\Enums\AcademicYearStatus::ARCHIVED)
        @can('create', App\Models\Classroom::class)
        <a href="{{ route('academic-years.classrooms.create', $academicYear) }}" class="btn btn-primary btn-sm">
            + Créer
        </a>
        @endcan
        @endif
    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th class="text-center">Nom court</th>
                    <th class="text-center">Position</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($classrooms as $classroom)

                <tr>
                    <td>
                        <a href="{{ route('academic-years.classrooms.edit', [$academicYear, $classroom]) }}" class="fw-bold text-primary text-decoration-none me-2">
                            {{ $classroom->name }}
                        </a>

                    </td>
                    <td class="text-center">
                        {{ $classroom->short_name }}
                    </td>
                    <td class="text-center">
                        {{ $classroom->position }}
                    </td>
                    
                    <td>
                        @if($academicYear->status !== App\Enums\AcademicYearStatus::ARCHIVED)
                        <button class="btn btn-sm  btn-link btn-delete-classroom"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            data-id="{{ $classroom->id }}"
                            data-name="{{ $classroom->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>



    </div>

</div>


{{-- ============ --}}
{{-- MODAL DELETE --}}
{{-- ============ --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <div class="modal-body p-4 text-center">

                <div class="mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                    </div>
                </div>

                {{-- Titre et sous-titre --}}
                <p class="modal-title fw-bold mb-2" id="exampleModalLabel">
                    Supprimer la classe <span id="classroom-name-to-delete" class="text-danger"></span> ?
                </p>

                <p class="text-muted small">
                    Êtes-vous sûr de vouloir supprimer cette classe ? <br>
                    <span class="fw-semibold text-danger">En supprimant la classe, vous supprimez également toutes ses affectations. Cette action est définitive et irréversible.</span>
                </p>
            </div>

            <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-end gap-2">
                <button type="button"
                    class="btn btn-outline-secondary px-3"
                    data-bs-dismiss="modal">
                    Annuler
                </button>

                <form id="form-delete-classroom" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger px-3">
                        Oui, supprimer
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

        $('.btn-delete-classroom').click(function() {
            let classroomId = $(this).attr('data-id')
            let name = $(this).attr('data-name')

            $('#classroom-name-to-delete').text(name)
            $('#form-delete-classroom').attr('action', '/academic-years/{{ $academicYear->id }}' + '/classrooms/' + classroomId)
        })

    });
</script>
@endsection