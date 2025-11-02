<div>
    @extends('layouts.app')

    @section('title', 'Dashboard')

    @section('content')

    <h1>Selamat datang, {{ Auth::user()->name }}</h1>
    <p>Anda login sebagai customer.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    @endsection
</div>
