@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    @foreach($categories as $category)
        <a href="{{ route('categories.show', $category) }}" class="block">
            <div>
                <p>{{ $category->name }}</p>
                <p>{{ $category->description }}</p>
                <a href="{{ route('categories.edit', $category) }}" class="btn">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="post">
                    @method('DELETE') @csrf
                    <button class="btn">Hapus</button>
                </form>
            </div>
        </a>
    @endforeach
@endsection
