<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Penangkaran Penyu Cilacap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Conservation-themed hero styles */
    .hero-section {
      position: relative;
      color: #fff;
      padding: 80px 0;
      background-color: #05243a;
      /* fallback */
      overflow: hidden;
    }

    .hero-section .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(2, 48, 71, 0.55), rgba(0, 0, 0, 0.55));
      z-index: 0;
    }

    .hero-section .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-cta.btn-lg {
      padding-left: 1.4rem;
      padding-right: 1.4rem;
    }

    .stat-pill {
      background: rgba(255, 255, 255, 0.08);
      padding: 8px 12px;
      border-radius: 999px;
      display: inline-block;
      color: #fff;
      margin-right: 8px;
    }

    .turtle-card {
      transition: transform 0.3s;
    }

    .turtle-card:hover {
      transform: translateY(-5px);
    }

    .post-card {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      margin-bottom: 20px;
      overflow: hidden;
    }

    .post-header {
      padding: 15px;
      border-bottom: 1px solid #e0e0e0;
    }

    .post-content {
      padding: 15px;
    }

    .post-image {
      width: 100%;
      max-height: 500px;
      object-fit: cover;
    }

    .post-actions {
      padding: 10px 15px;
      border-top: 1px solid #e0e0e0;
    }

  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('home') }}">
        Penangkaran Penyu Cilacap
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#kenali-penyu">Kenali Penyu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#postingan">Postingan</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-black ms-2" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-black ms-2" href="{{ route('register') }}">Register</a>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section: Konservasi Penyu -->
  <section class="hero-section text-white" style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3?w=1600'); background-size: cover; background-position: center; min-height: 70vh;">
    <div class="hero-overlay" aria-hidden="true"></div>

    <div class="container hero-content">
      <div class="row align-items-center">
        <div class="col-lg-7 text-start">
          <h1 class="display-4 fw-bold">Selamat Datang di Penangkaran Penyu Cilacap</h1>
          <p class="lead">Bersama melestarikan penyu untuk generasi mendatang — ikut berkontribusi dalam konservasi, pelepasan tukik, dan edukasi masyarakat.</p>
          <div class="mt-4">
            @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg hero-cta me-2">Gabung Komunitas</a>
            @endguest
            <a href="#kenali-penyu" class="btn btn-outline-light btn-lg hero-cta">Pelajari Penyu</a>
          </div>

          <div class="mt-4">
            <span class="stat-pill">Komunitas: <strong>120+</strong></span>
            <span class="stat-pill">Telur Diselamatkan: <strong>3.2k</strong></span>
            <span class="stat-pill">Pelepasan Tahunan: <strong>45</strong></span>
          </div>
        </div>

        <div class="col-lg-5 d-none d-lg-flex justify-content-end">
          <!-- Inline turtle SVG for consistent look and no external dependency -->
          <img src="https://png.pngtree.com/png-clipart/20230427/original/pngtree-turtle-sea-turtle-green-turtle-shell-pattern-png-image_9114186.png" width="300" height="300" alt="" srcset="">
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Kenali Penyu -->
  <section id="kenali-penyu" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold">Kenali Jenis-Jenis Penyu</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card turtle-card h-100 shadow-sm">
            <img src="https://images.unsplash.com/photo-1437622368342-7a3d73a34c8f?w=400" class="card-img-top" alt="Penyu Hijau">
            <div class="card-body">
              <h5 class="card-title fw-bold">Penyu Hijau</h5>
              <p class="card-text">Penyu hijau (Chelonia mydas) adalah salah satu spesies penyu laut terbesar. Dinamakan "hijau" karena warna lemak di bawah karapasnya.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card turtle-card h-100 shadow-sm">
            <img src="https://images.unsplash.com/photo-1437622368342-7a3d73a34c8f?w=400" class="card-img-top" alt="Penyu Sisik">
            <div class="card-body">
              <h5 class="card-title fw-bold">Penyu Sisik</h5>
              <p class="card-text">Penyu sisik (Eretmochelys imbricata) memiliki cangkang yang indah dengan pola seperti sisik. Terancam punah karena perburuan.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card turtle-card h-100 shadow-sm">
            <img src="https://images.unsplash.com/photo-1437622368342-7a3d73a34c8f?w=400" class="card-img-top" alt="Penyu Lekang">
            <div class="card-body">
              <h5 class="card-title fw-bold">Penyu Lekang</h5>
              <p class="card-text">Penyu lekang (Lepidochelys olivacea) adalah penyu laut terkecil. Sering ditemukan di pantai-pantai Indonesia.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Postingan Komunitas -->
  <section id="postingan" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold">Postingan Komunitas</h2>

      @if($posts->isEmpty())
      <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Belum ada postingan. Login untuk membuat postingan pertama!
      </div>
      @else
      <div class="row">
        <div class="col-lg-8 mx-auto">
          @foreach($posts as $post)
          <div class="post-card bg-white shadow-sm">
            <div class="post-header d-flex align-items-center">
              <div class="me-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                  {{ strtoupper(substr($post->user->username, 0, 1)) }}
                </div>
              </div>
              <div>
                <h6 class="mb-0 fw-bold">{{ $post->user->username }}</h6>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
              </div>
            </div>

            <div class="post-content">
              <p class="mb-2">{{ $post->content }}</p>
              @if($post->image)
              <img src="{{ asset('storage/' . $post->image) }}" class="post-image" alt="Post image">
              @endif
            </div>

            <div class="post-actions d-flex gap-3">
              <span><i class="fas fa-heart text-danger"></i> {{ $post->likes_count }} Suka</span>
              <span><i class="fas fa-comment text-primary"></i> {{ $post->comments_count }} Komentar</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      @guest
      <div class="text-center mt-4">
        <p class="lead">Ingin berbagi cerita tentang penyu?</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-md">Login</a> atau <a href="{{ route('register') }}" class="btn btn-primary btn-md">Register</a><br /> <strong> untuk membuat postingan pertama!</strong>
      </div>
      @endguest
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; 2024 Penangkaran Penyu Cilacap. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
