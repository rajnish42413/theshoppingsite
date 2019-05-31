<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Setting;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        return $this->to($this->user['email'])->subject($site_name . ' - New User Registration')->view('emails.newuser');
    }
}
