@extends('layout')

@section('title', 'Liste des années scolaires')

@section('content')

@include('errors.session-values')

<div class="row">
    <div class="d-flex justify-content-center align-items-center gap-3 mb-4">

        <h1 class="fw-bold mb-0">Liste des années scolaires</h1>

        @can('create', App\Models\AcademicYear::class)
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Année scolaire</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Statut</th>
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
                </tr>

                @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection