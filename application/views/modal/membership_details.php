<script>
	$(document).ready( function () {
		//$('#myTab a:first').tab('show')	;
		
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
		
		$("#btn_show_more").click(function(){
			$('.tr_hide_show').show();
			$(this).hide();
		});
		
		$("#btn_show_less").click(function(){
			$(".tr_hide_show").hide();
			$("#btn_show_more").show();
			
		});
	});
</script>

<!-- Modal -->
<div class="modal-dialog" style="width: 900px">
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
						<img class="img-thumbnail" src="assets/img/profile-image.png" height="100" width="100" alt="Generic placeholder image">
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
							if( $row->term_type == TERM_ROLLING_MONTLY ){ echo '<p>Rolling Monthly</p>'; }
							if( $row->term_type == TERM_EXTEND_6 ){ echo '<p>Extend 6 months</p>'; }
							if( $row->term_type == TERM_EXTEND_12 ){ echo '<p>Extend 12 months</p>'; }
						?>
						
						<h2 style="padding-top: 0px; margin-top: 0px;"><?php echo $status; ?></h2>
					</div>
				</div>
				<br style="clear:both" />
				
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="myTab">
				  <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
				  <li><a href="#terms" data-toggle="tab">Terms</a></li>
				  <li><a href="#freebies" data-toggle="tab">Freebies/Misc</a></li>
				  <li><a href="#others" data-toggle="tab">Others</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<form  role="form" name="form_details" method="post" onsubmit="return membershiptransaction.updateInfo(this);">
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<div class="col-lg-9">
								<table class="table">
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
										<td><strong>Next Billing</strong></td>
										<td><?php echo date('d/m/Y',strtotime($due_date)); ?></td>
									</tr>									
									<tr>
										<td><strong>Expiry Date</strong></td>
										<td><?php echo date('d/m/Y',strtotime($exp_date)); ?></td>
									</tr>									
									<tr>
										<td><strong>Addr:(Unit/Blk #, Street)</strong></td>
										<td>
											<input type="text" name="unit" value="<?php echo $row->unit; ?>" placeholder="Unit/Blk #" class="col-lg-4"/> 
											<input type="text" name="street1" value="<?php echo $row->street1; ?>" placeholder="Street" class="col-lg-6"/>
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
										<td colspan="2"><strong>Emergency contact's address</strong></td>
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
										<td colspan="2"><strong>Medical History</strong></td>
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
								<div style="height: 380px; overflow:auto">
								<?php 
									foreach($schedulepayements as $s){ 
										if($s->status == 'Accepted') echo  '<span class="label label-success">'.$s->Tran_date.' '.$s->status.'</span>';
										else if($s->status == 'Rejected') echo '<span class="label label-warning">'.$s->Tran_date.' '.$s->status.'</span>';
										else if($s->status == 'Suspend') echo '<span class="label label-default">'.$s->Tran_date.' '.$s->status.'</span>';
										else{}
									}
								?>
								</div>
							</div>
							<br style="clear:both" />
						</form>
						 
					</div>
				   
					<div class="tab-pane" id="terms">
						<form  role="form" name="form_terms" method="post" onsubmit="">
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="token1" value="<?php echo $row->tran_id; ?>" />
							<br />	
							<button type="button" class="btn btn-primary btn-xs" id="term-button-add">New</button>
							<div id="term_div" style="display:none; padding: 15px;"> 
								<fieldset>
									<legend>New Term</legend>
									<strong>Term Type</strong>
									<select name="terms" class="input-sm">
										<option value="<?php echo TERM_CURRENT; ?>"> Active </option>
										<option value="<?php echo TERM_ROLLING_MONTLY; ?>">Rolling Montly</option>
										<option value="<?php echo TERM_EXPIRED; ?>">Expired</option>
										<option value="<?php echo TERM_SUSPENSION; ?>">Suspension</option>
										<option value="<?php echo TERM_TERMINATION; ?>">Termination</option>
									</select> 
									<button type="submit" class="btn btn-primary btn-sm">Save</button>
									<button type="button" class="btn btn-warning btn-sm" id="term-button-cancel">Cancel</button>
								</fieldset>
							</div>
							<div>
								<table class="table">
									<tr>
										<td><strong>Date/Time</strong></td>
										<td><strong>Term Description</strong></td>
										<td><strong>Action By</strong></td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>Rolling Monthly</td>
										<td>Milo</td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>Suspension</td>
										<td>Milo</td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>Termination</td>
										<td>Milo</td>
									</tr>
								</table>
							</div>
						</form>	
					
					</div>
					
					<div class="tab-pane" id="freebies">
					
						<form  role="form" name="form_freebies" method="post" onsubmit="">
							<input type="hidden" name="mem_id" value="<?php echo $token; ?>" />
							<input type="hidden" name="tran_id" value="<?php echo $row->tran_id; ?>" />
							<br />
							<button type="button" class="btn btn-primary btn-xs" id="freebies-button-add">New</button>
							<div id="freebies_div" style="display:none; padding: 15px;">
								
								<fieldset>
									<legend>New Item</legend>
									<strong>Description: </strong>
									<input type="text" name="freebiesdesc" value="" style="width:250px"/> 
									<button type="submit" class="btn btn-primary btn-sm">Save</button>
									<button type="button" class="btn btn-warning btn-sm" id="freebies-button-cancel">Cancel</button>
								</fieldset>
							</div>
							
							<div>
								<table class="table">
									<tr>
										<td><strong>Date/Time</strong></td>
										<td><strong>Description</strong></td>
										<td><strong>Action By</strong></td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>This is a test description</td>
										<td>Milo</td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>This is a test description</td>
										<td>Milo</td>
									</tr>
									<tr>
										<td>2010-02-24 05:12:19</td>
										<td>This is a test description</td>
										<td>Milo</td>
									</tr>
								</table>
							</div>
						</form>						
					
					</div> 
					
					<div class="tab-pane" id="others">
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
 