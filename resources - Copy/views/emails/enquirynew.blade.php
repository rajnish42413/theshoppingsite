<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width" />
    </head>
    <body style="margin: 0; padding: 10px;">
        <div>
		Hello Admin, <br><br>
		New enquiry from portal Contact Us Page.<br/><br/>
        Name: {{ $info->name }}<br/>
        Email: {{ $info->email }}<br/>
        Subject: {{ $info->subject }}<br/>
		Contact No.: {{ $info->contact_no }}<br/>		
		Message: {{ $info->message }}<br/>
		<br><br>
		</div>
		<div>
		Thanks<br>
		{{env('APP_NAME')}} Team
		</div>
    </body>
</html>