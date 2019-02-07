<div class="box box-warning">
  <div class="box-header with-border">
      <h3 class="box-title"><?php echo $box_title;?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
  </div>
  
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
          <th>Trx Type</th>
	        <th>Trx Date</th>
          <th>Trx Desc</th>
          <th>Amount</th>
          <th>Balance</th>
          <th>Vacc Number</th>
          <th>Vacc From</th>
          <th>Vacc To</th>
          <th>Phone</th>
          <th>Referral</th>
	      </tr>
      </thead>
		</table>
	</div>
</div>

<script>
    $(function () {
    $('#example2').DataTable({
      'processing': true,
      'serverSide': true,
      "columnDefs": [ {
              "targets"  : 'no-sort',
              "orderable": false,
              },
              
            ],
      ajax: {
        url: "<?php echo base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/ajax_list') ?>",
        type:'POST',
      }
    })
    })
</script>