@extends('Admin.Layouts.master')
@section('title', 'Dashboard - Mercato')
@section('content')

<style>
  .clickable-image:hover {
    transform: scale(1.2);
    transition: 0.3s;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }
</style>

<div class="page-wrapper" style="font-family: 'Lora', serif;">

  <!-- ============================================================== -->
  <!-- Bread crumb -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb border-bottom">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-xs-12 d-flex align-items-center">
        <h5 class="font-weight-bold text-uppercase mb-0">Omnisport</h5>
      </div>
      <div class="col-lg-9 col-md-8 col-xs-12 d-flex justify-content-md-end justify-content-start align-self-center">
        <nav aria-label="breadcrumb" class="mt-2">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Collaborateur</li>
          </ol>
        </nav>
        <a href="#" class="btn btn-danger text-white ms-3 d-none d-md-block"
          style="font-size: 16px;"
          data-bs-toggle="modal"
          data-bs-target="#addCollaborateurModal">
          <i class="mdi mdi-plus-circle"></i> Ajouter un collaborateur
        </a>
      </div>
    </div>
  </div>

  <!-- Modal Ajouter Collaborateur -->
  <div class="modal fade" id="addCollaborateurModal" tabindex="-1" aria-labelledby="addCollaborateurLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="addCollaborateurLabel">Ajouter un collaborateur</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" name="prenom" id="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Adresse Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-danger">Créer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ============================================================== -->
  <!-- Container fluid -->
  <!-- ============================================================== -->
  <div class="container-fluid page-content">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-lg border-0">
          <div class="border-bottom title-part-padding bg-light">
            <h4 class="card-title mb-0 text-center text-uppercase">Liste des Collaborateurs</h4>
          </div>
          <div class="card-body">

            <div class="table-responsive">
              <table id="mercato_table" class="table table-hover table-striped table-bordered text-center align-middle shadow-sm">
                <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>

                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($collaborateurs as $index => $collaborateur)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-size: 18px; font-weight:bold;">{{ $collaborateur->nom }}</td>
                    <td>{{ $collaborateur->prenom }}</td>
                    <td>{{ $collaborateur->email }}</td>
                    <td>
                      <!-- Bouton Éditer -->
                      <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $collaborateur->id }}">
                        <i class="mdi mdi-pencil"></i>
                      </button>

                      <!-- Bouton Supprimer (ouvre modal) -->
                      <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                        data-bs-target="#deleteModal{{ $collaborateur->id }}">
                        <i class="mdi mdi-delete"></i>
                      </button>

                      <!-- Suspendre / Activer -->
                      @if($collaborateur->is_active)
                      <form action="{{ route('admin.users.suspend', $collaborateur) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-secondary">Suspendre</button>
                      </form>
                      @else
                      <form action="{{ route('admin.users.activate', $collaborateur) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Activer</button>
                      </form>
                      @endif
                    </td>
                  </tr>

                  <!-- Modal Éditer -->
                  <div class="modal fade" id="editModal{{ $collaborateur->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content shadow-lg">
                        <div class="modal-header bg-warning">
                          <h5 class="modal-title">Modifier {{ $collaborateur->nom }} {{ $collaborateur->prenom }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.users.update', $collaborateur) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-body">
                            <div class="mb-3">
                              <label class="form-label">Nom</label>
                              <input type="text" name="nom" class="form-control" value="{{ $collaborateur->nom }}" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Prénom</label>
                              <input type="text" name="prenom" class="form-control" value="{{ $collaborateur->prenom }}" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" value="{{ $collaborateur->email }}" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Mot de passe (laisser vide si inchangé)</label>
                              <input type="password" name="password" class="form-control">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-warning">Mettre à jour</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Modal Supprimer -->
                  <div class="modal fade" id="deleteModal{{ $collaborateur->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content shadow-lg">
                        <div class="modal-header bg-danger text-white">
                          <h5 class="modal-title">Confirmer la suppression</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <p>Êtes-vous sûr de vouloir supprimer <b>{{ $collaborateur->nom }} {{ $collaborateur->prenom }}</b> ?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                          <form action="{{ route('admin.users.destroy', $collaborateur) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Supprimer</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </tbody>
                <tfoot class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>

                    <th>Actions</th>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================== -->
  <!-- footer -->
  <!-- ============================================================== -->
  <footer class="footer text-center">
    &copy; {{ date('Y') }} - Tous droits réservés par <b>infoflashsport</b>.
    <p>développé par Asoras</p>
  </footer>
</div>
@endsection