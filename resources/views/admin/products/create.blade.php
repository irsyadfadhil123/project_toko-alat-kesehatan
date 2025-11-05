<div>
    @extends('layouts.app')

    @section('title', 'Tambah Produk')

    @section('content')
        <div class="container mt-4">
            <h2>Tambah Produk</h2>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>Nama Produk:</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required><br><br>

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

                <label>Foto Produk:</label><br>
                <input type="file" name="image" accept="image/*"><br><br>

                <button type="submit">Simpan</button>
                @error('image')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </form>
        </div>
    @endsection
</div>
