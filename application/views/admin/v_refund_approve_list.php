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
                  <th data-orderable="false" width="10">No</th>
                  <th data-orderable="false">trx_date</th>
                  <th data-orderable="false">trx_type</th>
                  <th data-orderable="false">trx_desc</th>
                  <th data-orderable="false">amount</th>
                  <th data-orderable="false">dk</th>
                  <th data-orderable="false">balance</th>
                  <th data-orderable="false">vacc_number</th>
                  <th data-orderable="false">request_by</th>
                  <th data-orderable="false">request_on</th>
                  <th data-orderable="false">approve_by</th>
                  <th data-orderable="false">approve_on</th>
                 
               
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
							 {"className": "align-right", "targets": [4, 6]},
							 {"className": "align-center", "targets": [5]}
						],
			ajax: {
				url: "<?php echo base_url('admin/refund_approve/ajax_list') ?>",
				type:'POST',
			}
		})
	  })
	</script>
	
	
	