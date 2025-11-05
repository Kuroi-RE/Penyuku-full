<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Data Konservasi Penyu Cilacap') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .stat-card {
      transition: all 0.3s ease;
      border-left: 4px solid;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .chart-container {
      position: relative;
      height: 300px;
    }

  </style>

  <div class="py-12">
    <div class="container-fluid px-4">

      <!-- Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="text-center mb-4">
            <h2 class="fw-bold text-success mb-2">
              <i class="fas fa-turtle fa-2x"></i>
              <br>
              Dashboard Konservasi Penyu Cilacap
            </h2>
            <p class="text-muted">Transparansi Data Peneluran dan Penetasan Penyu {{ $year }}</p>
          </div>
        </div>
      </div>

      <!-- Year Filter -->
      <div class="row mb-4">
        <div class="col-12 text-center">
          <form method="GET" action="{{ route('turtle-data.dashboard') }}" class="d-inline-flex gap-3 align-items-center">
            <label class="fw-bold mb-0">Pilih Tahun:</label>
            <select name="year" class="form-select w-auto" onchange="this.form.submit()">
              @foreach($years as $y)
              <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endforeach
            </select>
          </form>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #0d6efd !important;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1">Total Sarang Ditemukan</p>
                  <h2 class="fw-bold text-primary mb-0">{{ number_format($totalNests) }}</h2>
                  <small class="text-muted">Sarang</small>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                  <i class="fas fa-egg fa-2x text-primary"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #0dcaf0 !important;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1">Total Telur</p>
                  <h2 class="fw-bold text-info mb-0">{{ number_format($totalEggs) }}</h2>
                  <small class="text-muted">Butir</small>
                </div>
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                  <i class="fas fa-circle fa-2x text-info"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #198754 !important;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1">Berhasil Menetas</p>
                  <h2 class="fw-bold text-success mb-0">{{ number_format($totalHatched) }}</h2>
                  <small class="text-muted">Tukik</small>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                  <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #ffc107 !important;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="text-muted mb-1">Tingkat Keberhasilan</p>
                  <h2 class="fw-bold text-warning mb-0">{{ number_format($hatchingRate, 1) }}%</h2>
                  <small class="text-muted">Rata-rata</small>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                  <i class="fas fa-percentage fa-2x text-warning"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <!-- Temuan per Lokasi -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Temuan Sarang per Lokasi Pantai</h5>
            </div>
            <div class="card-body">
              @if($findingsByLocation->count() > 0)
              @foreach($findingsByLocation as $location)
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="fw-bold">{{ $location->location }}</span>
                  <span class="badge bg-primary">{{ $location->count }} sarang</span>
                </div>
                <div class="progress" style="height: 25px;">
                  <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($location->count / $findingsByLocation->max('count')) * 100 }}%;">
                    {{ $location->total_eggs }} telur | {{ $location->total_hatched }} menetas
                  </div>
                </div>
                <small class="text-muted">
                  Tingkat keberhasilan:
                  <strong class="{{ $location->total_eggs > 0 && (($location->total_hatched / $location->total_eggs) * 100) >= 80 ? 'text-success' : 'text-warning' }}">
                    {{ $location->total_eggs > 0 ? number_format(($location->total_hatched / $location->total_eggs) * 100, 1) : 0 }}%
                  </strong>
                </small>
              </div>
              @endforeach
              @else
              <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Belum ada data temuan untuk tahun {{ $year }}</p>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Wilayah Peneluran -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-success text-white">
              <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Distribusi Peneluran per Lokasi</h5>
            </div>
            <div class="card-body">
              @if($nestingLocations->count() > 0)
              @foreach($nestingLocations->take(10) as $location)
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="fw-bold">{{ $location->location_name }}</span>
                  <span class="badge bg-success">{{ $location->total }} peneluran</span>
                </div>
                <div class="progress" style="height: 25px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($location->total / $nestingLocations->max('total')) * 100 }}%;">
                    {{ number_format(($location->total / $nestingLocations->sum('total')) * 100, 1) }}% dari total
                  </div>
                </div>
              </div>
              @endforeach

              @if($nestingLocations->count() > 0)
              <div class="text-center mt-3">
                <small class="text-muted">
                  <strong>Total Peneluran:</strong> {{ number_format($nestingLocations->sum('total')) }} peneluran
                </small>
              </div>
              @endif
              @else
              <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Belum ada data peneluran untuk tahun {{ $year }}</p>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Monthly Trend -->
      @if($monthlyData->count() > 0)
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
              <h5 class="mb-0"><i class="fas fa-chart-line"></i> Tren Bulanan Temuan dan Penetasan</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Bulan</th>
                      <th class="text-center">Jumlah Temuan</th>
                      <th class="text-center">Total Telur</th>
                      <th class="text-center">Total Menetas</th>
                      <th class="text-center">Tingkat Keberhasilan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp
                    @foreach($monthlyData as $data)
                    <tr>
                      <td class="fw-bold">{{ $monthNames[$data->month] }}</td>
                      <td class="text-center">
                        <span class="badge bg-primary">{{ $data->count }}</span>
                      </td>
                      <td class="text-center">{{ number_format($data->eggs) }}</td>
                      <td class="text-center">{{ number_format($data->hatched) }}</td>
                      <td class="text-center">
                        @php
                        $rate = $data->eggs > 0 ? ($data->hatched / $data->eggs) * 100 : 0;
                        @endphp
                        <span class="badge {{ $rate >= 80 ? 'bg-success' : ($rate >= 50 ? 'bg-warning' : 'bg-danger') }}">
                          {{ number_format($rate, 1) }}%
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
      </div>
      @endif

      <!-- Recent Findings -->
      @if($recentFindings->count() > 0)
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
              <h5 class="mb-0"><i class="fas fa-clock"></i> Temuan Terbaru</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Tanggal</th>
                      <th>Kode</th>
                      <th>Lokasi</th>
                      <th class="text-center">Telur</th>
                      <th class="text-center">Menetas</th>
                      <th class="text-center">Keberhasilan</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($recentFindings as $finding)
                    <tr>
                      <td>{{ $finding->finding_date->format('d M Y') }}</td>
                      <td>
                        @if($finding->nest_code)
                        <span class="badge bg-secondary">{{ $finding->nest_code }}</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td class="fw-bold">{{ $finding->location }}</td>
                      <td class="text-center">{{ $finding->egg_count }}</td>
                      <td class="text-center">{{ $finding->hatched_count }}</td>
                      <td class="text-center">
                        <span class="badge {{ $finding->hatching_percentage >= 80 ? 'bg-success' : ($finding->hatching_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}">
                          {{ number_format($finding->hatching_percentage, 1) }}%
                        </span>
                      </td>
                      <td>
                        @if($finding->status == 'monitoring')
                        <span class="badge bg-primary">Monitoring</span>
                        @elseif($finding->status == 'hatched')
                        <span class="badge bg-success">Menetas</span>
                        @else
                        <span class="badge bg-danger">Diambil Nelayan</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- Info Footer -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="alert alert-success border-0 shadow-sm">
            <div class="d-flex align-items-start">
              <i class="fas fa-leaf fa-2x me-3 mt-1"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-2">Tentang Data Konservasi</h5>
                <p class="mb-2">
                  Data ini menampilkan informasi real-time tentang upaya konservasi penyu di pantai-pantai Cilacap.
                  Transparansi data bertujuan untuk meningkatkan kesadaran masyarakat dan mendukung program konservasi penyu.
                </p>
                <p class="mb-0">
                  <strong>Data dikelola oleh:</strong> Tim Penangkaran Penyu Cilacap |
                  <strong>Terakhir diupdate:</strong> {{ now()->format('d F Y, H:i') }} WIB
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
