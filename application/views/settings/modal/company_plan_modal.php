<!-- Modal -->

<div class="modal-dialog">
	<div class="modal-content">
		<form class="form-horizontal" role="form" name="form1" method="post" onsubmit="return companyplan.save(this);">
			<input type="hidden" name="type" value="<?php echo $type; ?>" />
			<input type="hidden" name="ref" value="<?php echo @$this->common_model->enccrypData($row->mem_type_id); ?>" />
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title"><?php echo $title; ?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="inputTitle" class="col-lg-3 control-label">Title</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo @$row->title; ?>" placeholder="Title">
					</div>
				</div>
				<div class="form-group">
					<label for="inputMonth" class="col-lg-3 control-label">Company</label>
					<div class="col-lg-4">
						<select name="selectCompany" class="form-control">
						<?php 
							$companies = $this->common_model->getCompanyList();
							foreach( $companies as $company): ?>
							<option value="<?php echo $company->company_id ?>" <?php echo @($row->company_name == $company->company_id)?'selected':'';  ?>><?php echo $company->company_name; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputMonth" class="col-lg-3 control-label">Month</label>
					<div class="col-lg-2">
						<input type="month" class="form-control" name="inputMonth" id="inputMonth" value="<?php echo @$row->month; ?>" placeholder="Month">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Price/Month (S$)</label>
					<div class="col-lg-4">
						<input type="number" class="form-control" name="inputPrice" id="inputPrice" value="<?php echo @$row->price; ?>" placeholder="Price/Month">
					</div>
				</div> 
				
				<div style="margin-left: 120px">
					<label>Select Membership Payment Preference</label> <br /> 
					
					<?php

					
					
					$payment_mode=array();
					$cfull_payment=array();
					$dfull_payment=array(); 
					
					if(@$row->payment_mode!=""){
						$payment_mode = explode(",", @$row->payment_mode);
					}
					
					if(@$row->cfull_payment!=""){
						$cfull_payment = explode(",", @$row->cfull_payment);
					} 
					
					if(@$row->dfull_payment!=""){
						$dfull_payment = explode(",", @$row->dfull_payment);
					} 

					?>					 
					<label><input type="checkbox" name="payment_mode[]" value="0"  <?php if(in_array(0, $payment_mode)){ ?> checked <?php } ?> > Credit Card Payment</label> <br /> 
					<label style="padding-left: 20px"><input  name="cfull_payment[]" value="0" type="checkbox" <?php if(in_array(1, $cfull_payment)){ ?> checked <?php } ?>> Monthly Payment</label>
					<label style="padding-left: 20px"><input  name="cfull_payment[]" value="1"  type="checkbox" <?php if(in_array(2, $cfull_payment)){ ?> checked <?php } ?>> Full Payment</label>	
					
					 
					<label><input type="checkbox" name="payment_mode[]" value="1"  <?php if(in_array(1, $payment_mode)){ ?> checked <?php } ?>> Direct Debit Standing order organised through your bank </label>  <br /> 
					<label style="padding-left: 20px"><input  name="dfull_payment[]" value="0" type="checkbox" <?php if(in_array(0, $dfull_payment)){ ?> checked <?php } ?>> Monthly Payment</label>
					<label style="padding-left: 20px"><input  name="dfull_payment[]" value="1"  type="checkbox" <?php if(in_array(1, $dfull_payment)){ ?> checked <?php } ?>> Full Payment</label>	
					
					<label><input type="checkbox" name="payment_mode[]" value="2"  <?php if(in_array(2, $payment_mode)){ ?> checked <?php } ?>> Cash in full (pay the entire amount at the club)</label>  <br /> 
				</div>					
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 