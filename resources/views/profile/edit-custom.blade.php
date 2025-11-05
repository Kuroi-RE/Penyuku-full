<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Profil') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .profile-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .nav-tabs .nav-link {
      color: #6c757d;
    }

    .nav-tabs .nav-link.active {
      color: #0d6efd;
      font-weight: 600;
    }

    .alert-success {
      animation: slideIn 0.3s ease-in;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

  </style>

  <div class="py-12">
    <div class="profile-container px-4">
      <!-- Alert Container -->
      <div id="alert-container"></div>

      <div class="card shadow-sm">
        <div class="card-header bg-white">
          <h4 class="mb-0">Pengaturan Profil</h4>
        </div>
        <div class="card-body">
          <!-- Bootstrap Tabs -->
          <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-panel" type="button" role="tab">
                <i class="fas fa-user"></i> Edit Profil
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-panel" type="button" role="tab">
                <i class="fas fa-lock"></i> Ganti Password
              </button>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content" id="profileTabsContent">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="profile-panel" role="tabpanel">
              <form id="profile-form" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo Preview -->
                <div class="mb-3 text-center">
                  <div class="mb-2">
                    @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" id="photo-preview">
                    @else
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 3rem;">
                      {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                    @endif
                  </div>
                </div>

                <div class="mb-3">
                  <label for="profile_photo" class="form-label">Foto Profil</label>
                  <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                  <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                  <div class="invalid-feedback" id="profile_photo-error"></div>
                </div>

                <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                  <div class="invalid-feedback" id="name-error"></div>
                </div>

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username }}" required>
                  <div class="invalid-feedback" id="username-error"></div>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                  <div class="invalid-feedback" id="email-error"></div>
                </div>

                <div class="mb-3">
                  <label for="bio" class="form-label">Bio</label>
                  <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Ceritakan tentang dirimu...">{{ Auth::user()->bio }}</textarea>
                  <small class="text-muted">Maksimal 500 karakter</small>
                  <div class="invalid-feedback" id="bio-error"></div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Role</label>
                  <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" disabled>
                  <small class="text-muted">Role tidak dapat diubah</small>
                </div>

                <button type="submit" class="btn btn-primary" id="profile-submit-btn">
                  <i class="fas fa-save"></i> Simpan Perubahan
                </button>
              </form>
            </div>

            <!-- Password Tab -->
            <div class="tab-pane fade" id="password-panel" role="tabpanel">
              <form id="password-form">
                @csrf
                <div class="mb-3">
                  <label for="current_password" class="form-label">Password Saat Ini</label>
                  <input type="password" class="form-control" id="current_password" name="current_password" required>
                  <div class="invalid-feedback" id="current_password-error"></div>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password Baru</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                  <div class="invalid-feedback" id="password-error"></div>
                </div>

                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary" id="password-submit-btn">
                  <i class="fas fa-key"></i> Ubah Password
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // CSRF Token Setup
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Show Alert
    function showAlert(message, type = 'success') {
      const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
      $('#alert-container').html(alertHtml);

      // Auto hide after 5 seconds
      setTimeout(() => {
        $('.alert').fadeOut();
      }, 5000);
    }

    // Clear Error Messages
    function clearErrors() {
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    }

    // Show Error Messages
    function showErrors(errors) {
      $.each(errors, function(field, messages) {
        $(`#${field}`).addClass('is-invalid');
        $(`#${field}-error`).text(messages[0]);
      });
    }

    $('#profile_photo').on('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          $('#photo-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
      }
    });

    $('#profile-form').on('submit', function(e) {
      e.preventDefault();
      clearErrors();

      const btn = $('#profile-submit-btn');
      btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

      // Use FormData for file upload
      const formData = new FormData(this);

      $.ajax({
        url: '{{ route('profile.update.info') }}'
        , type: 'POST'
        , data: formData
        , processData: false
        , contentType: false
        , success: function(response) {
          showAlert(response.message, 'success');
          btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Perubahan');

          // Reload page after 1 second to show new photo
          setTimeout(function() {
            location.reload();
          }, 1000);
        }
        , error: function(xhr) {
          if (xhr.status === 422) {
            showErrors(xhr.responseJSON.errors);
          } else {
            showAlert('Terjadi kesalahan!', 'danger');
          }
          btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Perubahan');
        }
      });
    });

    // Submit Password Form
    $('#password-form').on('submit', function(e) {
      e.preventDefault();
      clearErrors();

      const btn = $('#password-submit-btn');
      btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

      $.ajax({
        url: '{{ route('profile.update.password') }}'
        , type: 'POST'
        , data: $(this).serialize()
        , success: function(response) {
          showAlert(response.message, 'success');
          $('#password-form')[0].reset();
          btn.prop('disabled', false).html('<i class="fas fa-key"></i> Ubah Password');
        }
        , error: function(xhr) {
          if (xhr.status === 422) {
            showErrors(xhr.responseJSON.errors);
          } else {
            showAlert('Terjadi kesalahan!', 'danger');
          }
          btn.prop('disabled', false).html('<i class="fas fa-key"></i> Ubah Password');
        }
      });
    });

    // Tab switching dengan JavaScript (requirement: wajib pakai JavaScript)
    document.querySelectorAll('#profileTabs button').forEach(button => {
      button.addEventListener('click', function() {
        clearErrors();
        $('#alert-container').empty();
      });
    });

  </script>
</x-app-layout>
