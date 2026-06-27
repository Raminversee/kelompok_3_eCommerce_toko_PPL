<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Hanya customer dan admin pembelian yang boleh akses chat
        if (!in_array($user->role, ['customer', 'admin_pembelian'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $messages = Chat::with(['sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Customer hanya melihat Admin Pembelian
        if ($user->role === 'customer') {
            $admins = User::where('role', 'admin_pembelian')->get();
        }

        // Admin Pembelian hanya melihat Customer
        if ($user->role === 'admin_pembelian') {
            $admins = User::where('role', 'customer')->get();
        }

        return view('chat.index', compact('messages', 'admins'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['customer', 'admin_pembelian'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required'
        ]);

        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }
}