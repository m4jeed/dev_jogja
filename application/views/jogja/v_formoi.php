<div class="box box-warning">
	<div class="box-header with-border">
	    <h3 class="box-title"><?php echo $box_title;?></h3>
	    <div class="box-tools pull-right">
	      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
	              title="Collapse">
	        <i class="fa fa-minus"></i></button>
	      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
	        <i class="fa fa-times"></i></button>
	    </div>
	</div>
	 		
	<form method="post" action="<?php echo base_url('oi/oigroup/save') ?>">
		<div class="box-body">
			<!-- <input type="hidden" name="ids" id="ids" class="form-control"> -->
		<div class="col-md-6">
			<div class="form-group">
              <label>Group Name</label>
              <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Group Name" autocomplete="off">
              <span style="color: red"><?php echo form_error('group_name'); ?></span> 
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
              <label>Address</label>
              <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
              <span style="color: red"><?php echo form_error('address'); ?></span> 
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Phone</label>
              <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone">
              <span style="color: red"><?php echo form_error('phone'); ?></span> 
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>City</label>
	            <select id="city" name="city" class="form-control select2" style="width:100%;">
	              <?php 
	              // var_dump($kota);
                foreach($kota as $row){ 
                  echo '<option value=""></option>';
                  echo '<option value="'.$row['city'].'" selected>'.$row['city'].
                  '</option>';
                }
          		?>
        		</select>
        		<span style="color: red"><?php echo form_error('city'); ?></span> 
            </div>
        </div>
        
		</div><!-- </div> -->
		<div class="modal-footer">
	       <button type="submit" value="upload" class="btn btn-primary">Submit</button>
	       <a href="<?php echo base_url('oi/oigroup') ?>" class="btn btn-default">Back</a>       
	    </div>
	</form>
</div>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>