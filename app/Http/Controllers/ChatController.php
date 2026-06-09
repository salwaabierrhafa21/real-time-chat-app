<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('chat.index', compact('users'));
    }

    public function show(User $user)
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        return view('chat.index', compact(
            'users',
            'user',
            'messages'
        ));
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required'
        ]);

       $message = Message::create([
    'sender_id' => auth()->id(),
    'receiver_id' => $user->id,
    'message' => $request->message
]);

broadcast(new MessageSent($message))->toOthers();

return redirect()->route('chat.show', $user->id);
    }
}