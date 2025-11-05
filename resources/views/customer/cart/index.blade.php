@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    @if($carts->isEmpty())
        <p>Keranjang Masih Kosong</p>
    @else
        @php $grandTotal = 0; @endphp
        @foreach($carts as $cart)
            @php
                $subtotal = $cart->product->price * $cart->quantity;
                $grandTotal += $subtotal;
            @endphp
            <div>
                <p>{{ $cart->product->name }}</p>
                <p>{{ $cart->product->category->name ?? '' }}</p>
                <p>Rp{{ number_format($cart->product->price, 0, ',', '.') }}</p>
            </div>
            <form action="{{ route('carts.update', $cart->id) }}" method="POST" class="inline-flex">
                @csrf
                @method('PUT')
                <input type="number"
                       name="quantity"
                       value="{{ $cart->quantity }}"
                       min="0"
                       class="w-16 text-center border" />
                <button class="ml-2 text-blue-600">Update</button>
            </form>
            <p>Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
            <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                  onsubmit="return confirm('Hapus item ini?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600">Hapus</button>
            </form>
            <p>Total Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
        @endforeach
        <div class="mt-6 flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                Total: Rp{{ number_format($grandTotal, 0, ',', '.') }}
            </h2>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="total" value="{{ $grandTotal }}">
                <button
                    type="submit"
                    class="px-4 py-2 rounded bg-green-600 text-black hover:bg-green-700">
                    Pesan Sekarang
                </button>
            </form>
        </div>
    @endif
@endsection
