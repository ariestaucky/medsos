<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('about');
    }

    public function ToS()
    {
        return view('policy.ToS');
    }

    public function privacy()
    {
        return view('policy.privacy');
    }

    public function cookie()
    {
        return view('policy.cookie');
    }

    public function contact()
    {
        return view('contact_us');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);
        
        // Create Message
        $msg = new Contact;
        $msg->subject = $request->input('subject');
        $msg->body = $request->input('body');
        $msg->email = $request->input('email');
        $msg->save();

        return redirect('contact-us')->with('success', 'Thank you! Message has been sent');
    }

}
