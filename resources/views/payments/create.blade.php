@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
    <div>
        <form action="{{ route('payments.store', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Metode Pembayaran:</label><br>
            <label>
                <input type="radio" name="payment_method"
                       value="prepaid"
                       {{ old('payment_method') === 'prepaid' ? 'checked' : '' }} required>
                Prepaid
            </label><br>

            <label>
                <input type="radio" name="payment_method"
                       value="postpaid"
                       {{ old('payment_method') === 'postpaid' ? 'checked' : '' }} required>
                Postpaid
            </label><br><br>

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
