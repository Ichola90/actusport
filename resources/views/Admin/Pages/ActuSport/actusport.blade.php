@extends('Admin.Layouts.master')
@section('title','Dashboard - ActuSport')
@section('content')

<style>
    .clickable-image:hover {
        transform: scale(1.2);
        transition: 0.3s;
    }
</style>

<div class="page-wrapper" style="font-family: 'Lora', serif;">

    <!-- ============================================================== -->
    <!-- Bread crumb -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb border-bottom">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 d-flex align-items-center">
                <h5 class="font-weight-bold text-uppercase mb-0">ActusSport</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 d-flex justify-content-md-end justify-content-start align-self-center">
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ActusSport</li>
                    </ol>
                </nav>
                <a href="{{ route('add.actus') }}"
                    class="btn btn-danger text-white ms-3 d-block d-md-block"
                    style="font-size: 16px;">
                    <i class="mdi mdi-plus-circle"></i> Ajouter un actualité
                </a>

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
                        <h4 class="card-title mb-0 text-center text-uppercase">Liste des actualités Sportifs (Europe / Afrique )</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="mercato_table" class="table table-striped table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Titre</th>
                                        <th>Image</th>
                                        <th>Contenu</th>
                                        <th>Mots-clés</th>
                                        <th>Categorie</th>
                                        <th>Status</th>
                                        <th>Date de création</th>
                                        <th>Commentaires</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actualites as $actualite)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="font-size: 20px;">
                                            <h4>{{ Str::limit(strip_tags($actualite->title), 20) }}</h4>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($actualite->image)
                                            <img src="{{ asset($actualite->image) }}" alt="{{ $actualite->title }}"
                                                class="rounded shadow-sm clickable-image"
                                                style="width: 60px; height: auto; cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $actualite->id }}">

                                            <!-- Modal image -->
                                            <div class="modal fade" id="imageModal{{ $actualite->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-body d-flex justify-content-center align-items-center p-0">
                                                        <img src="{{ asset($actualite->image) }}" alt="{{ $actualite->title }}"
                                                            class="img-fluid rounded" style="max-height: 90vh; width: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-muted">Pas d'image</span>
                                            @endif
                                        </td>

                                        <style>
                                            .clickable-image:hover {
                                                transform: scale(1.2);
                                                transition: 0.3s;
                                            }
                                        </style>

                                        <td>{!! Str::limit(strip_tags(html_entity_decode($actualite->content)), 50) !!}</td>
                                        <td>{{ $actualite->tags }}</td>
                                        <td>{{ $actualite->category }}</td>
                                        <td>
                                            @if($actualite->publish_at && \Carbon\Carbon::parse($actualite->publish_at)->isFuture())
                                            <span class="badge bg-warning">
                                                Programmé pour : {{ \Carbon\Carbon::parse($actualite->publish_at)->format('d/m/Y H:i') }}
                                            </span>
                                            @else
                                            <span class="badge bg-success">Publié</span>
                                            @endif
                                        </td>
                                        <td>{{ $actualite->created_at->format('d/m/Y') }}</td>

                                        <!-- Nombre de commentaires et bouton pour les voir -->
                                        <td>
                                            {{ $actualite->comments->count() }}
                                            @if($actualite->comments->count() > 0)
                                            <button class="btn btn-sm btn-info ms-2 ml-8" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $actualite->id }}">
                                                <i class="mdi mdi-eye"></i>
                                            </button>

                                            <!-- Modal des commentaires -->
                                            <div class="modal fade" id="commentsModal{{ $actualite->id }}" tabindex="-1" aria-labelledby="commentsModalLabel{{ $actualite->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                    <div class="modal-content border-0 shadow-lg">
                                                        <!-- Header -->
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title" id="commentsModalLabel{{ $actualite->id }}">
                                                                Commentaires de "{{ Str::limit($actualite->title, 30) }}"
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Body avec DataTable -->
                                                        <div class="modal-body p-3">
                                                            <div class="table-responsive">
                                                                <table id="viewsTable{{ $actualite->id }}" class="table table-striped table-bordered table-hover align-middle">
                                                                    <thead class="">
                                                                        <tr>
                                                                            <th style="color:black;">#</th>
                                                                            <th style="color:black;">Nom</th>
                                                                            <th style="color:black;">Email</th>
                                                                            <th style="color:black;">Commentaire</th>
                                                                            <th style="color:black;">Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($actualite->comments as $index => $comment)
                                                                        <tr>
                                                                            <td>{{ $index + 1 }}</td>
                                                                            <td>{{ $comment->name }}</td>
                                                                            <td>{{ $comment->email }}</td>
                                                                            <td>{{ $comment->comment }}</td>

                                                                            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @push('scripts')
                                            <script>
                                                $(document).ready(function() {
                                                    // Initialiser le DataTable pour chaque modal individuellement
                                                    $('#viewsTable{{ $actualite->id }}').DataTable({
                                                        pageLength: 10,
                                                        lengthMenu: [5, 10, 25, 50],
                                                        order: [
                                                            [4, 'desc']
                                                        ], // trier par date
                                                        language: {
                                                            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                                                        },
                                                        responsive: true
                                                    });

                                                    // Ajuster les colonnes à l'ouverture du modal
                                                    $('#commentsModal{{ $actualite->id }}').on('shown.bs.modal', function() {
                                                        $('#viewsTable{{ $actualite->id }}').DataTable().columns.adjust().draw();
                                                    });
                                                });
                                            </script>
                                            @endpush

                                            @endif
                                        </td>

                                        <td>
                                            <!-- Bouton Éditer -->
                                            <button class="btn btn-sm btn-warning me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $actualite->id }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>

                                            <!-- Bouton Supprimer -->
                                            <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $actualite->id }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>

                                            <!-- Bouton Voir l'article -->
                                            <a href="{{ route('actuafrique.detail', $actualite->slug) }}" target="_blank"
                                                class="btn btn-sm btn-secondary">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Titre</th>
                                        <th>Image</th>
                                        <th>Contenu</th>
                                        <th>Mots-clés</th>
                                        <th>Categorie</th>
                                        <th>Status</th>
                                        <th>Date de création</th>
                                        <th>Commentaires</th>
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

    @foreach($actualites as $actualite)

    <!-- Modal Éditer -->
    <div class="modal fade" id="editModal{{ $actualite->id }}" tabindex="-1" aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white bg-primary">
                    <h5 class="modal-title">Modifier l’article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('actus.update', $actualite->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control" value="{{ $actualite->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($actualite->image)
                            <img src="{{ asset($actualite->image) }}" class="mt-2 rounded shadow-sm" width="100">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contenu</label>
                            <textarea id="editor-{{ $actualite->id }}" name="content" class="form-control editor" rows="10" required>{!! old('content', $actualite->content) !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select name="category" class="form-select">
                                <option value="Europe" {{ $actualite->category=='Europe' ? 'selected' : '' }}>Europe</option>
                                <option value="Afrique" {{ $actualite->category=='Afrique' ? 'selected' : '' }}>Afrique</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mots-clés</label>
                            <input type="text" name="tags" class="form-control" value="{{ $actualite->tags }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Programmer la publication</label>
                            <input type="datetime-local" name="publish_at" class="form-control"
                                value="{{ $actualite->publish_at ? \Carbon\Carbon::parse($actualite->publish_at)->format('Y-m-d\TH:i') : '' }}">
                            <small class="text-muted">Laissez vide pour publier immédiatement.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Supprimer -->
    <div class="modal fade" id="deleteModal{{ $actualite->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('actus.destroy', $actualite->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer <b>{{ $actualite->title }}</b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach


    <!-- TinyMCE (une seule fois, après la boucle) -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea.editor',
                height: 380,
                menubar: false,
                plugins: 'lists link image table code fullscreen',
                toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright | link image table | code fullscreen',
                branding: false,
                link_context_toolbar: true,
                link_default_target: '_blank',
                link_assume_external_targets: 'https'
            });
        });
    </script>




    <!-- Modal Aperçu Image -->
    @if($actualite->image)
    <div class="modal fade" id="imageModal{{ $actualite->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-body d-flex justify-content-center align-items-center p-0">
                <img src="{{ asset($actualite->image) }}"
                    alt="{{ $actualite->title }}"
                    class="img-fluid rounded"
                    style="max-height: 90vh; width: auto; width: 600px; height: 600px;">
            </div>
        </div>
    </div>
    @endif



    @endsection
    <!-- -------------------------------------------------------------- -->