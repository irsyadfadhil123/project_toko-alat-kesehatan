@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div>
        <p>Nama: {{$customer['name']}}</p>
        <p>Email: {{$customer['email']}}</p>
        <p>No. Telepon: {{$customer['phone']}}</p>
        <p>Alamat: {{$customer['address']}}</p>
    </div>

    <form action="{{ route('customers.destroy', $customer['id']) }}" method="post">
        @method('DELETE') @csrf
        <button class="btn">Hapus</button>
    </form>

@endsection
