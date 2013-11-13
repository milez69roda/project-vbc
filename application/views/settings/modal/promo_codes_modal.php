<!-- Modal -->

<div class="modal-dialog">
	<div class="modal-content">
		<form class="form-horizontal" role="form" name="form1" method="post" onsubmit="return promocodes.save(this);">
			<input type="hidden" name="type" value="<?php echo $type; ?>" /> 
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title"><?php echo $title; ?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="inputTitle" class="col-lg-3 control-label">Total Units</label>
					<div class="col-lg-2">
						<select name="totalunit" class="form-control">	  
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
						</select> 				  
					</div>
				</div>
				
				<div class="form-group">
					<label for="inputMonth" class="col-lg-3 control-label">Type</label>
					<div class="col-lg-4">  
						<select name="operator" class="form-control">
							<option value="percent">Percent</option> 
						</select> 
					</div>
				</div> 
				
				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Amount</label>
					<div class="col-lg-4">
						<input type="number" class="form-control" name="inputAmount" id="inputAmount" value="<?php echo @$row->promo_val; ?>" placeholder="Amount">
					</div>
				</div> 				

				<div class="form-group">
					<label for="inputPrice" class="col-lg-3 control-label">Company</label>
					<div class="col-lg-6">
						<input type="number" class="form-control" name="inputCompany" id="inputCompany" value="<?php echo @$row->company_name; ?>" placeholder="Company Name, etc.">
					</div>
				</div> 
				
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 