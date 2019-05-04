<?php
namespace App\Contracts;

interface EmailServiceContract {
	 public function send_email($info,$file,$attachment);
}
