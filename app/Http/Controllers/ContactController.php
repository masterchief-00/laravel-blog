<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    function index()
    {

        return view('contact');
    }
    public function store(Request $request)
    {
        $data =  $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Mail::to('kwizerapacifique19@gmail.com')->send(new Contact($data));

        return redirect(route('contact.index'))->with('status', 'Message sent');
    }
}
