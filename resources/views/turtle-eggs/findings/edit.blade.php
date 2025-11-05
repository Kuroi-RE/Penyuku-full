<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Temuan Sarang Penyu') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <div class="py-12">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">

          <!-- Back Button -->
          <div class="mb-4">
            <a href="{{ route('turtle-eggs.findings.index') }}" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
          </div>

          <!-- Form Card -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
              <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Data Temuan Sarang</h5>
            </div>
            <div class="card-body p-4">

              @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <form action="{{ route('turtle-eggs.findings.update', $finding) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                  <!-- Tanggal Temuan -->
                  <div class="col-md-6 mb-3">
                    <label for="finding_date" class="form-label fw-bold">
                      Tanggal Temuan <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control @error('finding_date') is-invalid @enderror" id="finding_date" name="finding_date" value="{{ old('finding_date', $finding->finding_date->format('Y-m-d')) }}" required>
                    @error('finding_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Kode Sarang -->
                  <div class="col-md-6 mb-3">
                    <label for="nest_code" class="form-label fw-bold">
                      Kode Sarang <small class="text-muted">(Opsional)</small>
                    </label>
                    <input type="text" class="form-control @error('nest_code') is-invalid @enderror" id="nest_code" name="nest_code" value="{{ old('nest_code', $finding->nest_code) }}" placeholder="Contoh: P1, P2, P3...">
                    <small class="text-muted">Kosongkan jika telur diambil nelayan</small>
                    @error('nest_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <!-- Lokasi -->
                  <div class="col-md-6 mb-3">
                    <label for="location" class="form-label fw-bold">
                      Lokasi Pantai <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                      <option value="">Pilih Lokasi...</option>
                      @foreach($locations as $loc)
                      <option value="{{ $loc }}" {{ old('location', $finding->location) == $loc ? 'selected' : '' }}>
                        {{ $loc }}
                      </option>
                      @endforeach
                    </select>
                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Jumlah Telur -->
                  <div class="col-md-6 mb-3">
                    <label for="egg_count" class="form-label fw-bold">
                      Jumlah Telur <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('egg_count') is-invalid @enderror" id="egg_count" name="egg_count" value="{{ old('egg_count', $finding->egg_count) }}" min="0" required>
                    @error('egg_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <!-- Perkiraan Menetas -->
                  <div class="col-md-6 mb-3">
                    <label for="estimated_hatching_date" class="form-label fw-bold">
                      Perkiraan Tanggal Menetas <small class="text-muted">(Opsional)</small>
                    </label>
                    <input type="date" class="form-control @error('estimated_hatching_date') is-invalid @enderror" id="estimated_hatching_date" name="estimated_hatching_date" value="{{ old('estimated_hatching_date', $finding->estimated_hatching_date?->format('Y-m-d')) }}">
                    @error('estimated_hatching_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Jumlah Menetas -->
                  <div class="col-md-6 mb-3">
                    <label for="hatched_count" class="form-label fw-bold">
                      Jumlah yang Menetas <small class="text-muted">(Opsional)</small>
                    </label>
                    <input type="number" class="form-control @error('hatched_count') is-invalid @enderror" id="hatched_count" name="hatched_count" value="{{ old('hatched_count', $finding->hatched_count) }}" min="0">
                    <small class="text-muted">
                      Persentase saat ini: <strong>{{ number_format($finding->hatching_percentage, 1) }}%</strong>
                    </small>
                    @error('hatched_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                  <label for="status" class="form-label fw-bold">
                    Status <span class="text-danger">*</span>
                  </label>
                  <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status...</option>
                    <option value="monitoring" {{ old('status', $finding->status) == 'monitoring' ? 'selected' : '' }}>
                      Monitoring
                    </option>
                    <option value="hatched" {{ old('status', $finding->status) == 'hatched' ? 'selected' : '' }}>
                      Sudah Menetas
                    </option>
                    <option value="taken_by_fisherman" {{ old('status', $finding->status) == 'taken_by_fisherman' ? 'selected' : '' }}>
                      Diambil Nelayan
                    </option>
                  </select>
                  @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                  <label for="notes" class="form-label fw-bold">
                    Catatan Tambahan <small class="text-muted">(Opsional)</small>
                  </label>
                  <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Catatan atau informasi tambahan tentang temuan ini...">{{ old('notes', $finding->notes) }}</textarea>
                  @error('notes')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 justify-content-end">
                  <a href="{{ route('turtle-eggs.findings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                  </a>
                  <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Update Data
                  </button>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
