var processing = false;
var tpl;
var membershiptransaction = {
	
	details: function(id){
		
		var title = 'Membership Details';
		tpl = $('<div class="modal fade"></div>').load('membership/ajax_membership_details/?_t='+(new Date).getTime(), {token:id, title:title});	
						
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
				$.post('membership/ajax_membership_delete?_t='+(new Date).getTime(),{delid:delid}, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg);
						//window.location = json.url;
						if( typeof oTable !== 'undefined' ) oTable.fnDraw();
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
			$.post('membership/ajax_membership_update_details/?_t='+(new Date).getTime(),data, function(json){
				processing = false;
				if(json.status){							
					alert(json.msg);
					//window.location = json.url; 
					$('#label-top-fname').html(json.fullname);
					if( typeof oTable !== 'undefined' ) oTable.fnDraw();
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
				$.post('membership/ajax_membership_freebies_save/?_t='+(new Date).getTime(),data, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg); 
						var tr = '<tr>';
							tr += '<td>'+json.data.date+'</td>';
							tr += '<td>'+json.data.f_desc+'</td>';
							tr += '<td>'+json.data.added_by+'</td>';
						$("#freebies_table tbody>tr:first").after(tr);	

						$("#freebiesdesc").val('');	
						
						$('#freebies-button-add').show();
						$("#freebies_div").hide();	 						
						
						//oTable.fnDraw();
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
				$.post('membership/ajax_membership_terms_save/?_t='+(new Date).getTime(),data, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg);  
						//if( json.term == 0 ){
							window.location = document.URL;
							//console.log(document.URL);
						//}
						//oTable.fnDraw();
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

	saveotherpayment: function(form){

		if( !processing ){ 
		
			if( confirm('Do you want to submit payment?') ){
				processing = true;
				data = $(form).serialize();
				$.post('membership/ajax_membership_otherpayment_save/?_t='+(new Date).getTime(),data, function(json){
					processing = false;
					if(json.status){							
						alert(json.msg);  
						var tr = '<tr>';
							tr += '<td>'+json.data.date+'</td>';
							tr += '<td>'+json.data.Order_Date+'</td>';
							tr += '<td>'+json.data.mode+'</td>';
							tr += '<td>'+json.data.Amount+'</td>';
							tr += '<td>'+json.data.reason+'</td>';
							tr += '<td>'+json.data.uploaded_by+'</td>';
						$("#otherpayment_table tbody>tr:first").after(tr);	
						
						$('#otherpayment-button-add').show();
						$("#otherpayment_div").hide();							
						$("#other_desc").val('');							
						
						//if( typeof oTable !== 'undefined' ) oTable.fnDraw();
						//else window.location = document.URL;
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
	
	sendemail: function(type, ref){
		if( !processing ){ 
		
			if( confirm('Do you want to send email?') ){
				processing = true; 
				$.post('membership/ajax_membership_mail',{type:type,refno:ref}, function(json){
					processing = false;
					alert(json);
					/* if(json.status){							
						alert(json.msg);  
						var tr = '<tr>';
							tr += '<td>'+json.data.date+'</td>';
							tr += '<td>'+json.data.Order_Date+'</td>';
							tr += '<td>'+json.data.Amount+'</td>';
							tr += '<td>'+json.data.reason+'</td>';
							tr += '<td>'+json.data.uploaded_by+'</td>';
						$("#otherpayment_table tbody>tr:first").after(tr);	
						
						$('#otherpayment-button-add').show();
						$("#otherpayment_div").hide();							
						$("#other_desc").val('');							
						
						oTable.fnDraw();
						
					}else{
						alert(json.msg);
					} */
				}); 	
			}
		}else{
			alert('Please wait, there is still transaction being process.');
		}

		return false;	
	}
}

var updates = {
	modal: function(){
	
	}
}


var generatereports = {

	export: function(){
		form = $("#searchForm").serialize();
		window.location = 'export/download/?'+form;
		
		/* $.post('export/download', form.serialize(), function(result){
			window.location = result;
		}); */ 
	},
	
	pdfinvoice: function(){ 
		
		var formfields = $('#searchForminvoice').serialize();
		
		//window.location = 'reports/invoicepdf/?startdate='+$('#startdate').val()+'&enddate='+$('#enddate').val(); 
		var ref = jQuery.trim($("#ref").val());
		if(  ref === '' ){
			 window.location = 'reports/invoicepdf/?'+formfields; 
		}else{
			window.location = 'reports/invoicepdfmember/?'+formfields; 
		}
		
		//window.location = 'reports/invoicepdf/?'+formfields; 
	},
	
	pdfinvoicemember: function(ref){
		var type = $("#report_type_status_payment").val();
		window.location = 'reports/invoicepdfmember/?ref='+ref+'&report_type='+type;
	}
} 


//keystroke
$(document).keyup(function(e) { 
	//keystroke ESC, remove modal
	if (e.keyCode == 27) { 
		$('.modal').remove(); 
		$('.modal-backdrop').remove(); 
		processing = false;
	} 
	
	//keystroke F2, redirect
	if (e.keyCode == 113) { 
		window.location = 'membership';
	}
});
  

$(document).ready( function () { 

	$(window).scroll(function(){
	    if ($(this).scrollTop() > 190) {  $('#go_up').fadeIn(); } 
		else { $('#go_up').fadeOut(); }
	});

	$("#go_up").click(function(){
		$("html, body").animate({ scrollTop: 0 }, 300);
	});
	
	
	//datatables arrow keyes left right 
	$(document).bind('keydown', 'right', function() {
		oTable.fnPageChange('next');
	});

	$(document).bind('keydown', 'left', function() {
		oTable.fnPageChange('previous');
	}); 	

	 

});

