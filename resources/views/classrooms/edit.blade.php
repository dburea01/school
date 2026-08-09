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

                <form action="{{ $classroom->exists ? route('academic-years.classrooms.update', [$academicYear, $classroom]) : route('academic-years.classrooms.store', $academicYear) }}" method="POST">
                    @csrf

                    @if ($classroom->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-4">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="30"
                                required
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $classroom->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- short name --}}
                        <div class="col-2">
                            <label for="short_name" class="form-label">Nom court *</label>
                            <input type="text"
                                id="short_name"
                                name="short_name"
                                maxlength="5"
                                required
                                class="form-control form-control-sm @error('short_name') is-invalid @enderror"
                                value="{{ old('short_name', $classroom->short_name) }}">
                            @error('short_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- user_id --}}
                        <div class="col-6">
                            <label for="user_id" class="form-label">Professeur principal</label>
                            <x-select-user
                                id="user_id"
                                name="user_id"
                                class="form-select form-select-sm"
                                role="TEACHER"
                                :value="old('user_id', $classroom->user_id)"
                            />

                            @error('user_id')
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
                                class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $classroom->comment) }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-1 pt-3">
                        <a href="{{ route('academic-years.classrooms.index', $academicYear) }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                    </div>

                </form>

                <div class="text-muted small">
                    <x-created-updated-by :model="$classroom" />
                </div>

            </div>
        </div>
    </div>
</div>


@endsection