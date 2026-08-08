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

                <form action="{{ $level->exists ? route('academic-years.levels.update', [$academicYear, $level]) : route('academic-years.levels.store', $academicYear) }}" method="POST">
                    @csrf

                    @if ($level->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-6">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="30"
                                required
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $level->name) }}">
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
                                value="{{ old('short_name', $level->short_name) }}">
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
                                value="{{ old('position', $level->position) }}">
                            @error('position')
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
                                class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $level->comment) }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-1 pt-3">
                        <a href="{{ route('academic-years.levels.index', $academicYear) }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                    </div>

                </form>

                <div class="text-muted small">
                    <x-created-updated-by :model="$level" />
                </div>

            </div>
        </div>
    </div>
</div>


@endsection