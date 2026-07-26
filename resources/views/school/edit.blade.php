@extends('layout')

@section('title', 'Modifier école')

@section('content')


<div class="row justify-content-center">
    <div class="col-12 col-lg-9">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <div>
                <h1 class="h3 fw-bold mb-1">Modifier l'école</h1>
                <p class="text-muted mb-0">Mettez à jour les informations de l'établissement</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                @include('errors.messages-error-info')

                <form action="{{ route('school.update', $school) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-12">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text"
                                id="name"
                                name="name"
                                maxlength="50"
                                required
                                autocomplete="organization"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $school->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-12">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea
                                id="address"
                                name="address"
                                maxlength="100"
                                rows="2"
                                autocomplete="street-address"
                                class="form-control form-control-sm @error('address') is-invalid @enderror">{{ old('address', $school->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Postal code --}}
                        <div class="col-md-3">
                            <label for="postal_code" class="form-label">Code postal *</label>
                            <input type="text"
                                id="postal_code"
                                name="postal_code"
                                maxlength="5"
                                inputmode="numeric"
                                required
                                autocomplete="postal-code"
                                class="form-control form-control-sm @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code', $school->postal_code) }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <label for="city" class="form-label">Ville *</label>
                            <input type="text"
                                id="city"
                                name="city"
                                maxlength="50"
                                required
                                autocomplete="address-level2"
                                class="form-control form-control-sm text-uppercase @error('city') is-invalid @enderror"
                                value="{{ old('city', $school->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Country --}}
                        <div class="col-md-3">
                            <label for="country_id" class="form-label">Pays *</label>
                            <input type="text"
                                id="country_id"
                                name="country_id"
                                maxlength="2"
                                required
                                autocomplete="country"
                                class="form-control form-control-sm text-uppercase @error('country_id') is-invalid @enderror"
                                value="{{ old('country_id', $school->country_id) }}">
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                    </div>

                </form>

                <div class="mt-4 pt-2 border-top text-muted small">
                    <x-created-updated-by :model="$school" />
                </div>

            </div>
        </div>
    </div>
</div>

@endsection