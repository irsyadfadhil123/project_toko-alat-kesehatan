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
        <script src="//unpkg.com/alpinejs" defer></script>
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

        {{-- Modal Flash Message (Success / Error) --}}
        @php
            $flashSuccess = session('success');
            $flashError = session('error') ?? (session('status') && session('status') !== true ? session('status') : null);
        @endphp
        @if($flashSuccess || $flashError)
            <div x-data="{ open: true }"
                 x-show="open"
                 x-transition.opacity
                 class="fixed inset-0 z-40 flex items-center justify-center px-4 py-6">
                <div class="fixed inset-0 bg-black/40" @click="open=false"></div>

                <div class="relative z-10 w-full max-w-md">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <div class="flex items-start gap-3">
                            @if($flashSuccess)
                                <div class="shrink-0 text-green-600">
                                    <!-- Check icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M2.25 12a9.75 9.75 0 1119.5 0 9.75 9.75 0 01-19.5 0zm14.03-2.28a.75.75 0 10-1.06-1.06l-4.72 4.72-2.22-2.22a.75.75 0 10-1.06 1.06l2.75 2.75c.3.3.79.3 1.06 0l5.25-5.25z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900">Berhasil</h3>
                                    <p class="mt-1 text-sm text-gray-700">{{ $flashSuccess }}</p>
                                </div>
                            @else
                                <div class="shrink-0 text-red-600">
                                    <!-- Error icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zM10.94 8.44a.75.75 0 011.06 0l.53.53.53-.53a.75.75 0 111.06 1.06l-.53.53.53.53a.75.75 0 11-1.06 1.06l-.53-.53-.53.53a.75.75 0 11-1.06-1.06l.53-.53-.53-.53a.75.75 0 010-1.06zM9.75 15a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900">Gagal</h3>
                                    <p class="mt-1 text-sm text-gray-700">{{ $flashError }}</p>
                                </div>
                            @endif
                            <button @click="open=false" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 11-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <x-primary-button @click="open=false">Tutup</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
