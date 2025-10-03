<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecivedMail;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{

 public function __construct()
    {
        $this->middleware(['permission:contact message index,admin'])->only(['index']);
        $this->middleware(['permission:contact message update,admin'])->only(['sendReplay']);
    }


 public function index()
    {
        RecivedMail::query()->update(['seen' => 1]);
        $messages = RecivedMail::all();
        return view('admin.contact-message.index', compact('messages'));
    }

 public function sendReplay(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        try {
            $contact = Contact::where('language', 'en')->first();

            /** Send mail */
            Mail::to($request->email)->send( new ContactMail($request->subject, $request->message, $contact->email));
            toast(__('Mail Sent Successfully!'), 'success');

            $makeReplied = RecivedMail::find($request->message_id);
            $makeReplied->replied = 1;
            $makeReplied->save();

            return redirect()->back();
        } catch (\Throwable $th) {
            toast($th->getMessage(), 'error');

            return redirect()->back();
        }
    }
}
