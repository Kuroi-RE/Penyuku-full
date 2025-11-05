<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Pencatatan Data Penyu') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <!-- Header Section -->
      <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">
          <i class="fas fa-egg text-green-600"></i> Panel Pencatatan Data Penyu Cilacap
        </h3>
        <p class="text-gray-600">Kelola data temuan sarang dan wilayah peneluran penyu</p>
      </div>

      <!-- Menu Cards -->
      <div class="row g-4">

        <!-- Card 1: Temuan Sarang -->
        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                  <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                </div>
                <div>
                  <h5 class="card-title mb-0 fw-bold">Data Temuan Sarang</h5>
                  <p class="text-muted small mb-0">Pencatatan temuan telur penyu</p>
                </div>
              </div>
              <p class="card-text text-gray-600 mb-4">
                Kelola data temuan sarang penyu meliputi: tanggal temuan, lokasi, jumlah telur,
                perkiraan menetas, dan hasil penetasan.
              </p>
              <div class="d-grid gap-2">
                <a href="{{ route('turtle-eggs.findings.index') }}" class="btn btn-primary">
                  <i class="fas fa-list me-2"></i> Lihat Data Temuan
                </a>
                <a href="{{ route('turtle-eggs.findings.create') }}" class="btn btn-outline-primary">
                  <i class="fas fa-plus me-2"></i> Tambah Temuan Baru
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 2: Wilayah Peneluran -->
        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                  <i class="fas fa-map-marked-alt fa-2x text-success"></i>
                </div>
                <div>
                  <h5 class="card-title mb-0 fw-bold">Wilayah Peneluran</h5>
                  <p class="text-muted small mb-0">Data statistik per lokasi & bulan</p>
                </div>
              </div>
              <p class="card-text text-gray-600 mb-4">
                Kelola data wilayah peneluran penyu di berbagai pantai Cilacap.
                Data dikelompokkan per bulan dan lokasi untuk analisis pola peneluran.
              </p>
              <div class="d-grid gap-2">
                <a href="{{ route('turtle-eggs.locations.index') }}" class="btn btn-success">
                  <i class="fas fa-table me-2"></i> Lihat Data Wilayah
                </a>
                <a href="{{ route('turtle-eggs.locations.create') }}" class="btn btn-outline-success">
                  <i class="fas fa-plus me-2"></i> Input Data Wilayah
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Info Section -->
      <div class="mt-6">
        <div class="alert alert-info border-0 shadow-sm">
          <div class="d-flex align-items-start">
            <i class="fas fa-info-circle fa-2x me-3 mt-1"></i>
            <div>
              <h5 class="alert-heading fw-bold mb-2">Informasi Penting</h5>
              <p class="mb-2"><strong>Data Temuan Sarang:</strong> Catat setiap temuan sarang penyu dengan lengkap termasuk kode peneluran, jumlah telur, dan hasil penetasan.</p>
              <p class="mb-0"><strong>Wilayah Peneluran:</strong> Data agregat jumlah peneluran per lokasi pantai dan per bulan untuk monitoring pola peneluran.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <style>
    .hover-card {
      transition: all 0.3s ease;
    }

    .hover-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

  </style>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
