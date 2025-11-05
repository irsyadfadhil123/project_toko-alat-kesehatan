<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        if ($order->user_id != auth()->id()) abort(403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan ini tidak dapat dibayar.');
        }

        return response()
            ->view('payments.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id != auth()->id()) abort(403);

        $request->validate([
            'payment_method' => 'required|in:prepaid,postpaid',
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]
        );

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Metode pembayaran tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
