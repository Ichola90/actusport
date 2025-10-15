@extends('Admin.Layouts.master')
@section('title', 'Dashbord')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->


    <!-- -------------------------------------------------------------- -->
    <!-- Container fluid  -->
    <!-- -------------------------------------------------------------- -->
    <div class="container-fluid page-content">
        <!-- -------------------------------------------------------------- -->
        <!-- Start Page Content -->
        <!-- -------------------------------------------------------------- -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3">
                    <div class="border-bottom title-part-padding bg-light">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-newspaper-variant-outline"></i>Omnisport | Ajouter une Actualité
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store.omnisport') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Titre -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Titre de l’article</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Entrez le titre de l’article">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Image de couverture</label>

                                <!-- Boutons de sélection -->
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <!-- Choisir depuis la galerie -->
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                        <i class="mdi mdi-image-multiple"></i> Choisir depuis la galerie
                                    </button>

                                    <!-- Upload depuis l’ordinateur -->
                                    <label class="btn btn-outline-success mb-0">
                                        <i class="mdi mdi-upload"></i> Upload depuis l’ordinateur
                                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" hidden>
                                    </label>
                                </div>

                                <!-- Input caché pour stocker l’image sélectionnée depuis la galerie -->
                                <input type="hidden" name="existing_image" id="selectedImage">

                                <!-- Aperçu -->
                                <div class="mt-2">
                                    <img id="preview" src="#" alt="Aperçu de l'image"
                                        style="max-width: 200px; display: none;" class="img-thumbnail rounded">
                                </div>
                            </div>

                            <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Galerie d’images</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="gallerySearch" class="form-control mb-3" placeholder="Rechercher une image...">
                                            <div class="row" id="galleryImages" style="max-height: 500px; overflow-y: auto;"></div>
                                            <div id="loading" class="text-center my-3" style="display:none;">Chargement...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Contenu -->
                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Contenu</label>
                                <textarea name="content" id="editor" rows="8" class="form-control" placeholder="Écrivez votre article..."></textarea>
                                @error('content')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Mots-clés -->
                             <div class="mb-3 position-relative">
                                <label for="tags" class="form-label fw-bold">Mots-clés</label>
                                <input type="text"
                                    name="tags"
                                    id="tags"
                                    class="form-control"
                                    placeholder="Ex: PSG, Mbappé, Transfert"
                                    autocomplete="off">
                                <div id="tag-suggestions" class="list-group position-absolute w-100" style="z-index:2000; display:none;"></div>
                                <small class="text-muted">Séparez les mots-clés par des virgules.</small>
                            </div>
                            <!-- Date de publication -->
                            <div class="mb-3">
                                <label for="publish_at" class="form-label fw-bold">Programmer la publication</label>
                                <input type="datetime-local" name="publish_at" id="publish_at" class="form-control">
                                <small class="text-muted">Laissez vide pour publier immédiatement.</small>
                            </div>
                            <!-- Bouton -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="mdi mdi-check-circle-outline"></i> Publier
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- End Page Content -->
        <!-- -------------------------------------------------------------- -->
    </div>

    <!-- TinyMCE éditeur -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
             tinymce.init({
                selector: '#editor',
                height: 400,
                menubar: false,
                plugins: [
                    'lists', 'link', 'image', 'table', 'code', 'fullscreen', 'paste', 'media', 'advlist'
                ],
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | copybtn pastebtn cutbtn | code fullscreen',
                paste_as_text: false,
                paste_data_images: true,
                paste_auto_cleanup_on_paste: true,
                link_context_toolbar: false,
                selection_toolbar: false,
                contextmenu: 'link image table',

                // Mobile config
                mobile: {
                    menubar: false, // toolbar minimal
                    toolbar: 'undo redo | bold italic | bullist numlist | link image | copybtn pastebtn cutbtn',
                    height: 300,
                },

                setup: function(editor) {
                    // --- BOUTON "COLLER" ---
                    editor.ui.registry.addButton('pastebtn', {
                        text: '📋 Coller',
                        tooltip: 'Coller depuis le presse-papiers',
                        onAction: async function() {
                            try {
                                const text = await navigator.clipboard.readText();
                                if (text) editor.execCommand('mceInsertContent', false, text);
                            } catch (err) {
                                const fallback = prompt('Impossible d’accéder au presse-papiers. Collez ici :');
                                if (fallback !== null) editor.execCommand('mceInsertContent', false, fallback);
                            }
                        }
                    });

                    // --- BOUTON "COPIER" ---
                    editor.ui.registry.addButton('copybtn', {
                        text: '📄 Copier',
                        tooltip: 'Copier la sélection',
                        onAction: function() {
                            const selectedText = editor.selection.getContent({
                                format: 'text'
                            });
                            if (!selectedText) {
                                editor.notificationManager.open({
                                    text: 'Sélectionnez du texte',
                                    type: 'info'
                                });
                                return;
                            }
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(selectedText).then(() => {
                                    editor.notificationManager.open({
                                        text: 'Texte copié',
                                        type: 'success'
                                    });
                                }).catch(fallbackCopy);
                            } else fallbackCopy(selectedText);

                            function fallbackCopy(text) {
                                const ta = document.createElement('textarea');
                                ta.value = text;
                                document.body.appendChild(ta);
                                ta.select();
                                try {
                                    document.execCommand('copy');
                                    editor.notificationManager.open({
                                        text: 'Texte copié',
                                        type: 'success'
                                    });
                                } catch (e) {
                                    editor.notificationManager.open({
                                        text: 'Copie impossible',
                                        type: 'error'
                                    });
                                }
                                document.body.removeChild(ta);
                            }
                        }
                    });

                    // --- BOUTON "COUPER" ---
                    editor.ui.registry.addButton('cutbtn', {
                        text: '✂️ Couper',
                        tooltip: 'Couper la sélection',
                        onAction: function() {
                            const selectedText = editor.selection.getContent({
                                format: 'text'
                            });
                            if (!selectedText) {
                                editor.notificationManager.open({
                                    text: 'Sélectionnez du texte',
                                    type: 'info'
                                });
                                return;
                            }
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                navigator.clipboard.writeText(selectedText).then(() => {
                                    editor.execCommand('mceReplaceContent', false, '');
                                    editor.notificationManager.open({
                                        text: 'Texte coupé',
                                        type: 'success'
                                    });
                                }).catch(() => {
                                    editor.execCommand('mceReplaceContent', false, '');
                                    editor.notificationManager.open({
                                        text: 'Texte coupé (presse-papiers non accessible)',
                                        type: 'warning'
                                    });
                                });
                            } else {
                                editor.execCommand('mceReplaceContent', false, '');
                                editor.notificationManager.open({
                                    text: 'Texte coupé',
                                    type: 'success'
                                });
                            }
                        }
                    });

                    // Optionnel : focus automatique sur mobile
                    document.addEventListener('touchstart', function() {
                        if (!editor.hasFocus || !editor.hasFocus()) {
                            try {
                                editor.focus();
                            } catch (e) {}
                        }
                    }, {
                        passive: true
                    });
                }
            });
         });
    

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
                document.getElementById('preview').style.display = 'block';
                document.getElementById('selectedImage').value = '';
            }
        }

        let page = 1;
        let search = '';
        let loading = false;
        const container = document.getElementById('galleryImages');
        const loadingEl = document.getElementById('loading');

        function loadImages(reset = false) {
            if (loading) return;
            loading = true;
            loadingEl.style.display = 'block';

            if (reset) {
                page = 1;
                container.innerHTML = '';
            }

            fetch(`{{ route('medias.list') }}?page=${page}&search=${search}`)
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(media => {
                        const div = document.createElement('div');
                        div.className = 'col-3 mb-3 gallery-item';
                        div.innerHTML = `
                    <img src="{{ asset('') }}${media.path}" 
                    class="img-fluid img-thumbnail selectable-image"
                    style="width:100%; height:150px; object-fit:cover; cursor:pointer;"
                    data-path="${media.path}">

                `;
                        container.appendChild(div);
                    });

                    document.querySelectorAll('.selectable-image').forEach(img => {
                        img.addEventListener('click', function() {
                            document.getElementById('selectedImage').value = this.dataset.path;
                            document.getElementById('preview').src = this.src;
                            document.getElementById('preview').style.display = 'block';
                            bootstrap.Modal.getInstance(document.getElementById('galleryModal')).hide();
                        });
                    });

                    loading = false;
                    loadingEl.style.display = 'none';

                    if (data.next_page_url) {
                        page++;
                    } else {
                        container.dataset.end = 'true';
                    }
                });
        }

        // Recherche dynamique
        document.getElementById('gallerySearch').addEventListener('input', function() {
            search = this.value;
            container.dataset.end = 'false';
            loadImages(true);
        });

        // Scroll infini
        container.addEventListener('scroll', function() {
            if (container.dataset.end === 'true') return;
            if (container.scrollTop + container.clientHeight >= container.scrollHeight - 50) {
                loadImages();
            }
        });

        // Initial load
        loadImages();
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('tags');
            const box = document.getElementById('tag-suggestions');
            let items = []; // suggestions actuelles
            let active = -1;

            // Helper: afficher/masquer
            const showBox = () => {
                box.style.display = 'block';
            };
            const hideBox = () => {
                box.style.display = 'none';
                active = -1;
                box.innerHTML = '';
                items = [];
            };

            // Récupère la "dernière partie" (après la dernière virgule)
            function getLastPart(val) {
                const parts = val.split(',');
                return parts.pop().trim();
            }

            // Replace la dernière partie par 'tag' et ajoute ", "
            function insertTag(tag) {
                const parts = input.value.split(',');
                parts.pop(); // retire la dernière partie incomplète
                // Reconstitue en ignorant éléments vides
                const prefix = parts.map(p => p.trim()).filter(p => p.length).join(', ');
                const newVal = prefix ? (prefix + ', ' + tag + ', ') : (tag + ', ');
                input.value = newVal;
                input.focus();
                hideBox();
                // déclenche un event input pour que d'autres scripts réagissent si besoin
                input.dispatchEvent(new Event('input'));
            }

            // Render des suggestions
            function render(data) {
                box.innerHTML = '';
                active = -1;
                items = data;

                data.forEach((tag, index) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action';
                    btn.textContent = tag;
                    // click / touch
                    btn.addEventListener('click', () => insertTag(tag));
                    btn.addEventListener('touchstart', () => insertTag(tag), {
                        passive: true
                    });
                    box.appendChild(btn);
                });

                // bouton fermer
                const closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'list-group-item list-group-item-action text-center text-muted';
                closeBtn.textContent = 'Fermer ✕';
                closeBtn.addEventListener('click', hideBox);
                box.appendChild(closeBtn);

                showBox();
            }

            // Keyboard navigation (flèches + Entrée + Echap)
            input.addEventListener('keydown', function(e) {
                if (box.style.display === 'none') return;

                const len = box.children.length;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    active = (active + 1) % len;
                    updateActive();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    active = (active - 1 + len) % len;
                    updateActive();
                } else if (e.key === 'Enter') {
                    // si une suggestion active, la sélectionner
                    if (active >= 0 && active < len) {
                        e.preventDefault();
                        box.children[active].click();
                    }
                } else if (e.key === 'Escape') {
                    hideBox();
                }
            });

            function updateActive() {
                for (let i = 0; i < box.children.length; i++) {
                    box.children[i].classList.toggle('active', i === active);
                    if (i === active) {
                        // scroll into view
                        box.children[i].scrollIntoView({
                            block: 'nearest'
                        });
                    }
                }
            }

            // Requête serveur (débounce)
            let timer = null;
            input.addEventListener('input', function() {
                const raw = input.value;
                const last = getLastPart(raw);
                if (!last || last.length < 1) {
                    hideBox();
                    return;
                }

                // Debounce 250ms
                if (timer) clearTimeout(timer);
                timer = setTimeout(() => {
                    fetch("{{ route('tags.suggestions') }}?q=" + encodeURIComponent(last))
                        .then(resp => resp.json())
                        .then(json => {
                            // on attend un tableau de strings
                            if (!Array.isArray(json) || json.length === 0) {
                                hideBox();
                                return;
                            }
                            // Filtre local: on n'affiche pas le tag si identique à la partie en cours
                            const filtered = json
                                .map(s => String(s).trim())
                                .filter(s => s.length && s.toLowerCase().includes(last.toLowerCase()));
                            if (filtered.length) render(filtered);
                            else hideBox();
                        })
                        .catch(err => {
                            // console.error(err);
                            hideBox();
                        });
                }, 180);
            });

            // Clic en dehors => cacher
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !box.contains(e.target)) hideBox();
            });

            // Touch outside (mobile)
            document.addEventListener('touchstart', function(e) {
                if (!input.contains(e.target) && !box.contains(e.target)) hideBox();
            }, {
                passive: true
            });
        });
    </script>



    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        &copy; {{ date('Y') }} - Tous droits réservés par <b>infoflashsport</b>.
        <p>développé par Asoras</p>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
@endsection