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
	 		
	<form method="post" action="<?php echo base_url('jogja/notifikasi/save') ?>">
		<div class="box-body">
			<!-- <input type="hidden" name="ids" id="ids" class="form-control"> -->
		<div class="col-md-6">
			<div class="form-group">
              <label>Notifikasi</label>
              <input type="text" name="notifikasi" id="notifikasi" class="form-control" placeholder="Notifikasi" autocomplete="off">
              <span style="color: red"><?php echo form_error('notifikasi'); ?></span> 
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Group Id</label>
	            <select id="userid" name="userid" class="form-control select2" style="width:100%;"> 
	              <?php 
	              // var_dump($kota);
                foreach($notif as $row){ 
                  echo '<option value=""></option>';
                  echo '<option value="'.$row['group_id'].'" selected>'.$row['group_name'].
                  '</option>';
                }
          		?>
        		</select>
        		<span style="color: red"><?php echo form_error('userid'); ?></span> 
            </div>
        </div>
        
		</div><!-- </div> -->
		<div class="modal-footer">
	       <button type="submit" value="upload" class="btn btn-primary">Submit</button>
	       <a href="<?php echo base_url('jogja/notifikasi') ?>" class="btn btn-default">Back</a>       
	    </div>
	</form>
</div>
<script type="text/javascript">
	$('.append-row').click(function() {
    $("table box-body").append
    ('<tr><td class="col-md-1 center-block"><input type="text" name="userid[]" value="' + row_id_val++ + '" class="form-control" /></td> <td><input type="text" placeholder="enter descreption" class="form-control" name="notifikasi[]" /></td><td><button class="btn btn-danger center-block  remove-row"><span class="glyphicon glyphicon-remove"></span> Remove</button></td></tr>');
    $('.selectpicker').selectpicker('refresh');
});
</script>


<script>
  $(function () {
    $('.select2').select2()
  })
</script>