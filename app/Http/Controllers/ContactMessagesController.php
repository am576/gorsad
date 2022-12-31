<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('id', 'DESC')->get();

        return  view('admin.messages.index', compact('messages'));
    }
}
