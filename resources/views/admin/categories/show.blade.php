@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{$category->name}}</p>
        <p>Deskripsi: {{$category->description}}</p>
    </div>

        <a href="{{ route('categories.edit', $category) }}" class="btn">Edit</a>

        <form action="{{ route('categories.destroy', $category) }}" method="post">
            @method('DELETE') @csrf
            <button class="btn">Hapus</button>
        </form>

@endsection
