<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Message;
use DB;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $received = auth()->user()->notifications()->where('type', 'App\Notifications\NewMessage')->get()->toArray();
        $sent = Message::where('sender_id', auth()->user()->id)->whereNull('sender_delete')->orderby('created_at', 'desc')->get();
// foreach($received as $out){dd($out['read_at']);};
        return view('message', compact('received', 'sent'));
    }

    public function create($id)
    {
        $msg = Message::findorFail($id);

        return view('message.reply', compact('msg'));
    }

    public function store(Request $request)
    {
        // dd($request->input('receiver'));
        $this->validate($request, [
            'message' => 'required|string|max:255',
        ]);

        if($request->input('receiver_id')) {
            $userID = $request->input('receiver_id');
        } else {
            $userID = User::select('id')->where('username', $request->input('receiver'))->get();
        }

        if (User::findorFail($userID)->count() > 0) {

            if($request->input('receiver_id') != auth()->user()->id) {
                // Create Post
                $msg = new Message;
                $msg->sender_id = auth()->user()->id;
                $msg->receiver_id = $request->input('receiver_id');
                $msg->subject = $request->input('subject')? : 'No subject';
                $msg->message = $request->input('message');
                
                $msg->save();
            } else {
                return redirect()->back()->with('error', "You can't send message to yourself!")
                                    ->withInput($request->except('receiver'));
            } 

        } else {
            return redirect()->back()->with('error', "Username doesn't exist!")
                                    ->withInput($request->except('receiver'));
        } 
        
        if(request()->routeIs('reply')){
            return redirect('/message')->with('success', 'Message send!');
        } else {
            return redirect()->back()->with('success', 'Message send!');
        }
    }

    public function show($id)
    {
        session(['link' => url()->previous()]);
        $msg = Message::findorFail($id);

        if($msg->sender_id == Auth()->user()->id) {
            $sent = $msg;

            return view('message.index')->with(compact('sent'));
        } else if($msg->receiver_id == Auth()->user()->id) {
            $inc = $msg;

            $notif = $msg->receiver->notifications()
                        ->where('type', 'App\Notifications\NewMessage')
                        ->where(DB::raw('JSON_EXTRACT(`data`, "$.message_id")'), $msg->id)
                        ->first();
            if($notif) {
                $notif->markAsRead();
            }

            return view('message.index')->with(compact('inc'));
        }    
        return redirect('/home')->with('error', 'Unauthorized action');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $msg = Message::findorFail($id);

        $notif = $msg->receiver->notifications()
                            ->where('type', 'App\Notifications\NewMessage')
                            ->where(DB::raw('JSON_EXTRACT(`data`, "$.message_id")'), $msg->id)
                            ->first();
        if($notif) {
            $notif->markAsRead();
        }

        return redirect()->back()->with('success', 'Message mark as read');
    }

    public function destroy($id)
    {
        $message = Message::findorFail($id);

        if($message->sender_id == auth()->user()->id) {
            $message->sender_delete = \Carbon\Carbon::now();
            $message->save();
        } elseif($message->receiver_id == auth()->user()->id) {
            $message->receiver->notifications()
                                ->where('type', 'App\Notifications\NewMessage')
                                ->where(DB::raw('JSON_EXTRACT(`data`, "$.message_id")'), $message->id)
                                ->delete();

            $message->receiver_delete = \Carbon\Carbon::now();
            $message->save();
        } 
        
        if((!empty($message->sender_delete)) && (!empty($message->receiver_delete))) {
            $message->delete();
        }

        return redirect('/message')->with('success', 'Message deleted');
    }

    public function notif()
    {
        return auth()->user()->unreadNotifications()->where('type', 'App\Notifications\NewMessage')->limit(5)->get()->toArray();
    }
}
