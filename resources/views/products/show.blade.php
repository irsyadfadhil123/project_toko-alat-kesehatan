@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{$product->name}}</p>
        <p>Harga: {{$product->price}}</p>
        <p>Deskripsi: {{$product->description}}</p>
        <p>Stok: {{$product->stock}}</p>
    </div>

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
