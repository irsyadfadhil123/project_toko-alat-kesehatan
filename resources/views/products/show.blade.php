@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{$product->name}}</p>
        <p>Harga: {{$product->price}}</p>
        <p>Deskripsi: {{$product->description}}</p>
        <p>Stok: {{$product->stock}}</p>
    </div>

    @can('addToCart', $product)
        <form action="{{ route('carts.store') }}" method="POST" class="inline-flex items-center gap-3">
            @csrf
            {{-- kirim id produk --}}
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- input quantity dapat diubah jika mau --}}
            <input type="number"
                   name="quantity"
                   value="1"
                   min="1"
                   max="{{ $product->stock }}"
                   class="w-20 border rounded px-2 py-1 text-center">

            <button type="submit" class="btn-primary">
                Add to Cart
            </button>
        </form>
    @else
        {{-- opsional: tampilkan pesan bila tidak diizinkan --}}
        <p class="text-gray-500">Anda tidak dapat menambahkan produk ini ke keranjang.</p>
    @endcan

    @can('update', $product)
        <a href="{{ route('products.edit', $product) }}" class="btn">Edit</a>
    @endcan

    @can('delete', $product)
        <form action="{{ route('products.destroy', $product) }}" method="post">
            @method('DELETE') @csrf
            <button class="btn">Hapus</button>
        </form>
    @endcan

@endsection
