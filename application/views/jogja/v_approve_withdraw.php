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
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
          <th width="5px">Nama Pemilik</th>
          <th width="5px">Nominal Withdraw</th>
          <th width="5px">Saldo Jogjaaccess</th> 
          <th width="5px">No. Rek</th>
          <th width="5px">Nama Bank</th>
          <th width="5px">Request ON</th>
          <th width="5px">Approve By</th>
          <th width="5px">Approve On</th>
          <th width="5px">Status</th>
	      </tr>
      </thead>
		</table>
	</div>
</div>

<script>
    $(document).ready(function () {
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
      
    });
   
    })
</script>