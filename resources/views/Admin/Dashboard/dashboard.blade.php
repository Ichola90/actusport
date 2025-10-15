@extends('Admin.Layouts.master')
@section('title','Dashbord')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb border-bottom">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 justify-content-start d-flex align-items-center">
                <h5 class="font-weight-medium text-uppercase mb-0">Tableau de bord</h5>
            </div>
            <div
                class="col-lg-9 col-md-8 col-xs-12 d-flex justify-content-start justify-content-md-end align-self-center">
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Card Group  -->
        <!-- ============================================================== -->

        <div class="card-group">
            <!-- Total Articles -->
            <div class="card p-2 p-lg-3">
                <div class="p-lg-3 p-2">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-circle btn-danger text-white btn-lg">
                            <i class="ti-clipboard"></i>
                        </button>
                        <div class="ms-4" style="width: 38%;">
                            <h4 class="fw-normal">Total des articles</h4>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <h2 class="display-7 mb-0">{{ $totalArticles }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Views -->
            <div class="card p-2 p-lg-3">
                <div class="p-lg-3 p-2">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-circle btn-cyan text-white btn-lg">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="ms-4" style="width: 38%;">
                            <h4 class="fw-normal">Total des vues</h4>
                            <div class="progress">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="ms-auto d-flex align-items-center">
                            <h2 class="display-7 mb-0 me-3">{{ $totalViews }}</h2>

                            <!-- Bouton détail -->

                            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewsModal">
                                <i class="fas fa-list"></i> Détails
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="viewsModal" tabindex="-1" aria-labelledby="viewsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="viewsModalLabel">
                                    <i class="fas fa-chart-bar"></i> Détail des vues par article
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <table id="viewsTable" class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Article</th>
                                            <th>Catégorie</th>
                                            <th>Vues</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewsByArticles as $article)
                                        <tr>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ ucfirst($article->type) }}</td>
                                            <td>{{ $article->views }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                        var table = $('#viewsTable').DataTable({
                                            pageLength: 10,
                                            lengthMenu: [5, 10, 25, 50, 100],
                                            order: [
                                                [2, 'desc']
                                            ],
                                            language: {
                                                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                                            }
                                        });

                                        $('#viewsModal').on('shown.bs.modal', function() {
                                            table.columns.adjust().draw();
                                        });
                                    });
                                </script>
                                @endpush

                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <!-- Total Subscribers -->
            <div class="card p-2 p-lg-3">
                <div class="p-lg-3 p-2">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-circle btn-warning text-white btn-lg">
                            <i class="fas fa-users"></i>
                        </button>
                        <div class="ms-4" style="width: 38%;">
                            <h4 class="fw-normal">Total des abonnés</h4>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <h2 class="display-7 mb-0">{{ $totalSubscribers }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Products yearly sales, Weather Cards Section  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="d-flex align-items-stretch col-lg-8">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-md-flex align-items-center">
                            <h5 class="card-title">Articles publiés pars mois</h5>
                            <ul class="list-inline dl mb-0 ms-auto">
                                <!-- <li class="list-inline-item text-danger"><i class="fa fa-circle"></i> Mac</li> -->
                                <li class="list-inline-item text-info"><i class="fa fa-circle"></i> Articles publiés</li>
                            </ul>
                        </div>
                        <div id="products-yearly-sales"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-stretch col-lg-4">
                <div class="card w-100 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-danger text-white text-center">
                        <h4 class="mb-0">Articles publiés par semaine</h4>
                        <small class="fw-light">Répartition des publications (Lundi → Dimanche)</small>
                    </div>
                    <div class="card-body">

                        <div id="week-sales" class="mx-auto" style="height: 300px; width: 300px;"></div>
                    </div>

                </div>

            </div>

        </div>

        <!-- ============================================================== -->
        <!-- Manage Table & Walet Cards Section  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- User Table & Profile Cards Section  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Derniers articles publiés</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-bordered mb-0 shadow-sm">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Contenu</th>
                                    <th scope="col">Date de publication</th>
                                    <th scope="col">Auteur</th>
                                    <th scope="col">Catégorie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($articles as $index => $article)
                                <tr>
                                    <!-- ID -->
                                    <td>{{ $loop->iteration }}</td>

                                    <!-- Titre -->
                                    <td>
                                        <h6 class="mb-1">{{ $article->title ?? 'Sans titre' }}</h6>

                                    </td>

                                    <!-- Contenu -->
                                    <td>{!! Str::limit(strip_tags($article->content), 50) !!}</td>


                                    <!-- Date -->
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            Publié le {{ $article->created_at->format('d M Y') }}
                                        </span>
                                    </td>

                                    <!-- Auteur -->
                                    <td>
                                        <span class="fw-medium">{{ $article->author->name}}</span><br>

                                    </td>

                                    <!-- Catégorie -->
                                    <td>
                                        <span class="badge rounded-pill bg-info text-white px-3 py-2">
                                            {{ ucfirst($article->type) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        <p class="mb-0">
            &copy; <strong>infoflashsport</strong>. Tous droits réservés. <br>
            développé par <strong>Asoras</strong>
        </p>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->

  <script>
document.addEventListener("DOMContentLoaded", function() {
    // === GRAPH 1 : Articles publiés par mois (année en cours) ===
    var monthlyData = @json(array_values($monthlyArticles));
    var monthlyLabels = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"];

    var monthlyChart = new ApexCharts(document.querySelector("#products-yearly-sales"), {
        chart: {
            type: 'bar',
            height: 300,
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    // Récupérer le mois cliqué (index + 1 car index = 0 => janvier)
                    var month = config.dataPointIndex + 1;

                    // Redirection via la route nommée Laravel
                    var url = "{{ route('articles.byMonth', ':month') }}".replace(':month', month);
                    window.location.href = url;
                }
            }
        },
        series: [{
            name: "Articles publiés",
            data: monthlyData
        }],
        xaxis: {
            categories: monthlyLabels
        },
        colors: ['#007bff'],
        plotOptions: {
            bar: {
                columnWidth: '50%',
                borderRadius: 6
            }
        },
        dataLabels: {
            enabled: true
        }
    });

    monthlyChart.render();

    // === GRAPH 2 : Articles publiés par jour de la semaine ===
    var weekData = @json(array_values($weekSales)); // nombre d'articles par jour
    var weekLabels = @json(array_keys($weekSales)); // jours de la semaine en anglais

    // Traduction des jours en français et ajout du nombre devant
    var joursFrancais = {
        'Monday': 'Lundi',
        'Tuesday': 'Mardi',
        'Wednesday': 'Mercredi',
        'Thursday': 'Jeudi',
        'Friday': 'Vendredi',
        'Saturday': 'Samedi',
        'Sunday': 'Dimanche'
    };

    var weekLabelsFR = weekLabels.map((day, i) => {
        var labelFR = joursFrancais[day] || day;
        return `${weekData[i]} - ${labelFR}`; // ex: "5 - Lundi"
    });

    var weekChart = new ApexCharts(document.querySelector("#week-sales"), {
        chart: {
            type: 'donut',
            height: 220
        },
        series: weekData,       // nombre d’articles
        labels: weekLabelsFR,   // labels français avec nombres
        colors: ['#ff4757', '#ffa502', '#2ed573', '#1e90ff', '#3742fa', '#70a1ff', '#5352ed'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true
        }
    });

    weekChart.render();
});
</script>




</div>

@endsection
