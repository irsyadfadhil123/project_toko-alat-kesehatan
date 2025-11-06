@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Tambah Produk</h1>
        <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 underline">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" value="Nama Produk" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                              value="{{ old('name') }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="category_id" value="Kategori" />
                <select id="category_id" name="category_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="price" value="Harga (Rp)" />
                    <x-text-input id="price" name="price" type="number" min="0" class="mt-1 block w-full"
                                  value="{{ old('price') }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                </div>
                <div>
                    <x-input-label for="stock" value="Stok" />
                    <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full"
                                  value="{{ old('stock') }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                </div>
            </div>

            <div>
                <x-input-label for="description" value="Deskripsi" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="image" value="Foto Produk" />
                <input id="image" type="file" name="image" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0 file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </div>
</section>
@endsection
