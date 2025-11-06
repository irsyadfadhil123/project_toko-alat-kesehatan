@extends('layouts.app')
@section('title', 'Detail Pelanggan')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Detail Pelanggan</h1>
        <a href="{{ route('customers.index') }}"
           class="text-sm text-indigo-600 hover:text-indigo-700 underline">Kembali ke Daftar</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <p class="text-xs text-gray-500">Nama</p>
                <p class="text-lg font-semibold text-gray-900">{{ $customer['name'] ?? '—' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs text-gray-500">Email</p>
                <p class="text-sm text-gray-900">{{ $customer['email'] ?? '—' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs text-gray-500">No. Telepon</p>
                <p class="text-sm text-gray-900">{{ $customer['phone'] ?? '—' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs text-gray-500">Alamat</p>
                <p class="text-sm text-gray-900">{{ $customer['address'] ?? '—' }}</p>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('customers.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                Kembali
            </a>
            <x-confirm-modal
                title="Hapus Pelanggan?"
                message="Data pelanggan yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?"
                :action="route('customers.destroy', $customer['id'])"
                method="DELETE"
                button-text="Ya, Hapus">
                Hapus
            </x-confirm-modal>
        </div>
    </div>

    {{-- Contoh ringkasan terkait toko alat kesehatan (opsional) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Aktivitas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xs text-gray-500">Total Pesanan</p>
                <p class="text-xl font-semibold text-gray-900">{{ $customer['orders_count'] ?? 0 }}</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xs text-gray-500">Nilai Belanja</p>
                <p class="text-xl font-semibold text-gray-900">Rp {{ number_format($customer['orders_total'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4">
                <p class="text-xs text-gray-500">Feedback</p>
                <p class="text-xl font-semibold text-gray-900">{{ $customer['feedbacks_count'] ?? 0 }} ulasan</p>
            </div>
        </div>
    </div>
</section>
@endsection
