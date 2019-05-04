$(document).ready(function() {

	/*  categoriesTable */
	
    window.categoriesTable = $('#categoriesTable').DataTable({
      "processing": true,
      "serverSide": true,
       "ordering": true,
      "dom": '<l<t>ip>',
        "ajax": 'searchajaxcategories',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "categoryName"},	
			{ "data": "parentCategoryName"},	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="categories-edit/'+data+'"  class="hide btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'categoriesTable\',\'categories-delete\')" class="btn btn-sm btn-danger">Delete</button>';

		   }},	
        ]
		,"columnDefs": [ 
		{
		'targets': 0,
         'searchable': false,
         'orderable': false,
		},
		
		],
		'rowCallback': function(row, data, dataIndex){
			var strVale = $('#checked_ids').val();
			var rowId = data.id;
			var arr = strVale.split(',');
			arr = arr.map(Number);
			//alert(rowId);
           if($.inArray(rowId,arr) !== -1){
			  $(row).find('input[type="checkbox"]').prop('checked', true);
			}
      }
    });

     $('#categoriesTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(categoriesTable);
		e.stopPropagation();
		var ids = $('#checked_ids').val();
		var nids = '';
		
		 if(this.checked){ 
			if(ids.length == 0){
				nids = $(this).val();
			}else{
				nids = $(this).val()+','+ids;
			}
			$('#checked_ids').val(nids);
		}else{
			var nlist = removeValue(ids,$(this).val());
			$('#checked_ids').val(nlist);
		}
		var cvals = $('#checked_ids').val();
		var arr = cvals.split(',');
		if(cvals.length == 0){ 
			$('#selected_count').hide();
		}else{
			$('#selected_count').html('Selected Count : '+arr.length);
			$('#selected_count').show();
		}
    });
   
    $('#categoriesTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#categoriesTable thead input[name="select_all"]', categoriesTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#categoriesTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#categoriesTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   categoriesTable.on('draw', function(){
      updateDataTableSelectAllCtrl(categoriesTable);
   });
	
	
   
  
	$("#categoriesfrm #filter_submit").on('click', function () {

		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#categoriesfrm #name").val();
        var parent_id = $("#categoriesfrm #parent_id").val();
		window.categoriesTable.column(1).search(name).column(2).search(parent_id).draw();      
    });
	
	/* ./ categoriesTable */

	/*  productsTable */
	
    window.productsTable = $('#productsTable').DataTable({
      "processing": true,
      "serverSide": true,
       "ordering": true,
      "dom": '<l<t>ip>',
        "ajax": 'searchajaxproducts',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "title" },
			{ "data": "categoryName"},	
			{ "data": "parentCategoryName"},	
			{ "data": "current_price"},	
			{ "data": "current_price_currency"},	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="'+row.viewItemURL+'" target="_blank"  class="btn btn-sm btn-info">View</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'productsTable\',\'products-delete\')" class="btn btn-sm btn-danger">Delete</button>';

		   }},	
        ]
		,"columnDefs": [ 
		{
		'targets': 0,
         'searchable': false,
         'orderable': false,
		},
		
		],
		'rowCallback': function(row, data, dataIndex){
			var strVale = $('#checked_ids').val();
			var rowId = data.id;
			var arr = strVale.split(',');
			arr = arr.map(Number);
			//alert(rowId);
           if($.inArray(rowId,arr) !== -1){
			  $(row).find('input[type="checkbox"]').prop('checked', true);
			}
      }
    });

     $('#productsTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(productsTable);
		e.stopPropagation();
		var ids = $('#checked_ids').val();
		var nids = '';
		
		 if(this.checked){ 
			if(ids.length == 0){
				nids = $(this).val();
			}else{
				nids = $(this).val()+','+ids;
			}
			$('#checked_ids').val(nids);
		}else{
			var nlist = removeValue(ids,$(this).val());
			$('#checked_ids').val(nlist);
		}
		var cvals = $('#checked_ids').val();
		var arr = cvals.split(',');
		if(cvals.length == 0){ 
			$('#selected_count').hide();
		}else{
			$('#selected_count').html('Selected Count : '+arr.length);
			$('#selected_count').show();
		}
    });
   
    $('#productsTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#productsTable thead input[name="select_all"]', productsTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#productsTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#productsTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   productsTable.on('draw', function(){
      updateDataTableSelectAllCtrl(productsTable);
   });
	
	
   
  
	$("#productsfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();  
        var name = $("#productsfrm #name").val();
        var parent_id = $("#productsfrm #parent_id").val();
        var cat_id = $("#productsfrm #cat_id").val();
		window.productsTable.column(1).search(name).column(2).search(cat_id).column(3).search(parent_id).draw(); 		
    });
	
	/* ./ productsTable */


	
	
	
	
/**************************************************************************************************************************************************************************************/

	
	/* COMMON FUNCTIONS */
    $(function(){        
      $(".listEdit #submit").click(function(){
        
        var company     = $("#company").val();
        var industry    = $("#industry").val();
        var city        = $("#city option:selected").val();
        var country     = $("#country option:selected").val();
          
        $.getJSON("/listsearchcontactsajax",{'company':company  ,'industry':industry  ,'country':country,'city':city  , ajax: 'true'}, function(res){
            var option = '';
            for (var i = 0; i < res.data.length; i++) {
                option += '<option value="' + res.data[i].id + '">' + res.data[i].firstName + '</option>';
            }

            $("#public-methods").multiselect('destroy');            
            $("select.listContacts").html(option);
            $('#public-methods').multiSelect('refresh'); 
            
        })
        
      })
    })
    
    
});

function get_city_list(content,ctry_id){
	$("#"+content+" #city").html('');
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url: 'getCities',
		data: {'country_id':ctry_id}, // serializes the form's elements.
		success: function(res)
		{ 
			 $("#"+content+" #city").html(res);
		}
		});
}

function updateDataTableSelectAllCtrl(table){ 
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}


function edit_row(content,redirect){
	var form = $('#'+content);
	var id =0;
	if($('#'+content+' tbody input[type="checkbox"]:checked').length == 1){ 
	
	$.each($('#'+content+' tbody input[type="checkbox"]:checked'),function(index, rowId){
		id = $(this).val();
	});
	
	if(id != 0){ 
		window.location.href = redirect+'/'+id;
	}
	}
}

function delete_row(content,action){
	var form = $('#'+content);
	if($('#'+content+' tbody input[type="checkbox"]:checked').length == 0){
	$.notify({
	  message: 'Please select atleast one row to delete' 
	 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
	});	
	}
	else if($('#'+content+' tbody input[type="checkbox"]:checked').length > 0){
	if(confirm("Are you sure you want to delete this?")){
	var ids = $('#checked_ids').val();
	
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url: action,
		data: {'ids':ids}, // serializes the form's elements.
		success: function(res)
		{  
			$.notify({
			  message: 'Successfully Deleted' 
			 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});			
			if(content == 'categoriesTable'){
				window.categoriesTable.draw();
			}
			if(content == 'productsTable'){
				window.productsTable.draw();
			}
			if(content == 'districtsTable'){
				window.districtsTable.draw();
			}
			if(content == 'citiesTable'){
				window.citiesTable.draw();
			}
			if(content == 'companyprofileTable'){
				window.companyprofileTable.draw();
			}
			if(content == 'contactsTable'){
				window.contactsTable.draw();
			}
			if(content == 'departmentsTable'){
				window.departmentsTable.draw();
			}
			if(content == 'branchesTable'){
				window.branchesTable.draw();
			}
			if(content == 'employeesTable'){
				window.employeesTable.draw();
			}
			if(content == 'airlinesTable'){
				window.airlinesTable.draw();
			}
			if(content == 'airportsTable'){
				window.airportsTable.draw();
			}
			if(content == 'mealsplanTable'){
				window.mealsplanTable.draw();
			}
			if(content == 'hotelfacilitiesTable'){
				window.hotelfacilitiesTable.draw();
			}
			if(content == 'hotelchainTable'){
				window.hotelchainTable.draw();
			}
			if(content == 'airticketfareclassTable'){
				window.airticketfareclassTable.draw();
			}
			if(content == 'ratingTable'){
				window.ratingTable.draw();
			}
			if(content == 'paymentmethodsTable'){
				window.paymentmethodsTable.draw();
			}
			if(content == 'languagesTable'){
				window.languagesTable.draw();
			}
			if(content == 'marketsTable'){
				window.marketsTable.draw();
			}
			if(content == 'segmentsTable'){
				window.segmentsTable.draw();
			}
			if(content == 'currenciesTable'){
				window.currenciesTable.draw();
			}
			if(content == 'cuisinesTable'){
				window.cuisinesTable.draw();
			}
			if(content == 'paymenttermsTable'){
				window.paymenttermsTable.draw();
			}
			if(content == 'bookingstatusTable'){
				window.bookingstatusTable.draw();
			}
			if(content == 'rateperiodsTable'){
				window.rateperiodsTable.draw();
			}
			if(content == 'landservicecategoryTable'){
				window.landservicecategoryTable.draw();
			}
			if(content == 'hotelscategoryTable'){
				window.hotelscategoryTable.draw();
			}
			if(content == 'venuesetupTable'){
				window.venuesetupTable.draw();
			}
			if(content == 'sitescategoryTable'){
				window.sitescategoryTable.draw();
			}
			if(content == 'sitesareaTable'){
				window.sitesareaTable.draw();
			}
			if(content == 'sitesTable'){
				window.sitesTable.draw();
			}
			if(content == 'eventsholidaysTable'){
				window.eventsholidaysTable.draw();
			}
			if(content == 'vehiclesTable'){
				window.vehiclesTable.draw();
			}
			$('#selected_count').hide();	 
		}
		});
	}
	}
}


function delete_single_row(id,content,action){
	if(confirm("Are you sure you want to delete this?")){
	
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url:  action,
		data: {'ids':id}, // serializes the form's elements.
		success: function(res)
		{ 
			$.notify({
			  message: 'Successfully Deleted' 
			 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});	
			if(content == 'categoriesTable'){
				window.categoriesTable.draw();
			}
			if(content == 'productsTable'){
				window.productsTable.draw();
			}
			if(content == 'districtsTable'){
				window.districtsTable.draw();
			}
			if(content == 'citiesTable'){
				window.citiesTable.draw();
			}
			if(content == 'companyprofileTable'){
				window.companyprofileTable.draw();
			}
			if(content == 'contactsTable'){
				window.contactsTable.draw();
			}
			if(content == 'departmentsTable'){
				window.departmentsTable.draw();
			}
			if(content == 'branchesTable'){
				window.branchesTable.draw();
			}
			if(content == 'employeesTable'){
				window.employeesTable.draw();
			}
			if(content == 'airlinesTable'){
				window.airlinesTable.draw();
			}
			if(content == 'airportsTable'){
				window.airportsTable.draw();
			}
			if(content == 'mealsplanTable'){
				window.mealsplanTable.draw();
			}
			if(content == 'hotelfacilitiesTable'){
				window.hotelfacilitiesTable.draw();
			}
			if(content == 'hotelchainTable'){
				window.hotelchainTable.draw();
			}
			if(content == 'airticketfareclassTable'){
				window.airticketfareclassTable.draw();
			}
			if(content == 'ratingTable'){
				window.ratingTable.draw();
			}
			if(content == 'paymentmethodsTable'){
				window.paymentmethodsTable.draw();
			}
			if(content == 'languagesTable'){
				window.languagesTable.draw();
			}
			if(content == 'marketsTable'){
				window.marketsTable.draw();
			}
			if(content == 'segmentsTable'){
				window.segmentsTable.draw();
			}
			if(content == 'currenciesTable'){
				window.currenciesTable.draw();
			}
			if(content == 'cuisinesTable'){
				window.cuisinesTable.draw();
			}
			if(content == 'paymenttermsTable'){
				window.paymenttermsTable.draw();
			}
			if(content == 'bookingstatusTable'){
				window.bookingstatusTable.draw();
			}
			if(content == 'rateperiodsTable'){
				window.rateperiodsTable.draw();
			}
			if(content == 'landservicecategoryTable'){
				window.landservicecategoryTable.draw();
			}
			if(content == 'hotelscategoryTable'){
				window.hotelscategoryTable.draw();
			}
			if(content == 'venuesetupTable'){
				window.venuesetupTable.draw();
			}
			if(content == 'sitescategoryTable'){
				window.sitescategoryTable.draw();
			}
			if(content == 'sitesareaTable'){
				window.sitesareaTable.draw();
			}
			if(content == 'sitesTable'){
				window.sitesTable.draw();
			}
			if(content == 'eventsholidaysTable'){
				window.eventsholidaysTable.draw();
			}
			if(content == 'vehiclesTable'){
				window.vehiclesTable.draw();
			}
			$('#selected_count').hide();	
		}
		});
	}
}


function copy_single_row(id,content,action){
	if(confirm("Are you sure you want to copy this?")){
	
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url:  action,
		data: {'ids':id}, // serializes the form's elements.
		success: function(res)
		{ 
		
			$.notify({
			  message: 'Successfully Copied' 
			 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});	
			if(content == 'sequenceTable'){
			window.sequenceTable.draw();
			}
				
		}
		});
	}
}

function set_status_row(selected_type, type,list_id,content,action){
	var form = $('#'+content);
	if(selected_type == 0){
		if($('#'+content+' tbody input[type="checkbox"]:checked').length == 0){
			$.notify({
			  message: 'Please select atleast one row to change status' 
			 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});			
		return false;
		}
	
	}
	if(confirm("Are you sure you want to change status?")){
	var ids = [];
	$.each($('#'+content+' tbody input[type="checkbox"]:checked'),function(index, rowId){
		var id = $(this).val();
		ids.push(id);
	});
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url: action,
		data: {'list_id':list_id,'ids':ids,'status':type,'selected_type':selected_type}, // serializes the form's elements.
		success: function(res)
		{  
			if(content == 'listContactTable'){
			window.listContactTable.draw();
			}
			if(selected_type == 1){
				if(type == 1){
					$.notify({
					  message: 'All Contact list set Active successfully!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});						
				}else{
					$.notify({
					  message: 'All Contact list set InActive successfully!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});						
				}
			}else{
				if(type == 1){
					$.notify({
					  message: 'Selected Contacts set Active successfully!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});						
				}else{
					$.notify({
					  message: 'Selected Contacts set InActive successfully!' 
					 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
					});
				}
			}
		}
		});
	}
	
}

function removeValue(list, value) {
  return list.replace(new RegExp(",?" + value + ",?"), function(match) {
      var first_comma = match.charAt(0) === ',',
          second_comma;

      if (first_comma &&
          (second_comma = match.charAt(match.length - 1) === ',')) {
        return ',';
      }
      return '';
    });
};