@extends('layout')

@section('title', 'Accueil')

@section('content')


<div class="container py-5">

  <!-- HERO SECTION : Présentation de la Démo -->
  <section class="row align-items-center mb-5 pb-4 border-bottom">
    <div class="col-lg-7">
      <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-3">
        <i class="bi bi-play-circle-fill me-1"></i> Version Démo
      </span>
      <h1 class="display-4 fw-bold lh-1 mb-3">
        La gestion d'école, <span class="text-primary">simplifiée</span> et prête à l'emploi.
      </h1>
      <p class="lead text-secondary mb-4">
        Découvrez une application légère, intuitive et pleinement opérationnelle pour gérer facilement les élèves, les classes, les notes et les présences sans inutile complexité.
      </p>
      <div class="d-flex flex-wrap gap-3">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">
          <i class="bi bi-box-arrow-up-right me-2"></i> Tester la démo
        </a>
        
      </div>
    </div>
    <div class="col-lg-5 mt-4 mt-lg-0 text-center">
      <!-- Illustration / Aperçu visuel -->
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden bg-light p-4">
        <div class="p-4 bg-primary bg-opacity-10 rounded-3 border border-primary-subtle">
          <i class="bi bi-mortarboard display-1 text-primary"></i>
          <h5 class="mt-3 fw-bold text-dark">SchoolApp Demo</h5>
          <p class="small text-muted mb-0">Gestion globale des élèves, cours & emplois du temps.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- OPEN SOURCE & GITHUB -->
  <section class="row align-items-center bg-light rounded-4 p-4 p-md-5 mx-0 border mb-5">
    <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
      <i class="bi bi-github display-3 text-dark"></i>
    </div>
    <div class="col-md-7">
      <h3 class="fw-bold mb-1">Projet 100% Open Source</h3>
      <p class="text-muted mb-0">
        Le code source est entièrement accessible à tous. Vous pouvez explorer le projet, remonter des issues ou contribuer directement à son évolution.
      </p>
    </div>
    <div class="col-md-3 text-md-end mt-3 mt-md-0">
      <a href="https://github.com/dburea01/school" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-lg w-100">
        <i class="bi bi-github me-2"></i> Voir sur GitHub
      </a>
    </div>
  </section>

  <!-- APERÇU FONCTIONNEL -->
  <section class="mb-5 py-3">
    <div class="row text-center mb-4">
      <div class="col-md-8 mx-auto">
        <h2 class="fw-bold">Une base solide et fonctionnelle</h2>
        <p class="text-muted">Tout ce dont un établissement a besoin pour démarrer immédiatement.</p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3 text-center">
          <div class="card-body">
            <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 mx-auto d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
              <i class="bi bi-people-fill fs-3"></i>
            </div>
            <h5 class="fw-bold">Gestion des Éleves & Classes</h5>
            <p class="text-muted small">Inscriptions, fiches élèves, répartition par niveaux et suivi administratif simple.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3 text-center">
          <div class="card-body">
            <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 mx-auto d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
              <i class="bi bi-journal-check fs-3"></i>
            </div>
            <h5 class="fw-bold">Notes & Appréciations</h5>
            <p class="text-muted small">Saisie rapide des notes, suivi du contrôle continu et génération des récapitulatifs.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-3 text-center">
          <div class="card-body">
            <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 mx-auto d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
              <i class="bi bi-calendar-week fs-3"></i>
            </div>
            <h5 class="fw-bold">Présences & Emploi du temps</h5>
            <p class="text-muted small">Appel quotidien en un clic, gestion des retards et vision claire de l'agenda.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CALL TO ACTION : APPEL À PRODUCT OWNER -->
  <section id="po-call" class="mb-5">
    <div class="card bg-dark text-white rounded-4 p-4 p-md-5 shadow">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <span class="badge bg-warning text-dark fw-bold mb-3">
            <i class="bi bi-lightbulb-fill me-1"></i> Collaboration
          </span>
          <h2 class="fw-bold mb-3">Recherche de Product Owner (PO) / Co-pilote</h2>
          <p class="lead text-light opacity-75 mb-4">
            Le socle technique est prêt et fonctionnel ! Je cherche désormais un <strong>Product Owner</strong> passionné pour guider la vision du produit, définir les fonctionnalités prioritaires et rédiger les User Stories.
          </p>
          <ul class="list-unstyled mb-4">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Structurer la roadmap fonctionnelle</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Rédiger et ordonner le backlog / User Stories</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Apporter une expertise métier (éducation / gestion)</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Tester l'appli</li>
          </ul>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <a href="{{ route('contact-the-author') }}" class="btn btn-warning btn-lg fw-bold w-100 py-3">
            <i class="bi bi-envelope-fill me-2"></i> Me contacter
          </a>
        </div>
      </div>
    </div>
  </section>

  

</div>


@endsection