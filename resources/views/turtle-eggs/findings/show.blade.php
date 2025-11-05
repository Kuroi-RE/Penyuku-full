<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Detail Temuan Sarang') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <div class="py-12">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">

          <!-- Back & Action Buttons -->
          <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('turtle-eggs.findings.index') }}" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn-group">
              <a href="{{ route('turtle-eggs.findings.edit', $finding) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form action="{{ route('turtle-eggs.findings.destroy', $finding) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </div>

          <!-- Detail Card -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white py-3">
              <h5 class="mb-0">
                <i class="fas fa-info-circle"></i> Informasi Temuan Sarang
                @if($finding->nest_code)
                <span class="badge bg-light text-dark ms-2">{{ $finding->nest_code }}</span>
                @endif
              </h5>
            </div>
            <div class="card-body p-4">

              <div class="row mb-4">
                <div class="col-md-6">
                  <h6 class="text-muted mb-1">Tanggal Temuan</h6>
                  <p class="h5"><i class="fas fa-calendar text-primary"></i> {{ $finding->finding_date->format('d F Y') }}</p>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted mb-1">Lokasi Pantai</h6>
                  <p class="h5"><i class="fas fa-map-marker-alt text-danger"></i> {{ $finding->location }}</p>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <h6 class="text-muted mb-1">Kode Sarang</h6>
                  <p class="h5">
                    @if($finding->nest_code)
                    <span class="badge bg-secondary fs-6">{{ $finding->nest_code }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                  </p>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted mb-1">Status</h6>
                  <p class="h5">
                    @if($finding->status == 'monitoring')
                    <span class="badge bg-primary fs-6"><i class="fas fa-eye"></i> Monitoring</span>
                    @elseif($finding->status == 'hatched')
                    <span class="badge bg-success fs-6"><i class="fas fa-check"></i> Sudah Menetas</span>
                    @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-ban"></i> Diambil Nelayan</span>
                    @endif
                  </p>
                </div>
              </div>

              <hr>

              <!-- Statistics -->
              <div class="row text-center mb-4">
                <div class="col-md-3">
                  <div class="p-3 bg-info bg-opacity-10 rounded">
                    <i class="fas fa-circle fa-2x text-info mb-2"></i>
                    <h3 class="fw-bold text-info mb-0">{{ $finding->egg_count }}</h3>
                    <small class="text-muted">Total Telur</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 bg-success bg-opacity-10 rounded">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="fw-bold text-success mb-0">{{ $finding->hatched_count }}</h3>
                    <small class="text-muted">Yang Menetas</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 bg-warning bg-opacity-10 rounded">
                    <i class="fas fa-percentage fa-2x text-warning mb-2"></i>
                    <h3 class="fw-bold text-warning mb-0">{{ number_format($finding->hatching_percentage, 1) }}%</h3>
                    <small class="text-muted">Tingkat Keberhasilan</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="p-3 bg-danger bg-opacity-10 rounded">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h3 class="fw-bold text-danger mb-0">{{ $finding->egg_count - $finding->hatched_count }}</h3>
                    <small class="text-muted">Tidak Menetas</small>
                  </div>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-12">
                  <h6 class="text-muted mb-1">Perkiraan Tanggal Menetas</h6>
                  <p class="h5">
                    @if($finding->estimated_hatching_date)
                    <i class="fas fa-clock text-warning"></i> {{ $finding->estimated_hatching_date->format('d F Y') }}
                    <small class="text-muted">
                      ({{ $finding->finding_date->diffInDays($finding->estimated_hatching_date) }} hari dari temuan)
                    </small>
                    @else
                    <span class="text-muted">Tidak ada perkiraan</span>
                    @endif
                  </p>
                </div>
              </div>

              @if($finding->notes)
              <div class="row">
                <div class="col-md-12">
                  <h6 class="text-muted mb-1">Catatan</h6>
                  <div class="alert alert-light border">
                    <i class="fas fa-sticky-note text-secondary"></i> {{ $finding->notes }}
                  </div>
                </div>
              </div>
              @endif

            </div>
            <div class="card-footer text-muted">
              <small>
                <i class="fas fa-user"></i> Dicatat oleh: <strong>{{ $finding->user->name }}</strong> |
                <i class="fas fa-clock"></i> {{ $finding->created_at->diffForHumans() }}
                @if($finding->created_at != $finding->updated_at)
                | Diupdate: {{ $finding->updated_at->diffForHumans() }}
                @endif
              </small>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
