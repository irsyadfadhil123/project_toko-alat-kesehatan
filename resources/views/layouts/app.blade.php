<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Toko Alat Kesehatan | @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
                <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                    @yield('content')

                </main>
                {{-- Footer Feedback / Guest Book --}}
                @php($user = auth()->user())
                @if(!$user || ($user && $user->role !== 'admin'))
                    <footer class="bg-white border-t mt-10">
                        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                            @if($user)
                                {{-- Feedback (customer login): hanya rating + message --}}
                                <h3 class="text-lg font-semibold mb-4">Kirim Feedback</h3>
                                <form action="{{ route('feedbacks.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm text-gray-700">Rating</label>
                                        <select name="rating" class="mt-1 w-full border rounded p-2" required>
                                            <option value="">-- Pilih Rating --</option>
                                            @for($i = 5; $i >= 1; $i--)
                                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                                    {{ $i }} {{ $i == 1 ? 'bintang' : 'bintang' }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('rating') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-700">Pesan</label>
                                        <textarea name="message" rows="3" class="mt-1 w-full border rounded p-2" required>{{ old('message') }}</textarea>
                                        @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Kirim Feedback
                                    </button>
                                </form>
                            @else
                                {{-- Guest Book (belum login) tetap seperti sebelumnya --}}
                                <h3 class="text-lg font-semibold mb-4">Buku Tamu</h3>
                                <form action="{{ route('guestBook.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm text-gray-700">Nama</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded p-2" required>
                                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-700">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded p-2" required>
                                        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-700">Pesan</label>
                                        <textarea name="message" rows="3" class="mt-1 w-full border rounded p-2" required>{{ old('message') }}</textarea>
                                        @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        Kirim Buku Tamu
                                    </button>
                                </form>
                            @endif
                        </div>
                    </footer>
                @endif
            </div>
        </body>
    </html>
