<!DOCTYPE html>
<html lang="en">
<style>
  * {
    font-family: 'Lora', serif;
  }

  .whatsapp-float {
    position: fixed;
    bottom: 20px;
    left: 20px;
    width: 55px;
    height: 55px;
    background-color: #25D366;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .whatsapp-float:hover {
    transform: scale(1.1);
    box-shadow: 2px 4px 12px rgba(0, 0, 0, 0.3);
    color: #fff;
  }

  /* Structure générale */
  .blog-item {
    position: relative;
    /* important pour overlay */
    overflow: hidden;
  }

  /* Inner wrapper si besoin */
  .blog-item .blog-inner {
    position: relative;
  }

  /* Thumb: définit la hauteur du visuel et rend l'image "cover" */
  .blog-thumb {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    /* moderne et responsive */
    overflow: hidden;
    display: block;
  }

  .blog-thumb img {
    position: absolute;
    inset: 0;
    /* top:0; right:0; bottom:0; left:0; */
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    /* centrage vertical/horizontal */
    display: block;
  }

  /* Overlay: couvre tout le <article> (image + zone visuelle) */
  .blog-item::after {
    content: "";
    position: absolute;
    inset: 0;
    /* top:0; right:0; bottom:0; left:0; */
    pointer-events: none;
    z-index: 1;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.25) 0%, rgba(0, 0, 0, 0.6) 100%);
  }

  /* Texte au-dessus de l'overlay */
  .blog-item .blog-content {
    position: relative;
    z-index: 2;
    color: #fff;
    /* si tu veux le texte en blanc pour contraste */
  }

  /* Si tu veux le featured plus grand dans une grille : */
  .blog-item.featured {
    /* selon ton grid, tu peux faire span 2 colonnes */
    /* grid-column: span 2; */
  }

  /* Ajustements mobile */
  @media (max-width: 992px) {
    .blog-thumb {
      aspect-ratio: 4/3;
    }
  }

  @media (max-width: 576px) {
    .blog-thumb {
      aspect-ratio: 3/2;
    }
  }
</style>
@include('Users.Template.head')

<body class="index-page">

  @include('Users.Template.header')

  <main class="main">
    <!-- Toast container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
      @if(session('success'))
      <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body">
            {{ session('success') }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
      @endif

      @if($errors->any())
      <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body">
            {{ $errors->first() }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
      @endif
    </div>

    <!-- Blog Hero Section -->
    <section id="blog-hero" class="blog-hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="blog-grid">

          {{-- Article vedette --}}
          @if($articles->count())
          @php $featured = $articles->first(); @endphp
          <article class="blog-item featured" data-aos="fade-up">
            @php
            $author = $featured->author;
            $authorPhoto = $author && $author->photo
            ? asset('assets/images/users/' . $author->photo)
            : asset('assets/images/users/1.jpg');
            @endphp

            <!-- Ajout d'un wrapper autour de l'image -->
            <div class="blog-thumb">
              <img src="{{ $featured->image ? asset($featured->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
                alt="{{ $featured->title }}" class="img-fluid">
            </div>

            <div class="blog-content mb-2">
              <div class="post-meta" style="margin-top: 8px;">
                <span class="author-photo">
                  <img src="{{ $authorPhoto }}" alt="{{ $author->name ?? 'Auteur' }}"
                    class="rounded-circle" width="25" height="25"
                    style="width:40px; height:40px;">
                </span>
                <span class="date">{{ \Carbon\Carbon::parse($featured->created_at)->locale('fr')->isoFormat('dddd DD/MM/YYYY') }}</span>
                <span class="category">{{ $featured->category ?? 'Actu' }}</span>
              </div>
              <h2 class="post-title">
                <a href="{{ $featured->route }}" title="{{ $featured->title }}">
                  {{ Str::limit($featured->title, 80) }}
                </a>
              </h2>
            </div>
          </article>
          @endif


          {{-- Les autres articles --}}
          @foreach($articles->skip(1) as $key => $article)
          @php
          $author = $article->author;
          $authorPhoto = $author && $author->photo
          ? asset('assets/images/users/' . $author->photo)
          : asset('assets/images/users/1.jpg');
          @endphp
          <article class="blog-item" data-aos="fade-up" data-aos-delay="{{ ($key+1) * 100 }}">
            <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
              alt="{{ $article->title }}" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="author-photo">
                  <img src="{{ $authorPhoto }}" alt="{{ $author->name ?? 'Auteur' }}" class="rounded-circle" width="15" height="15" style="width:40px; height:40px;">
                </span>
                <span class="date">{{ \Carbon\Carbon::parse($article->created_at)->locale('fr')->isoFormat('dddd DD/MM/YYYY') }}</span>
                <span class="category">{{ $article->category ?? 'Actu' }}</span>


              </div>
              <h3 class="post-title">
                <a href="{{ $article->route }}" title="{{ $article->title }}">
                  {{ Str::limit($article->title, 60) }}
                </a>
              </h3>
            </div>
          </article>
          @endforeach
        </div>
      </div>


    </section>

    <!-- /Blog Hero Section -->

    <!-- Featured Posts Section -->
    <section id="featured-posts" class="featured-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Article en vedette</h2>
        <div style="color: #7ed957;"><span>Découvrez </span> <span class="description-title">nos articles en vedette</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="blog-posts-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 800,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 3,
              "spaceBetween": 30,
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 20
                },
                "768": {
                  "slidesPerView": 2,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 30
                }
              }
            }
          </script>

          <div class="swiper-wrapper">
            @foreach($featuredArticles as $item)
            @php
            // s'assurer qu'on prend l'auteur du bon item
            $author = $item->author ?? null;
            $authorName = $author
            ? trim(($author->prenom ?? '') . ' ' . ($author->nom ?? $author->name ?? ''))
            : 'Admin';
            @endphp

            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="{{ $item->image ? asset($item->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
                  alt="{{ $item->title }}">
                <div class="blog-post-content">
                  <div class="post-meta">
                    @php
                    // Détermine le "slug" du type d'auteur (pour la route)
                    $authorType = ($author instanceof \App\Models\Collaborateur) ? 'collaborateur' : 'user';
                    @endphp
                    <span><i class="bi bi-person"></i><a href="{{ route('articles.byAuthor', ['type' => $authorType, 'id' => $author->id]) }}"
                        style="text-decoration:none; color:inherit;">
                        {{ $authorName }}
                      </a></span>

                    <span>
                      <i class="bi bi-clock"></i>
                      {{ \Carbon\Carbon::parse($item->created_at)->locale('fr')->isoFormat('dddd DD/MM/YYYY') }}
                    </span>
                  </div>

                  <h2>
                    <a href="{{ match($item->type) {
                  'mercato'    => route('articles.show', $item->slug),
                  'celebrite'  => route('articles.show.celebrite', $item->slug),
                  'omnisport'  => route('articles.show.omnisport', $item->slug),
                  'wags'       => route('articles.show.wags', $item->slug),
                  'actusport'  => route('actuafrique.detail', $item->slug),
                  default      => '#'
              } }}">
                      {{ Str::limit($item->title, 60) }}
                    </a>
                  </h2>

                  <p>{!! Str::limit(strip_tags($item->content), 120) !!}</p>
                  <a href="{{ match($item->type) {
                'mercato'    => route('articles.show', $item->slug),
                'celebrite'  => route('articles.show.celebrite', $item->slug),
                'omnisport'  => route('articles.show.omnisport', $item->slug),
                'wags'       => route('articles.show.wags', $item->slug),
                'actusport'  => route('actuafrique.detail', $item->slug),
                default      => '#'
            } }}" class="read-more">Lire la suite <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
            @endforeach
          </div>


        </div>

      </div>

    </section>
    <!-- /Featured Posts Section -->

    <!-- Category Section Section -->
    <section id="category-section" class="category-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Category Section</h2>
        <div style="color: #7ed957;"><span class="description-title">Découvrez nos articles par catégorie</span></div>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Featured Posts -->
        <div class="row gy-4 mb-4">
          @foreach($featuredCategoryArticles as $item)
          @php
          $article = $item['article'] ?? $item;
          $type = $item['type'] ?? $article->type;
          @endphp
          <div class="col-lg-4">
            <article class="featured-post">
              <div class="post-img">
                <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
                  alt="{{ $article->title }}" class="img-fluid" loading="lazy">
              </div>
              <div class="post-content">
                <div class="category-meta">
                  <span class="post-category">{{ $article->category ?? ucfirst($type) }}</span>
                </div>
                <h2 class="title">
                  <a href="{{ match($type) {
                    'mercato' => route('articles.show', $article->slug),
                    'celebrite' => route('articles.show.celebrite', $article->slug),
                    'omnisport' => route('articles.show.omnisport', $article->slug),
                    'wags' => route('articles.show.wags', $article->slug),
                    'actusport' => route('actuafrique.detail', $article->slug),
                    default => '#'
                } }}">
                    {{ Str::limit($article->title, 60) }}
                  </a>
                </h2>
                <div class="post-meta">

                </div>

              </div>
            </article>
          </div>
          @endforeach
        </div>

        <!-- List Posts -->
        <div class="row">
          @foreach($listCategoryArticles as $item)
          @php
          $article = $item['article'] ?? $item;
          $type = $item['type'] ?? $article->type;
          @endphp
          <div class="col-xl-4 col-lg-6">
            <article class="list-post">
              <div class="post-img">
                <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
                  alt="{{ $article->title }}" class="img-fluid" loading="lazy">
              </div>
              <div class="post-content">

                <h3 class="title">
                  <a href="{{ match($type) {
                    'mercato' => route('articles.show', $article->slug),
                    'celebrite' => route('articles.show.celebrite', $article->slug),
                    'omnisport' => route('articles.show.omnisport', $article->slug),
                    'wags' => route('articles.show.wags', $article->slug),
                    'actusport' => route('actuafrique.detail', $article->slug),
                    default => '#'
                } }}">
                    {{ Str::limit($article->title, 80) }}
                  </a>
                </h3>
                <div class="post-meta">
                  <span class="post-date">{{ $article->created_at->translatedFormat('d M, Y') }}</span>
                </div>
              </div>
            </article>
          </div>
          @endforeach
        </div>

      </div>

    </section>

    <!-- /Category Section Section -->

    <!-- Call To Action 2 Section -->
    <section id="call-to-action-2" class="call-to-action-2 section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative">

          <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
            <span class="badge text-uppercase mb-2">Ne Ratez Rien</span>
            <h2 style="color: #7ed957;">Restez à la pointe de l'actualité sportive</h2>
            <p class="my-4">Suivez les dernières infos Mercato, Omnisport et Célébrités du sport. Recevez nos articles exclusifs et analyses en avant-première.</p>

            <div class="features d-flex flex-wrap gap-3 mb-4">
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Dernières actualités</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Analyses exclusives</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Interviews et coulisses</span>
              </div>
            </div>

            <div class="cta-buttons d-flex flex-wrap gap-3">
              <a href="#newsletter" class="btn btn-primary">S’abonner à la newsletter</a>
              <a href="{{ route('articles.all') }}" class="btn btn-outline">Voir tous les articles</a>
            </div>
          </div>

          <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300">
            <img src="assets/img/misc/Benin-Tennes.jpg" alt="Digital Platform" class="img-fluid rounded-4">
            <div class="floating-card">
              <div class="card-icon">
                <i class="bi bi-trophy-fill"></i>
              </div>
              <div class="card-content">
                <span class="stats-number">{{ number_format($totalArticles, 0, ',', ' ') }} + </span>
                <span class="stats-text">Articles publiés</span>
              </div>
            </div>
          </div>

          <div class="decoration">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
          </div>

        </div>

      </div>

    </section>
    <!-- /Call To Action 2 Section -->

    <!-- Latest Posts Section -->
    <section id="latest-posts" class="latest-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Dernières Actualités</h2>
        <div style="color: #7ed957;"><span>Découvrez</span> <span class="description-title">nos derniers articles</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          @foreach($latestArticles as $item)
          @php
          $article = $item['article'];
          $type = $item['type'];
          $author = $article->author ?? null;
          $authorPhoto = $author && $author->photo
          ? asset('assets/images/users/' . $author->photo)
          : asset('assets/images/users/1.jpg');
          $authorName = $author
          ? trim(($author->prenom ?? '') . ' ' . ($author->nom ?? $author->name ?? ''))
          : 'Admin';
          @endphp

          <div class="col-lg-4">
            <article>
              <div class="post-img">
                <img src="{{ $article->image ? asset($article->image) : 'https://via.placeholder.com/600x400?text=Article' }}"
                  alt="{{ $article->title }}" class="img-fluid">
              </div>

              <p class="post-category">{{ ucfirst($type) }}</p>

              <h2 class="title">
                <a href="{{ match($type) {
                  'mercato' => route('articles.show', $article->slug),
                  'celebrite' => route('articles.show.celebrite', $article->slug),
                  'omnisport' => route('articles.show.omnisport', $article->slug),
                  'wags' => route('articles.show.wags', $article->slug),
                  'actusport' => route('actuafrique.detail', $article->slug),
                  default => '#'
              } }}">
                  {{ Str::limit($article->title, 60) }}
                </a>
              </h2>

              <div class="d-flex align-items-center gap-2">
                <img src="{{ $authorPhoto }}"
                  alt="{{ $authorName }}"
                  class="img-fluid post-author-img flex-shrink-0 rounded-circle"
                  width="25" height="25" style="width:25px;height:25px;">
                <div class="post-meta d-flex align-items-center gap-2">
                  @php
                  // Détermine le "slug" du type d'auteur (pour la route)
                  $authorType = ($author instanceof \App\Models\Collaborateur) ? 'collaborateur' : 'user';
                  @endphp

                  <p class="post-author">
                    <a href="{{ route('articles.byAuthor', ['type' => $authorType, 'id' => $author->id]) }}"
                      style="text-decoration:none; color:inherit;">
                      {{ $authorName }}
                    </a>
                  </p>
                  <p class="post-date d-flex align-items-center gap-2">
                    <time datetime="{{ $article->created_at->format('Y-m-d') }}">
                      {{ \Carbon\Carbon::parse($article->created_at)->locale('fr')->isoFormat('DD/MM/YYYY') }}
                    </time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          @endforeach

        </div>
      </div>

    </section>

    <!-- /Latest Posts Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-between align-items-center">

          <div class="col-lg-6">
            <div class="cta-content" id="newsletter" data-aos="fade-up" data-aos-delay="200">
              <h2 style="color: #7ed957;">Abonnez-vous à notre newsletter</h2>
              <p>Recevez toutes les dernières actualités et mises à jour directement dans votre boîte mail. Ne manquez aucune information sur le sport et le divertissement.</p>

              <form action="{{ route('newsletter.subscribe') }}" method="POST" class="cta-form" data-aos="fade-up" data-aos-delay="300">
                @csrf
                <div class="input-group mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Adresse email..." aria-label="Adresse email" aria-describedby="button-subscribe" required>
                  <button class="btn btn-primary" type="submit">S'abonner</button>
                </div>
              </form>




            </div>
          </div>

          <div class="col-lg-4">
            <div class="cta-image" data-aos="zoom-out" data-aos-delay="200">
              <img src="assets/img/cta/cta-1.webp" alt="Newsletter" class="img-fluid">
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- /Call To Action Section -->

  </main>

  @include('Users.Template.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <a href="https://wa.me/22953087433" target="_blank" class="whatsapp-float">
    <i class="bi bi-whatsapp"></i>
  </a>
  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>