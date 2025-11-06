@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Kategori</h1>

        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            + Tambah Kategori
        </a>
    </div>

    @if($categories->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-600">Belum ada kategori yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        <span class="text-xs text-gray-500">ID #{{ $category->id }}</span>
                    </div>

                    <p class="mt-2 text-sm text-gray-700 line-clamp-4">
                        {{ $category->description ?: 'Tidak ada deskripsi.' }}
                    </p>

                    <div class="mt-4 pt-4 border-t flex items-center gap-2">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="ml-auto"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Hapus</x-danger-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($categories, 'links'))
            <div class="pt-6">
                {{ $categories->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
