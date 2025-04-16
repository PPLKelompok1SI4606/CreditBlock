<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportMessageController extends Controller
{
    public function index()
    {
        $messages = SupportMessage::with('user')
            ->latest()
            ->paginate(10);
        
        return view('admin.support.index', compact('messages'));
    }

    public function show(SupportMessage $supportMessage)
    {
        return view('admin.support.show', compact('supportMessage'));
    }

    public function respond(Request $request, SupportMessage $supportMessage)
    {
        $validated = $request->validate([
            'response' => 'required|string',
        ]);

        $supportMessage->update([
            'response' => $validated['response'],
            'status' => 'responded',
            'responded_at' => now(),
        ]);

        return redirect()->route('admin.support.index')
            ->with('success', 'Respon telah dikirim!');
    }
}