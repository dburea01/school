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

                <form action="{{ $subject->exists ? route('subjects.update', $subject) : route('subjects.store') }}" method="POST">
                    @csrf

                    @if ($subject->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- is_active --}}
                        <div class="col-md-7">

                            <div class="form-check form-switch d-flex align-items-center gap-2 p-0">
                                <!-- Champ caché pour envoyer 0 si décoché -->
                                <input type="hidden" name="is_active" value="0">

                                <input class="form-check-input m-0 ms-0 float-none"
                                    type="checkbox"
                                    role="switch"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    style="cursor: pointer;"
                                    @checked(old('is_active', $subject->is_active ?? true))>

                                <label class="form-check-label mb-0 user-select-none" for="is_active" style="cursor: pointer;">
                                    Matière active
                                </label>
                            </div>
                            @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- name --}}
                        <div class="col-6">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="30"
                                required
                                class="form-control form-control-sm @error('name') is-invalid @enderror text-capitalize"
                                value="{{ old('name', $subject->name) }}">
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
                                maxlength="10"
                                required
                                class="form-control form-control-sm @error('short_name') is-invalid @enderror text-uppercase"
                                value="{{ old('short_name', $subject->short_name) }}">
                            @error('short_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- color --}}
                        <div class="col-2">
                            <label for="color" class="form-label">Couleur</label>
                            <input type="color"
                                id="color"
                                name="color"
                                class="form-control form-control-sm @error('color') is-invalid @enderror"
                                value="{{ old('color', $subject->color) }}">
                            @error('color')
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
                                class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $subject->comment) }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-1 pt-3">



                        <a href="{{ route('subjects.index') }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                    </div>

                </form>

                <div class="text-muted small">
                    <x-created-updated-by :model="$subject" />
                </div>

            </div>
        </div>
    </div>
</div>

@endsection