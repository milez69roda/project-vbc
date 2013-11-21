var processing = false;

var membershiptransaction = {
	
	details: function(id){
		
		var title = 'Membership Details';
		var tpl = $('<div class="modal fade"></div>').load('membership/ajax_membership_details/?_t='+(new Date).getTime(), {token:id, title:title});	
						
		$(tpl).modal({ backdrop: 'static', keyboard: true }).on('hidden.bs.modal', function () {
				//if( redirect != '' ) window.location = redirect;
				//tpl = null;
				$('.modal').remove();
		});			
	}, 		
	
	activate: function(ref){
		
		if( !processing ){
		
			if( confirm('Do you want to Activate?') ){	
				processing = true; 
				$.post('membership/ajax_membership_transaction_sucess',{Ref:ref}, function(json){
					processing = false;
					if(json.status){ 
						alert(json.msg);
						window.location = json.url;
					}else{
						alert(json.msg);
					}
				}, 'json'); 
			}
		}else{
			alert('Please wait, there is still transaction being process.');
		}
	},
	
	delete: function(delid){
		if( !processing ){ 
			if( confirm('Do you want to delete?') ){
				processing = true;
				$.post('membership/ajax_membership_transaction_delete',{delid:delid}, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg);
						window.location = json.url;
					}else{
						alert(json.msg);
					}
				}, 'json');
			}
		}else{
			alert('Please wait, there is still transaction being process.');
		}
	},
	
	updateInfo: function(form){

		if( !processing ){ 
			data = $(form).serialize()	
			processing = true;
			$.post('membership/ajax_membership_update_details',data, function(json){
				processing = false;
				if(json.status){							
					alert(json.msg);
					//window.location = json.url; 
					$('#label-top-fname').html(json.fullname);
					oTable.fnDraw();
				}else{
					alert(json.msg);
				}
			}, 'json');
			 
		}else{
			alert('Please wait, there is still transaction being process.');
		}
		
		return false;
	},

	savefreebies: function(form){

		if( !processing ){ 
		
			if( confirm('Do you want to Submit?') ){	
				processing = true;
				data = $(form).serialize();
				$.post('membership/ajax_membership_freebies_save',data, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg); 
						var tr = '<tr>';
							tr += '<td>'+json.data.date+'</td>';
							tr += '<td>'+json.data.f_desc+'</td>';
							tr += '<td>'+json.data.added_by+'</td>';
						$("#freebies_table tbody tr:first").after(tr);	

						$("#freebiesdesc").val('');	
						$('#freebies-button-cancel').on('click',function(){
							$('#freebies-button-add').show();
							$("#freebies_div").hide();		
						});								
						
						oTable.fnDraw();
					}else{
						alert(json.msg);
					}
				}, 'json'); 	
				
			}
		
		}else{
			alert('Please wait, there is still transaction being process.');
		}

		return false;
	},

	saveterms: function(form){

		if( !processing ){ 
		
			if( confirm('Do you want to Submit?') ){
				processing = true;
				data = $(form).serialize();
				$.post('membership/ajax_membership_terms_save',data, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg);  
						//if( json.term == 0 ){
							window.location = document.URL;
							//console.log(document.URL);
						//}
						oTable.fnDraw();
					}else{
						alert(json.msg);
					}
				}, 'json'); 	
			}
		}else{
			alert('Please wait, there is still transaction being process.');
		}

		return false;
	}
}