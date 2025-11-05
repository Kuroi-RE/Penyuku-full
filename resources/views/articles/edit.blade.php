<x-app-layout>
  <div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Header -->
      <div class="mb-8">
        <a href="{{ route('articles.index') }}" class="text-teal-600 hover:text-teal-800 mb-4 inline-block">
          ← Kembali ke Daftar Artikel
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Artikel</h1>
        <p class="text-gray-600 mt-2">Perbarui artikel konservasi penyu</p>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Title -->
          <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Judul Artikel <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Masukkan judul artikel..." required>
            @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Category -->
          <div class="mb-6">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
              Kategori <span class="text-red-500">*</span>
            </label>
            <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
              <option value="">Pilih Kategori</option>
              @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ old('category', $article->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
            @error('category')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Current Image -->
          @if($article->image)
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="h-48 w-auto rounded-lg object-cover">
          </div>
          @endif

          <!-- Image Upload -->
          <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $article->image ? 'Ganti Gambar Header' : 'Gambar Header' }}
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-teal-500 transition">
              <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500">
                    <span>Upload file</span>
                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                  </label>
                  <p class="pl-1">atau drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF sampai 2MB</p>
              </div>
            </div>
            <div id="imagePreview" class="mt-4 hidden">
              <img src="" alt="Preview" class="max-w-full h-64 rounded-lg object-cover">
            </div>
            @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Excerpt -->
          <div class="mb-6">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
              Ringkasan <span class="text-red-500">*</span>
            </label>
            <textarea name="excerpt" id="excerpt" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Tulis ringkasan singkat artikel (maks 500 karakter)..." required>{{ old('excerpt', $article->excerpt) }}</textarea>
            <p class="mt-1 text-sm text-gray-500">
              <span id="excerptCount">0</span>/500 karakter
            </p>
            @error('excerpt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Content -->
          <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
              Konten Artikel <span class="text-red-500">*</span>
            </label>
            <textarea name="content" id="content" rows="15" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Tulis konten artikel lengkap di sini..." required>{{ old('content', $article->content) }}</textarea>
            @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status -->
          <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
              Status Publikasi <span class="text-red-500">*</span>
            </label>
            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
              <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft (Belum dipublikasikan)</option>
              <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published (Langsung tayang)</option>
            </select>
            @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Submit Buttons -->
          <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('articles.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
              Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
              Update Artikel
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>

  <script>
    // Image preview
    function previewImage(event) {
      const preview = document.getElementById('imagePreview');
      const img = preview.querySelector('img');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
          preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      }
    }

    // Character counter for excerpt
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerptCount');

    excerptTextarea.addEventListener('input', function() {
      const length = this.value.length;
      excerptCount.textContent = length;

      if (length > 500) {
        excerptCount.classList.add('text-red-600');
      } else {
        excerptCount.classList.remove('text-red-600');
      }
    });

    // Initialize count
    excerptCount.textContent = excerptTextarea.value.length;

  </script>
</x-app-layout>
