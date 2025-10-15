<style>
    .sidebar-link:hover {
        background-color: #0056b3 !important;
        color: white;
    }
</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(Auth::guard('web')->check())
                <li class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link waves-effect waves-dark"
                        aria-expanded="false">
                        <i class="mdi mdi-av-timer"></i>
                        <span class="hide-menu">Tableau de bord</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="#ecommerceMenu"
                        data-bs-toggle="collapse"
                        aria-expanded="false"
                        aria-controls="ecommerceMenu">
                        <i class="mdi mdi-format-color-fill"></i>
                        <span class="hide-menu">Actualité</span>
                    </a>

                    <ul id="ecommerceMenu" class="collapse first-level" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{ route('mercato') }}" class="sidebar-link">
                                <i class="mdi mdi-cards-variant"></i>
                                <span class="hide-menu">Mercato</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('show.actu') }}" class="sidebar-link">
                                <i class="mdi mdi-cards-outline"></i>
                                <span class="hide-menu">ActusSport</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('omnisports') }}" class="sidebar-link">
                                <i class="mdi mdi-cart-plus"></i>
                                <span class="hide-menu">Omnisport</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('wags') }}" class="sidebar-link">
                                <i class="mdi mdi-camera-burst"></i>
                                <span class="hide-menu">Wags</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('celebrites') }}" class="sidebar-link">
                                <i class="mdi mdi-chart-pie"></i>
                                <span class="hide-menu">Célébrités</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(Auth::guard('web')->check())
                <li class="sidebar-item">
                    <a href="{{ route('show.subscribe') }}" class="sidebar-link">
                        <i class="mdi mdi-chart-pie"></i>
                        <span class="hide-menu">Abonnés</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Mes collaborateurs</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-item">
                    <a href="{{ route('profile.show') }}" class="sidebar-link">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Mon profile</span>
                    </a>
                </li>
            </ul>
            <li class="sidebar-item mt-4">
                <a href="/" target="_blank" class="sidebar-link d-flex align-items-center"
                    style="background-color: #007bff; color: white; font-weight: 600; padding: 0.7rem 1rem; transition: all 0.3s; font-size: 16px; font-family: 'lora';">
                    <i class="mdi mdi-home mdi-24px"></i>
                    <span class="hide-menu ms-2">VOIR LE SITE</span>
                </a>
            </li>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>