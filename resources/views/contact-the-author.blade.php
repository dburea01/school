@extends('layout')

@section('title', 'Contacter l\'auteur')

@section('content')

<div class="row">
    <div class="col-md-8 mx-auto">
        @include('errors.messages-error-info')
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header text-center">Contacter l'auteur</div>
            <div class="card-body">

                <p class="text-center">Vous souhaitez contacter l'auteur pour une nouvelle fonctionnalité ? pour participer à la conception de SCHOOL ? Ca se passe ici. Petits mots d'encouragement sont également les bienvenus ;-)</p>
                
                <form action="/contact-the-author" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <x-honeypot />

                    {{-- your name --}}
                    <div class="row mb-3">
                        <label for="name" class="col-sm-4 col-form-label col-form-label-sm text-truncate text-sm-end">
                            Votre nom : *
                        </label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" required name="name" id="name" maxlength="60" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- your email --}}
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label col-form-label-sm text-truncate text-sm-end">
                            Votre email : *
                        </label>

                        <div class="col-sm-8">
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" required name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- your message --}}
                    <div class="row mb-3">
                        <label for="message" class="col-sm-4 col-form-label col-form-label-sm text-truncate text-sm-end">
                            Votre message : *
                        </label>

                        <div class="col-sm-8">
                            <textarea rows="5" maxlength="1000" class="form-control @error('message') is-invalid @enderror" required name="message"
                                id="message">{{ old('message') }}</textarea>
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- submit button --}}
                    <div class="row mb-3">
                        <div class="col-sm-8 offset-sm-4 d-grid gap-2 d-block">
                            <button type="submit" class="btn btn-success btn-block">Envoyer <i class="bi bi-send">&nbsp;</i></button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

@endsection