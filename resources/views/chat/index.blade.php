@extends('layouts.app')

@section('title', 'Realtime Chat')

@section('content')
<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    body{
        background:#f4f5f9;
    }

    .chat-container{
        display:flex;
        height:100vh;
        width:100%;
        position:fixed;
        top:0;
        left:0;
        background:white;
    }

    /* Sidebar */
    .sidebar{
        width:300px;
        background:#5b21b6;
        color:white;
        display:flex;
        flex-direction:column;
    }

    .sidebar-header{
        padding:20px;
        font-size:20px;
        font-weight:bold;
        border-bottom:1px solid rgba(255,255,255,.15);
    }

    .user-item{
        padding:15px 20px;
        cursor:pointer;
        border-bottom:1px solid rgba(255,255,255,.1);
        transition:.3s;
    }

    .user-item:hover{
        background:#6d28d9;
    }

    /* Chat Area */
    .chat-area{
        flex:1;
        display:flex;
        flex-direction:column;
        background:#f8f9fc;
    }

    .chat-header{
        height:70px;
        padding:20px;
        background:white;
        border-bottom:1px solid #ddd;
        font-size:18px;
        font-weight:600;
    }

    .messages{
        flex:1;
        overflow-y:auto;
        padding:25px;
    }

    .message{
        display:flex;
        margin-bottom:15px;
    }

    .message.me{
        justify-content:flex-end;
    }

    .bubble{
        padding:12px 18px;
        border-radius:18px;
        max-width:60%;
        word-wrap:break-word;
    }

    .message.me .bubble{
        background:#6d28d9;
        color:white;
        border-bottom-right-radius:5px;
    }

    .message.other .bubble{
        background:white;
        border:1px solid #ddd;
        color:#333;
        border-bottom-left-radius:5px;
    }

    /* Input */
    .chat-input{
        display:flex;
        gap:10px;
        padding:15px;
        background:white;
        border-top:1px solid #ddd;
    }

    .chat-input input{
        flex:1;
        padding:12px;
        border:1px solid #ccc;
        border-radius:8px;
        outline:none;
    }

    .chat-input button{
        background:#6d28d9;
        color:white;
        border:none;
        padding:12px 25px;
        border-radius:8px;
        cursor:pointer;
    }

    .chat-input button:hover{
        background:#5b21b6;
    }
</style>

<div class="chat-container">

    <div class="sidebar">

        <div class="sidebar-header">
            {{ auth()->user()->name }}
        </div>

        @foreach($users as $user)
    <a href="{{ route('chat.show', $user->id) }}"
       style="text-decoration:none;color:white;">

        <div class="user-item">
            {{ $user->name }}
        </div>

    </a>
@endforeach

    </div>

    <div class="chat-area">

       <div class="chat-header">

    @isset($user)
        Chat dengan {{ $user->name }}
    @else
        Pilih User
    @endisset

</div>

        <div class="messages">

    @isset($messages)

        @foreach($messages as $msg)

    <div class="message {{ $msg->sender_id == auth()->id() ? 'me' : 'other' }}">

        <div class="bubble">

            {{ $msg->message }}

            <div style="
                text-align:right;
                margin-top:5px;
                font-size:11px;
                opacity:.8;
            ">
                {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
            </div>

        </div>

    </div>

@endforeach

    @endisset

</div>

        @isset($user)

<form method="POST"
      action="{{ route('chat.send', $user->id) }}"
      class="chat-input">

    @csrf

    <input
        type="text"
        name="message"
        placeholder="Ketik pesan..."
        required
    >

    <button type="submit">
        Kirim
    </button>

</form>

@endisset

</div> {{-- chat-area --}}

</div> {{-- chat-container --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.Echo) {

        window.Echo.channel('chat')
            .listen('.message.sent', (e) => {

                console.log('Pesan diterima:', e);

            });

    }

});
</script>

@endsection