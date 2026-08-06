@extends('layout')

@section('title', $pageTitle)

@section('content')


<div class="row justify-content-center">
    <div class="col-12 col-lg-9">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $academicYear->name }} : {{ $pageTitle }}</h1>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                @include('errors.messages-error-info')

                <form action="{{ $period->exists ? route('academic-years.periods.update', [$academicYear, $period]) : route('academic-years.periods.store', $academicYear) }}" method="POST">
                    @csrf

                    @if ($period->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- status --}}
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Statut *</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach (App\Enums\PeriodStatus::cases() as $status)
                                <input type="radio"
                                    class="btn-check"
                                    name="status"
                                    id="status_{{ $status->value }}"
                                    value="{{ $status->value }}"
                                    @checked($status->value === old('status', $period->status?->value ?? App\Enums\PeriodStatus::UPCOMING->value))>

                                <label class="btn btn-outline-{{ $status->color() }} btn-sm d-flex align-items-center justify-content-center gap-2"
                                    for="status_{{ $status->value }}"
                                    title="{{ $status->description() }}"
                                    style="min-width: 110px;"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top">

                                    <span>{{ $status->label() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-8">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="30"
                                required
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $period->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- short name --}}
                        <div class="col-4">
                            <label for="short_name" class="form-label">Nom court *</label>
                            <input type="text"
                                id="short_name"
                                name="short_name"
                                maxlength="5"
                                required
                                class="form-control form-control-sm @error('short_name') is-invalid @enderror"
                                value="{{ old('short_name', $period->short_name) }}">
                            @error('short_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- position --}}
                        <div class="col-2">
                            <label for="position" class="form-label">Position *</label>
                            <input type="number"
                                id="position"
                                name="position"
                                min="0" max="100"
                                required
                                class="form-control form-control-sm @error('position') is-invalid @enderror"
                                value="{{ old('position', $period->position) }}">
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Start date --}}
                        <div class="col-md-5">
                            <label for="start_date" class="form-label">Date début *</label>
                            <input type="text"
                                id="start_date"
                                name="start_date"
                                maxlength="10"
                                placeholder="JJ/MM/AAAA"
                                class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', $period->start_date?->format('d/m/Y')) }}">
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- end date --}}
                        <div class="col-md-5">
                            <label for="end_date" class="form-label">Date fin *</label>
                            <input type="text"
                                id="end_date"
                                name="end_date"
                                maxlength="10"
                                placeholder="JJ/MM/AAAA"
                                class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', $period->end_date?->format('d/m/Y')) }}">
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="col-12">
                            <label for="comment" class="form-label">Commentaire</label>
                            <textarea
                                id="comment"
                                name="comment"
                                maxlength="300"
                                rows="4"
                                class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $period->comment) }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between gap-2 mt-1 pt-3">

                        @if ($period->exists)

                        
                        <button type="button"
                            class="btn btn-outline-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deletePeriodModal">
                            <i class="bi bi-trash me-1"></i> Supprimer cette période
                        </button>
                        @endif

                        <a href="{{ route('academic-years.index') }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                    </div>

                </form>

                <div class="text-muted small">
                    <x-created-updated-by :model="$academicYear" />
                </div>

            </div>
        </div>
    </div>
</div>


{{-- Modale de confirmation de suppression --}}
<div class="modal fade" id="deletePeriodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body p-4 text-center">
                <p class="fw-bold mb-2">Supprimer {{ $period->name }} ?</p>
                <p class="text-muted small mb-0">
                    Cette action supprimera la période de l'année <strong>{{ $academicYear->name }}</strong>.
                </p>
            </div>
            <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                
                <form action="{{ route('academic-years.periods.destroy', [$academicYear, $period]) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Oui, supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection