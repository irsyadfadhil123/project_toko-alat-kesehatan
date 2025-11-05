@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block">
                <div class="card">
                    <h3>Pesanan #{{ $order->id }}</h3>
                    <p>Status: {{ $order->status }}</p>
                    <p>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p>Tanggal: {{ $order->created_at->format('d F Y') }}</p>
                </div>
            </a>

            @if ($order->status === 'pending' && $order->payment === null)
                <a href="{{ route('payments.create', $order) }}" class="btn btn-primary btn-sm">
                    Bayar
                </a>
            @endif

            {{-- tombol batal: status pending atau approved --}}
            @if (in_array($order->status, ['pending','approved']))
                <form action="{{ route('orders.cancel', $order) }}" method="POST"
                      onsubmit="return confirm('Batalkan pesanan?')"
                      style="display:inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        Batalkan Pesanan
                    </button>
                </form>
            @endif
        @empty
            <p>Tidak ada Pesanan.</p>
        @endforelse
    </div>
@endsection
