@extends('layouts.app')

@section('content')

<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!-- Privacy Policy Wrapper Start-->
	<div class="sh_privacy_wrapper sh_float_width">
		<div class="container">
			<?php echo $row->page_content;?>
		</div>
	</div>

</div>	

@endsection
