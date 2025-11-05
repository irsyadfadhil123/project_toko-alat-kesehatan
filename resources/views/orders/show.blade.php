@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: Pesanan {{$order->id}}</p>
        <p>Harga Pesanan: {{$order->total_amount}}</p>
        <p>Status: {{$order->status}}</p>
        <p>Dikirim ke: {{$order->shipping_address}}</p>
    </div>

    @if(!$order->payment && $order->status === 'pending' && auth()->id() === $order->user_id)
        <div class="mt-4">
            <a href="{{ route('payments.create', $order) }}" class="btn btn-primary">Pilih Metode Pembayaran</a>
        </div>
    @endif

    @if($order->payment)
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold">Pembayaran</h3>
            <p>Metode: {{ $order->payment->payment_method ?? '-' }}</p>
            <p>Status: {{ $order->payment->payment_status ?? '-' }}</p>
            <p>Tanggal: {{ optional($order->payment->payment_date)->format('d M Y H:i') ?? '-' }}</p>
        </div>
    @endif

    @if($order->relationLoaded('orderItems') && $order->orderItems->count())
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold">Produk Dipesan</h3>
            <ul class="list-disc pl-5 space-y-2">
                @foreach($order->orderItems as $item)
                    <li>
                        <div class="flex justify-between">
                            <div>
                                <span class="font-medium">
                                    {{ $item->product->name ?? $item->name ?? 'Produk' }}
                                </span>
                            </div>
                            <div class="text-right">
                                <div>Qty: {{ $item->quantity }}</div>
                                <div>Harga: {{ $item->price }}</div>
                                <div class="font-semibold">Subtotal: {{ $item->quantity * $item->price }}</div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="mt-8 border-t pt-4">
            <h3 class="font-semibold mb-2">Admin: Ubah Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm">Status Pesanan</label>
                    <select name="status" class="border rounded p-2">
                        @foreach(['pending','approved','processing','shipped','completed','cancelled'] as $st)
                            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm">Status Pembayaran</label>
                    <select name="payment_status" class="border rounded p-2">
                        @foreach(['pending','paid','failed','refunded'] as $ps)
                            <option value="{{ $ps }}" {{ optional($order->payment)->payment_status === $ps ? 'selected' : '' }}>
                                {{ ucfirst($ps) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm">Metode Pembayaran</label>
                    <select name="payment_method" class="border rounded p-2">
                        @foreach(['prepaid','postpaid'] as $pm)
                            <option value="{{ $pm }}" {{ optional($order->payment)->payment_method === $pm ? 'selected' : '' }}>
                                {{ ucfirst($pm) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    @endif
@endsection
