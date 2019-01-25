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
                  <th data-orderable="false">vacc_from</th>
                  <th data-orderable="false">vacc_to</th>
                  <th data-orderable="false"></th>
               
                  </tr>
                </thead>
               </table>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->
	  
	  
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Konfirmasi Refund Trx</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						
						<input type="hidden" class="form-control" id="trx_id">
						<table class="table table-bordered">
							<tr>
								<td><label>trx_date</label></td>
								<td><span id="trx_date"></span></td>
							</tr>
							<tr>
								<td><label>trx_type</label></td>
								<td><span id="trx_type"></span></td>
							</tr>
							<tr>
								<td><label>trx_desc</label></td>
								<td><span id="trx_desc"></span></td>
							</tr>
							<tr>
								<td><label>amount</label></td>
								<td><span id="amount"></span></td>
							</tr>
							<tr>
								<td><label>dk</label></td>
								<td><span id="dk"></span></td>
							</tr>
							<tr>
								<td><label>balance</label></td>
								<td><span id="balance"></span></td>
							</tr>
							<tr>
								<td><label>vacc_number</label></td>
								<td><span id="vacc_number"></span></td>
							</tr>
						</table>
				
					</div>
				</div>
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<a href="javascript:void(0)" class="btn btn-primary" onclick="jsonRefundRequest()">Submit</a>
		  </div>
		</div>

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
							 {"className": "align-right", "targets": [4, 6]},
							 {"className": "align-center", "targets": [5]}
						],
			ajax: {
				url: "<?php echo base_url('admin/ma_trx/ajax_list') ?>",
				type:'POST',
			}
		})
	  })
	</script>
	
	<script>
	function jsonGetOneData(_trx_id){
		$.ajax({
		url: '<?php echo base_url();?>admin/ma_trx/jsonGetOneData',
		type: 'POST',
		data: {trx_id:_trx_id
				},
		dataType: 'json',
			beforeSend: function() {
				$.LoadingOverlay("show");
				
			},
			complete: function() {
				$.LoadingOverlay("hide");
				
			},
			success: function(json) {
				if(json['status']=='sukses'){
					//alert(json['data']);
					var value=json['data'];
					$('#myModal').modal('show');
					
					//console.log(value);
					$('#trx_id').val(value.trx_id);
					$('#trx_date').html(value.trx_date);
					$('#trx_type').html(value.trx_type);
					$('#trx_desc').html(value.trx_desc);
					$('#amount').html(value.amount);
					$('#dk').html(value.dk);
					$('#balance').html(value.balance);
					$('#vacc_number').html(value.vacc_number);
					
					
					
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	function jsonRefundRequest(){
		var r = confirm("Are You Sure??");
		if (r == false) {
			return false;
		}else{
			$.ajax({
			url: '<?php echo base_url();?>admin/ma_trx/jsonRefundRequest',
			type: 'POST',
			data: {trx_id:$('#trx_id').val()
					},
			dataType: 'json',
				beforeSend: function() {
					$.LoadingOverlay("show");
					
				},
				complete: function() {
					$.LoadingOverlay("hide");
					
				},
				success: function(json) {
					if(json['status']=='sukses'){
						alert(json['data']);
						window.location.href="<?php echo site_url(uri_string());?>";
					}else{
						alert(json['data']);
					}
					
				},
				error: function() {
					alert("Error occured. Please try again or contact administrator");
					
				}
			});
		}
	}
	
	
	</script>
	
	
	