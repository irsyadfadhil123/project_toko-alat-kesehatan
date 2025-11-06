@extends('layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
<section class="space-y-8">
    {{-- Ringkasan Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-900">Pesanan #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                {{ match($order->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved','processing' => 'bg-blue-100 text-blue-800',
                    'shipped' => 'bg-indigo-100 text-indigo-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                } }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500">Total</p>
                <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500">Alamat Pengiriman</p>
                <p class="text-sm text-gray-800">{{ $order->shipping_address ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500">Pembayaran</p>
                <p class="text-sm text-gray-800">
                    @if($order->payment)
                        {{ ucfirst($order->payment->payment_method) }} •
                        <span class="{{ $order->payment->payment_status === 'paid' ? 'text-green-600 font-medium' : '' }}">
                            {{ ucfirst($order->payment->payment_status) }}
                        </span>
                    @else
                        Belum dipilih
                    @endif
                </p>
            </div>
        </div>

        {{-- Aksi Customer --}}
        @if(!$order->payment && $order->status === 'pending' && auth()->id() === $order->user_id)
            <div class="mt-4">
                <a href="{{ route('payments.create', $order) }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Pilih Metode Pembayaran
                </a>
            </div>
        @endif
    </div>

    {{-- Detail Pembayaran --}}
    @if($order->payment)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Pembayaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Metode</p>
                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($order->payment->payment_method ?? '-') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Status</p>
                    <p class="text-sm font-medium {{ $order->payment->payment_status === 'paid' ? 'text-green-700' : 'text-gray-900' }}">
                        {{ ucfirst($order->payment->payment_status ?? '-') }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Tanggal</p>
                    <p class="text-sm font-medium text-gray-900">
                        {{ optional($order->payment->payment_date)->format('d M Y H:i') ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Produk Dipesan --}}
    @if($order->relationLoaded('orderItems') && $order->orderItems->count())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Produk Dipesan</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-start justify-between gap-4 border border-gray-100 rounded-xl p-4">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900 truncate">
                                {{ $item->product->name ?? $item->name ?? 'Produk' }}
                            </p>
                            @if(!empty($item->variant))
                                <p class="text-sm text-gray-500">Varian: {{ $item->variant }}</p>
                            @endif
                            @if(!empty($item->notes))
                                <p class="text-sm text-gray-500">Catatan: {{ $item->notes }}</p>
                            @endif
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm text-gray-600">Qty: <span class="text-gray-900 font-medium">{{ $item->quantity }}</span></p>
                            <p class="text-sm text-gray-600">Harga: <span class="text-gray-900 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span></p>
                            <p class="text-sm text-gray-900 font-semibold">Subtotal: Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Panel Admin --}}
    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin: Ubah Status</h2>
            <form action="{{ route('orders.update', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="status" value="Status Pesanan" />
                    <select id="status" name="status"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['pending','approved','processing','shipped','completed','cancelled'] as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="payment_status" value="Status Pembayaran" />
                    <select id="payment_status" name="payment_status"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['pending','paid','failed','refunded'] as $ps)
                            <option value="{{ $ps }}" @selected(optional($order->payment)->payment_status === $ps)>{{ ucfirst($ps) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="payment_method" value="Metode Pembayaran" />
                    <select id="payment_method" name="payment_method"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['prepaid','postpaid'] as $pm)
                            <option value="{{ $pm }}" @selected(optional($order->payment)->payment_method === $pm)>{{ ucfirst($pm) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3 flex justify-end pt-2">
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    @endif
</section>
@endsection
