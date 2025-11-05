<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Profil {{ $user->username }}
    </h2>
  </x-slot>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .profile-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 40px 0;
      color: white;
    }

    .profile-photo {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border: 5px solid white;
    }

    .profile-photo-placeholder {
      width: 150px;
      height: 150px;
      border: 5px solid white;
      font-size: 4rem;
    }

    .stats-box {
      text-align: center;
      padding: 15px;
    }

    .stats-number {
      font-size: 1.5rem;
      font-weight: bold;
      color: #667eea;
    }

    .stats-label {
      color: #6c757d;
      font-size: 0.875rem;
    }

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
      color: #6c757d;
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
      border-left: 3px solid #667eea;
    }

  </style>

  <div class="profile-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-3 text-center">
          @if($user->profile_photo)
          <img src="{{ asset('storage/' . $user->profile_photo) }}" class="rounded-circle profile-photo" alt="{{ $user->username }}">
          @else
          <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center profile-photo-placeholder">
            {{ strtoupper(substr($user->username, 0, 1)) }}
          </div>
          @endif
        </div>
        <div class="col-md-9">
          <h2 class="mb-2">{{ $user->name }}</h2>
          <p class="mb-2"><i class="fas fa-at"></i> {{ $user->username }}</p>
          <p class="mb-2"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
          <p class="mb-3">
            <span class="badge bg-light text-dark">
              <i class="fas fa-user-tag"></i> {{ ucfirst($user->role) }}
            </span>
          </p>
          @if($user->bio)
          <p class="mb-0"><i class="fas fa-info-circle"></i> {{ $user->bio }}</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="py-5">
    <div class="container" style="max-width: 1000px;">
      <!-- Statistics -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body stats-box">
              <div class="stats-number">{{ $stats['total_posts'] }}</div>
              <div class="stats-label">Postingan</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body stats-box">
              <div class="stats-number">{{ $stats['total_likes'] }}</div>
              <div class="stats-label">Total Suka</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body stats-box">
              <div class="stats-number">{{ $stats['total_comments'] }}</div>
              <div class="stats-label">Total Komentar</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Posts -->
      <h4 class="mb-4">
        <i class="fas fa-images"></i> Postingan {{ $user->username }}
      </h4>

      @forelse($user->posts as $post)
      <div class="post-card" id="post-{{ $post->id }}">
        <div class="post-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="me-3">
              @if($user->profile_photo)
              <img src="{{ asset('storage/' . $user->profile_photo) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
              @else
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                {{ strtoupper(substr($user->username, 0, 1)) }}
              </div>
              @endif
            </div>
            <div>
              <h6 class="mb-0 fw-bold">{{ $user->username }}</h6>
              <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
          </div>
        </div>

        <div class="post-content">
          <p class="mb-2">{{ $post->content }}</p>
          @if($post->image)
          <img src="{{ asset('storage/' . $post->image) }}" class="post-image" alt="Post image">
          @endif
        </div>

        <div class="post-actions d-flex gap-4">
          @auth
          <button class="btn-like {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}" onclick="toggleLike({{ $post->id }})">
            <i class="fas fa-heart"></i>
            <span class="likes-count">{{ $post->likes_count }}</span> Suka
          </button>
          <button class="btn btn-link text-decoration-none p-0" onclick="toggleComments({{ $post->id }})">
            <i class="fas fa-comment"></i>
            <span class="comments-count">{{ $post->comments_count }}</span> Komentar
          </button>
          @else
          <span>
            <i class="fas fa-heart text-danger"></i>
            {{ $post->likes_count }} Suka
          </span>
          <span>
            <i class="fas fa-comment text-primary"></i>
            {{ $post->comments_count }} Komentar
          </span>
          @endauth
        </div>

        <!-- Comments Section -->
        @auth
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
        @else
        <!-- Comments Preview (First 3) for guests -->
        @if($post->comments->count() > 0)
        <div class="comment-section">
          <h6 class="mb-3">Komentar:</h6>
          @foreach($post->comments->take(3) as $comment)
          <div class="comment-item">
            <strong>{{ $comment->user->username }}</strong>
            <p class="mb-0">{{ $comment->body }}</p>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
          </div>
          @endforeach
          @if($post->comments->count() > 3)
          <p class="text-muted small mb-0 mt-2">
            dan {{ $post->comments->count() - 3 }} komentar lainnya...
          </p>
          @endif
        </div>
        @endif
        @endauth
      </div>
      @empty
      <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> {{ $user->username }} belum memiliki postingan.
      </div>
      @endforelse
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

  </script>
</x-app-layout>
