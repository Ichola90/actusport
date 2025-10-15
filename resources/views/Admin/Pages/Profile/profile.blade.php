@extends('Admin.Layouts.master')
@section('title', 'Dashboard - Profile')
@section('content')
@php
if(Auth::guard('web')->check()) {
    $user = Auth::guard('web')->user();
    $fullName = $user->name;
    $role = 'Administrateur';
} elseif(Auth::guard('collaborateur')->check()) {
    $user = Auth::guard('collaborateur')->user();
    $fullName = $user->prenom . ' ' . $user->nom;
    $role = 'Collaborateur';
} else {
    $user = null;
    $fullName = '';
    $role = '';
}

$email = old('email', $user->email ?? '');
$phone = $user->phone ?? '-';
$about = old('about', $user->about ?? '');
$photo = $user && $user->photo ? asset('assets/images/users/' . $user->photo) : asset('assets/images/users/1.jpg');
@endphp

<div class="preloader">
    <!-- SVG preloader -->
</div>

<div id="main-wrapper">
    <div class="page-wrapper">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb border-bottom">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-xs-12 d-flex align-items-center">
                    <h5 class="font-weight-bold text-uppercase mb-0">Mon profil</h5>
                </div>
                <div class="col-lg-9 col-md-8 col-xs-12 d-flex justify-content-md-end justify-content-start align-self-center">
                    <nav aria-label="breadcrumb" class="mt-2">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mon profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container-fluid page-content">
            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <img src="{{ $photo }}" class="rounded-circle mb-3" width="150" height="150" alt="Profile Image">
                            <h4 class="card-title">{{ $fullName }}</h4>
                            <h6 class="card-subtitle text-muted">{{ $role }}</h6>
                        </div>
                        <hr class="my-0">
                        <div class="card-body text-start">
                            <small class="text-muted">Email</small>
                            <h6>{{ $email }}</h6>

                            <small class="text-muted pt-4 db">Phone</small>
                            <h6>{{ $phone }}</h6>

                            <small class="text-muted pt-4 db">À propos</small>
                            <p>{{ $about ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Details & Settings -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card border-0 shadow-sm">
                        <ul class="nav nav-pills custom-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#profile-tab" role="tab" aria-controls="profile-tab" aria-selected="true">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-setting-tab" data-bs-toggle="pill" href="#settings-tab" role="tab" aria-controls="settings-tab" aria-selected="false">Paramètre</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Profile Tab -->
                            <div class="tab-pane fade show active" id="profile-tab" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3"><strong>Nom complet</strong>
                                            <p class="text-muted">{{ $fullName }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3"><strong>Email</strong>
                                            <p class="text-muted">{{ $email }}</p>
                                        </div>

                                        <div class="col-md-6 mb-3"><strong>Role</strong>
                                            <p class="text-muted">{{ $role }}</p>
                                        </div>
                                        <div class="col-12 mb-3"><strong>À propos</strong>
                                            <p class="text-muted">{{ $about ?: '-' }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <p>Bienvenue sur votre profil, vous pouvez mettre à jour vos informations dans l'onglet Paramètre.</p>
                                </div>
                            </div>

                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings-tab" role="tabpanel" aria-labelledby="pills-setting-tab">
                                <div class="card-body">
                                    <form class="form-horizontal form-material" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        @if(Auth::guard('collaborateur')->check())
                                            <div class="mb-3">
                                                <label>Prénom</label>
                                                <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" class="form-control form-control-line" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Nom</label>
                                                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="form-control form-control-line" required>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                <label>Nom complet</label>
                                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-line" required>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-line" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Password (laisser vide pour ne pas changer)</label>
                                            <input type="password" name="password" class="form-control form-control-line">
                                        </div>

                                        <div class="mb-3">
                                            <label>Confirmer Password</label>
                                            <input type="password" name="password_confirmation" class="form-control form-control-line">
                                        </div>

                                        <div class="mb-3">
                                            <label>Photo de profil</label>
                                            <input type="file" name="photo" class="form-control form-control-line">
                                        </div>

                                        <div class="mb-3">
                                            <label>À propos</label>
                                            <textarea name="about" rows="4" class="form-control form-control-line">{{ old('about', $user->about ?? '') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-success w-100">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Profile Details -->
            </div>
        </div>

        <footer class="footer text-center">
            &copy; {{ date('Y') }} - Tous droits réservés par <b>infoflashsport</b>.
            <p>Développé par Asoras</p>
        </footer>

    </div>
</div>
@endsection
