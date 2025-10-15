@extends('Admin.Layouts.master')
@section('title','Articles du mois - ActuSport')

@section('content')

<style>
    .clickable-image:hover {
        transform: scale(1.2);
        transition: 0.3s;
    }
</style>

<div class="page-wrapper" style="font-family: 'Lora', serif;">
    <!-- ============================================================= -->
    <!-- En-tête -->
    <!-- ============================================================= -->
    <div class="page-breadcrumb border-bottom">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 d-flex align-items-center">
                <h5 class="font-weight-bold text-uppercase mb-0">
                    Articles publiés en {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F Y') }}
                </h5>
            </div>
            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary ms-3">
                    <i class="mdi mdi-arrow-left"></i> Retour au Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- Tableau -->
    <!-- ============================================================= -->
    <div class="container-fluid page-content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="border-bottom title-part-padding bg-light">
                        <h4 class="card-title mb-0 text-center text-uppercase">
                            Liste des articles publiés en {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>Image</th>
                                        <th>Catégorie</th>
                                        <th>Source</th>
                                        <th>Vues 👁️</th>
                                        <th>Date de création</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actualites as $actualite)
                                    <tr>
                                        <td>{{ $loop->iteration + ($actualites->currentPage() - 1) * $actualites->perPage() }}</td>
                                        <td style="font-size: 16px;">
                                            <strong>{{ Str::limit(strip_tags($actualite->title), 60) }}</strong>
                                        </td>
                                        <td>
                                            @if($actualite->image)
                                                <img src="{{ asset($actualite->image) }}"
                                                     alt="{{ $actualite->title }}"
                                                     class="rounded shadow-sm clickable-image"
                                                     style="width: 60px; height: 60px; cursor: pointer;"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal{{ $actualite->id }}">
                                            @else
                                                <span class="text-muted">Aucune</span>
                                            @endif
                                        </td>
                                        <td>{{ $actualite->category ?? 'N/A' }}</td>
                                        <td><span class="badge bg-primary">{{ $actualite->source }}</span></td>
                                        <td><strong>{{ number_format($actualite->views ?? 0, 0, ',', ' ') }}</strong></td>
                                        <td>{{ $actualite->created_at ? $actualite->created_at->format('d/m/Y') : '-' }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $actualites->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- Footer -->
    <!-- ============================================================= -->
    <footer class="footer text-center">
        &copy; {{ date('Y') }} - Tous droits réservés par <b>infoflashsport</b>.
        <p>Développé par Asoras</p>
    </footer>
</div>
@endsection
