<?php
namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    // Handle storing inquiry
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect('/contact')->with('success', 'Your message has been sent!');
    }

    // Show admin inquiries page
    public function index()
    {
        $inquiries = ContactInquiry::all();

        return view('manageinquiries', compact('inquiries'));
    }
}
