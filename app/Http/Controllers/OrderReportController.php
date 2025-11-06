<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReportController extends Controller
{
    public function send(Request $request, Order $order)
    {
        // Otorisasi: admin atau pemilik
        if (!auth()->user() || (auth()->user()->role !== 'admin' && $order->user_id !== auth()->id())) {
            abort(403);
        }

        $order->load(['user','payment','orderItems.product']);

        // 1) Render PDF dari view
        $pdf = Pdf::loadView('orders.pdf', ['order' => $order]);

        // 2) Kirim email dengan attachment
        Mail::send('orders.email', ['order' => $order], function ($message) use ($order, $pdf) {
            $message->to($order->user->email, $order->user->name ?? null)
                ->subject('Laporan Pesanan #'.$order->id)
                ->attachData($pdf->output(), "order-{$order->id}.pdf", ['mime' => 'application/pdf']);
        });

        return back()->with('success', 'Laporan pesanan telah dikirim ke email pelanggan.');
    }
}
