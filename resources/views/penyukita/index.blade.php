<x-app-layout>
  <!-- Hero Section -->
  <div class="relative bg-gradient-to-r from-teal-600 to-blue-600 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
          PenyuKita - Bersama Lindungi Penyu
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-teal-100">
          Blog & Kegiatan Konservasi Penyu Cilacap
        </p>
        <div class="flex justify-center gap-8 text-center">
          <div>
            <div class="text-3xl font-bold">{{ $articles->total() }}</div>
            <div class="text-sm text-teal-100">Artikel & Kegiatan</div>
          </div>
          <div>
            <div class="text-3xl font-bold">7</div>
            <div class="text-sm text-teal-100">Spesies Penyu</div>
          </div>
          <div>
            <div class="text-3xl font-bold">1000+</div>
            <div class="text-sm text-teal-100">Tukik Dilepasliarkan</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Edukasi Penyu Section -->
      <div class="mb-12 bg-white rounded-lg shadow-md p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
          🌊 Mengapa Konservasi Penyu Penting?
        </h2>
        <div class="grid md:grid-cols-3 gap-6">
          <div class="text-center p-6 bg-teal-50 rounded-lg">
            <div class="text-4xl mb-3">🌍</div>
            <h3 class="text-xl font-semibold mb-2 text-teal-800">Ekosistem Laut</h3>
            <p class="text-gray-600">Penyu menjaga keseimbangan ekosistem laut dengan memakan ubur-ubur dan menjaga kesehatan terumbu karang.</p>
          </div>
          <div class="text-center p-6 bg-blue-50 rounded-lg">
            <div class="text-4xl mb-3">⚠️</div>
            <h3 class="text-xl font-semibold mb-2 text-blue-800">Terancam Punah</h3>
            <p class="text-gray-600">6 dari 7 spesies penyu terancam punah akibat polusi plastik, perburuan, dan kerusakan habitat.</p>
          </div>
          <div class="text-center p-6 bg-green-50 rounded-lg">
            <div class="text-4xl mb-3">💚</div>
            <h3 class="text-xl font-semibold mb-2 text-green-800">Warisan Alam</h3>
            <p class="text-gray-600">Penyu telah ada selama 100 juta tahun. Kita bertanggung jawab melindungi mereka untuk generasi mendatang.</p>
          </div>
        </div>
      </div>

      <!-- Search & Filter -->
      <div class="mb-8">
        <form action="{{ route('penyukita.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
          <!-- Search -->
          <div class="flex-1 min-w-[300px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Artikel</label>
            <div class="relative">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, konten..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>

          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
              <option value="all">Semua Kategori</option>
              @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
            Cari
          </button>

          <!-- Reset Button -->
          @if(request('search') || request('category'))
          <a href="{{ route('penyukita.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
            Reset
          </a>
          @endif
        </form>
      </div>

      <!-- Results Info -->
      @if(request('search') || request('category'))
      <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-blue-800">
          Menampilkan <strong>{{ $articles->total() }}</strong> hasil
          @if(request('search'))
          untuk pencarian "<strong>{{ request('search') }}</strong>"
          @endif
          @if(request('category') && request('category') != 'all')
          di kategori "<strong>{{ request('category') }}</strong>"
          @endif
        </p>
      </div>
      @endif

      <!-- Blog/Activity Cards -->
      <div id="activities-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
        <a href="{{ route('articles.public.show', $article->slug) }}" class="activity-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1" data-category="{{ $article->category }}">
          <!-- Image -->
          <div class="relative h-48 overflow-hidden">
            @if($article->image)
            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center">
              <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            @endif
            <div class="absolute top-4 left-4">
              <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ $article->category === 'Kegiatan' ? 'bg-teal-500 text-white' : '' }}
                {{ $article->category === 'Edukasi' ? 'bg-amber-500 text-white' : '' }}
                {{ $article->category === 'Berita' ? 'bg-blue-500 text-white' : '' }}
                {{ $article->category === 'Panduan' ? 'bg-purple-500 text-white' : '' }}
                {{ $article->category === 'Penelitian' ? 'bg-pink-500 text-white' : '' }}">
                {{ $article->category }}
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-6">
            <div class="flex items-center text-sm text-gray-500 mb-3">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
              </svg>
              {{ $article->created_at->format('d M Y') }}
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
              {{ $article->title }}
            </h3>

            <p class="text-gray-600 mb-4 line-clamp-3">
              {{ $article->excerpt }}
            </p>

            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-gray-500 pt-4 border-t border-gray-200">
              <div class="flex items-center gap-4">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                  </svg>
                  {{ $article->views }}
                </span>
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                  </svg>
                  {{ $article->likes_count }}
                </span>
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                  </svg>
                  {{ $article->comments_count }}
                </span>
              </div>
              <span class="text-teal-600 font-semibold">
                Baca →
              </span>
            </div>
          </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16">
          <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada artikel</h3>
          <p class="text-gray-500">{{ request('search') ? 'Tidak ada artikel yang cocok dengan pencarian Anda.' : 'Artikel akan segera hadir!' }}</p>
        </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($articles->hasPages())
      <div class="mt-12">
        {{ $articles->links() }}
      </div>
      @endif



    </div>
  </div>

  <style>
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

  </style>
</x-app-layout>
