<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guestBooks = GuestBook::latest()->paginate(10);
        return view('guestBook.index', compact('guestBooks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        GuestBook::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Terima kasih atas feedback Anda.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guestBook = GuestBook::findOrFail($id);
         return view('guestBook.show', compact('guestBook'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        GuestBook::findOrFail($id)->delete();
        return redirect()->route('guestBooks.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
