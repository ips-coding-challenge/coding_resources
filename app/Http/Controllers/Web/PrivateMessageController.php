<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\PrivateMessage;
use App\Http\Controllers\Controller;

class PrivateMessageController extends Controller
{
    public function contact() {
        return view('web.contact');
    }

    public function store (Request $request) {

        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        PrivateMessage::create([
            'subject' => request('subject'),
            'message' => request('message'),
            'email' => request('email')
        ]);

        return redirect()->back()->with('success', 'Message send!');
    }
}
