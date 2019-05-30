@extends('layouts.app')

@section('content')

<!--Main Wrapper Start-->
<div class="sh_main_wrap sh_float_width">
	<!--Terms of Use Wrapper Start-->
	<div class="sh_terms_wrapper sh_float_width">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
					<div class="sh_heading">
						<h2>Conditions of Use</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo $row->page_content;?>
				</div>
			</div>
		</div>
	</div>

</div>	
@endsection
