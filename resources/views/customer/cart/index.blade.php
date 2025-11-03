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
    @endif
@endsection
