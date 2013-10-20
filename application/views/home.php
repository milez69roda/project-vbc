

   
    
      <!-- Example row of columns -->
      <div class="row">
		<?php echo $this->common_model->enccrypData(3);	?><br />
		<?php echo $this->common_model->deccrypData($this->common_model->enccrypData(3));	?>
      </div> 