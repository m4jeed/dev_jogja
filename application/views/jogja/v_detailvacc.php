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

	<div class="box-header">
	<a href="<?php echo base_url('jogja/verified_masterusers') ?>" class="btn btn-warning">Back to List
	</a>  
  	</div>

	<div class="box-body">
	    <table id="example1" class="table table-bordered table-striped">
	      <thead>
		    <tr>
		      <th width="2%">No</th>
	          <th>Fullname</th>
	          <th>Vacc Number</th>
	          <th>Trx Type</th>
	          <th>Trx Date</th>
	          <th>Trx Desc</th>
	          <th>Amount</th>
	          <th>Balance</th>
		    </tr>
	      </thead>
	      <tbody>
		      <tr>
			        <?php 
			        $no=1;
			        	foreach ($data_vacc as $data) {
			        ?> 
			        <td><center><?php echo $no++ ?></center></td>
			        <td><?php echo $data['fullname'] ?></td>
			        <td><?php echo $data['vacc_number'] ?></td>
			        <td><?php echo $data['trx_type'] ?></td>
			        <td><?php echo $data['trx_date'] ?></td>
			        <td><?php echo $data['trx_desc'] ?></td>
			        <td><?php echo $data['amount'] ?></td>
			        <td><?php echo $data['balance'] ?></td>
		      </tr>
		      <?php } ?>
		  </tbody>
			</table>
	</div>
</div>

<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>