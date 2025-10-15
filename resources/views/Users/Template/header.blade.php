<style>
    .logo-img {
        height: 60px;
        width: 100px;
    }

    #navmenu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    #navmenu ul li {
        position: relative;
    }

    /* Supprimer la flèche Bootstrap générée automatiquement */
    .nav-link.dropdown-toggle::after {
        display: none !important;
    }

    #navmenu ul li a {
        text-decoration: none;
        padding: 8px 12px;
        display: block;
        color: inherit;
    }



    #navmenu .dropdown-menu {
        display: none;
        /* Toujours caché par défaut */
        position: absolute;
        top: 100%;
        left: 0;
        padding: 10px 0;
        border-radius: 4px;
        min-width: 180px;
        background: #fff;
        /* important sur desktop */
        z-index: 100;
    }

    /* Active dropdown item */
    .dropdown-menu .dropdown-item.active,
    .dropdown-menu .dropdown-item:active {
        background-color: #7ed957 !important;
        color: #fff !important;
    }

    /* Active main link */
    #navmenu ul li a.active {
        color: #7ed957;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Responsive mobile */
    @media (max-width: 991px) {
        #navmenu ul {
            flex-direction: column;
            gap: 0;
        }

        #navmenu .dropdown-menu {
            position: static;
            padding-left: 15px;
            border: none;
            box-shadow: none;
        }

        /* Toggle class 'show' pour afficher/masquer menu mobile */
        #navmenu .dropdown-menu.show {
            display: block;
        }
    }

    /* Style flèche dropdown */
    .dropdown-arrow {
        display: inline-block;
        margin-left: 5px;
        transition: transform 0.3s ease;
        font-size: 0.8rem;
    }

    /* Quand le menu est ouvert */
    .dropdown-menu.show~.dropdown-arrow,
    .nav-link.active .dropdown-arrow {
        transform: rotate(180deg);
        /* flèche vers le haut */
    }

    #navmenu .dropdown-menu.show {
        display: block;
        /* affiché quand JS ajoute la classe */
    }

    .nav-link.dropdown-toggle {
        cursor: pointer;
        /* indique que c'est cliquable */
    }

    #header nav a {
        text-decoration: none;
        transition: color 0.2s;
    }

    #header nav a:hover {
        color: #006400;

    }

    /* Style de base */
    .nav-link-custom {
        color: white !important;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    /* Hover */
    .nav-link-custom:hover {
        background-color: #28a745;
        /* vert bootstrap */
        color: white !important;
    }

    /* Active (page en cours) */
    .nav-link-custom.active {
        background-color: #1e7e34;
        /* vert plus foncé */
        color: white !important;
    }

    #searchResults {
        position: absolute;
        background: white;
        width: 100%;
        z-index: 2000;
        max-height: 400px;
        /* plus haut pour plus de résultats */
        overflow-y: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #searchResults a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    #searchResults a:hover {
        background-color: #f0f0f0;
    }

    #searchResults .close-btn {
        display: block;
        text-align: right;
        padding: 4px 8px;
        font-weight: bold;
        cursor: pointer;
        color: #888;
    }

    #searchResults .close-btn:hover {
        color: #000;
    }
</style>

<header id="header">



    <!-- Bandeau jaune -->
    <div style="background: #FCD116; padding: 2px;">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- Hamburger -->
            <button class="navbar-toggler border-0 d-xl-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>

            <a href="{{ route('home') }}" class="d-flex flex-column align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo/logoif.png') }}" alt="ActuSport Logo" style="height:70px;">
                <span class="fw-bold" style="font-size: 16px; color: black;">InfoFlashSports</span>
            </a>


            <div class="search-box d-flex align-items-center">
                <!-- Bouton icône -->
                <button class="btn" id="searchToggle"
                    style="background-color: #008751; color:#fff; border:none; outline:none;">
                    <i class="bi bi-search fs-5"></i>
                </button>

                <!-- Champ de recherche masqué -->
                <form action="{{ route('search.results') }}" method="GET" class="ms-2 d-none flex-grow-1" id="searchForm">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control"
                            placeholder="Rechercher..." style="border-radius: 20px 0 0 20px;">
                        <button class="btn" type="submit"
                            style="background-color:#008751; color:#fff; border-radius:0 20px 20px 0;">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Menu principal -->
    <nav class="bg-success">
        <div class="container">
            <div id="navmenu" class="collapse navbar-collapse d-xl-flex">
                <ul class="navbar-nav d-flex flex-column flex-xl-row gap-3 text-center py-2 text-uppercase fw-bold">
                    <li><a href="{{ route('home') }}" class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-custom {{ request()->routeIs('show.mercato') || request()->routeIs('show.mercatoafrique') ? 'active' : '' }}" href="#" id="mercatoDropdown">
                            Mercato <span class="dropdown-arrow">▼</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-bold text-uppercase" href="{{ route('show.mercato') }}">Europe</a></li>
                            <li><a class="dropdown-item fw-bold text-uppercase" href="{{ route('show.mercatoafrique') }}">Afrique</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-custom {{ request()->routeIs('show.actuafrique') || request()->routeIs('show.actueurope') ? 'active' : '' }}" href="#" id="actusDropdown">
                            ActusSport <span class="dropdown-arrow">▼</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-bold text-uppercase" href="{{ route('show.actuafrique') }}">Afrique</a></li>
                            <li><a class="dropdown-item fw-bold text-uppercase" href="{{ route('show.actueurope') }}">Europe</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('show.omnisport') }}" class="nav-link-custom {{ request()->routeIs('show.omnisport') ? 'active' : '' }}">Omnisport</a></li>
                    <li><a href="{{ route('show.wags') }}" class="nav-link-custom {{ request()->routeIs('show.wags') ? 'active' : '' }}">Wags</a></li>
                    <li><a href="{{ route('show.celebrites') }}" class="nav-link-custom {{ request()->routeIs('show.celebrites') ? 'active' : '' }}">Célébrités Sportives</a></li>
                    <li><a href="{{ route('show.contact') }}" class="nav-link-custom {{ request()->routeIs('show.contact') ? 'active' : '' }}">Contact</a></li>
                </ul>

            </div>

        </div>
    </nav>


    <!-- Bandeau vert (mobile uniquement, scrollable) -->


</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggles = document.querySelectorAll('#navmenu .dropdown > .nav-link');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const dropdownMenu = this.nextElementSibling;

                // Si déjà ouvert → fermer
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    this.classList.remove('active'); // enlève la flèche vers le haut
                    return;
                }

                // Fermer les autres
                document.querySelectorAll('#navmenu .dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.previousElementSibling.classList.remove('active'); // remet flèche vers le bas
                });

                // Ouvrir celui-ci
                dropdownMenu.classList.add('show');
                this.classList.add('active'); // flèche vers le haut
            });
        });

        // Clic en dehors → tout ferme
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#navmenu')) {
                document.querySelectorAll('#navmenu .dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.previousElementSibling.classList.remove('active'); //  remet flèche vers le bas
                });
            }
        });
    });
    const searchToggle = document.getElementById("searchToggle");
    const searchForm = document.getElementById("searchForm");

    // Quand on clique sur la loupe → cacher la loupe, afficher le champ
    searchToggle.addEventListener("click", function() {
        searchToggle.classList.add("d-none"); // cache la loupe
        searchForm.classList.remove("d-none"); // affiche le champ
    });

    // Quand on envoie le formulaire → cacher le champ, remettre la loupe
    searchForm.addEventListener("submit", function() {
        setTimeout(() => {
            searchForm.classList.add("d-none");
            searchToggle.classList.remove("d-none");
        }, 300);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector("#searchForm input[name='q']");
        const searchForm = document.getElementById("searchForm");

        // Conteneur des résultats
        const resultsBox = document.createElement("div");
        resultsBox.setAttribute("id", "searchResults");
        resultsBox.style.display = "none"; // caché par défaut
        searchForm.style.position = "relative"; // pour que resultsBox soit bien positionné
        searchForm.appendChild(resultsBox);

        // Fonction pour afficher les résultats
        function showResults(data) {
            resultsBox.innerHTML = "";

            // Bouton fermer
            const closeBtn = document.createElement("span");
            closeBtn.classList.add("close-btn");
            closeBtn.innerHTML = "✖";
            closeBtn.onclick = () => resultsBox.style.display = "none";
            resultsBox.appendChild(closeBtn);

            if (data.length === 0) {
                const p = document.createElement("p");
                p.classList.add("p-2");
                p.textContent = "Aucun résultat trouvé";
                resultsBox.appendChild(p);
            } else {
                data.forEach(item => {
                    const a = document.createElement("a");
                    a.href = item.url; // URL complète générée côté backend
                    a.innerHTML = `<strong>[${item.type.toUpperCase()}]</strong> ${item.title}`;
                    a.classList.add("d-block", "p-2", "border-bottom", "text-dark", "text-decoration-none");
                    resultsBox.appendChild(a);
                });


                // Lien voir tous les résultats
                const aMore = document.createElement("a");
                aMore.href = "{{ route('search.results') }}?q=" + encodeURIComponent(searchInput.value);
                aMore.classList.add("bg-light", "text-center", "text-success", "fw-bold");
                aMore.style.display = "block";
                aMore.style.padding = "8px 12px";
                aMore.textContent = "Voir tous les résultats";
                resultsBox.appendChild(aMore);
            }

            resultsBox.style.display = "block";
        }

        // Événement keyup
        searchInput.addEventListener("keyup", function() {
            const query = this.value;

            if (query.length < 2) {
                resultsBox.style.display = "none";
                return;
            }

            fetch("{{ route('search.ajax') }}?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    resultsBox.innerHTML = "";

                    // Bouton fermer
                    const closeBtn = document.createElement("span");
                    closeBtn.classList.add("close-btn");
                    closeBtn.innerHTML = "✖";
                    closeBtn.onclick = () => resultsBox.style.display = "none";
                    resultsBox.appendChild(closeBtn);

                    if (data.length === 0) {
                        const p = document.createElement("p");
                        p.classList.add("p-2");
                        p.textContent = "Aucun résultat trouvé";
                        resultsBox.appendChild(p);
                    } else {
                        data.forEach(item => {
                            const a = document.createElement("a");
                            a.href = item.url; // maintenant toujours défini
                            a.innerHTML = `<strong>[${item.type.toUpperCase()}]</strong> ${item.title}`;
                            a.classList.add("d-block", "p-2", "border-bottom", "text-dark", "text-decoration-none");
                            resultsBox.appendChild(a);
                        });

                        // Voir tous les résultats
                        const aMore = document.createElement("a");
                        aMore.href = "{{ route('search.results') }}?q=" + encodeURIComponent(searchInput.value);
                        aMore.classList.add("bg-light", "text-center", "text-success", "fw-bold");
                        aMore.style.display = "block";
                        aMore.style.padding = "8px 12px";
                        aMore.textContent = "Voir tous les résultats";
                        resultsBox.appendChild(aMore);
                    }

                    resultsBox.style.display = "block";
                });
        });

    });
</script>