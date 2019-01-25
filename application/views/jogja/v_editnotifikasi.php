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
   		<!-- <span style="color: red"><?php //echo validation_errors(); ?></span> -->
		<form method="post" action="<?php echo base_url('oi/notifikasi/update/').$ambil_id['data']['ids'] ?>">
			<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
	              <label>Group Name</label>
	              <input type="hidden" name="ids" id="ids" value="<?php echo $ambil_id['data']['ids'] ?>" class="form-control">
	              <input type="text" name="notifikasi" id="notifikasi" value="<?php echo $ambil_id['data']['notifikasi'] ?>" class="form-control" placeholder="Notifikasi" autocomplete="off">
	              <span style="color: red"><?php echo form_error('notifikasi'); ?></span><!--  -->
	            </div>
	        </div>
	         <div class="col-md-6">
	            <div class="form-group">
	              <label>Group Id</label>
		            <select id="userid" name="userid" class="form-control select2" style="width:100%;">
		              <?php 
		              echo '<option value="'.$ambil_id['data']['group_id'].'">'.$ambil_id['data']['group_name'].'</option>';
                    foreach($notif as $row){ 
                     	echo '<option value="'.$row['group_id'].'">'.$row['group_name'].
                      '</option>';
                      }
              		?>
            		</select>
	            </div>
	        </div> <!---->
	        
			</div>
			<div class="modal-footer">
		       <button type="submit" value="upload" class="btn btn-primary">Submit</button>
		       <a href="<?php echo base_url('oi/notifikasi') ?>" class="btn btn-default">Back</a>
		    </div>
		</form>
</div>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>