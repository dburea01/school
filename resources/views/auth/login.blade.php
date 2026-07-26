@extends('layout')

@section('title', 'Connexion')

@section('content')


<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">

        <div class="text-center mb-4">
            <h1 class="h3 fw-bold mb-1">Connexion</h1>
            <p class="text-muted mb-0">Accédez à votre espace</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                @include('errors.messages-error-info')

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- email --}}
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
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Mot de passe
                        </label>

                        <input type="password"
                            id="password"
                            name="password"
                            required
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••">

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- remember --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                id="remember_me"
                                name="remember_me">

                            <label class="form-check-label" for="remember_me">
                                Rester connecté
                            </label>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg" type="submit" id="submit">
                            Connexion
                        </button>

                        <a href="{{ route('password-lost') }}"
                            class="text-center small text-decoration-none text-muted">
                            Mot de passe oublié ?
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <div class="col-12 col-md-6 col-lg-4">

        <div class="text-center mb-4">
            <h1 class="h3 fw-bold mb-1">Comptes de test</h1>
            <p class="text-muted mb-0">Mot de passe : password</p>
        </div>

        <div class="card border-warning shadow-sm">


            <div class="card-body">

                @php
                $admin = App\Models\User::where('role', 'ADMIN')->where('status', 'ACTIVE')->first();
                $director = App\Models\User::where('role', 'DIRECTOR')->where('status', 'ACTIVE')->first();
                $teacher = App\Models\User::where('role', 'TEACHER')->where('status', 'ACTIVE')->first();
                $parent = App\Models\User::where('role', 'PARENT')->where('status', 'ACTIVE')->first();
                $student = App\Models\User::where('role', 'STUDENT')->where('status', 'ACTIVE')->first();
                @endphp

                <div class="list-group">

                    @foreach([
                    'ADMIN' => $admin,
                    'DIRECTEUR' => $director,
                    'ENSEIGNANT' => $teacher,
                    'PARENT' => $parent,
                    'ECOLIER' => $student
                    ] as $label => $user)

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">{{ $label }}</div>
                            <div class="text-muted small">
                                {{ $user->email ?? 'unknown' }}
                            </div>
                        </div>

                        <button type="button"
                            class="btn btn-sm btn-outline-primary login"
                            data-email="{{ $user->email ?? '' }}">
                            Login
                        </button>
                    </div>

                    @endforeach

                </div>

            </div>
        </div>

    </div>
</div>




@endsection

@section('extra_js')
<script>
    $(document).ready(function() {

        $('.login').click(function() {
            let email = $(this).data('email');

            $('#email').val(email);
            $('#password').val('password');
            $('#submit').click();
        });

    });
</script>
@endsection