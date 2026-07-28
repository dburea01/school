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

                <form action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" method="POST">
                    @csrf

                    @if ($user->exists)
                    @method('PUT')
                    @endif

                    <div class="row g-3">

                        {{-- last name --}}
                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Nom *</label>
                            <input type="text"
                                id="last_name"
                                name="last_name"
                                maxlength="50"
                                required
                                @readonly($readonly)
                                class="form-control form-control-sm text-uppercase @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name', $user->last_name) }}">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- first name --}}
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">Prénom *</label>
                            <input type="text"
                                id="first_name"
                                name="first_name"
                                maxlength="50"
                                required
                                @readonly($readonly)
                                class="form-control form-control-sm text-capitalize @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name', $user->first_name) }}">
                            @error('first_name')
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
                                @readonly($readonly)
                                class="form-control form-control-sm @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
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

                                required
                                @readonly($readonly)
                                class="form-control form-control-sm @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code', $user->postal_code) }}">
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
                                @readonly($readonly)
                                class="form-control form-control-sm text-uppercase @error('city') is-invalid @enderror"
                                value="{{ old('city', $user->city) }}">
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
                                @readonly($readonly)
                                class="form-control form-control-sm text-uppercase @error('country_id') is-invalid @enderror"
                                value="{{ old('country_id', $user->country_id) }}">
                            @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        @if(! $readonly)
                        <button class="btn btn-success btn-sm px-4" type="submit" id="submit">
                            Sauvegarder
                        </button>
                        @endif
                    </div>

                </form>

                <div class="mt-4 pt-2 border-top text-muted small">
                    <x-created-updated-by :model="$user" />
                </div>

            </div>
        </div>
    </div>
</div>

@endsection