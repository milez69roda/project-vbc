<script>
	$(document).ready( function () { 
		
		$('#term-button-add').click(function(){
			$(this).hide();
			$("#term_div").show();
		}); 
		
		$('#term-button-cancel').click(function(){
			$('#term-button-add').show();
			$("#term_div").hide();		
		});
		
		$('#freebies-button-add').click(function(){
			$(this).hide();
			$("#freebies_div").show();
		}); 
		
		$('#freebies-button-cancel').click(function(){
			$('#freebies-button-add').show();
			$("#freebies_div").hide();		
		});
		
		$('#otherpayment-button-add').click(function(){
			$(this).hide();
			$("#otherpayment_div").show();
		}); 
		
		$('#otherpayment-button-cancel').click(function(){
			$('#otherpayment-button-add').show();
			$("#otherpayment_div").hide();		
		});
		
		$("#btn_show_more").click(function(){
			$('.tr_hide_show').show();
			$(this).hide();
		});
		
		$("#btn_show_less").click(function(){
			$(".tr_hide_show").hide();
			$("#btn_show_more").show();
			
		}); 

		$(".modal").draggable({
			handle: ".modal-header"
		});		
	
		var formdata = false;
		if (window.FormData) {
			formdata = new FormData();
			document.getElementById("btn").style.display = "none";
		}
	
		function showUploadedItem (source) { 
				$("#profile-image").src = source; 
				console.log(source);	
		}  	
		$("#upload_images").change(function(files){ 
			
			var i = 0, len = this.files.length, img, reader, file;
			
			for ( ; i < len; i++ ) {
				file = this.files[i];
		
				if (!!file.type.match(/image.*/)) {
					if ( window.FileReader ) {
						reader = new FileReader();
						reader.onloadend = function (e) { 
							//showUploadedItem(e.target.result, file.fileName);
						};
						reader.readAsDataURL(file);
					}
					if (formdata) {
						formdata.append("files[]", file);
						formdata.append("payref", $("#profile-image").attr('data'));
						formdata.append("id", document.form_details.token.value);
					}
				}	
			}
			  
			if (formdata) {
				$.ajax({
					url: "membership/do_upload",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					dataType: 'json',
					success: function (res) {
						//document.getElementById("response").innerHTML = res; 
						if(res.status){	
							$("#profile-image").attr('src', '');
							$("#profile-image").attr('src', res.filename);
						}else{ 
							alert(res.msg);
						}
					}
				});
			} 
		});			
	});
</script>

<!-- Modal -->
<div class="modal-dialog" style="width: 900px" id="myModal">
	<div class="modal-content">  
			<div class="modal-header" style="padding: 4px; background-color:#428BCA; color: #fff">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
			  <h4 class="modal-title"><?php echo $title; ?></h4>
			</div>
			<div class="modal-body" style="padding-top:4px">
			
			<?php 
				$status = '<strong style="color:green;font-weight:bold">ACTIVE</strong>';
				if( $row->pay_status == 0){ 
					$status = '<strong style="color:red;font-weight:bold">INACTIVE</strong>'; 
				}else{
					if( $row->term_type == TERM_EXPIRED ){ $status = '<strong style="color:red;font-weight:bold">EXPIRED</strong>';   }
					elseif( $row->term_type == TERM_SUSPENSION ){ $status = '<strong style="color:red;font-weight:bold">SUSPENDED</strong>';  }
					elseif( $row->term_type == TERM_TERMINATION ){ $status = '<strong style="color:red;font-weight:bold">TERMINATED</strong>';  } 
					elseif( $row->term_type == TERM_DELETED ){ $status = '<strong style="color:red;font-weight:bold">DELETED</strong>';  } 
					else{}
				}
			
				$active_date = $row->active_date;
				$due_date = $row->due_date;
				$exp_date = $row->exp_date;

				if($active_date=="0000-00-00"){
					$active_date="0000-00-00";
				}else{
					$active_date= $active_date;
				}
				
				if($exp_date=="0000-00-00"){
					$exp_date="0000-00-00";
				}else{
					$exp_date = $exp_date;
				}
				
				if($due_date=="0000-00-00"){
					$due_date="0000-00-00";
				}else{
					
					$due_date = $due_date;
				}

			?>			
			
				<div>
					<div class="col-lg-2" style="padding-left:0px">
						<img id="profile-image" class="img-thumbnail" data="<?php echo $row->pay_ref ?>" src="<?php echo ($row->photo != '')?PROFILE_IMAGE_PATH.'/'.$row->photo:'assets/img/profile-image.png'; ?>" height="100" width="100" alt="Generic placeholder image">
					</div>
					<div class="col-lg-3" style="">
						<h4><span id="label-top-fname"><?php echo $row->ai_fname.' '.$row->ai_lname; ?></span></h4>
						<h4><?php echo $row->pay_ref?></h4>
					</div>	
					<div class="col-lg-5" style="margin-right: -30px;"> 
						<label class="col-lg-6" style="font-size: 14px;">Signup:</label> <?php echo date('d/m/Y',strtotime($row->create_date)); ?> 
						<br style="clear:both" />
						<label class="col-lg-6" style="font-size: 14px">Payment Pref:</label><?php echo ($row->full_payment==0)?'Monthly Payment':'Full Payment'?> 
						<br style="clear:both" />
						<label class="col-lg-6" style="font-size: 14px">Payment Mode:</label>
						<?php 
							if( $row->payment_mode==0 ) echo 'Credit Card';
							elseif($row->payment_mode==1) echo '<span title="Direct Debit Standing order organised through your bank">Direct Debit</span>';
							else echo '<span title="Cash Payment at the Club for the entire membership amount">Cash Payment</span>'	;
						?>
						<br style="clear:both" />
					</div>	
					<div class="col-lg-2" style="">
						<?php 
							if( $row->term_type == TERM_ROLLING_MONTLY ){ echo '<p style="color:blue">Rolling Monthly</p>'; }
							if( $row->term_type == TERM_EXTEND_6 ){ echo '<p style="color:blue">Extend 6 months</p>'; }
							if( $row->term_type == TERM_EXTEND_12 ){ echo '<p style="color:blue">Extend 12 months</p>'; }
						?>
						
						<h3 style="padding-top: 0px; margin-top: 0px;"><?php echo $status; ?></h3>
					</div>
				</div>
				<br style="clear:both" />
				
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="myTab">
				  <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
				  <li><a href="#terms" data-toggle="tab">Terms</a></li>
				  <li><a href="#freebies" data-toggle="tab">Freebies/Misc</a></li>
				  <li><a href="#otherpayment" data-toggle="tab">Manual/Cash Payment</a></li>
				  <li><a href="#invoice" data-toggle="tab">Invoice</a></li>
				  <li><a href="#email" data-toggle="tab">Email</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="details"> 
						<form role="form" method="post" enctype="multipart/form-data"  action="membership/do_upload">
							<input type="file" name="file" style="width:78px" id="upload_images"/>
							<button type="submit" id="btn">Upload Photo!</button>
						</form>						
						<form  role="form" name="form_details" method="post" onsubmit="return membershiptransaction.updateInfo(this);" >
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<div class="col-lg-9">
							
								<div>
								<?php 
									if( isset($alerts) ){
										foreach($alerts as $alert){
											echo $alert; 
										}
									}	
								?>
								</div>
								
								<table class="table"> 
									<tr>
										<td><strong>NRIC/FIN no.</strong></td>
										<td><input type="text" name="ai_nric" value="<?php echo $row->ai_nric; ?>" class="col-lg-8" /></td>
									</tr>		
									<tr>
										<td style="width: 165px"><strong>Name</strong></td>
										<td>
											<input type="text" name="firstname" value="<?php echo $row->ai_fname; ?>" placeholder="Firstname" class="col-lg-4"/> 
											<input type="text" name="lastname" value="<?php echo $row->ai_lname; ?>" placeholder="Lastname" class="col-lg-4"/>
										</td>
									</tr>	
									<tr>
										<td><strong>Email</strong></td>
										<td><input type="text" name="email" value="<?php echo $row->ai_email; ?>" class="col-lg-8" /></td>
									</tr>									
									<tr>
										<td><strong>Amount</strong></td>
										<td>SGD <?php echo $row->pay_amt.' '.(($row->ct_promo_name != '')?'<span class="label label-success">'.$row->ct_promo_name.'</span':''); ?></td>
									</tr>									
									<tr>
										<td><strong>Membership</strong></td>
										<td><?php echo $row->mem_name; ?></td>
									</tr> 									
									<tr>
										<td><strong>Due Date</strong></td>
										<?php $suffix = '';
											$active_day = (int)date('d',strtotime($active_date));
											if($active_day == 1) $active_day = $active_day.'st';
											elseif($active_day == 2 OR $active_day == 22) $active_day = $active_day.'nd';
											else $active_day = $active_day.'th';
										?>
										<td>Every <?php echo $active_day; ?> of the month</td>
									</tr>									
									<tr>
										<td><strong>Expiry Date</strong></td>
										<td><?php echo date('d/m/Y',strtotime($exp_date)); ?></td>
									</tr>									
									<tr>
										<td><strong>Addr:(Unit#/St./Bldg.)</strong></td>
										<td>
											<input type="text" name="unit" value="<?php echo $row->unit; ?>" placeholder="Unit/Blk #" class="col-lg-3"/> 
											<input type="text" name="street1" value="<?php echo $row->street1; ?>" placeholder="Street" class="col-lg-4"/>
											<input type="text" name="street2" value="<?php echo $row->street2; ?>" placeholder="Building" class="col-lg-4"/>
										</td>
									</tr> 								
									<tr>
										<td><strong>Country</strong></td>
										<td>
											<?php echo form_dropdown('country', $countries, $row->country); ?>
										</td>
									</tr>										
									<tr>
										<td><strong>Postal Code</strong></td>
										<td><input type="text" name="postalcode" value="<?php echo $row->postalcode; ?>" class="col-lg-4"/></td>
									</tr>										
									<tr>
										<td><strong>Phone</strong></td>
										<td>
											<input type="text" name="phone" value="<?php echo $row->ai_hp; ?>" class="col-lg-4"/>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btn_show_more" class="btn btn-default btn-xs">show more</button>
										</td>
									</tr>	 
									
									<tr  class="tr_hide_show" style="display:none"> 
										<td colspan="2" style="background-color:#ccc"><strong>Emergency contact's address</strong></td>
									</tr>	 
									<tr class="tr_hide_show" style="display:none">
										<td><strong>Addr(Unit#/St/Blg):</strong></td>
										<td>
											<input type="text" name="emg_unit" value="<?php echo $row->emg_unit; ?>" class="col-lg-3" placeholder="Unit/Blk #"/>
											<input type="text" name="emg_street1" value="<?php echo $row->emg_street1; ?>" class="col-lg-4" placeholder="Street 1"/>
											<input type="text" name="emg_street2" value="<?php echo $row->emg_street2; ?>" class="col-lg-4" placeholder="Building"/>
										</td>
									</tr> 
									<tr class="tr_hide_show" style="display:none">
										<td><strong>Country:</strong></td>
										<td>
											<?php echo form_dropdown('emg_country', $countries, $row->emg_country); ?>
										</td>
									</tr> 
									<tr class="tr_hide_show" style="display:none">
										<td><strong>Postal:</strong></td>
										<td>
											<input type="text" name="emg_postalcode" value="<?php echo $row->emg_postalcode; ?>" class="col-lg-4"/> 
										</td>
									</tr>

									<tr  class="tr_hide_show" style="display:none">
										<td colspan="2" style="background-color:#ccc"><strong>Medical History</strong></td>
									</tr>  
									<tr class="tr_hide_show" style="display:none">
										<td><strong>Relevant medical details or current condition:</strong></td>
										<td>
											<textarea name="mh_curr_condi" class="col-lg-10" rows="2"><?php echo $row->mh_curr_condi; ?></textarea>
										</td>
									</tr>
									<tr class="tr_hide_show" style="display:none">
										<td><strong>Medication Taken:</strong></td>
										<td>
											<textarea name="mh_medicine" class="col-lg-10" rows="2"><?php echo $row->mh_medicine; ?></textarea>
											<br style="clear:both"/>
											<button type="button" id="btn_show_less" class="btn btn-default btn-xs">show less</button>
										</td>
									</tr>
									
									<tr>
										<td></td>
										<td><button type="submit" class="btn btn-primary">Save</button></td>
									</tr>									
									
								</table> 
							</div>
							<div class="col-lg-3" > 
								<h4>Payment History</h4>
								<div style="height:300px; overflow:auto">
								<?php 
									foreach($schedulepayements_results as $s){ 
										$type1 = ($s->transaction_type)?'[M]':'';
										if($s->status == 'Accepted') echo  '<span class="label label-success">'.date('d/m/Y',strtotime($s->Tran_Date)).' '.$s->status.' '.$type1.'</span><br/>';
										else if($s->status == 'Rejected') echo '<span class="label label-warning">'.date('d/m/Y',strtotime($s->Tran_Date)).' '.$s->status.'</span><br/>';
										else if($s->status == 'Suspend') echo '<span class="label label-default">'.date('d/m/Y',strtotime($s->Tran_Date)).' '.$s->status.'</span><br/>';
										else{}
									}
								?>
								</div>
							</div>
							<br style="clear:both" />
						</form>
						 
					</div>
				   
					<div class="tab-pane" id="terms">
						<form  role="form" name="form_terms" method="post" onsubmit="return membershiptransaction.saveterms(this);" class="form-horizontal">
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="token1" value="<?php echo $row->tran_id; ?>" />
							<input type="hidden" name="expire_date" value="<?php echo $exp_date; ?>" />
							<br />	
							<button type="button" class="btn btn-primary btn-xs" id="term-button-add">New</button>
							<div id="term_div" style="display:none; padding: 15px;"> 
							
								<div class="form-group">
									<label for="terms" class="col-sm-2 control-label">Term</label>
									<div class="col-sm-10">
									 
										<select name="terms" class="input-sm"> 
											<?php 
												//$active_collection_term = array(TERM_ACTIVE, TERM_ROLLING_MONTLY, TERM_EXTEND_6, TERM_EXTEND_12 ); //collection of active term indicator
												
												if( !in_array($row->term_type, $this->terms_active) ){
													$option = '<option value="'.TERM_ACTIVE.'"> Activate / Reactivate </option>';
												}else{
													$option = '<option value="'.TERM_ROLLING_MONTLY.'">Rolling Montly </option>';
													if( $membership_type_month == 6 ){ $option .= '<option value="'.TERM_EXTEND_6.'">Extend 6 Months</option>'; }
													if( $membership_type_month == 12 ){ $option .= '<option value="'.TERM_EXTEND_12.'">Extend 12 Months</option>'; }
													$option .= '<option value="'.TERM_EXPIRED.'">Expired</option>'; 
													$option .= '<option value="'.TERM_SUSPENSION.'">Suspension</option>'; 
													$option .= '<option value="'.TERM_TERMINATION.'">Termination</option>'; 
													$option .= '<option value="'.TERM_DELETED.'">Delete</option>'; 
												}
												echo $option;
											?> 
										</select> 
									</div>
								</div>				
							
								<div class="form-group">
									<label for="reason" class="col-sm-2 control-label">Reason</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" maxlength="200"> 
									</div>
								</div>	 
								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10"> 
										<button type="submit" class="btn btn-primary btn-sm">Submit</button>
										<button type="button" class="btn btn-warning btn-sm" id="term-button-cancel">Cancel</button>
									</div>
								</div>							
							 
							</div>
							<div>
								<table class="table">
									<tr>
										<td><strong>Date/Time</strong></td>
										<td><strong>Description</strong></td>
										<td><strong>Reason</strong></td>
										<td><strong>Action By</strong></td>
									</tr>
									<?php foreach( $terms_results as $term ): ?>
									<tr>
										<td><?php echo $term->date_created; ?></td>
										<td><?php echo $this->terms_desc[$term->term_type]; ?></td>
										<td><?php echo $term->term_reason; ?></td>
										<td><?php echo $term->added_by; ?></td>
									</tr>
									<?php endforeach; ?>
								</table>
							</div>
						</form>	
					
					</div>
					
					<div class="tab-pane" id="freebies">
					
						<form  role="form" name="form_freebies" method="post" onsubmit="return membershiptransaction.savefreebies(this);" class="form-horizontal">
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="token1" value="<?php echo $row->tran_id; ?>" />
							<br />
							<button type="button" class="btn btn-primary btn-xs" id="freebies-button-add">New</button>
							<div id="freebies_div" style="display:none; padding: 15px;">
								  
								<div class="form-group">
									<label for="reson" class="col-sm-2 control-label">Description</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="freebiesdesc" name="freebiesdesc" placeholder="" maxlength="200"> 
									</div>
								</div>	
								 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10"> 
										<button type="submit" class="btn btn-primary btn-sm">Submit</button>
										<button type="button" class="btn btn-warning btn-sm" id="freebies-button-cancel">Cancel</button>
									</div>
								</div>									
								
							</div>
							
							<div>
								<table class="table" id="freebies_table">
									<thead>	
										<tr>
											<td><strong>Date/Time</strong></td>
											<td><strong>Description</strong></td>
											<td><strong>Action By</strong></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td></td>
											<td></td> 
										</tr>									
										<?php foreach( $freebies_results as $freebies ): ?>
										<tr>
											<td><?php echo $freebies->date_created; ?></td>
											<td><?php echo $freebies->f_desc; ?></td>
											<td><?php echo $freebies->added_by; ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</form>						
					
					</div> 
					
					<div class="tab-pane" id="otherpayment">
						<!--<p style="color:red">The purpose of this tab is to update the failed transaction on schedule payment.</p>
						<p style="color:red">Need to verify with willi how does the cash payment works</p>-->
						<form  role="form" name="form_otherpayment" method="post" onsubmit="return membershiptransaction.saveotherpayment(this);" class="form-horizontal">
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="token1" value="<?php echo $row->tran_id; ?>" />
							<input type="hidden" name="pay_ref" value="<?php echo $row->pay_ref; ?>" /> 
							<br />
							<button type="button" class="btn btn-primary btn-xs" id="otherpayment-button-add">Add Payment</button>
							<div id="otherpayment_div" style="display:none; padding: 15px;">
								<div class="form-group">
									<label for="reson" class="col-sm-3 control-label">Amount: (SGD)</label>
									<div class="col-lg-3">
										<input type="text" class="form-control" id="other_amount" name="other_amount" value="<?php echo $row->pay_amt; ?>" readonly> 
									</div>
								</div>	
								<div class="form-group">
									<label for="reson" class="col-sm-3 control-label">Due date(d/m/y)</label>
									<div class="col-lg-3">
										<input type="text" class="form-control" id="other_duedate" name="other_duedate" value="<?php echo date('d',strtotime($active_date)).date('/m/Y'); ?>"> 
									</div>
								</div>	
								<div class="form-group">
									<label for="reson" class="col-sm-3 control-label">Mode of Payment</label>
									<div class="col-lg-3">
									<select class="form-control input-sm" name="other_payment_type">
										<option value="<?php echo PAYMENT_TYPE_CASH; ?>">Cash</option>
										<option value="<?php echo PAYMENT_TYPE_MAILORDER; ?>">Mail Order</option>
										<option value="<?php echo PAYMENT_TYPE_NETS; ?>">Nets</option>
										<option value="<?php echo PAYMENT_TYPE_VISA; ?>">Visa</option>
										<option value="<?php echo PAYMENT_TYPE_MASTERCARD; ?>">Mastercard</option>
										<option value="<?php echo PAYMENT_TYPE_CHEQUE; ?>">Cheque</option>
									</select>
									</div>
								</div>	
								<div class="form-group">
									<label for="reson" class="col-sm-3 control-label">Description/Reason</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" id="other_desc" name="other_desc" maxlength="200" > 
									</div>
								</div>	 
								 
								<div class="form-group">
									<label for="reson" class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-lg-6">
										<button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
										<button type="button" class="btn btn-warning btn-sm" id="otherpayment-button-cancel">Cancel</button>
									</div>
								</div>			
							</div>
							
							<div>
								<table class="table" id="otherpayment_table">
									<thead>	
										<tr>
											<td><strong>Date/Time</strong></td>
											<td><strong>Due date</strong></td>
											<td><strong>Amount</strong></td>
											<td><strong>Desc/Reason</strong></td>
											<td><strong>Action By</strong></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									<?php foreach( $schedulepayements_results as $otherpay ):
											if( $otherpay->transaction_type == 1  ):
										?>
										<tr>
											<td><?php echo $otherpay->date_created; ?></td>
											<td><?php echo date('d/m/Y',strtotime($otherpay->Tran_Date)); ?></td>
											<td><?php echo $otherpay->Amount; ?></td>
											<td><?php echo $otherpay->reason; ?></td>
											<td><?php echo $otherpay->uploaded_by; ?></td>
										</tr>
									<?php endif;
										endforeach; 
									?>
									</tbody>
								</table>
							</div>								
						</form>
					</div>
					
					<div class="tab-pane" id="invoice">
						<br /><br />
						<button type="button" class="btn btn-warning btn-sm" onclick="generatereports.pdfinvoicemember('<?php echo $row->pay_ref?>')">Generete PDF Invoice</button>			
						<br />
						<br />
					</div>
					
					<div class="tab-pane" id="email">
						SEND EMAIL TO MEMBER<br/>
						SEND EMAIL TO ADMIN<br/>
						SEND EMAIL <br/>
						SEND EMAIL<br/>
						
						<div>
							<table class="table">
								<tr>
									<td><strong>Date/Time</strong></td>
									<td><strong>Description</strong></td>
									<td><strong>Action By</strong></td>
								</tr>
								<tr>
									<td>2010-02-24 05:12:19</td>
									<td>EMAIL SENT TO MEMBER</td>
									<td>Milo</td>
								</tr>
								<tr>
									<td>2010-02-24 05:12:19</td>
									<td>EMAIL SENT TO MEMBER</td>
									<td>Milo</td>
								</tr>
								<tr>
									<td>2010-02-24 05:12:19</td>
									<td>EMAIL SENT TO MEMBER</td>
									<td>Milo</td>
								</tr>
							</table>
						</div>						
					</div>
					
					
				</div>
			<?php //else: ?>
				<!--<div class="jumbotron" style="text-align:center">
					<h2>Not a valid member!</h1>
				</div>-->
			<?php //endif; ?>  
			</div>
			<!--<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save</button>
			</div>-->
		 
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 