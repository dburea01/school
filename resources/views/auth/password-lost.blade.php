@extends('layout')

@section('title', 'Mot de passe perdu')

@section('content')



<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">

        <div class="text-center mb-4">
            <h1 class="h3 fw-bold mb-1">Mot de passe oublié (@todo)</h1>
            <p class="text-muted mb-0">Recevez un lien de réinitialisation</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                @include('errors.messages-error-info')

                <p class="text-muted small mb-4">
                    Saisissez votre adresse email. Nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>

                <form action="{{ route('password-lost') }}" method="POST">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Adresse email
                        </label>

                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="nom@exemple.com">

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg" id="submit">
                            Envoyer le lien
                        </button>

                        <a href="{{ route('login') }}"
                            class="text-center small text-decoration-none text-muted">
                            Retour à la connexion
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>



@endsection