@extends('layouts.app')
@section('title', 'Detail Guest Book')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Detail Guest Book</h1>
        <a href="{{ route('guestBooks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 underline">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-gray-500">Nama</p>
                <p class="text-lg font-semibold text-gray-900">{{ $guestBook->name ?? 'Tamu' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Email</p>
                <p class="text-sm text-gray-900">{{ $guestBook->email ?? '—' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-xs text-gray-500 mb-1">Pesan</p>
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-gray-800">
                {{ $guestBook->message }}
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('guestBooks.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                Kembali
            </a>
            <x-confirm-modal
                title="Hapus Guest Book?"
                message="Data guest book yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?"
                :action="route('guestBooks.destroy', $guestBook)"
                method="DELETE"
                button-text="Ya, Hapus">
                Hapus
            </x-confirm-modal>
        </div>
    </div>
</section>
@endsection
