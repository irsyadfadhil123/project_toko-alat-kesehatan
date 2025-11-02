@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    @foreach($customers as $customer)
        <a href="{{ route('customers.show', $customer) }}" class="block">
            <div>
                <p>{{ $customer->name }}</p>
                <p>{{ $customer->email }}</p>
                <p>{{ $customer->phone }}</p>
                <p>{{ $customer->address }}</p>
                <form action="{{ route('customers.destroy', $customer) }}" method="post">
                    @method('DELETE') @csrf
                    <button class="btn">Hapus</button>
                </form>
            </div>
        </a>
    @endforeach
@endsection
