@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Keranjang Belanja</h1>
    </div>

    @if($carts->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-600">Keranjang masih kosong.</p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center mt-4 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Lihat Produk
            </a>
        </div>
    @else
        @php $grandTotal = 0; @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Daftar Item --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($carts as $cart)
                    @php
                        $subtotal = $cart->product->price * $cart->quantity;
                        $grandTotal += $subtotal;
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-5 flex items-start gap-4">
                        <div class="hidden sm:block">
                            <div class="h-20 w-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="{{ $cart->product->image ? asset('storage/'.$cart->product->image) : asset('images/placeholder.png') }}"
                                     alt="{{ $cart->product->name }}"
                                     class="object-cover h-full w-full">
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h2 class="text-base md:text-lg font-semibold text-gray-900 truncate">
                                {{ $cart->product->name }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                {{ $cart->product->category->name ?? '-' }}
                            </p>

                            <div class="mt-2 flex flex-wrap items-center gap-3">
                                <span class="text-sm text-gray-600">Harga</span>
                                <span class="text-sm font-medium text-gray-900">
                                    Rp{{ number_format($cart->product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <form action="{{ route('carts.update', $cart->id) }}" method="POST"
                                  class="mt-3 flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <label class="text-sm text-gray-600">Qty</label>
                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1"
                                       class="w-20 text-center border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <x-primary-button>Update</x-primary-button>
                            </form>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="text-sm text-gray-600">Subtotal</p>
                            <p class="text-lg font-semibold text-indigo-600">
                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </p>

                            <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="mt-3"
                                  onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Hapus</x-danger-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Kolom Kanan: Ringkasan & Checkout --}}
            <aside class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
                <h2 class="text-xl font-semibold text-gray-900 border-b pb-3">Ringkasan Belanja</h2>

                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-700">
                        <span>Total Item</span>
                        <span class="font-medium">{{ $carts->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal</span>
                        <span class="font-medium">Rp{{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Ongkir</span>
                        <span class="font-medium">Rp0</span>
                    </div>
                    <div class="flex justify-between text-gray-900 text-lg font-semibold pt-2 border-t">
                        <span>Total Bayar</span>
                        <span>Rp{{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('orders.store') }}" method="POST" class="pt-5">
                    @csrf
                    <input type="hidden" name="total" value="{{ $grandTotal }}">
                    <x-primary-button class="w-full justify-center py-2">
                        Pesan Sekarang
                    </x-primary-button>
                </form>

                <a href="{{ route('products.index') }}"
                   class="mt-3 inline-flex w-full items-center justify-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    Tambah Produk
                </a>
            </aside>
        </div>
    @endif
</section>
@endsection
