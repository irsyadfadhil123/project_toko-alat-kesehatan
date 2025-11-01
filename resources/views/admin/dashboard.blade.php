<div>
    @extends('layouts.app')

    @section('title', 'Dashboard')

    @section('content')

    <h1>Selamat datang, Admin {{ Auth::user()->name }}</h1>
    @endsection
</div>
