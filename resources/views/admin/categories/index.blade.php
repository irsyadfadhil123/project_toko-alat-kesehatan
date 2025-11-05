@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
    <section class="space-y-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Kategori</h1>

            <x-primary-button href="{{ route('categories.create') }}">
                + Tambah Kategori
            </x-primary-button>
        </div>

        {{-- Jika kosong --}}
        @if($categories->isEmpty())
            <div class="text-center text-gray-500 py-10">
                <p>Belum ada kategori yang tersedia.</p>
            </div>
        @else
            {{-- Grid kategori --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h2>
                            <p class="text-gray-500 text-sm mt-1 line-clamp-3">
                                {{ $category->description ?: 'Tidak ada deskripsi.' }}
                            </p>
                        </div>

                        {{-- Bagian bawah card --}}
                        <div class="border-t p-4 flex justify-between items-center">
                            <div class="flex gap-2">
                                <x-secondary-button type="button" onclick="window.location='{{ route('categories.edit', $category) }}'">
                                    ✏️ {{ __('Edit') }}
                                </x-secondary-button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>
                                        🗑️ Hapus
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
