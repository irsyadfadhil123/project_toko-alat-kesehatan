@extends('layouts.app')
@section('title', 'Home')

@section('content')
<section class="space-y-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Selamat Datang di Toko Alat Kesehatan</h1>
                <p class="mt-1 text-gray-600">
                    Temukan perlengkapan kesehatan berkualitas: tensimeter, oksimeter, kursi roda, termometer, dan lainnya.
                </p>
            </div>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Lihat Produk
            </a>
        </div>
    </div>

    {{-- Kategori Unggulan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Kategori Unggulan</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('products.index', ['category' => request('category', '')]) }}"
               class="group border border-gray-100 rounded-xl p-4 hover:shadow transition">
                <div class="h-20 w-full bg-gray-50 rounded-lg mb-3 flex items-center justify-center">
                    <span class="text-3xl">🩺</span>
                </div>
                <p class="font-medium text-gray-900 group-hover:text-indigo-700">Alat Diagnostik</p>
                <p class="text-sm text-gray-500">Tensimeter, Stetoskop, Termometer</p>
            </a>
            <a href="{{ route('products.index') }}" class="group border border-gray-100 rounded-xl p-4 hover:shadow transition">
                <div class="h-20 w-full bg-gray-50 rounded-lg mb-3 flex items-center justify-center">
                    <span class="text-3xl">🧤</span>
                </div>
                <p class="font-medium text-gray-900 group-hover:text-indigo-700">Perlengkapan Klinik</p>
                <p class="text-sm text-gray-500">Sarung Tangan, Masker, Disinfektan</p>
            </a>
            <a href="{{ route('products.index') }}" class="group border border-gray-100 rounded-xl p-4 hover:shadow transition">
                <div class="h-20 w-full bg-gray-50 rounded-lg mb-3 flex items-center justify-center">
                    <span class="text-3xl">🦽</span>
                </div>
                <p class="font-medium text-gray-900 group-hover:text-indigo-700">Rehabilitasi</p>
                <p class="text-sm text-gray-500">Kursi Roda, Walker, Tongkat</p>
            </a>
            <a href="{{ route('products.index') }}" class="group border border-gray-100 rounded-xl p-4 hover:shadow transition">
                <div class="h-20 w-full bg-gray-50 rounded-lg mb-3 flex items-center justify-center">
                    <span class="text-3xl">🧪</span>
                </div>
                <p class="font-medium text-gray-900 group-hover:text-indigo-700">Tes Kesehatan</p>
                <p class="text-sm text-gray-500">Glukometer, Test Pack, Strip</p>
            </a>
        </div>
    </div>

    {{-- Keunggulan Toko --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Mengapa Belanja di Kami?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xl mb-2">✅</p>
                <p class="font-semibold text-gray-900">Produk Terverifikasi</p>
                <p class="text-sm text-gray-600">Kualitas terjamin, sesuai standar kesehatan.</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xl mb-2">🚚</p>
                <p class="font-semibold text-gray-900">Pengiriman Cepat</p>
                <p class="text-sm text-gray-600">Packing aman dan pengiriman tepat waktu.</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xl mb-2">💬</p>
                <p class="font-semibold text-gray-900">Layanan Pelanggan</p>
                <p class="text-sm text-gray-600">Bantuan responsif untuk kebutuhan Anda.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-indigo-900">Butuh rekomendasi alat kesehatan?</h3>
            <p class="text-sm text-indigo-800">Jelajahi katalog dan pilih sesuai kebutuhan rumah tangga atau klinik Anda.</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            Belanja Sekarang
        </a>
    </div>
</section>
@endsection
