<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReferenceEmail;

use Illuminate\Http\Request;

class MailController extends Controller
{
    function sendEmail(){
        $to="loplama3621@gmail.com";
        $subject="Test Email";
        $message="This is a test email.";
        $headers="From: cellapp@gmail.com";

        Mail::to($to)->send(new ReferenceEmail($subject, $message, $headers));
    }
}
