<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PrivateMessage;
use App\Http\Controllers\Controller;

class PrivateMessageController extends Controller
{
    public function index(){
        $messages = PrivateMessage::paginate(20);
        return view('admin.private_messages.index', compact('messages'));
    }

    public function show(PrivateMessage $message) {
        $message->read = true;
        $message->save();
        return view('admin.private_messages.show', compact('message'));
    }

    public function destroy (PrivateMessage $message) {
        
        $message->delete();

        return redirect('/admin/message')->with('deleted', "Message deleted");
    }
}
