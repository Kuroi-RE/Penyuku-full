<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-2xl font-bold mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>
          {{-- <p class="mb-2">Role: <span class="font-semibold">{{ ucfirst(Auth::user()->role) }}</span></p> --}}
          <p class="mb-2">Today is: <span class="font-semibold">{{ now()->format('l, d F Y') }}</span></p>

          @if(Auth::user()->role === 'penangkaran')
          <div class="mt-6">
            <h4 class="text-lg font-semibold mb-3">Menu Admin Penangkaran:</h4>
            <ul class="space-y-2">
              <li><a href="{{ route('turtle-eggs.index') }}" class="text-blue-600 hover:underline">📊 Kelola Data Telur Penyu</a></li>
              <li><a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">📝 Kelola Postingan</a></li>
              <li><a href="{{ route('chat.index') }}" class="text-blue-600 hover:underline">💬 Chat Global</a></li>
            </ul>
          </div>
          @else
          <div class="mt-6">
            <h4 class="text-lg font-semibold mb-3">Menu:</h4>
            {{-- <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Lihat & Buat Post</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div> --}}
            <ul class="space-y-2">
              <li><a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">📝 Lihat & Buat Postingan</a></li>
              <li><a href="{{ route('chat.index') }}" class="text-blue-600 hover:underline">💬 Chat Global</a></li>
            </ul>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
