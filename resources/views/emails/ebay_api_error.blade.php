<?php 
use \App\Http\Controllers\DetailController;
$settings = DetailController::get_settings();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php if($settings){ echo $settings->title;} ?></title>
        <meta name="viewport" content="width=device-width" />
    </head>
    <body style="margin: 0; padding: 10px;">
        <div>
		Hello Admin, <br><br>
		There is an Ebay Error occured during products updation using Ebay APIs.
		<br><br>
		<b><?php echo '<pre>'; print_r($info);?></b>
		<br><br>
		</div>
		<div>
		Thanks<br>
		<?php if($settings){ echo $settings->title;} ?> Team
		</div>
    </body>
</html>