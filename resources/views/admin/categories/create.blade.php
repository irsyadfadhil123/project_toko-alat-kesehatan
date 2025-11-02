@php
    $isEdit = isset($category) && $category->exists;
    $title  = $isEdit ? 'Edit Produk' : 'Tambah Produk';
    $route  = $isEdit ? route('categories.update', $category) : route('categories.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@extends('layouts.app')
@section('title', $title)
@section('content')
    <div>
        <h2>Tambah Produk</h2>

        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <label>Nama Kategori:</label><br>
            <input type="text" name="name" required value="{{ old('name', $category->name ?? '') }}"><br><br>

            <label>Deskripsi Kategori:</label><br>
            <textarea name="description" rows="4" >{{ old('description', $category->description ?? '') }}</textarea><br><br>

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
