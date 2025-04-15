<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportMessageController extends Controller
{
    public function index()
    {
        $messages = SupportMessage::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('support.index', compact('messages'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportMessage::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return redirect()->route('support.index')
            ->with('success', 'Pesan dukungan telah dikirim!');
    }

    public function show(SupportMessage $supportMessage)
    {
        if ($supportMessage->user_id !== Auth::id()) {
            abort(403);
        }

        return view('support.show', compact('supportMessage'));
    }
}