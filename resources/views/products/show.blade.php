@extends('layouts.app')
@section('title', $product->name)

@section('content')
<section class="space-y-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Gambar Produk --}}
            <div>
                <div class="w-full aspect-[4/3] bg-gray-100 rounded-2xl overflow-hidden flex items-center justify-center">
                    <img
                        src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}"
                        alt="{{ $product->name }}"
                        class="object-cover w-full h-full">
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="flex flex-col gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Harga</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Stok</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->stock }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Ketersediaan</p>
                        <p class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                    <div class="prose prose-sm max-w-none text-gray-800">
                        {{ $product->description ?: 'Tidak ada deskripsi.' }}
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="mt-2 flex flex-wrap items-center gap-3">
                    @can('addToCart', $product)
                        <form action="{{ route('carts.store') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <label class="text-sm text-gray-600">Qty</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-24 text-center border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <x-primary-button>
                                🛒 Tambah ke Keranjang
                            </x-primary-button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500">Anda tidak dapat menambahkan produk ini ke keranjang.</p>
                    @endcan

                    @can('update', $product)
                        <a href="{{ route('products.edit', $product) }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                            ✏️ Edit
                        </a>
                    @endcan

                    @can('delete', $product)
                            <x-confirm-modal
                                title="Hapus Produk?"
                                message="Data produk yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?"
                                :action="route('products.destroy', $product)"
                                method="DELETE"
                                button-text="Ya, Hapus">
                                Hapus
                            </x-confirm-modal>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
            ← Kembali ke Daftar
        </a>
    </div>
</section>
@endsection
