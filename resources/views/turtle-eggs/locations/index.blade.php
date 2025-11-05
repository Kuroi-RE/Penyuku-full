<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Data Wilayah Peneluran Penyu') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .matrix-table {
      font-size: 0.9rem;
    }

    .matrix-table th {
      background-color: #f8f9fa;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .matrix-table td {
      text-align: center;
      vertical-align: middle;
    }

    .location-header {
      writing-mode: vertical-rl;
      text-orientation: mixed;
      white-space: nowrap;
      padding: 10px 5px !important;
      font-size: 0.85rem;
    }

    .total-row {
      background-color: #e9ecef;
      font-weight: bold;
    }

    .count-cell {
      transition: all 0.2s;
      cursor: default;
    }

    .count-cell:hover {
      background-color: #e3f2fd;
      transform: scale(1.05);
    }

    .count-zero {
      color: #ccc;
    }

  </style>

  <div class="py-12">
    <div class="container-fluid px-4">

      <!-- Success Message -->
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      <!-- Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h3 class="fw-bold mb-1">
                <i class="fas fa-map-marked-alt text-success"></i> Data Wilayah Peneluran Penyu
              </h3>
              <p class="text-muted mb-0">Cilacap - Tahun {{ $year }}</p>
            </div>
            <a href="{{ route('turtle-eggs.locations.create') }}" class="btn btn-success">
              <i class="fas fa-plus"></i> Input Data
            </a>
          </div>
        </div>
      </div>

      <!-- Year Filter & Stats -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <form method="GET" action="{{ route('turtle-eggs.locations.index') }}" class="d-flex gap-3 align-items-center">
                <label class="fw-bold mb-0">Filter Tahun:</label>
                <select name="year" class="form-select w-auto" onchange="this.form.submit()">
                  @foreach($years as $y)
                  <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                  @endforeach
                </select>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h6 class="text-white-50 mb-1">Total Peneluran {{ $year }}</h6>
                <h2 class="mb-0 fw-bold">{{ number_format($grandTotal) }}</h2>
              </div>
              <i class="fas fa-egg fa-3x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Matrix Table -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white py-3">
          <h5 class="mb-0"><i class="fas fa-table"></i> Matriks Peneluran per Lokasi & Bulan</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered matrix-table mb-0">
              <thead>
                <tr>
                  <th class="text-center" style="min-width: 120px;">BULAN</th>
                  @foreach($locations as $location)
                  <th class="location-header">{{ $location }}</th>
                  @endforeach
                  <th class="text-center bg-warning" style="min-width: 80px;">TOTAL</th>
                </tr>
              </thead>
              <tbody>
                @foreach($months as $month)
                <tr>
                  <td class="fw-bold text-start ps-3">{{ $month }}</td>
                  @foreach($locations as $location)
                  <td class="count-cell {{ $matrixData[$month][$location] == 0 ? 'count-zero' : '' }}">
                    {{ $matrixData[$month][$location] > 0 ? $matrixData[$month][$location] : '-' }}
                  </td>
                  @endforeach
                  <td class="fw-bold bg-warning bg-opacity-10">
                    {{ $monthTotals[$month] > 0 ? $monthTotals[$month] : '-' }}
                  </td>
                </tr>
                @endforeach

                <!-- Total Row -->
                <tr class="total-row">
                  <td class="text-center fw-bold">TOTAL</td>
                  @foreach($locations as $location)
                  <td class="fw-bold">
                    {{ $locationTotals[$location] > 0 ? $locationTotals[$location] : '-' }}
                  </td>
                  @endforeach
                  <td class="fw-bold bg-success text-white">{{ $grandTotal }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Top Locations Chart -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
              <h5 class="mb-0"><i class="fas fa-chart-bar text-primary"></i> Lokasi dengan Peneluran Terbanyak</h5>
            </div>
            <div class="card-body">
              <div class="row">
                @php
                $sortedLocations = collect($locationTotals)->sortDesc()->take(5);
                $maxCount = $sortedLocations->first() ?: 1;
                @endphp
                @foreach($sortedLocations as $location => $count)
                <div class="col-md-12 mb-3">
                  <div class="d-flex align-items-center">
                    <div class="fw-bold me-3" style="min-width: 180px;">{{ $location }}</div>
                    <div class="flex-grow-1">
                      <div class="progress" style="height: 30px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($count / $maxCount) * 100 }}%;" aria-valuenow="{{ $count }}" aria-valuemin="0" aria-valuemax="{{ $maxCount }}">
                          <strong>{{ $count }} peneluran</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Info -->
      <div class="mt-4">
        <div class="alert alert-info border-0">
          <i class="fas fa-info-circle"></i>
          <strong>Keterangan:</strong> Data menampilkan jumlah peneluran penyu di setiap lokasi pantai per bulan.
          Klik tombol <strong>Input Data</strong> untuk menambah atau mengupdate data peneluran.
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
