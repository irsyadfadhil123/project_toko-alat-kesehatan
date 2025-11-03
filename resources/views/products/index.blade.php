@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    @can('create', \App\Models\Product::class)
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endcan
    @foreach($products as $product)
        <a href="{{ route('products.show', $product) }}" class="block">
            <div class="card">
                <h3>{{ $product->name }}</h3>

                @can('update', $product)
                    <a href="{{ route('products.edit', $product) }}" class="btn">Edit</a>
                @endcan

                @can('delete', $product)
                    <form action="{{ route('products.destroy', $product) }}" method="post">
                        @method('DELETE') @csrf
                        <button class="btn">Hapus</button>
                    </form>
                @endcan

                @can('addToCart', $product)
                    <form action="{{ route('carts.store', $product) }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn">Add to Cart</button>
                    </form>
                @endcan
            </div>
        </a>
    @endforeach
@endsection
