@extends('Admin.Layouts.master')
@section('title', 'Dashboard - Wags')
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
                    <h5 class="font-weight-bold text-uppercase mb-0">Abonnés</h5>
                </div>
                <div
                    class="col-lg-9 col-md-8 col-xs-12 d-flex justify-content-md-end justify-content-start align-self-center">
                    <nav aria-label="breadcrumb" class="mt-2">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('show.subscribe') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mes abonnés</li>
                        </ol>
                    </nav>

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
                            <h4 class="card-title mb-0 text-center text-uppercase">Liste des articles Wags</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="mercato_table"
                                    class="table table-striped table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="text-align: center;">Numéro</th>
                                            <th style="text-align: center;">Adresse Email</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscribers as $subscribe)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="font-size: 20px;">
                                                    <h4>{{ Str::limit(strip_tags($subscribe->email), 20) }}<h4>
                                                </td>
                                              
                                                <style>
                                                    .clickable-image:hover {
                                                        transform: scale(1.2);
                                                        transition: 0.3s;
                                                    }
                                                </style>



                                                 
                                            </tr>

                                           
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th style="text-align: center;">Numéro</th>
                                            <th style="text-align: center;">Adresse Email</th>
                                            
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
