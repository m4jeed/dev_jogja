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
                  <th>Fullname</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>VA Number</th>
                  <th>Balance</th>
                  <th>Poin</th>
                  <th>Mail Cnfrm</th>
                  <th>Phone Cnfrm</th>
                  <th class="no-sort" >Created On</th>
                  <th class="no-sort"></th>
                  </tr>
                </thead>
               </table>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->
	  
	  <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detil Customer</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						
						<input type="hidden" class="form-control" id="user_id">
						
						<div class="form-group">
							<label>Fullname</label>
							<input readonly type="text" class="form-control" id="fullname">
						</div>
						
						<div class="form-group">
							<label>POB</label>
							<input readonly type="text" class="form-control" id="pob">
						</div>
						
						<div class="form-group">
							<label>DOB</label>
							<input readonly type="text" class="form-control" id="dob">
						</div>
						
						<div class="form-group">
							<label>No.KTP</label>
							<input readonly type="text" class="form-control" id="id_card_number">
						</div>
						
						<div class="form-group">
							<label>Nama Ibu</label>
							<input readonly type="text" class="form-control" id="mom">
						</div>
						
						<div class="form-group">
							<label>Alamat</label>
							<input readonly type="text" class="form-control" id="address">
						</div>
						
						<div class="form-group">
							<label>Provinsi</label>
							<input readonly type="text" class="form-control" id="province">
						</div>
						
						<div class="form-group">
							<label>Kota</label>
							<input readonly type="text" class="form-control" id="city">
						</div>
						
						<div class="form-group">
							<label>Kecamatan</label>
							<input readonly type="text" class="form-control" id="districts">
						</div>
						
						<div class="form-group">
							<label>Kelurahan</label>
							<input readonly type="text" class="form-control" id="village">
						</div>
						
						<div class="form-group">
							<label>KodePos</label>
							<input readonly type="text" class="form-control" id="postalcode">
						</div>
						
						
						<div class="form-group">
							<label>referal_code</label>
							<input readonly type="text" class="form-control" id="referal_code">
						</div>
						
						<div class="form-group">
							<label>my_referal_code</label>
							<input readonly type="text" class="form-control" id="my_referal_code">
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<table>
								<tr>
									<td><b>Foto KTP</b></td>
									<td width="10px"></td>
									<td><b>Foto Selfi</b></td>
								</tr>
								<tr>
									<td><img class="modal-content" id="img01" width="200px"></td>
									<td></td>
									<td><img class="modal-content" id="img02" width="200px"></td>
								</tr>
							</table>
							
							
						</div>
						
						<div class="form-group">
							<label>is_confirmed_hp</label>
							<input readonly type="text" class="form-control" id="is_confirmed_hp">
						</div>
						
						<div class="form-group">
							<label>is_confirmed_email</label>
							<input readonly type="text" class="form-control" id="is_confirmed_email">
						</div>
						
						<div class="form-group">
							<label>is_verified</label>
							<input readonly type="text" class="form-control" id="is_verified">
						</div>
						
						<div class="form-group">
							<label>verified_on</label>
							<input readonly type="text" class="form-control" id="verified_on">
						</div>
						
						<div class="form-group">
							<label>verified_by</label>
							<input readonly type="text" class="form-control" id="verified_on">
						</div>
						
						
						<div class="form-group">
							<label>created_on</label>
							<input readonly type="text" class="form-control" id="created_on">
						</div>
						
						<div class="form-group">
							<label>status_verifikasi</label>
							<?php 
								$options=array(
												'proses'=>'proses',
												'salah'=>'belum',
												'berhasil'=>'berhasil');
								echo form_dropdown('status_verifikasi', $options, '','class="form-control" id="status_verifikasi"');
							
							?>
						</div>
						
						<div class="form-group">
							<label>verifikasi_msg</label>
							<textarea class="form-control" id="verifikasi_msg"></textarea>
						</div>
						
						<a href="javascript:void(0)" class="btn btn-default" onclick="jsonResetPin()">Reset PIN</a>
						<a href="javascript:void(0)" class="btn btn-default" onclick="jsonResetPassword()">Reset Password</a>
						
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<a href="javascript:void(0)" class="btn btn-primary" onclick="jsonUpdateData()">Submit</a>
		  </div>
		</div>

	  </div>
	</div>
	  
	  

	  <script>
	  $(function () {
		$('#example2').DataTable({
			"scrollX": true,
			'processing': true,
			'serverSide': true,
			"columnDefs": [ {
							"targets"  : 'no-sort',
							"orderable": false,
							},
							 {"className": "align-right", "targets": [5, 6]},
							 {"className": "align-center", "targets": [7,8]}
						],
			ajax: {
				url: "<?php echo base_url('admin/customer/ajax_list') ?>",
				type:'POST',
			}
		})
	  })
	</script>
	
	<script>
	function showModalData(user_id){
		jsonGetOneData(user_id)
		
	}
	
	function jsonGetOneData(post_user_id){
		$.ajax({
		url: '<?php echo base_url();?>admin/customer/jsonGetOneData',
		type: 'POST',
		data: {user_id:post_user_id
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
					$('#user_id').val(value.user_id);
					$('#fullname').val(value.fullname);
					$('#email').val(value.email);
					$('#gender').val(value.gender);
					$('#pob').val(value.pob);
					$('#dob').val(value.dob);
					$('#phone').val(value.phone);
					$('#job').val(value.job);
					$('#id_card_number').val(value.id_card_number);
					$('#address').val(value.address);
					$('#mom').val(value.mom);
					$('#is_confirmed_hp').val(value.is_confirmed_hp);
					$('#is_confirmed_email').val(value.is_confirmed_email);
					$('#is_verified').val(value.is_verified);
					$('#verified_on').val(value.verified_on);
					$('#verified_by').val(value.verified_by);
					$('#referal_code').val(value.referal_code);
					$('#my_referal_code').val(value.my_referal_code);
					$('#created_on').val(value.created_on);
					$('#verifikasi_msg').val(value.verifikasi_msg);
					$('#status_verifikasi').val(value.status_verifikasi);
					
					$('#city').val(value.city);
					$('#districts').val(value.districts);
					$('#postalcode').val(value.postalcode);
					$('#province').val(value.province);
					$('#village').val(value.village);
					
					var modalImg1 = document.getElementById("img01");
					modalImg1.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_photo;
					
					var modalImg2 = document.getElementById("img02");
					modalImg2.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_selfi;
					
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	
	
	function jsonUpdateData(post_user_id){
		var is_confirmed_hp=$('#is_confirmed_hp').val();
		var is_confirmed_email=$('#is_confirmed_email').val();
		
		if(is_confirmed_email!='1'){
			alert('EMail belum dikonfirmasi');
			return false
		}
		
		if(is_confirmed_hp!='1'){
			alert('Handphone belum dikonfirmasi');
			return false
		}
		
		$.ajax({
		url: '<?php echo base_url();?>admin/customer/jsonUpdateData',
		type: 'POST',
		data: {user_id:$('#user_id').val(),
				status_verifikasi:$('#status_verifikasi').val(),
				verifikasi_msg:$('#verifikasi_msg').val(),
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
					alert(value);
					$('#myModal').modal('hide');
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	
	function jsonResetPassword(post_user_id){
		
		$.ajax({
		url: '<?php echo base_url();?>admin/customer/jsonResetPassword',
		type: 'POST',
		data: {user_id:$('#user_id').val(),
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
					alert(value);
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	function jsonResetPin(post_user_id){
		
		$.ajax({
		url: '<?php echo base_url();?>admin/customer/jsonResetPin',
		type: 'POST',
		data: {user_id:$('#user_id').val(),
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
					alert(value);
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	
	</script>
	
	
	