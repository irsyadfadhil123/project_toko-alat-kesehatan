@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
    <section class="space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Pesanan</h1>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <p class="text-gray-600">Belum ada pesanan.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center mt-4 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Jelajahi Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col gap-3">
                        <div class="flex items-start justify-between">
                            <a href="{{ route('orders.show', $order) }}" class="group">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700 transition">
                                    Pesanan #{{ $order->id }}
                                </h3>
                            </a>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
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

                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Total</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal</span>
                                <span>{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pembayaran</span>
                                <span class="{{ optional($order->payment)->payment_status === 'paid' ? 'text-green-600' : 'text-gray-800' }}">
                                    {{ optional($order->payment)->payment_status ? ucfirst($order->payment->payment_status) : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-2 flex items-center gap-2">
                            <a href="{{ route('orders.show', $order) }}"
                               class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                                Detail
                            </a>

                            @if ($order->status === 'pending' && $order->payment === null && Auth::user()->role !== 'admin')
                                <a href="{{ route('payments.create', $order) }}"
                                   class="inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                                    Bayar
                                </a>
                            @endif

                            @if (in_array($order->status, ['pending','approved']))
                                <x-confirm-modal
                                    title="Batalkan Pesanan?"
                                    message="Tindakan ini tidak dapat dibatalkan. Yakin ingin melanjutkan?"
                                    :action="route('orders.cancel', $order)"
                                    button-text="Ya, Batalkan">
                                    Batalkan
                                </x-confirm-modal>
                            @endif
                        <form action="{{ route('orders.send-pdf', $order) }}" method="POST" class="ml-auto">
                            @csrf
                            <button class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                                Kirim Laporan PDF
                            </button>
                        </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </section>
@endsection
