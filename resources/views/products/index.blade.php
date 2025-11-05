@extends('layouts.app')
@section('title', 'Produk')

@section('content')
    <section class="space-y-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Produk</h1>

            <x-primary-button class="ms-auto">
                <a href="{{ route('products.create') }}">
                    + {{ __('Tambah Produk') }}
                </a>
            </x-primary-button>
        </div>

        <header class="flex flex-col md:flex-row md:items-end gap-4 bg-white shadow-sm rounded-xl p-5">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <x-input-label for="category" value="Kategori" />
                    <select id="category" name="category"
                            class="mt-1 w-52 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Semua --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>
                                {{ $cat->name }}
                            </option>
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

        {{-- ===== Grid Produk ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <div
                    class="group relative bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col">

                    <a href="{{ route('products.show', $product) }}">
                        <div class="h-48 w-full bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden mb-4">
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                 alt="{{ $product->name }}"
                                 class="object-cover h-full w-full group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->category->name ?? '-' }}</p>
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </a>

                    <div class="mt-auto pt-4 flex flex-wrap gap-2 border-t border-gray-100">
                        @can('update', $product)
                            <x-secondary-button type="button" onclick="window.location='{{ route('products.edit', $product) }}'">
                                ✏️ {{ __('Edit') }}
                            </x-secondary-button>
                        @endcan

                        @can('delete', $product)
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $product->id }}')">
                                🗑️ {{ __('Hapus') }}
                            </x-danger-button>

                            {{-- Modal konfirmasi hapus --}}
                            <x-modal name="confirm-delete-{{ $product->id }}" focusable>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="p-6 space-y-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Hapus produk ini?') }}
                                    </h2>
                                    <p class="text-sm text-gray-600">
                                        {{ __('Produk akan terhapus permanen.') }}
                                    </p>

                                    <div class="flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Batal') }}
                                        </x-secondary-button>
                                        <x-danger-button class="ms-3">
                                            {{ __('Hapus') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
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

        {{-- ===== Pagination ===== --}}
        <div class="pt-6">
            {{ $products->withQueryString()->links() }}
        </div>

    </section>
@endsection
