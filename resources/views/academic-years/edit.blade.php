@extends('layout')

@section('title', $pageTitle)

@section('content')


<div class="row justify-content-center">
    <div class="col-12 col-lg-9">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $pageTitle }}</h1>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                @include('errors.messages-error-info')

                <form action="{{ $academicYear->exists ? route('academic-years.update', $academicYear) : route('academic-years.store') }}" method="POST">
                    @csrf

                    @if ($academicYear->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- status --}}
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Statut *</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach (App\Enums\AcademicYearStatus::cases() as $status)
                                <input type="radio"
                                    class="btn-check"
                                    name="status"
                                    id="status_{{ $status->value }}"
                                    value="{{ $status->value }}"
                                    @checked($status->value === old('status', $academicYear->status?->value ?? App\Enums\AcademicYearStatus::DRAFT->value))>

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
                        <div class="col-12">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="50"
                                required
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $academicYear->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Start date --}}
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Date début *</label>
                            <input type="text"
                                id="start_date"
                                name="start_date"
                                maxlength="10"
                                placeholder="JJ/MM/AAAA"
                                class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', $academicYear->start_date?->format('d/m/Y')) }}">
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- end date --}}
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Date fin *</label>
                            <input type="text"
                                id="end_date"
                                name="end_date"
                                maxlength="10"
                                placeholder="JJ/MM/AAAA"
                                class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', $academicYear->end_date?->format('d/m/Y')) }}">
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
                                class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $academicYear->comment) }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-1 pt-3">
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

@endsection