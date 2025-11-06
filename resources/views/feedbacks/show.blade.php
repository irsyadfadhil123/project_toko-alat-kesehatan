@extends('layouts.app')
@section('title', 'Detail Feedback')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Detail Feedback</h1>
        <a href="{{ route('feedbacks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 underline">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500">Pelanggan</p>
                <p class="text-lg font-semibold text-gray-900">{{ $feedback->user?->name ?? 'Pengguna' }}</p>
                <p class="text-sm text-gray-500">{{ $feedback->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Rating</p>
                <div class="flex items-center justify-end gap-1">
                    @for($i=1;$i<=5;$i++)
                        <span class="{{ $i <= (int)$feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                    @endfor
                    <span class="text-sm text-gray-600 ml-1">({{ $feedback->rating }})</span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-xs text-gray-500 mb-1">Pesan</p>
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-gray-800">
                {{ $feedback->message }}
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('feedbacks.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                Kembali
            </a>
            <x-confirm-modal
                title="Hapus Feedback?"
                message="Data feedback yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?"
                :action="route('feedbacks.destroy', $feedback)"
                method="DELETE"
                button-text="Ya, Hapus">
                Hapus
            </x-confirm-modal>
        </div>
    </div>
</section>
@endsection
