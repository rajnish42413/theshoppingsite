$(document).ready(function() {
	/*  usersTable */
	
    window.usersTable = $('#usersTable').DataTable({
      "processing": true,
      "serverSide": true,
       "ordering": true,
      "dom": '<l<t>ip>',
        "ajax": 'searchajaxusers',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "name" },
            { "data": "is_super_admin","render": function(data, type, row, meta){ 
				if(data=='1'){
					return 'Super Admin';
				}
				else if(data=='0'){
					return 'Sub Admin';
				}
			}},				
			{ "data": "email"},	
            { "data": "active","render": function(data, type, row, meta){ 
				if(data=='1'){
					return '<button type="button" onclick="status_row_single('+row.id+',\'usersTable\',\'users-status\',\'0\')" class="btn btn-sm btn-success">Active</button>';
				}
				else if(data=='0'){
					return '<button type="button" onclick="status_row_single('+row.id+',\'usersTable\',\'users-status\',\'1\')" class="btn btn-sm btn-danger">Deactive</button>';
				}
			}},		
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="users-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'usersTable\',\'users-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#usersTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(usersTable);
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
   
    $('#usersTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#usersTable thead input[name="select_all"]', usersTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#usersTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#usersTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   usersTable.on('draw', function(){
      updateDataTableSelectAllCtrl(usersTable);
   });
	
	
   
  
	$("#usersfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#usersfrm #name").val();
		window.usersTable.column(1).search(name).draw();      
    });
	
	/* ./ usersTable */
	
	/*  navigationMenuTable */
	
    window.navigationMenuTable = $('#navigationMenuTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxnavmenu',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "name" },
            { "data": "parent_name","render": function(data, type, row, meta){ 
			if(data == null){
				return '-';
			}else{
				return data;
			}
			}},	
            { "data": "link_name"},		
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="navigation-menu-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'navigationMenuTable\',\'navigation-menu-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#navigationMenuTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(navigationMenuTable);
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
   
    $('#navigationMenuTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#navigationMenuTable thead input[name="select_all"]', navigationMenuTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#navigationMenuTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#navigationMenuTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   navigationMenuTable.on('draw', function(){
      updateDataTableSelectAllCtrl(navigationMenuTable);
   });
	
	
   
  
	$("#navmenufrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#navmenufrm #name").val();
		window.navigationMenuTable.column(1).search(name).draw();      
    });
	
	/* ./ navigationMenuTable */
	
	/*  bannersTable */
	
    window.bannersTable = $('#bannersTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxbanners',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "name" },
			{ "data": "heading_title"},
            { "data": "description","render": function(data, type, row, meta){ 
			return data.substring(0, 50)+'...';
			}},	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="banners-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'bannersTable\',\'banners-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#bannersTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(bannersTable);
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
   
    $('#bannersTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#bannersTable thead input[name="select_all"]', bannersTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#bannersTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#bannersTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   bannersTable.on('draw', function(){
      updateDataTableSelectAllCtrl(bannersTable);
   });
	
	
	$("#bannersfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#bannersfrm #name").val();
		window.bannersTable.column(1).search(name).draw();      
    });
	
	/* ./ bannersTable */
	
	/*  trendingproductsTable */
	
    window.trendingproductsTable = $('#trendingproductsTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxtrendingproducts',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "title" },
			{ "data": "categoryName"},
            { "data": "created_at"},	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="trending-products-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'trendingproductsTable\',\'trending-products-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#trendingproductsTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(trendingproductsTable);
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
   
    $('#trendingproductsTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#trendingproductsTable thead input[name="select_all"]', trendingproductsTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#trendingproductsTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#trendingproductsTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   trendingproductsTable.on('draw', function(){
      updateDataTableSelectAllCtrl(trendingproductsTable);
   });
	
	
	$("#trendingproductsfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#trendingproductsfrm #name").val();
		window.trendingproductsTable.column(1).search(name).draw();      
    });
	
	/* ./ trendingproductsTable */
	
	
	
	
	/*  merchantsTable */
	
    window.merchantsTable = $('#merchantsTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxmerchants',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "name" },	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="merchants-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>';

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

     $('#merchantsTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(merchantsTable);
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
   
    $('#merchantsTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#merchantsTable thead input[name="select_all"]', merchantsTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#merchantsTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#merchantsTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   merchantsTable.on('draw', function(){
      updateDataTableSelectAllCtrl(merchantsTable);
   });
	
	
	$("#merchantsfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#merchantsfrm #name").val();
		window.merchantsTable.column(1).search(name).draw();      
    });
	
	/* ./ merchantsTable */
	
	/*  categoriesTable */
	
    window.categoriesTable = $('#categoriesTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        }, 	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxcategories',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "categoryName"},	
			{ "data": "parentCategoryName"},
			{ "data": "cat3Name"},
			{ "data": "cat4Name"},
            { "data": "status","render": function(data, type, row, meta){ 
				if(data=='1'){
					return '<button type="button" onclick="status_row_single('+row.id+',\'categoriesTable\',\'categories-status\',\'0\')" class="btn btn-sm btn-success">Active</button>';
				}
				else if(data=='0'){
					return '<button type="button" onclick="status_row_single('+row.id+',\'categoriesTable\',\'categories-status\',\'1\')" class="btn btn-sm btn-danger">Deactive</button>';
				}
			}},			
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="categories-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>';

		   }},	
        ]
		,"columnDefs": [ 
		{
		'targets': 0,
         'searchable': false,
         'orderable': false,
		},
		{
		'targets': 3,
         'visible': false,
		},
		{
		'targets': 4,
         'visible': false,
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
        var cat_id = $("#categoriesfrm #cat_id").val();
        var sub_cat_id = $("#categoriesfrm #sub_cat_id").val();
		window.categoriesTable.column(1).search(name).column(2).search(parent_id).column(3).search(cat_id).column(4).search(sub_cat_id).draw();      
    });
	
	/* ./ categoriesTable */

	/*  parentcategoriesTable */
	
    window.parentcategoriesTable = $('#parentcategoriesTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        }, 	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxparentcategories',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "categoryName"},	
            { "data": "status","render": function(data, type, row, meta){ 
				if(data=='1'){
					return '<span class="label label-success">Active</span>';
				}
				else if(data=='0'){
					return '<span class="label label-danger">Deactive</span>';
				}
			}},			
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="categories-edit/'+data+'"  class="btn btn-sm btn-info">Edit</a>&nbsp;&nbsp;<button type="button" onclick="delete_single_row('+data+',\'parentcategoriesTable\',\'categories-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#parentcategoriesTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(parentcategoriesTable);
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
   
    $('#parentcategoriesTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#parentcategoriesTable thead input[name="select_all"]', parentcategoriesTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#parentcategoriesTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#parentcategoriesTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   parentcategoriesTable.on('draw', function(){
      updateDataTableSelectAllCtrl(parentcategoriesTable);
   });
	
	
   
  
	$("#parentcategoriesfrm #filter_submit").on('click', function () {

		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#parentcategoriesfrm #name").val();
		window.parentcategoriesTable.column(1).search(name).draw();      
    });
	
	/* ./ parentcategoriesTable */
	
	/*  productsTable */
	
    window.productsTable = $('#productsTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },  
      "serverSide": true,
      "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxproducts',

        "columns": [
            { "data": "itemId","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
            { "data": "title","render": function(data, type, row, meta){ 
				if(data.length > 30){
					return data.substring(0,30)+'...';
				}else{
					return data;
				}
			}},		
			{ "data": "merchant_name"},				
			{ "data": "catName2"},		//parent - level 2	
			{ "data": "catName1"},		//cat	- level 1
			{ "data": "catName3"},		//cat	 - level 3
			{ "data": "catName4"},		//cat	- level 4
			{ "data": "current_price"},	
			{ "data": "current_price_currency"},
            { "data": "status","render": function(data, type, row, meta){ 
				if(data=='1'){
					return '<button type="button" onclick="status_row_single('+row.itemId+',\'productsTable\',\'products-status\',\'0\')" class="btn btn-sm btn-success">Active</button>';
				}
				else if(data=='0'){
					return '<button type="button" onclick="status_row_single('+row.itemId+',\'productsTable\',\'products-status\',\'1\')" class="btn btn-sm btn-danger">Deactive</button>';
				}
			}},			
		   { "data": "itemId","orderable":false,"render": function(data, type, row, meta){ 
			   return '<a href="products-edit/'+data+'"  class="btn btn-sm btn-primary">Edit</a>&nbsp;&nbsp;<a href="'+row.viewItemURL+'" target="_blank"  class="btn btn-sm btn-info">View</a>';

		   }},	
        ]
		,"columnDefs": [ 
		{
		'targets': 0,
         'searchable': false,
         'orderable': false,
		},
		{
		'targets': 5,
         'searchable': false,
         'orderable': false,
         'visible': false,
		},
		{
		 'targets': 6,
         'searchable': false,
         'orderable': false,
         'visible': false,
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
        var merchant_id = $("#productsfrm #merchant_id").val();
        var parent_id = $("#productsfrm #parent_id").val();
        var cat_id = $("#productsfrm #cat_id").val();
        var sub_cat_id = $("#productsfrm #sub_cat_id").val();
        var sub2_cat_id = $("#productsfrm #sub2_cat_id").val();
		window.productsTable.column(1).search(name).column(2).search(merchant_id).column(3).search(parent_id).column(4).search(cat_id).column(5).search(sub_cat_id).column(6).search(sub2_cat_id).draw(); 		
    });
	
	/* ./ productsTable */


	/*  enquiriesTable */
	
    window.enquiriesTable = $('#enquiriesTable').DataTable({
      "processing": true,
	  "language": {
            "processing": "<div class='pageloader'></div>"
        },	  
      "serverSide": true,
       "ordering": true,
      "dom": 'lrtip',
        "ajax": 'searchajaxenquiries',

        "columns": [
            { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			return '<input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() + ' " >';
			}},
			{ "data": "name" },
			{ "data": "email"},
			{ "data": "subject"},
			{ "data": "contact_no"},
            { "data": "message","render": function(data, type, row, meta){ 
			return data.substring(0, 50)+'...';
			}},	
		   { "data": "id","orderable":false,"render": function(data, type, row, meta){ 
			   return '<button type="button" onclick="delete_single_row('+data+',\'enquiriesTable\',\'enquiries-delete\')" class="btn btn-sm btn-danger">Delete</button>';

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

     $('#enquiriesTable tbody').on('click', 'input[type="checkbox"]', function(e){ 
        updateDataTableSelectAllCtrl(enquiriesTable);
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
   
    $('#enquiriesTable').on('click', 'tbody td, thead th:first-child', function(e){ 
      $(this).parent().find('input[type="checkbox"]').trigger('click');
	});
   
   $('#enquiriesTable thead input[name="select_all"]', enquiriesTable.table().container()).on('click', function(e){
      if(this.checked){ 
	  	  
		$('#enquiriesTable tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else { 
			$('#enquiriesTable tbody input[type="checkbox"]:checked').trigger('click');
	 }
	e.stopPropagation();
   });

   // Handle table draw event
   enquiriesTable.on('draw', function(){
      updateDataTableSelectAllCtrl(enquiriesTable);
   });
	
	
	$("#enquiriesfrm #filter_submit").on('click', function () {
		$('#checked_ids').val('');
		$('#selected_count').hide();
        var name = $("#enquiriesfrm #name").val();
		window.enquiriesTable.column(1).search(name).draw();      
    });
	
	/* ./ enquiriesTable */	
	
	
	
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
			if(content == 'usersTable'){
				window.usersTable.draw();
			}			
			if(content == 'categoriesTable'){
				window.categoriesTable.draw();
			}
			if(content == 'productsTable'){
				window.productsTable.draw();
			}
			if(content == 'bannersTable'){
				window.bannersTable.draw();
			}
			if(content == 'navigationMenuTable'){
				window.navigationMenuTable.draw();
			}			
			if(content == 'enquiriesTable'){
				window.enquiriesTable.draw();
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
			if(content == 'usersTable'){
				window.usersTable.draw();
			}			
			if(content == 'categoriesTable'){
				window.categoriesTable.draw();
			}
			if(content == 'productsTable'){
				window.productsTable.draw();
			}
			if(content == 'bannersTable'){
				window.bannersTable.draw();
			}		
			if(content == 'navigationMenuTable'){
				window.navigationMenuTable.draw();
			}			
			if(content == 'enquiriesTable'){
				window.enquiriesTable.draw();
			}
			if(content == 'trendingproductsTable'){
				window.trendingproductsTable.draw();
			}
			$('#selected_count').hide();	
		}
		});
	}
}


function status_row_single(id,content,action,value){
	if(confirm("Are you sure you want to change status?")){
	
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url:  action,
		data: {'id':id,'value':value}, // serializes the form's elements.
		success: function(res)
		{ 
			$.notify({
			  message: 'Status Successfully Changed' 
			 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});	
			if(content == 'usersTable'){
				window.usersTable.draw();
			}			
			if(content == 'categoriesTable'){
				window.categoriesTable.draw();
			}
			if(content == 'productsTable'){
				window.productsTable.draw();
			}
			if(content == 'bannersTable'){
				window.bannersTable.draw();
			}		
			if(content == 'navigationMenuTable'){
				window.navigationMenuTable.draw();
			}			
			if(content == 'enquiriesTable'){
				window.enquiriesTable.draw();
			}
			$('#selected_count').hide();
			setTimeout(function(){ 
				$('#checked_ids').val('');
				$(content+' tbody input[type="checkbox"]').prop('checked', false);
				}, 200);				
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

function set_status_row(content,action,type){

	var form = $('#'+content);

		if($('#'+content+' tbody input[type="checkbox"]:checked').length == 0){
			$.notify({
			  message: 'Please select atleast one row to change status' 
			 },{ element: 'body', type: "danger", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
			});			
		return false;
		}
	

	if(confirm("Are you sure you want to change status?")){

	var ids = $("#checked_ids").val();	
	$.ajax({
		headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
		type: "POST",
		url: action,
		data: {'ids':ids,'status':type}, // serializes the form's elements.
		success: function(res)
		{  
		var itemName = 'Items';
			if(content == 'usersTable'){
				itemName = 'Users';
				window.usersTable.draw();
			}		
			if(content == 'productsTable'){
				window.productsTable.draw();
				itemName = 'Products';
			}
			if(content == 'categoriesTable'){
				itemName = 'Categories';
				window.categoriesTable.draw();
			}
			setTimeout(function(){ 
				$('#checked_ids').val('');
				$(content+' tbody input[type="checkbox"]').prop('checked', false);
				}, 200);				
			
			if(type == 1){
				$.notify({
				  message: 'Selected '+itemName+' set Active successfully!' 
				 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});						
			}else{
				$.notify({
				  message: 'Selected '+itemName+' set Deactive successfully!' 
				 },{ element: 'body', type: "success", allow_dismiss: true, offset: { x: 0, y: 60 }, delay: 1000 
				});
			}
			$("#selected_count").html('');
			$("#selected_count").hide();
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