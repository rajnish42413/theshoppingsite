@extends('admin.layouts.app')

@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <?php echo $data['title'].' - '.$data['sub_title'];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo env('APP_URL');?>products-list"><?php echo $data['title'];?></a></li>
        <li class="active"><?php echo $data['sub_title'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-offset-1 col-md-10 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" id="addForm">
			 {{csrf_field()}}
              <div class="box-body">
				<div class="row">
					<div class="col-sm-12">							
						<div class="admin_errors alert alert-danger" style="display:none;">
							<ul class="nav"></ul>
						</div>
					</div>
				</div>				
					<div class="form-group">
					  <label for="page_title"><span class="text-danger font_12"> * </span>Page Title</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="page_title" class="form-control" ><?php if($row){ echo $row->page_title; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="page_title_error"></div>
					</div>
					<div class="form-group">
					  <label for="meta_keywords"><span class="text-danger font_12"> * </span>Meta Keywords</label>
					  <div class="input-group " id="testing">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
							<input size="2" type="text" name="meta_keywords[]" class="form-control sugg-input" value="<?php if($row){ if(!empty($row->meta_keywords)){ echo $row->meta_keywords; }}?>" autocomplete="off" >
											
					  </div>
					  <small>(Type a comma to create a new keyword)</small>
					  <div class="text-danger error font_12" id="meta_keywords_error"></div>
					</div>					
					<div class="form-group">
					  <label for="meta_description"><span class="text-danger font_12"> * </span>Meta Description</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="meta_description" id="meta_description" class="form-control" ><?php if($row){ echo $row->meta_description; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="meta_description_error"></div>
					</div>
					<div class="form-group">
					  <label for="editor1"><span class="text-danger font_12"> * </span>Content</label>
					  <div class="input-group">
						<div class="input-group-addon"><i class="fa fa-edit"></i></div>
						<textarea name="page_content" class="form-control tiny_msg tiny_txtarea" id="editor1"  ><?php if($row){ echo $row->page_content; } ?></textarea>
					  </div>
					  <div class="text-danger error font_12" id="page_content_error"></div>
					</div>		
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			  <input type="hidden" name="page_type" value="<?php if($row){ echo $row->page_type; }else{ echo 'privacy_policy';} ?>">
				<input type="hidden" name="id" id="id" value="<?php if($row){ echo $row->id; }?>" >
                <button type="submit" class="btn btn-primary" id="sub_btn">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script>
var bodies = [<?php if(!empty($meta_keywords)){ echo $meta_keywords; } ?>];
$('#testing input').suggester({
   data: bodies, 
   minChars: 1
});
</script>
<script>


$("#addForm").submit(function(e){
	$('.wait_loader').show();
	var content =  tinymce.get("editor1").getContent();
    $('#editor1').val(content);		
	e.preventDefault();
	$('.admin_errors.alert-danger').hide();
	$('.admin_errors.alert-danger ul').html('');
	$("#sub_btn").html('please wait..'); 
	$('.error').html('');
	$.ajax({
		type: "POST",
		url: '<?php echo route('settings-page-save');?>',
		data:  new FormData(this),
		processData:false,
		contentType:false,
		cache:false,
		datatype:"json",
		success: function(response)
		{
			$("#sub_btn").html('Submit'); 
			$('.wait_loader').hide();	
			var result = response.split("|"); 
			 if(result[0].length != 0){
				var err = JSON.parse(result[0]);
				var er = '';
				$.each(err, function(k, v) {
					if(k == 'file'){ 
						$('.admin_errors.alert-danger').show();
						$('.admin_errors.alert-danger ul').append('<li>'+v+'</li>');			 
					} 
				});
			}
			 
			else if(response == '|success'){

				<?php if($row){ ?>
					
					$.notify({
					  message: '<?php echo $data['title'];?> Content Updated Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				<?php }else{ ?>
					
					$.notify({
					  message: '<?php echo $data['title'];?> Content Added Successfully!!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					 });
				<?php } ?>
				
			window.setTimeout(function() { location.reload(); }, 1000); 			
		}

		},
		error: function(data){
			$("#sub_btn").html('Submit');
			var errors = data.responseJSON;
			$(".wait_loader").hide();
			console.log(errors.errors);
			$.each(errors.errors, function(key, value){
				$('.admin_errors.alert-danger').show();
				$('.admin_errors.alert-danger ul').append('<li>'+value+'</li>');
			});
		}		
	});
});


 </script>
<script src="{{env('APP_URL')}}admin_assets/plugins/tinymce/tinymce.js" type="text/javascript"></script>
<script src="{{env('APP_URL')}}admin_assets/plugins/tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
	tinymce.init({
			branding: false,
			selector: "textarea.tiny_txtarea",
			file_picker_types: 'file image media',
			theme: "modern",
			menubar: true,
			width: '100%',
			height: 400,
			plugins: [
				 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				 "save table contextmenu directionality emoticons template paste textcolor jbimages"
		   ],
		   content_css: "<?php echo env('APP_URL');?>admin_assets/plugins/tinymce/skins/lightgray/content.min.css",
		   toolbar: "insertfile undo redo | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | bold italic forecolor backcolor jbimages", 
		   style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			]
		});
</script>
 
@endsection
