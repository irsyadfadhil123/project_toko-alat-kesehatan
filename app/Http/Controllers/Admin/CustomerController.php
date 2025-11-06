<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::where('role', 'customer')->select(['id', 'name'])->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\User $customer)
    {
        $stats = \App\Models\Order::where('user_id', $customer->id)
            ->selectRaw('COUNT(*) as orders_count, COALESCE(SUM(total_amount),0) as orders_total')
            ->first();

        $feedbacksCount = \App\Models\Feedback::where('user_id', $customer->id)->count();

        // jika ingin akses sebagai array seperti di Blade kamu
        $data = $customer->only(['id','name','email','phone','address']);
        $data['orders_count'] = (int) $stats->orders_count;
        $data['orders_total'] = (int) $stats->orders_total;
        $data['feedbacks_count'] = (int) $feedbacksCount;

        return view('admin.customers.show', ['customer' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}
