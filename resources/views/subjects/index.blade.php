@extends('layout')

@section('title', 'Liste des matières')

@section('content')

@include('errors.session-values')

<div class="row">
    <div class="d-flex justify-content-center align-items-center gap-3 mb-4">

        <h1 class="fw-bold mb-0">Liste des <span class="text-primary">{{ $subjects->count() }}</span> matières</h1>

        @can('create', App\Models\Subject::class)
        <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm">
            + Créer
        </a>
        @endcan

    </div>
</div>



<div class="row">

    <div class="col-md-8 mx-auto">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>active ?</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($subjects as $subject)

                <tr class="align-middle">
                    <td>
                        <a href="{{ route('subjects.edit', $subject) }}" class="fw-bold text-primary text-decoration-none me-2">
                            {{ $subject->name }}
                        </a>
                        <span class="badge border text-dark" style="background-color: {{ $subject->color }}">
                            {{ $subject->short_name }}
                        </span>
                    </td>
                    <td>
                        @if($subject->is_active)
                        <span class="badge bg-success-subtle text-success">Actif</span>
                        @else
                        <span class="badge bg-secondary-subtle text-secondary">Inactif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm  btn-link btn-delete-subject"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            data-id="{{ $subject->id }}"
                            data-name="{{ $subject->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
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

            {{-- Corps de la modale avec icône et texte centralisé --}}
            <div class="modal-body p-4 text-center">

                {{-- Icône d'avertissement en fond rouge clair --}}
                <div class="mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                    </div>
                </div>

                {{-- Titre et sous-titre --}}
                <p class="modal-title fw-bold mb-2" id="exampleModalLabel">
                    Supprimer la matière <span id="subject-name-to-delete" class="text-danger"></span> ?
                </p>

                <p class="text-muted small">
                    Êtes-vous sûr de vouloir supprimer cette matière ? <br>
                    <span class="fw-semibold text-danger">Cette action est définitive et irréversible.</span>
                </p>

                <p class="text-muted small mb-0">
                    Vous pouvez également rendre la matière inactive au lieu de la supprimer.<br>
                </p>
            </div>

            {{-- Pied de modale avec fond légèrement gris pour séparer les actions --}}
            <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-end gap-2">
                <button type="button"
                    class="btn btn-outline-secondary px-3"
                    data-bs-dismiss="modal">
                    Annuler
                </button>

                <form id="form-delete-subject" method="POST" class="m-0">
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

        $('.btn-delete-subject').click(function() {
            let subjectId = $(this).attr('data-id')
            let name = $(this).attr('data-name')

            $('#subject-name-to-delete').text(name)
            $('#form-delete-subject').attr('action', '/subjects/' + subjectId)
        })

    });
</script>
@endsection