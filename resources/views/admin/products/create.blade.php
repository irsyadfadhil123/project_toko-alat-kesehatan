<div>
    @extends('layouts.app')

    @section('title', 'Tambah Produk')

    @section('content')
        <div class="container mt-4">
            <h2>Tambah Produk</h2>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <label>Nama Produk:</label><br>
                <input type="text" name="name" required><br><br>

                <label>Kategori:</label><br>
                <select name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select><br><br>

                <label>Harga:</label><br>
                <input type="number" name="price" required><br><br>

                <label>Stok:</label><br>
                <input type="number" name="stock" required><br><br>

                <label>Deskripsi:</label><br>
                <textarea name="description"></textarea><br><br>

                <button type="submit">Simpan</button>
            </form>
        </div>
    @endsection
</div>
