<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enquiry;
use App\Setting;

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
		$settings = Setting::limit(1)->first();
		if($settings && $settings->count() > 0){
			$site_name = $settings->title;	
		}else{
			$site_name = env('APP_NAME');
		}
        return $this->to('shopergy_admin@yopmail.com')->subject($site_name . ' - New enquiry form Contact Us')->view('emails.enquirynew');
    }
}
