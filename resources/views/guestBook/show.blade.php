@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{ $guestBook->name ?? '-' }}</p>
        <p>Email: {{$guestBook->email}}</p>
        <p>Pesan: {{$guestBook->message}}</p>
    </div>

    <form action="{{ route('guestBooks.destroy', $guestBook) }}" method="post">
        @method('DELETE') @csrf
        <button class="btn">Hapus</button>
    </form>

@endsection
