<div>
    @extends('layouts.app')

    @section('title', 'Edit Produk')

    @section('content')
        <div class="container mt-4">
            <h2>Edit Produk</h2>

            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label>Nama Produk:</label><br>
                <input type="text" name="name" value="{{ $product->name }}" required><br><br>

                <label>Kategori:</label><br>
                <select name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id === $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select><br><br>

                <label>Harga:</label><br>
                <input type="number" name="price" value="{{ $product->price }}" required><br><br>

                <label>Stok:</label><br>
                <input type="number" name="stock" value="{{ $product->stock }}" required><br><br>

                <label>Deskripsi:</label><br>
                <textarea name="description">{{ $product->description }}</textarea><br><br>

                <button type="submit">Update</button>
            </form>
        </div>
    @endsection
</div>
