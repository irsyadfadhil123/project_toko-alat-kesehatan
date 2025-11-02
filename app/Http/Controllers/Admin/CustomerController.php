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
    public function show(User $customer)
    {
        $customer = $customer->only('id', 'name', 'email', 'phone', 'address');
        return view('admin.customers.show', compact('customer'));
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
