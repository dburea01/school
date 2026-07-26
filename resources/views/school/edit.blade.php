@extends('layout')

@section('title', 'Modifier école')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">

            {{-- HEADER --}}
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Modifier école</h1>
                <p class="text-muted mb-0">
                    Mettez à jour les informations de l'école
                </p>
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    @include('errors.messages-error-info')

                    <form action="{{ route('school.update', $school) }}" method="POST">
                        @method('PUT')
                        @csrf

                        {{-- name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="50"
                                required
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $school->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea
                                id="address"
                                name="address"
                                maxlength="100"
                                rows="3"
                                class="form-control @error('address') is-invalid @enderror">{{ old('address', $school->address) }}
                            </textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- postal code --}}
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Code postal *</label>
                            <input type="text"
                                id="postal_code"
                                name="postal_code"
                                maxlength="5"
                                required
                                class="form-control @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code', $school->postal_code) }}">
                            @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- city --}}
                        <div class="mb-3">
                            <label for="city" class="form-label">Ville *</label>
                            <input type="text"
                                id="city"
                                name="city"
                                maxlength="50"
                                required
                                class="form-control text-uppercase @error('city') is-invalid @enderror"
                                value="{{ old('city', $school->city) }}">
                            @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- country --}}
                        <div class="mb-3">
                            <label for="country_id" class="form-label">Pays *</label>
                            <input type="text"
                                id="country_id"
                                name="country_id"
                                maxlength="2"
                                required
                                class="form-control @error('country_id') is-invalid @enderror"
                                value="{{ old('country_id', $school->country_id) }}">
                            @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- submit --}}
                        <div class="d-grid mt-4">
                            <button class="btn btn-success btn-lg" type="submit" id="submit">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <x-created-updated-by :model="$school" />
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection