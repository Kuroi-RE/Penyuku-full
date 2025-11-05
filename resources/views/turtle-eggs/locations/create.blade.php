<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Input Data Wilayah Peneluran') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .input-table {
      font-size: 0.9rem;
    }

    .input-table th {
      background-color: #198754;
      color: white;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .input-table input {
      text-align: center;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      width: 60px;
      padding: 5px;
    }

    .month-header {
      font-weight: 600;
      background-color: #f8f9fa;
      text-align: center;
    }

    .location-name {
      writing-mode: vertical-rl;
      text-orientation: mixed;
      white-space: nowrap;
      padding: 10px 5px !important;
      font-size: 0.85rem;
    }

  </style>

  <div class="py-12">
    <div class="container-fluid px-4">

      <!-- Back Button -->
      <div class="mb-4">
        <a href="{{ route('turtle-eggs.locations.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

      <!-- Form Card -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white py-3">
          <h5 class="mb-0"><i class="fas fa-table"></i> Form Input Data Wilayah Peneluran</h5>
        </div>
        <div class="card-body p-4">

          @if($errors->any())
          <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- Info Alert -->
          <div class="alert alert-info border-0 mb-4">
            <i class="fas fa-info-circle"></i>
            <strong>Petunjuk:</strong>
            <ul class="mb-0 mt-2">
              <li>Isi jumlah peneluran untuk setiap kombinasi bulan dan lokasi</li>
              <li>Gunakan angka <strong>0</strong> jika tidak ada peneluran</li>
              <li>Data akan otomatis menggantikan data lama jika sudah ada</li>
              <li>Scroll ke kanan untuk melihat semua lokasi</li>
            </ul>
          </div>

          <form action="{{ route('turtle-eggs.locations.store') }}" method="POST" id="locationForm">
            @csrf

            <!-- Year Selection -->
            <div class="row mb-4">
              <div class="col-md-4">
                <label for="year" class="form-label fw-bold">
                  Tahun <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control form-control-lg" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2100" required>
                <small class="text-muted">Pilih tahun untuk data peneluran</small>
              </div>
            </div>

            <!-- Matrix Input Table -->
            <div class="table-responsive">
              <table class="table table-bordered input-table">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 120px;">BULAN</th>
                    @foreach($locations as $location)
                    <th class="location-name">{{ $location }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach($months as $month)
                  <tr>
                    <td class="month-header">{{ $month }}</td>
                    @foreach($locations as $location)
                    <td class="text-center">
                      <input type="number" name="data[{{ $month }}][{{ $location }}]" value="{{ old("data.$month.$location", 0) }}" min="0" max="999" class="form-control-sm" required>
                    </td>
                    @endforeach
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 justify-content-end mt-4">
              <a href="{{ route('turtle-eggs.locations.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Batal
              </a>
              <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Simpan Semua Data
              </button>
            </div>
          </form>

        </div>
      </div>

      <!-- Quick Fill Helper -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="fas fa-magic text-warning"></i> Bantuan Cepat</h6>
        </div>
        <div class="card-body">
          <p class="mb-2"><strong>Tips Mengisi Data:</strong></p>
          <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillAllWith(0)">
              <i class="fas fa-eraser"></i> Isi Semua dengan 0
            </button>
            <button type="button" class="btn btn-sm btn-outline-success" onclick="focusYear()">
              <i class="fas fa-calendar"></i> Fokus ke Tahun
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sync year input to hidden field
    document.getElementById('year').addEventListener('change', function() {
      document.querySelector('input[name="year"][form="locationForm"]').value = this.value;
    });

    // Set initial year value
    document.querySelector('input[name="year"][form="locationForm"]').value = document.getElementById('year').value;

    // Helper function to fill all inputs with specific value
    function fillAllWith(value) {
      const inputs = document.querySelectorAll('input[type="number"][name^="data"]');
      if (confirm(`Isi semua field dengan nilai ${value}?`)) {
        inputs.forEach(input => {
          input.value = value;
        });
      }
    }

    // Focus to year input
    function focusYear() {
      document.getElementById('year').focus();
      document.getElementById('year').select();
    }

    // Keyboard navigation
    document.querySelectorAll('input[type="number"][name^="data"]').forEach((input, index, inputs) => {
      input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          const nextInput = inputs[index + 1];
          if (nextInput) {
            nextInput.focus();
            nextInput.select();
          }
        }
      });

      // Auto select on focus
      input.addEventListener('focus', function() {
        this.select();
      });
    });

  </script>
</x-app-layout>
