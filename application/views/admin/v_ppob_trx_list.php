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
         <table id="example2" class="table table-bordered table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >trx_date</th>
                  <th class="no-sort" >reffnum</th>
                  <th class="no-sort" >trx_desc</th>
                  <th class="no-sort" >trx_status</th>
                  <th class="no-sort" >trx_amount</th>
                  <th class="no-sort" >sale_price</th>
                  <th class="no-sort" >base_price</th>
                  <th class="no-sort" >admin_fee</th>
                  <th class="no-sort" >admin_bank</th>
                  <th class="no-sort" >cashback</th>
                  
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
				<h4 class="modal-title">Detil</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-condensed table-striped">
							<tr>
								<td width="100px">RefNumber</td>
								<td>:</td>
								<td><span id="RefNumber"></span></td>
							</tr>
							<tr>
								<td>TransDate</td>
								<td>:</td>
								<td><span id="TransDate"></span></td>
							</tr>
							<tr>
								<td>ProductCode</td>
								<td>:</td>
								<td><span id="ProductCode"></span></td>
							</tr>
							<tr>
								<td>ProductName</td>
								<td>:</td>
								<td><span id="ProductName"></span></td>
							</tr>
							<tr>
								<td>CustomerNumber1</td>
								<td>:</td>
								<td><span id="CustomerNumber1"></span></td>
							</tr>
							<tr>
								<td>CustomerNumber2</td>
								<td>:</td>
								<td><span id="CustomerNumber2"></span></td>
							</tr>
							<tr>
								<td>CustomerNumber3</td>
								<td>:</td>
								<td><span id="CustomerNumber3"></span></td>
							</tr>
							<tr>
								<td>TransPrice</td>
								<td>:</td>
								<td><span id="TransPrice"></span></td>
							</tr>
							<tr>
								<td>TransAdminCharge</td>
								<td>:</td>
								<td><span id="TransAdminCharge"></span></td>
							</tr>
							<tr>
								<td>TransCashback</td>
								<td>:</td>
								<td><span id="TransCashback"></span></td>
							</tr>
							<tr>
								<td>TransSn</td>
								<td>:</td>
								<td><span id="TransSn"></span></td>
							</tr>
							<tr>
								<td>TransVoucher</td>
								<td>:</td>
								<td><span id="TransVoucher"></span></td>
							</tr>
							<tr>
								<td>TransStatus</td>
								<td>:</td>
								<td><span id="TransStatus"></span></td>
							</tr>
							<tr>
								<td>TransRc</td>
								<td>:</td>
								<td><span id="TransRc"></span></td>
							</tr>
							<tr>
								<td>TransDesc</td>
								<td>:</td>
								<td><span id="TransDesc"></span></td>
							</tr>
							
						</table>
						
						
					</div>
				
				</div>
			</div>
			<div class="modal-footer">
				
					<button type="button" class="btn btn-default" onclick="closeModal()">Close</button>
				
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
							
							 {"className": "align-right", "targets": [5,6,7,8,9,10]}
						],
			 
			ajax: {
				url: "<?php echo base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/ajax_list') ?>",
				type:'POST',
			}
		})
	  })
	</script>
	
	<script>
		function jsonCekReffnum(reffnum){
			$('#myModal').modal('show');
			$.ajax({
				url: '<?php echo base_url();?>admin/ppob_trx/jsonCekReffnum',
				type: 'POST',
				data: {reffnum:reffnum,
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
							var value=json['data'];
							var val2=value.DataTransactions[0]
							console.log(val2);
							$('#RefNumber').html(val2.RefNumber);
							$('#TransDate').html(val2.TransDate);
							$('#ProductCode').html(val2.ProductCode);
							$('#ProductName').html(val2.ProductName);
							$('#CustomerNumber1').html(val2.CustomerNumber1);
							$('#CustomerNumber2').html(val2.CustomerNumber2);
							$('#CustomerNumber3').html(val2.CustomerNumber3);
							$('#TransPrice').html(val2.TransPrice);
							$('#TransAdminCharge').html(val2.TransAdminCharge);
							$('#TransCashback').html(val2.TransCashback);
							$('#TransSn').html(val2.TransSn);
							$('#TransVoucher').html(val2.TransVoucher);
							$('#TransStatus').html(val2.TransStatus);
							$('#TransRc').html(val2.TransRc);
							$('#TransDesc').html(val2.TransDesc);
							//alert(json['data']);
							//$('#myModal').modal('hide');
							//window.location.href="<?php echo site_url(uri_string());?>";
							
						}else{
							alert(json['data']);
						}
						
					},
					error: function() {
						alert("Error occured. Please try again or contact administrator");
						
					}
				});
		}
		
		function closeModal(){
			window.location.href="<?php echo site_url(uri_string());?>";
			$('#myModal').modal('hide');
		}
	</script>
	
	
	