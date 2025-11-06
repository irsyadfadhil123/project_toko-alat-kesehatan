@extends('layouts.app')
@section('title', 'Daftar Guest Book')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Guest Book</h1>
    </div>

    @if($guestBooks->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-600">Belum ada Guest Book yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($guestBooks as $guestBook)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <a href="{{ route('guestBooks.show', $guestBook) }}" class="group">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700 transition">
                                {{ $guestBook->name ?? 'Tamu' }}
                            </h3>
                        </a>
                        <span class="text-xs text-gray-500">{{ $guestBook->created_at->format('d M Y') }}</span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500 truncate">{{ $guestBook->email }}</p>

                    <p class="mt-3 text-sm text-gray-700 line-clamp-4">
                        {{ $guestBook->message ?: 'Tidak ada pesan.' }}
                    </p>

                    <div class="mt-4 pt-4 border-t flex items-center gap-2">
                        <a href="{{ route('guestBooks.show', $guestBook) }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Detail
                        </a>

                        <form action="{{ route('guestBooks.destroy', $guestBook) }}" method="POST" class="ml-auto"
                              onsubmit="return confirm('Yakin ingin menghapus Guest Book ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Hapus</x-danger-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($guestBooks, 'links'))
            <div class="pt-6">
                {{ $guestBooks->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
