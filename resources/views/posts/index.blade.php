<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Postingan Komunitas') }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .post-card {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      margin-bottom: 20px;
      overflow: hidden;
      background: white;
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

    .btn-like {
      border: none;
      background: none;
      cursor: pointer;
      transition: all 0.3s;
      padding: 5px 10px;
    }

    .btn-like:hover {
      transform: scale(1.1);
    }

    .btn-like.liked {
      color: #dc3545;
    }

    .comment-section {
      padding: 15px;
      background: #f8f9fa;
    }

    .comment-item {
      background: white;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .profile-link:hover {
      opacity: 0.8;
      transition: opacity 0.3s;
    }

    .profile-photo-small {
      width: 40px;
      height: 40px;
      object-fit: cover;
    }

    /* Custom Dropdown Styles */
    .custom-dropdown {
      position: relative;
    }

    .custom-dropdown-menu {
      min-width: 150px;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 0.375rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      padding: 0.5rem 0;
      position: absolute;
      right: 0;
      top: 100%;
      z-index: 1000;
      display: none;
    }

    .custom-dropdown-item {
      display: block;
      width: 100%;
      padding: 0.5rem 1rem;
      clear: both;
      font-weight: 400;
      color: #212529;
      text-align: inherit;
      text-decoration: none;
      white-space: nowrap;
      background-color: transparent;
      border: 0;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .custom-dropdown-item:hover {
      background-color: #f8f9fa;
    }

    .custom-dropdown-divider {
      height: 0;
      margin: 0.5rem 0;
      overflow: hidden;
      border-top: 1px solid #dee2e6;
    }

  </style>

  <div class="py-12">
    <div class="container" style="max-width: 800px;">
      <!-- Alert Messages -->
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      <!-- Create Post Form -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-3">
            <i class="fas fa-pen"></i> Buat Postingan Baru
          </h5>
          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <textarea name="content" class="form-control" rows="3" placeholder="Apa yang ingin kamu bagikan tentang penyu?" required>{{ old('content') }}</textarea>
              @error('content')
              <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">
                <i class="fas fa-image"></i> Upload Gambar (Opsional)
              </label>
              <input type="file" name="image" class="form-control" accept="image/*">
              @error('image')
              <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-paper-plane"></i> Posting
            </button>
          </form>
        </div>
      </div>

      <!-- Posts Feed -->
      @foreach($posts as $post)
      <div class="post-card" id="post-{{ $post->id }}">
        <div class="post-header d-flex align-items-center justify-content-between">
          <a href="{{ route('user.profile', $post->user) }}" class="text-decoration-none text-dark d-flex align-items-center profile-link">
            <div class="me-3">
              @if($post->user->profile_photo)
              <img src="{{ asset('storage/' . $post->user->profile_photo) }}" class="rounded-circle profile-photo-small" alt="{{ $post->user->username }}">
              @else
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                {{ strtoupper(substr($post->user->username, 0, 1)) }}
              </div>
              @endif
            </div>
            <div>
              <h6 class="mb-0 fw-bold">{{ $post->user->username }}</h6>
              <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
          </a>

          @if($post->user_id === auth()->id())
          <div class="custom-dropdown">
            <button class="btn btn-sm btn-link text-muted" type="button" onclick="toggleDropdown({{ $post->id }})">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="custom-dropdown-menu" id="dropdown-{{ $post->id }}">
              <button type="button" class="custom-dropdown-item" onclick="openEditModal({{ $post->id }})">
                <i class="fas fa-edit"></i> Edit
              </button>
              <div class="custom-dropdown-divider"></div>
              <button type="button" class="custom-dropdown-item text-danger" onclick="deletePost({{ $post->id }})">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </div>
          @endif
        </div>

        <div class="post-content">
          <p class="mb-2">{{ $post->content }}</p>
          @if($post->image)
          <img src="{{ asset('storage/' . $post->image) }}" class="post-image" alt="Post image">
          @endif
        </div>

        <div class="post-actions d-flex gap-4">
          <button class="btn-like {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}" onclick="toggleLike({{ $post->id }})">
            <i class="fas fa-heart"></i>
            <span class="likes-count">{{ $post->likes_count }}</span> Suka
          </button>
          <button class="btn btn-link text-decoration-none p-0" onclick="toggleComments({{ $post->id }})">
            <i class="fas fa-comment"></i>
            <span class="comments-count">{{ $post->comments_count }}</span> Komentar
          </button>
        </div>

        <!-- Comments Section -->
        <div class="comment-section" id="comments-{{ $post->id }}" style="display: none;">
          <form onsubmit="submitComment(event, {{ $post->id }})" class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" id="comment-input-{{ $post->id }}" placeholder="Tulis komentar..." required>
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-paper-plane"></i> Kirim
              </button>
            </div>
          </form>

          <div id="comments-list-{{ $post->id }}">
            @foreach($post->comments as $comment)
            @include('posts.partials.comment', ['comment' => $comment])
            @endforeach
          </div>
        </div>
      </div>

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                <i class="fas fa-edit"></i> Edit Postingan
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Konten</label>
                  <textarea name="content" class="form-control" rows="4" required>{{ $post->content }}</textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Ganti Gambar (Opsional)</label>
                  <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                @if($post->image)
                <div class="mb-3">
                  <label class="form-label">Gambar Saat Ini:</label>
                  <div>
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail" style="max-height: 200px;">
                  </div>
                </div>
                @endif
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

      @if($posts->isEmpty())
      <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Belum ada postingan. Buat postingan pertamamu!
      </div>
      @endif
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

    // Toggle Custom Dropdown
    function toggleDropdown(postId) {
      // Close all other dropdowns
      $('.custom-dropdown-menu').not(`#dropdown-${postId}`).hide();

      // Toggle current dropdown
      $(`#dropdown-${postId}`).toggle();
    }

    // Open Edit Modal
    function openEditModal(postId) {
      $(`#dropdown-${postId}`).hide();
      var editModal = new bootstrap.Modal(document.getElementById(`editModal${postId}`));
      editModal.show();
    }

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
      if (!$(e.target).closest('.custom-dropdown').length) {
        $('.custom-dropdown-menu').hide();
      }
    });

    // Toggle Like
    function toggleLike(postId) {
      $.ajax({
        url: `/posts/${postId}/like`
        , type: 'POST'
        , success: function(response) {
          const btn = $(`.btn-like[data-post-id="${postId}"]`);
          btn.toggleClass('liked', response.liked);
          btn.find('.likes-count').text(response.likes_count);
        }
        , error: function(xhr) {
          console.error('Error:', xhr);
          alert('Terjadi kesalahan saat menyukai postingan!');
        }
      });
    }

    // Toggle Comments Display
    function toggleComments(postId) {
      $(`#comments-${postId}`).slideToggle();
    }

    // Submit Comment
    function submitComment(event, postId) {
      event.preventDefault();

      const input = $(`#comment-input-${postId}`);
      const body = input.val();

      $.ajax({
        url: `/posts/${postId}/comment`
        , type: 'POST'
        , data: {
          body: body
        }
        , success: function(response) {
          $(`#comments-list-${postId}`).append(response.html);
          input.val('');

          // Update comment count
          const currentCount = parseInt($(`#post-${postId} .comments-count`).text());
          $(`#post-${postId} .comments-count`).text(currentCount + 1);
        }
        , error: function(xhr) {
          console.error('Error:', xhr);
          alert('Terjadi kesalahan saat menambahkan komentar!');
        }
      });
    }

    // Delete Comment
    function deleteComment(commentId, postId) {
      if (!confirm('Yakin ingin menghapus komentar ini?')) return;

      $.ajax({
        url: `/comments/${commentId}`
        , type: 'DELETE'
        , success: function(response) {
          $(`#comment-${commentId}`).fadeOut(300, function() {
            $(this).remove();
          });

          // Update comment count
          const currentCount = parseInt($(`#post-${postId} .comments-count`).text());
          $(`#post-${postId} .comments-count`).text(currentCount - 1);
        }
        , error: function(xhr) {
          console.error('Error:', xhr);
          alert('Terjadi kesalahan saat menghapus komentar!');
        }
      });
    }

    // Delete Post
    function deletePost(postId) {
      // Hide dropdown first
      $(`#dropdown-${postId}`).hide();

      if (!confirm('Yakin ingin menghapus postingan ini?\n\nPostingan yang dihapus tidak dapat dikembalikan.')) {
        return;
      }

      $.ajax({
        url: `/posts/${postId}`
        , type: 'POST'
        , data: {
          _method: 'DELETE'
          , _token: $('meta[name="csrf-token"]').attr('content')
        }
        , beforeSend: function() {
          // Add loading state
          $(`#post-${postId}`).css('opacity', '0.5');
        }
        , success: function(response) {
          // Remove post from DOM with animation
          $(`#post-${postId}`).fadeOut(300, function() {
            $(this).remove();
          });

          // Show success message
          const alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> Postingan berhasil dihapus!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
          $('.container').prepend(alertHtml);

          // Auto hide alert after 3 seconds
          setTimeout(function() {
            $('.alert-success').fadeOut();
          }, 3000);
        }
        , error: function(xhr) {
          console.error('Error:', xhr);
          $(`#post-${postId}`).css('opacity', '1');
          alert('Gagal menghapus postingan: ' + (xhr.responseJSON ? .message || 'Terjadi kesalahan'));
        }
      });
    }

    // Auto-hide success alerts on page load
    setTimeout(function() {
      $('.alert-success').fadeOut();
    }, 5000);

  </script>
</x-app-layout>
