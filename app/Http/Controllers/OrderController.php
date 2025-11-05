<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $orders = Order::with('user')
                ->latest()
                ->paginate(20);

            return view('orders.index', compact('orders'));
        }

        $orders = $user->orders()
            ->with('orderItems.product', 'payment')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created order (checkout).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong, tidak ada yang dapat diproses.');
        }

        DB::transaction(function () use ($carts, $user) {
            $total = 0;

            // 1. Buat record order
            $order = Order::create([
                'user_id'      => $user->id,
                'total_amount' => 0,          // akan di-update setelah dihitung
                'status'       => 'pending',  // atau status default Anda
            ]);

            foreach ($carts as $cart) {
                $subtotal = $cart->product->price * $cart->quantity;
                $total   += $subtotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price,
                ]);
            }

            $order->update(['total_amount' => $total]);

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat, lanjutkan ke pembayaran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['payment', 'orderItems.product']);
        return view('orders.show', compact('order'));
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
        $order = Order::with('payment')->findOrFail($id);

        if (auth()->user()->role === 'admin') {
            $data = $request->validate([
                'status' => 'required|in:pending,approved,processing,shipped,completed,cancelled',
                'payment_status' => 'nullable|in:pending,paid,failed,refunded',
                'payment_method' => 'nullable|in:prepaid,postpaid',
            ]);

            $order->update(['status' => $data['status']]);

            if (isset($data['payment_status']) || isset($data['payment_method'])) {
                $order->payment()->updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'payment_status' => $data['payment_status'] ?? ($order->payment->payment_status ?? 'pending'),
                        'payment_method' => $data['payment_method'] ?? ($order->payment->payment_method ?? null),
                        'payment_date'   => ($data['payment_status'] ?? null) === 'paid'
                            ? now()
                            : $order->payment->payment_date ?? null,
                    ]
                );
            }

            return back()->with('success', 'Order berhasil diperbarui.');
        }

        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(Order $order)
    {
        if ($order->user_id != auth()->id()) abort(403);

        if (! in_array($order->status, ['pending', 'approved'])) {
            return back()->with('error', 'Pesanan sudah tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
