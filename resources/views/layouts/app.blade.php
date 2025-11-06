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
                        <footer class="bg-white border-t">
                            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                                @if($user)
                                    {{-- Feedback (customer login): hanya rating + message --}}
                                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Kirim Feedback</h3>
                                            <span class="text-xs text-gray-500">Bantu kami meningkatkan pelayanan</span>
                                        </div>

                                        <form action="{{ route('feedbacks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @csrf
                                            <div>
                                                <x-input-label for="footer_rating" value="Rating" />
                                                <select id="footer_rating" name="rating"
                                                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="">-- Pilih Rating --</option>
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                                            {{ $i }} Bintang
                                                        </option>
                                                    @endfor
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('rating')" />
                                            </div>

                                            <div class="md:col-span-2">
                                                <x-input-label for="footer_message" value="Pesan" />
                                                <textarea id="footer_message" name="message" rows="3"
                                                          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                          placeholder="Tulis pengalaman Anda...">{{ old('message') }}</textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                                            </div>

                                            <div class="md:col-span-3 flex justify-end">
                                                <x-primary-button>Kirim Feedback</x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    {{-- Guest Book (belum login) --}}
                                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Buku Tamu</h3>
                                            <span class="text-xs text-gray-500">Tinggalkan pesan untuk kami</span>
                                        </div>

                                        <form action="{{ route('guestBook.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @csrf
                                            <div>
                                                <x-input-label for="guest_name" value="Nama" />
                                                <x-text-input id="guest_name" name="name" type="text" class="mt-1 block w-full"
                                                              value="{{ old('name') }}" required />
                                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                            </div>

                                            <div>
                                                <x-input-label for="guest_email" value="Email" />
                                                <x-text-input id="guest_email" name="email" type="email" class="mt-1 block w-full"
                                                              value="{{ old('email') }}" required />
                                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                            </div>

                                            <div class="md:col-span-3">
                                                <x-input-label for="guest_message" value="Pesan" />
                                                <textarea id="guest_message" name="message" rows="3"
                                                          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                          placeholder="Tulis pesan Anda...">{{ old('message') }}</textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                                            </div>

                                            <div class="md:col-span-3 flex justify-end">
                                                <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                                                    Kirim Buku Tamu
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                                {{-- Footer bottom meta --}}
                                <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-gray-500">
                                    <p>&copy; {{ date('Y') }} Toko Alat Kesehatan. Semua hak dilindungi.</p>
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('products.index') }}" class="hover:text-gray-700">Produk</a>
                                        <a href="{{ route('home') }}" class="hover:text-gray-700">Beranda</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    @endif
            </div>
        </body>
    </html>
