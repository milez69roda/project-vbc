<!-- Modal -->

<div class="modal-dialog">
	<div class="modal-content">
		<form class="form-horizontal" role="form" name="form1" method="post" onsubmit="return membershipplan.save(this);">
			<input type="hidden" name="type" value="<?php echo $type; ?>" />
			<input type="hidden" name="ref" value="<?php echo @$this->common_model->enccrypData($row->mem_type_id); ?>" />
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title">Edit Membership Plan</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="inputTitle" class="col-lg-3 control-label">Title</label>
					<div class="col-lg-6">
					  <input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo @$row->title; ?>" placeholder="Title">
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

			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 