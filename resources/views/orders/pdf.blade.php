<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 18px; margin: 0 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f5f5f5; }
        .muted { color: #666; font-size: 11px; }
        .totals { text-align: right; }
    </style>
</head>
<body>
<h1>Laporan Pesanan #{{ $order->id }}</h1>
<p class="muted">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>

<p><strong>Pelanggan:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
<p><strong>Alamat Kirim:</strong> {{ $order->shipping_address ?? '-' }}</p>
<p><strong>Status Pesanan:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Pembayaran:</strong>
    @if($order->payment)
        {{ ucfirst($order->payment->payment_method) }} • {{ ucfirst($order->payment->payment_status) }}
    @else
        Belum dipilih
    @endif
</p>

<table>
    <thead>
    <tr>
        <th>Produk</th>
        <th style="width: 70px;">Qty</th>
        <th style="width: 110px;">Harga</th>
        <th style="width: 120px;">Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->product->name ?? $item->name ?? 'Produk' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="totals"><strong>Total</strong></td>
        <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
    </tr>
    </tfoot>
</table>

<p class="muted" style="margin-top: 12px;">Toko Alat Kesehatan • Laporan otomatis</p>
</body>
</html>
