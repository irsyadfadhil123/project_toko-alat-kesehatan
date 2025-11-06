@extends('layouts.app')
@section('title', 'Daftar Feedback')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Feedback</h1>
    </div>

    @if($feedbacks->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-600">Belum ada feedback yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($feedbacks as $feedback)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <a href="{{ route('feedbacks.show', $feedback) }}" class="group">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700 transition">
                                {{ $feedback->user?->name ?? 'Pengguna' }}
                            </h3>
                        </a>
                        <span class="text-xs text-gray-500">{{ $feedback->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="mt-2 flex items-center gap-1">
                        @for($i=1;$i<=5;$i++)
                            <span class="{{ $i <= (int)$feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">({{ $feedback->rating }})</span>
                    </div>

                    <p class="mt-3 text-sm text-gray-700 line-clamp-4">
                        {{ $feedback->message ?: 'Tidak ada pesan.' }}
                    </p>

                    <div class="mt-4 pt-4 border-t flex items-center gap-2">
                        <a href="{{ route('feedbacks.show', $feedback) }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Detail
                        </a>

                        <form action="{{ route('feedbacks.destroy', $feedback) }}" method="POST" class="ml-auto"
                              onsubmit="return confirm('Yakin ingin menghapus feedback ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Hapus</x-danger-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($feedbacks, 'links'))
            <div class="pt-6">
                {{ $feedbacks->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
