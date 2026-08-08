@extends('layout')

@section('title', 'Niveaux / Classes')

@section('content')

@include('errors.session-values')

<div class="col-12 col-xl-10 mx-auto">

    <div class="mb-4">
        <h1 class="fw-bold mb-0">Niveaux / Classes</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Année scolaire</th>
                    <th>Statut</th>
                    <th>Niveaux</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($academicYears as $academicYear)
                <tr>
                    <td>
                        {{ $academicYear->name}}
                    </td>

                    <td>
                        <span class="badge bg-{{ $academicYear->status->color() }}">
                            {{ $academicYear->status->label() }}
                        </span>
                    </td>

                    <td>
                        <span class="badge rounded-pill text-bg-light">
                            <a href="{{ route('academic-years.levels.index', $academicYear) }}">
                                {{ $academicYear->levels_count }}
                                @if ($academicYear->levels_count <= 1) niveau @else niveaux @endif
                                    </span>
                            </a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection