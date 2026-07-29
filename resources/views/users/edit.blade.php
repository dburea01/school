@extends('layout')

@section('title', $pageTitle)

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-9">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $pageTitle }}</h1>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-2">

                @include('errors.messages-error-info')

                <form action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($user->exists)
                    @method('PUT')
                    @endif

                    <!-- SECTION 1 : IDENTITÉ & RÔLE -->
                    <fieldset class="mb-3">
                        <legend class="h6 fw-bold text-primary border-bottom pb-1 mb-1">
                            Identité & Rôle
                        </legend>

                        <div class="row g-1">
                            {{-- role --}}
                            <div class="col-md-4">
                                <label for="role" class="form-label">Rôle *</label>
                                <x-select-user-role name="role"
                                    id="role"
                                    class="form-select form-select-sm"
                                    :disabled="$readonly"
                                    :value="old('role', $user->role->value)" />
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- last name --}}
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text"
                                    id="last_name"
                                    name="last_name"
                                    maxlength="100"
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

                            {{-- gender --}}
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Genre</label>
                                <x-select-user-gender name="gender"
                                    id="gender"
                                    class="form-select form-select-sm"
                                    :disabled="$readonly"
                                    :value="old('gender', $user->gender?->value)" />
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- birth_date --}}
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">Date naissance</label>
                                <input type="text"
                                    id="birth_date"
                                    name="birth_date"
                                    maxlength="10"
                                    placeholder="JJ/MM/AAAA"
                                    @readonly($readonly)
                                    class="form-control form-control-sm @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date', $user->birth_date?->format('d/m/Y')) }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- the photo --}}
                    <fieldset class="mb-3">
                        <legend class="h6 fw-bold text-primary border-bottom pb-1 mb-2">
                            Photo
                        </legend>

                        <div class="d-flex align-items-center gap-3">
                            {{-- Conteneur carré rigide 100x100 avec masque circulaire --}}
                            <div class="rounded-circle border shadow-sm overflow-hidden flex-shrink-0" style="width: 50px; height: 50px;">
                                <img id="photo-preview" src="{{ $user->photo_url ?? asset('img/default-avatar.svg') }}"
                                    alt="Photo de {{ $user->first_name }}"
                                    class="w-100 h-100"
                                    style="object-fit: cover;">
                            </div>

                            @if(! $readonly)
                            <div class="flex-grow-1" style="max-width: 400px;">
                                <label for="photo" class="form-label small text-muted mb-1">Choisir une image</label>
                                <input type="file"
                                    id="photo"
                                    name="photo"
                                    accept="image/png, image/jpeg, image/webp"
                                    class="form-control form-control-sm @error('photo') is-invalid @enderror"
                                    onchange="previewPhoto(this)">
                                @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </fieldset>

                    <!-- SECTION 3 : ADRESSE POSTALE -->
                    <fieldset class="mb-3">
                        <legend class="h6 fw-bold text-primary border-bottom pb-1 mb-1">
                            Adresse postale
                        </legend>

                        <div class="row g-1">
                            {{-- Address --}}
                            <div class="col-12">
                                <label for="address" class="form-label">Adresse *</label>
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
                            <div class="col-md-4">
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
                            <div class="col-md-8">
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
                        </div>
                    </fieldset>

                    <!-- SECTION 4 : CONTACT & REMARQUES -->
                    <fieldset class="mb-3">
                        <legend class="h6 fw-bold text-primary border-bottom pb-1 mb-1">
                            Contact & Remarques
                        </legend>

                        <div class="row g-1">
                            {{-- email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse mail</label>
                                <input type="email"
                                    id="email"
                                    name="email"
                                    @readonly($readonly)
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- phone number --}}
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Téléphone</label>
                                <input type="tel"
                                    id="phone_number"
                                    name="phone_number"
                                    max="25"
                                    @readonly($readonly)
                                    class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number', $user->phone_number) }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Comment --}}
                            <div class="col-12">
                                <label for="comment" class="form-label">Commentaire</label>
                                <textarea
                                    id="comment"
                                    name="comment"
                                    maxlength="100"
                                    rows="2"
                                    @readonly($readonly)
                                    class="form-control form-control-sm @error('comment') is-invalid @enderror">{{ old('comment', $user->comment) }}</textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm border">
                            Annuler
                        </a>
                        @if(! $readonly)
                        <button class="btn btn-success btn-sm px-4" type="submit" id="btn-submit">
                            Sauvegarder
                        </button>
                        @endif
                    </div>

                </form>

                <div class="text-muted small">
                    <x-created-updated-by :model="$user" />
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Doublons -->
<div class="modal fade" id="duplicateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title fw-bold text-warning-emphasis">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Doublon potentiel détecté
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-content-body p-3">
                <p class="small text-muted mb-2">Des utilisateurs existants ressemblent aux informations saisies :</p>
                <ul id="duplicate-list" class="list-group list-group-flush border rounded mb-3 small">
                    <!-- Rempli en JS -->
                </ul>
                <p class="small mb-0">Voulez-vous quand même enregistrer cet utilisateur ?</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Modifier la saisie</button>
                <button type="button" id="btn-force-submit" class="btn btn-sm btn-warning">Forcer l'enregistrement</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('extra_js')
<script>
    function previewPhoto(input) {
        const [file] = input.files;
        if (file) {
            const preview = document.getElementById('photo-preview');
            preview.src = URL.createObjectURL(file);
        }
    }


    $(document).ready(function() {
        const duplicateModal = new bootstrap.Modal('#duplicateModal');
        const $btnSubmit = $('#btn-submit');
        const originalBtnText = $btnSubmit.html(); // Sauvegarde le texte d'origine "Sauvegarder"

        // Fonction pour activer / désactiver le loader
        function toggleSubmitLoading(isLoading) {
            if (isLoading) {
                $btnSubmit.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Vérification...
            `);
            } else {
                $btnSubmit.prop('disabled', false).html(originalBtnText);
            }
        }

        $('form').on('submit', function(e) {
            const $form = $(this);

            if ($form.data('checked')) return;

            e.preventDefault();

            // 1. On passe le bouton en état "chargement"
            toggleSubmitLoading(true);

            const lastName = $('#last_name').val();
            const firstName = $('#first_name').val();
            const userId = "{{ $user->id ?? '' }}";

            if (!lastName && !firstName) {
                $form[0].submit();
                return;
            }

            // Appel AJAX
            $.get("{{ route('users.check-duplicates') }}", {
                    last_name: lastName,
                    first_name: firstName,
                    ignore_id: userId
                })
                .done(function(duplicates) {
                    if (duplicates.data.length > 0) {
                        // Il y a des doublons : on remet le bouton normal et on affiche la modal
                        toggleSubmitLoading(false);

                        let htmlList = '';
                        $.each(duplicates.data, function(i, u) {
                            htmlList += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${u.last_name} ${u.first_name}</strong> 
                                <span class="text-muted">(${u.city ?? 'Ville N/C'})</span>
                            </div>
                            <a href="/users/${u.id}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-1">Voir</a>
                        </li>
                    `;
                        });

                        $('#duplicate-list').html(htmlList);
                        duplicateModal.show();
                    } else {
                        // 0 doublon : On change juste le texte pendant que la page recharge/soumet
                        $btnSubmit.html(`
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Enregistrement...
                `);

                        $form.data('checked', true);
                        $form[0].submit();
                    }
                })
                .fail(function() {
                    // En cas d'erreur de l'API, on laisse le spinner et on tente la soumission
                    $form[0].submit();
                });
        });

        // Clic sur "Forcer l'enregistrement" dans la modal
        $('#btn-force-submit').on('click', function() {
            // Désactive le bouton de la modal pour éviter le double clic
            $(this).prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Enregistrement...
        `);

            $('form')[0].submit();
        });
    });
</script>
@endsection