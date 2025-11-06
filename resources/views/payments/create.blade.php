@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<section class="space-y-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                <ul class="list-disc ms-5 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-xl font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h1>

        <form action="{{ route('payments.store', $order) }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="prepaid"
                           {{ old('payment_method') === 'prepaid' ? 'checked' : '' }} required>
                    <div>
                        <p class="font-medium text-gray-900">Prepaid</p>
                        <p class="text-sm text-gray-600">Bayar di muka sebelum proses.</p>
                    </div>
                </label>

                <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="postpaid"
                           {{ old('payment_method') === 'postpaid' ? 'checked' : '' }} required>
                    <div>
                        <p class="font-medium text-gray-900">Postpaid</p>
                        <p class="text-sm text-gray-600">Bayar setelah barang diterima/ditagih.</p>
                    </div>
                </label>
            </div>
            @error('payment_method')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-3">
                <a href="{{ route('orders.show', $order) }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </div>
</section>
@endsection
