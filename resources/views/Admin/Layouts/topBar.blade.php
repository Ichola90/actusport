@php
if(Auth::guard('web')->check()) {
// Admin connecté
$logoRoute = route('dashboard');
} elseif(Auth::guard('collaborateur')->check()) {
// Collaborateur connecté
$logoRoute = route('mercato');
} else {
// Utilisateur invité ou autre guard
$logoRoute = route('home');
}
@endphp
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header border-end">

            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href={{ route('dashboard') }}>
                <a class="navbar-brand" href="{{ $logoRoute }}">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <img src="{{ asset('assets/img/logo/logoif.png') }}" class="dark-logo" style="width: 50px; height: 50px;" />
                        <img src="{{ asset('assets/img/logo/logoif.png') }}" class="light-logo" style="width: 50px; height: 50px;" />
                    </b>
                    <span class="logo-text" style="font-size: 20px; font-weight: bold; color: #ffffff;">
                        Infoflashsports
                    </span>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                        class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                        href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu fs-5"></i></a>
                </li>
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                            class="fs-5 mdi mdi-gmail"></i>
                        <div class="notify">
                            <span class="heartbit"></span>
                            <span class="point"></span>
                        </div>
                    </a>
                    <div class="dropdown-menu mailbox dropdown-menu-start dropdown-menu-animate-up" aria-labelledby="2">
                        <ul class="list-style-none">
                            <li>
                                <div class="border-bottom rounded-top py-3 px-4">
                                    <div class="mb-0 font-weight-medium fs-4">You have 4 new messages</div>
                                </div>
                            </li>
                            <li>
                                <div class="message-center message-body position-relative" style="height:230px;">
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img
                                                src="{{ asset('assets/images/users/1.jpg') }}" alt="user"
                                                class="rounded-circle w-100"> <span
                                                class="profile-status rounded-circle online"></span> </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Pavan kumar</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate fw-normal mt-1">Just
                                                see
                                                the my admin!</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img
                                                src="{{ asset('../assets/images/users/2.jpg') }}" alt="user"
                                                class="rounded-circle w-100"> <span
                                                class="profile-status rounded-circle busy"></span> </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Sonu Nigam</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate">I've sung
                                                a song! See you at</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:10 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img
                                                src="{{ asset('../assets/images/users/3.jpg') }}" alt="user"
                                                class="rounded-circle w-100"> <span
                                                class="profile-status rounded-circle away"></span> </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Arijit Sinh</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate">I am a
                                                singer!</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:08 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img
                                                src="{{ asset('../assets/images/users/4.jpg') }}" alt="user"
                                                class="rounded-circle w-100"> <span
                                                class="profile-status rounded-circle offline"></span> </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Pavan kumar</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate">Just see
                                                the my admin!</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link border-top text-center text-dark pt-3" href="javascript:void(0);">
                                    <b>See all e-Mails</b> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                            class="mdi mdi-check-circle fs-5"></i>
                        <div class="notify">
                            <span class="heartbit"></span>
                            <span class="point"></span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-start mailbox dropdown-menu-animate-up">
                        <ul class="list-style-none">
                            <li>
                                <div class="border-bottom rounded-top py-3 px-4">
                                    <div class="mb-0 font-weight-medium fs-4">Notifications</div>
                                </div>
                            </li>
                            <li>
                                <div class="message-center notifications position-relative" style="height:230px;">
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-light-danger text-danger btn-circle">
                                            <i data-feather="link" class="feather-sm fill-white"></i>
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Luanch Admin</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">Just
                                                see
                                                the my new admin!</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-light-success text-success btn-circle">
                                            <i data-feather="calendar" class="feather-sm fill-white"></i>
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Event today</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">Just
                                                a
                                                reminder that you have event</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:10 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-light-info text-info btn-circle">
                                            <i data-feather="settings" class="feather-sm fill-white"></i>
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Settings</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">You
                                                can
                                                customize this template as you want</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:08 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-light-primary text-primary btn-circle">
                                            <i data-feather="users" class="feather-sm fill-white"></i>
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Pavan kumar</h5> <span
                                                class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">Just
                                                see
                                                the my admin!</span> <span
                                                class="fs-2 text-nowrap d-block subtext text-muted">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link border-top text-center text-dark pt-3" href="javascript:void(0);">
                                    <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- mega menu -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End mega menu -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item search-box">
                    <form class="app-search d-none d-lg-block">
                        <input type="text" class="form-control" placeholder="Search...">
                        <a href="" class="active"><i class="fa fa-search"></i></a>
                    </form>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user" class="rounded-circle"
                            width="36">
                        @if(Auth::guard('web')->check())
                        <span class="ms-2 font-weight-medium">{{ Auth::guard('web')->user()->nom }}</span>
                        @elseif(Auth::guard('collaborateur')->check())
                        <span class="ms-2 font-weight-medium">{{ Auth::guard('collaborateur')->user()->nom }}</span>
                        @endif
                        <span class="fas fa-angle-down ms-2"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                        <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                            <div class=""><img src="{{ asset('assets/images/users/1.jpg') }}" alt="user"
                                    class="rounded-circle" width="60"></div>
                            <div class="ms-2">
                                @if(Auth::guard('web')->check())
                                <h4 class="mb-0 text-white">{{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</h4>
                                <p class="mb-0">{{ Auth::guard('web')->user()->email }}</p>
                                @elseif(Auth::guard('collaborateur')->check())
                                <h4 class="mb-0 text-white">{{ Auth::guard('collaborateur')->user()->nom }} {{ Auth::guard('collaborateur')->user()->prenom }}</h4>
                                <p class="mb-0">{{ Auth::guard('collaborateur')->user()->email }}</p>
                                @endif
                            </div>

                        </div>
                        <a class="dropdown-item" href="{{ route('profile.show') }}"><i data-feather="user"
                                class="feather-sm text-info me-1 ms-1"></i> Mon
                            Profile</a>


                        <form action="{{ route('logout') }}" method="get">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="log-out"
                                    class="feather-sm text-danger me-1 ms-1"></i> Déconnexion</a>
                        </form>
                        <div class="dropdown-divider"></div>

                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>