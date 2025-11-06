@php
    $isEdit = isset($category) && $category->exists;
    $title  = $isEdit ? 'Edit Kategori' : 'Tambah Kategori';
    $route  = $isEdit ? route('categories.update', $category) : route('categories.store');
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
        <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 underline">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ $route }}" method="POST" class="space-y-5">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div>
                <x-input-label for="name" value="Nama Kategori" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                              value="{{ old('name', $category->name ?? '') }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="description" value="Deskripsi Kategori" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </div>
</section>
@endsection
