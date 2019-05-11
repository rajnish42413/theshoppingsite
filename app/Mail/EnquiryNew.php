<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enquiry;

class EnquiryNew extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Enquiry $enquiry)
    {
        $this->info = $enquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('shopergy_admin@yopmail.com')->subject(env('APP_NAME') . ' - New enquiry form Contact Us')->view('emails.enquirynew');
    }
}
