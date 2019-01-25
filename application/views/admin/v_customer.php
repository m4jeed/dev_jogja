<!-- Default box -->
      <div class="box">
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
        <div class="box-body">
         <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="align-right">Fullname</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>VA Number</th>
                  <th>Balance</th>
                  <th>Poin</th>
                  <th>Email Confirmed</th>
                  <th>Phone Confirmed</th>
                  <th class="no-sort"></th>
                  </tr>
                </thead>
               </table>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->
	  
	  

	  <script>
  $(function () {
    $('#example2').DataTable({
		'processing': true,
		'serverSide': true,
		"columnDefs": [ {
						"targets"  : 'no-sort',
						"orderable": false,
						},
						 {"className": "align-right", "targets": [5, 6]}
					],
		ajax: {
			url: "<?php echo base_url('admin/customer/ajax_list') ?>",
			type:'POST',
		}
    })
  })
</script>