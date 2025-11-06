@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Produk</h1>

        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            + Tambah Produk
        </a>
    </div>

    <header class="flex flex-col md:flex-row md:items-end gap-4 bg-white shadow-sm rounded-xl p-5">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <x-input-label for="category" value="Kategori" />
                <select id="category" name="category"
                        class="mt-1 w-52 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Semua --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-primary-button class="h-10">{{ __('Filter') }}</x-primary-button>

            @if ($categoryId)
                <a href="{{ route('products.index') }}" class="text-sm text-gray-500 underline hover:text-gray-700">
                    {{ __('Hapus Filter') }}
                </a>
            @endif
        </form>
    </header>

    {{-- Grid 4 kolom tetap (1 pada mobile, 2 pada sm, 4 pada lg) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse ($products as $product)
            <div class="group relative bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col">
                <a href="{{ route('products.show', $product) }}">
                    <div class="h-48 w-full bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden mb-4">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('/images/placeholder.png') }}"
                             alt="{{ $product->name }}"
                             class="object-cover h-full w-full group-hover:scale-105 transition-transform duration-300">
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $product->category->name ?? '-' }}</p>
                    <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </a>

                <div class="mt-auto pt-4 flex flex-wrap gap-2 border-t border-gray-100">
                    @can('update', $product)
                        <a href="{{ route('products.edit', $product) }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                           {{ __('Edit') }}
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

                    @can('addToCart', $product)
                        <form action="{{ route('carts.store') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <x-primary-button>
                                🛒 {{ __('Add to Cart') }}
                            </x-primary-button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">{{ __('Tidak ada produk.') }}</p>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $products->withQueryString()->links() }}
    </div>
</section>
@endsection
