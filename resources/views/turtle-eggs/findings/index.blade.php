<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Data Temuan Sarang Penyu') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <div class="py-12">
    <div class="container-fluid px-4">

      <!-- Success Message -->
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      <!-- Header & Stats -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h3 class="fw-bold mb-1"><i class="fas fa-clipboard-list text-primary"></i> Data Temuan Sarang</h3>
              <p class="text-muted mb-0">Total: {{ $totalNests }} temuan sarang</p>
            </div>
            <a href="{{ route('turtle-eggs.findings.create') }}" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah Temuan
            </a>
          </div>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-white-50 mb-1">Total Sarang</h6>
                  <h3 class="mb-0 fw-bold">{{ number_format($totalNests) }}</h3>
                </div>
                <i class="fas fa-egg fa-3x opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-white-50 mb-1">Total Telur</h6>
                  <h3 class="mb-0 fw-bold">{{ number_format($totalEggs) }}</h3>
                </div>
                <i class="fas fa-circle fa-3x opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-white-50 mb-1">Total Menetas</h6>
                  <h3 class="mb-0 fw-bold">{{ number_format($totalHatched) }}</h3>
                </div>
                <i class="fas fa-check-circle fa-3x opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-white-50 mb-1">Rata-rata Sukses</h6>
                  <h3 class="mb-0 fw-bold">{{ number_format($averageHatchingRate, 1) }}%</h3>
                </div>
                <i class="fas fa-percentage fa-3x opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <form method="GET" action="{{ route('turtle-eggs.findings.index') }}" class="row g-3">
            <div class="col-md-3">
              <label class="form-label small fw-bold">Tahun</label>
              <select name="year" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach($years as $y)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Lokasi</label>
              <select name="location" class="form-select">
                <option value="">Semua Lokasi</option>
                @foreach($locations as $loc)
                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-bold">Status</label>
              <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="monitoring" {{ request('status') == 'monitoring' ? 'selected' : '' }}>Monitoring</option>
                <option value="hatched" {{ request('status') == 'hatched' ? 'selected' : '' }}>Sudah Menetas</option>
                <option value="taken_by_fisherman" {{ request('status') == 'taken_by_fisherman' ? 'selected' : '' }}>Diambil Nelayan</option>
              </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Filter
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Data Table -->
      <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th class="px-4 py-3">No</th>
                  <th class="py-3">Tanggal</th>
                  <th class="py-3">Kode</th>
                  <th class="py-3">Lokasi</th>
                  <th class="py-3 text-center">Jumlah Telur</th>
                  <th class="py-3">Perkiraan Menetas</th>
                  <th class="py-3 text-center">Menetas</th>
                  <th class="py-3 text-center">Sukses</th>
                  <th class="py-3">Status</th>
                  <th class="py-3 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($findings as $index => $finding)
                <tr>
                  <td class="px-4 py-3">{{ $findings->firstItem() + $index }}</td>
                  <td class="py-3">{{ $finding->finding_date->format('d M Y') }}</td>
                  <td class="py-3">
                    @if($finding->nest_code)
                    <span class="badge bg-secondary">{{ $finding->nest_code }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="py-3 fw-bold">{{ $finding->location }}</td>
                  <td class="py-3 text-center">
                    <span class="badge bg-info">{{ $finding->egg_count }}</span>
                  </td>
                  <td class="py-3">
                    @if($finding->estimated_hatching_date)
                    {{ $finding->estimated_hatching_date->format('d M Y') }}
                    @else
                    <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="py-3 text-center">
                    <span class="badge bg-success">{{ $finding->hatched_count }}</span>
                  </td>
                  <td class="py-3 text-center">
                    <span class="badge {{ $finding->hatching_percentage >= 80 ? 'bg-success' : ($finding->hatching_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}">
                      {{ number_format($finding->hatching_percentage, 1) }}%
                    </span>
                  </td>
                  <td class="py-3">
                    @if($finding->status == 'monitoring')
                    <span class="badge bg-primary"><i class="fas fa-eye"></i> Monitoring</span>
                    @elseif($finding->status == 'hatched')
                    <span class="badge bg-success"><i class="fas fa-check"></i> Menetas</span>
                    @else
                    <span class="badge bg-danger"><i class="fas fa-ban"></i> Diambil Nelayan</span>
                    @endif
                  </td>
                  <td class="py-3 text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('turtle-eggs.findings.show', $finding) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ route('turtle-eggs.findings.edit', $finding) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('turtle-eggs.findings.destroy', $finding) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="10" class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data temuan sarang</p>
                    <a href="{{ route('turtle-eggs.findings.create') }}" class="btn btn-primary">
                      <i class="fas fa-plus"></i> Tambah Data Pertama
                    </a>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      @if($findings->hasPages())
      <div class="mt-4">
        {{ $findings->links() }}
      </div>
      @endif

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
