@extends('layout')

@section('title', 'Liste des années scolaires')

@section('content')

@include('errors.session-values')

<div class="col-12 col-xl-10 mx-auto">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Liste des années scolaires</h1>
        @can('create', App\Models\AcademicYear::class)
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary btn-sm">
            + Créer
        </a>
        @endcan
    </div>


    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Année scolaire</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Statut</th>
                    <th>&nbsp;</th>
                    <th>Périodes</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($academicYears as $academicYear)
                <tr>
                    <td>
                        <a href="{{ route('academic-years.edit', $academicYear) }}">{{ $academicYear->name}}</a>
                    </td>

                    <td>
                        {{ $academicYear->start_date->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $academicYear->end_date->format('d/m/Y') }}
                    </td>

                    <td>
                        <span class="badge bg-{{ $academicYear->status->color() }}">
                            {{ $academicYear->status->label() }}
                        </span>
                    </td>

                    <td>
                        @if($academicYear->status === App\Enums\AcademicYearStatus::DRAFT)
                        <button class="btn btn-sm  btn-link btn-delete-academic-year"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            data-id="{{ $academicYear->id }}"
                            data-name="{{ $academicYear->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            {{-- Liste des badges de périodes --}}
                            @foreach($academicYear->periods as $period)
                            <a href="{{ route('academic-years.periods.edit', [$academicYear, $period]) }}"
                                class="badge bg-light text-dark border text-decoration-none d-inline-flex align-items-center gap-1 px-2 py-1"
                                title="{{ $period->name }} ({{ $period->status->label() }})">

                                <span>{{ $period->short_name }}</span>
                            </a>
                            @endforeach

                            {{-- Bouton "+" pour ajouter une période --}}
                            @if($academicYear->status !== App\Enums\AcademicYearStatus::ARCHIVED)
                            <a href="{{ route('academic-years.periods.create', $academicYear) }}"
                                class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none px-2 py-1"
                                title="Ajouter une période à cette année">
                                +
                            </a>
                            @endif
                        </div>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <h5 class="modal-title fw-bold mb-2" id="exampleModalLabel">
                    Supprimer le brouillon <span id="academic-year-name-to-delete" class="text-danger"></span> ?
                </h5>

                <p class="text-muted small mb-0">
                    Êtes-vous sûr de vouloir supprimer cette année scolaire en préparation ? <br>
                    <span class="fw-semibold text-danger">Cette action est définitive et irréversible.</span>
                </p>
            </div>

            {{-- Pied de modale avec fond légèrement gris pour séparer les actions --}}
            <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-end gap-2">
                <button type="button"
                    class="btn btn-outline-secondary px-3"
                    data-bs-dismiss="modal">
                    Annuler
                </button>

                <form id="form-delete-academic-year" method="POST" class="m-0">
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

        $('.btn-delete-academic-year').click(function() {
            let academicYearId = $(this).attr('data-id')
            let name = $(this).attr('data-name')

            $('#academic-year-name-to-delete').text(name)
            $('#form-delete-academic-year').attr('action', '/academic-years/' + academicYearId)
        })

    });
</script>
@endsection