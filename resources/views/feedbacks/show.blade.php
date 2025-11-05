@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{ $feedback->user?->name ?? '-' }}</p>
        <p>Rating: {{$feedback->rating}}</p>
        <p>Pesan: {{$feedback->message}}</p>
    </div>

    <form action="{{ route('feedbacks.destroy', $feedback) }}" method="post">
        @method('DELETE') @csrf
        <button class="btn">Hapus</button>
    </form>

@endsection
