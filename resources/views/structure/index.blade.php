@extends('layout')

@section('title', 'Niveaux / Classes')

@section('content')

@include('errors.session-values')

<div class="row mb-3">
    <div class="col-md-8 mx-auto">

        <h1 class="fw-bold mb-0">Niveaux / Classes </h1>



    </div>
</div>



<div class="row">

    <div class="col-md-8 mx-auto">
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
                        <a href="{{ route('academic-years.levels.index', $academicYear) }}">{{ $academicYear->name}}</a>
                    </td>

                    <td>
                        <span class="badge bg-{{ $academicYear->status->color() }}">
                            {{ $academicYear->status->label() }}
                        </span>
                    </td>

                    <td>
                        <span class="badge rounded-pill text-bg-light">
                            {{ $academicYear->levels_count }} 
                            @if ($academicYear->levels_count <= 1) niveau @else niveaux @endif
                        </span>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>

    </div>

</div>



@endsection