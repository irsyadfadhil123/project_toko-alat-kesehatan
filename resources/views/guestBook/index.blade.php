@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
    <section class="space-y-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Guest Book</h1>
        </div>

        @if($guestBooks->isEmpty())
            <div class="text-center text-gray-500 py-10">
                <p>Belum ada Guest Book yang tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($guestBooks as $guestBook)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <a href="{{ route('guestBooks.show', $guestBook) }}">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $guestBook->name ?? '-' }}</h2>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-3">
                                    {{ $guestBook->message ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </div>
                        </a>

                        {{-- Bagian bawah card --}}
                        <div class="border-t p-4 flex justify-between items-center">
                            <div class="flex gap-2">
                                <form action="{{ route('guestBooks.destroy', $guestBook) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus Guest Book ini?')">
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
