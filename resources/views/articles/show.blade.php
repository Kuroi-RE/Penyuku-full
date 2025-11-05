<x-app-layout>
  <!-- Article Header -->
  <div class="relative bg-gradient-to-r from-teal-600 to-blue-600 text-white py-20">
    <div class="absolute inset-0 bg-black opacity-30"></div>
    @if($article->image)
    <div class="absolute inset-0 opacity-20">
      <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
    </div>
    @endif
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <a href="{{ route('penyukita.index') }}" class="text-white hover:text-teal-100 mb-4 inline-block">
        ← Kembali ke PenyuKita
      </a>
      <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full mb-4
        {{ $article->category === 'Kegiatan' ? 'bg-teal-500' : '' }}
        {{ $article->category === 'Edukasi' ? 'bg-amber-500' : '' }}
        {{ $article->category === 'Berita' ? 'bg-blue-500' : '' }}
        {{ $article->category === 'Panduan' ? 'bg-purple-500' : '' }}
        {{ $article->category === 'Penelitian' ? 'bg-pink-500' : '' }}">
        {{ $article->category }}
      </span>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $article->title }}</h1>
      <div class="flex items-center gap-6 text-teal-100">
        <div class="flex items-center">
          <img src="{{ $article->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($article->user->name) }}" alt="{{ $article->user->name }}" class="w-10 h-10 rounded-full mr-2">
          <span>{{ $article->user->name }}</span>
        </div>
        <span>{{ $article->created_at->format('d M Y') }}</span>
        <span>👁️ {{ $article->views }} views</span>
      </div>
    </div>
  </div>

  <!-- Article Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Main Content Card -->
      <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <!-- Excerpt -->
        <div class="text-xl text-gray-600 italic border-l-4 border-teal-500 pl-4 mb-8">
          {{ $article->excerpt }}
        </div>

        <!-- Featured Image -->
        @if($article->image)
        <div class="mb-8">
          <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-96 object-cover rounded-lg">
        </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg max-w-none">
          {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Article Footer (Like & Share) -->
        <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-200">
          <div class="flex items-center gap-4">
            <!-- Like Button -->
            <button onclick="toggleLike({{ $article->id }})" class="btn-like flex items-center gap-2 px-4 py-2 rounded-full transition {{ $isLiked ? 'liked bg-red-50' : 'bg-gray-100' }}" id="likeBtn">
              <svg class="w-6 h-6 {{ $isLiked ? 'text-red-500' : 'text-gray-600' }}" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              <span id="likeCount">{{ $article->likes_count }}</span>
            </button>

            <!-- Comment Count -->
            <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full">
              <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
              <span>{{ $article->comments_count }} Komentar</span>
            </div>
          </div>

          <!-- Share Buttons -->
          <div class="flex items-center gap-2">
            <span class="text-gray-600 mr-2">Bagikan:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.public.show', $article->slug)) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" /></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('articles.public.show', $article->slug)) }}&text={{ urlencode($article->title) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-sky-500 text-white rounded-full hover:bg-sky-600 transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" /></svg>
            </a>
            <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('articles.public.show', $article->slug)) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-green-600 text-white rounded-full hover:bg-green-700 transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" /></svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Comments Section -->
      <div class="bg-white rounded-lg shadow-md p-8" id="comments-section">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
          Komentar ({{ $article->comments_count }})
        </h2>

        <!-- Comment Form -->
        <form onsubmit="submitComment(event, {{ $article->id }})" class="mb-8">
          @csrf
          <textarea id="commentContent" placeholder="Tulis komentar Anda..." rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required></textarea>
          <button type="submit" class="mt-3 px-6 py-2 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
            Kirim Komentar
          </button>
        </form>

        <!-- Comments List -->
        <div id="commentsList" class="space-y-4">
          @forelse($article->comments as $comment)
          <div class="comment-item border-l-4 border-teal-500 bg-gray-50 p-4 rounded-r-lg" data-comment-id="{{ $comment->id }}">
            <div class="flex items-start justify-between">
              <div class="flex items-start gap-3 flex-1">
                <img src="{{ $comment->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                  <div class="flex items-center gap-2 mb-1">
                    <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                  </div>
                  <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
              </div>
              @if(Auth::id() === $comment->user_id)
              <button onclick="deleteComment({{ $comment->id }})" class="text-red-600 hover:text-red-800 ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
              @endif
            </div>
          </div>
          @empty
          <p class="text-center text-gray-500 py-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
          @endforelse
        </div>
      </div>

      <!-- Related Articles -->
      @if($relatedArticles->count() > 0)
      <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Artikel Terkait</h2>
        <div class="grid md:grid-cols-3 gap-6">
          @foreach($relatedArticles as $related)
          <a href="{{ route('articles.public.show', $related->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
            @if($related->image)
            <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
              <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            @endif
            <div class="p-4">
              <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $related->title }}</h3>
              <p class="text-sm text-gray-600 line-clamp-2">{{ $related->excerpt }}</p>
              <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                <span>👁️ {{ $related->views }}</span>
                <span>❤️ {{ $related->likes_count }}</span>
                <span>💬 {{ $related->comments_count }}</span>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

    </div>
  </div>

  <style>
    .btn-like.liked {
      background-color: #fee2e2;
    }

    .prose p {
      margin-bottom: 1rem;
    }

    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

  </style>

  <script>
    // Toggle Like
    function toggleLike(articleId) {
      fetch(`/articles/${articleId}/like`, {
          method: 'POST'
          , headers: {
            'Content-Type': 'application/json'
            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const btn = document.getElementById('likeBtn');
            const svg = btn.querySelector('svg');
            const count = document.getElementById('likeCount');

            if (data.isLiked) {
              btn.classList.add('liked', 'bg-red-50');
              btn.classList.remove('bg-gray-100');
              svg.classList.add('text-red-500');
              svg.classList.remove('text-gray-600');
              svg.setAttribute('fill', 'currentColor');
            } else {
              btn.classList.remove('liked', 'bg-red-50');
              btn.classList.add('bg-gray-100');
              svg.classList.remove('text-red-500');
              svg.classList.add('text-gray-600');
              svg.setAttribute('fill', 'none');
            }

            count.textContent = data.likesCount;
          }
        });
    }

    // Submit Comment
    function submitComment(event, articleId) {
      event.preventDefault();

      const content = document.getElementById('commentContent').value;

      fetch(`/articles/${articleId}/comment`, {
          method: 'POST'
          , headers: {
            'Content-Type': 'application/json'
            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
          , body: JSON.stringify({
            content
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Clear form
            document.getElementById('commentContent').value = '';

            // Add new comment to list
            const commentsList = document.getElementById('commentsList');
            const newComment = `
            <div class="comment-item border-l-4 border-teal-500 bg-gray-50 p-4 rounded-r-lg" data-comment-id="${data.comment.id}">
              <div class="flex items-start justify-between">
                <div class="flex items-start gap-3 flex-1">
                  <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.comment.user.name)}" 
                       alt="${data.comment.user.name}" 
                       class="w-10 h-10 rounded-full">
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                      <span class="font-semibold text-gray-800">${data.comment.user.name}</span>
                      <span class="text-sm text-gray-500">baru saja</span>
                    </div>
                    <p class="text-gray-700">${data.comment.content}</p>
                  </div>
                </div>
                <button onclick="deleteComment(${data.comment.id})" 
                        class="text-red-600 hover:text-red-800 ml-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                </button>
              </div>
            </div>
          `;

            if (commentsList.querySelector('p')) {
              commentsList.innerHTML = newComment;
            } else {
              commentsList.insertAdjacentHTML('afterbegin', newComment);
            }

            // Update comment count
            const commentCountEl = document.querySelector('.bg-white.rounded-lg.shadow-md h2');
            const currentCount = parseInt(commentCountEl.textContent.match(/\d+/)[0]);
            commentCountEl.textContent = `Komentar (${currentCount + 1})`;
          }
        });
    }

    // Delete Comment
    function deleteComment(commentId) {
      if (!confirm('Yakin ingin menghapus komentar ini?')) return;

      fetch(`/article-comments/${commentId}`, {
          method: 'DELETE'
          , headers: {
            'Content-Type': 'application/json'
            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Remove comment from DOM
            const commentEl = document.querySelector(`[data-comment-id="${commentId}"]`);
            commentEl.remove();

            // Update comment count
            const commentCountEl = document.querySelector('.bg-white.rounded-lg.shadow-md h2');
            const currentCount = parseInt(commentCountEl.textContent.match(/\d+/)[0]);
            commentCountEl.textContent = `Komentar (${currentCount - 1})`;

            // If no comments left, show empty message
            if (document.querySelectorAll('.comment-item').length === 0) {
              document.getElementById('commentsList').innerHTML = '<p class="text-center text-gray-500 py-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>';
            }
          }
        });
    }

  </script>
</x-app-layout>
