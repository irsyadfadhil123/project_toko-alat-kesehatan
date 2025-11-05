<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource. (admin)
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(20);

        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Store a newly created resource in storage. (customer)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:2000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'rating'   => $validated['rating'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Terima kasih atas feedback Anda.');
    }

    /**
     * Display the specified resource. (admin)
     */
    public function show(string $id)
    {
        $feedback = Feedback::with('user')->findOrFail($id);

        return view('feedbacks.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage. (admin)
     */
    public function destroy(string $id)
    {
        Feedback::findOrFail($id)->delete();
        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
