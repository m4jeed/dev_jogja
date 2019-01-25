<!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
         	<a href="javascript:void(0)" class="btn btn-success" onclick="showModalAddNew()"><i class="fa fa-plus"></i> Add New</a>
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
	              <th>Username</th>
	              <th>Fullname</th>
	              <th>Lvl</th>
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
						
						<input type="hidden" class="form-control" id="user_id">
						<div id="detil_div">
							<div class="form-group">
								<label>Username</label>
								<input type="text" class="form-control" id="uname">
							</div>
							
							<div class="form-group">
								<label>Fullname</label>
								<input type="text" class="form-control" id="fullname">
							</div>
							
							<div class="form-group">
								<label>Level</label>
								<?php 
									$options=array('STAFF'=>'STAFF',
													'SPV'=>'SPV',
													'ADMIN'=>'ADMIN');
									echo form_dropdown('lvl', $options, '','class="form-control" id="lvl"');
								
								?>
							</div>
						</div>
						
						<div id="password_div">
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" id="pass">
							</div>
							
							<div class="form-group">
								<label>Retype Password</label>
								<input type="password" class="form-control" id="retype_pass">
							</div>
						</div>
						
					</div>
				
				</div>
			</div>
			<div class="modal-footer">
				
				<div id="btn_submit_div">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<a href="javascript:void(0)" class="btn btn-primary" onclick="jsonSaveData()">Submit</a>
				</div>
				<div id="btn_cp_div">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<a href="javascript:void(0)" class="btn btn-primary" onclick="jsonCP()">Change Password</a>
				</div>
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
							
						],
			ajax: {
				url: "<?php echo base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/ajax_list') ?>",
				type:'POST',
			}
		})
	  })
	</script>
	
	<script>
	
	function showModalAddNew(){
		
		$('#user_id').val('');
		$('#fullname').val('');
		$('#uname').val('');
		$('#lvl').val('');
		$('#password_div').show();
		$('#detil_div').show();
		$('#btn_submit_div').show();
		$('#btn_cp_div').hide();
		$("#uname").prop("readonly",false);
		$('#myModal').modal('show');
	}
	
	function jsonSaveData(){
		var user_id=$('#user_id').val();
		if(user_id==''){
			jsonInsertData();
		}else{
			jsonUpdateData();
		}
	}
	
	function jsonInsertData(){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonInsertData',
		type: 'POST',
		data: {uname:$('#uname').val(),
				fullname:$('#fullname').val(),
				lvl:$('#lvl').val(),
				pass:$('#pass').val(),
				retype_pass:$('#retype_pass').val(),
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
					$('#myModal').modal('hide');
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
	
	
	function showModalData(user_id){
		jsonGetOneData(user_id)
		
	}
	
	
	
	function jsonGetOneData(post_user_id){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonGetOneData',
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
					$('#password_div').hide();
					$('#detil_div').show();
					$('#btn_submit_div').show();
					$('#btn_cp_div').hide();
					$("#uname").prop("readonly",true);
					$('#myModal').modal('show');
					
					//console.log(value);
					$('#user_id').val(value.user_id);
					$('#fullname').val(value.fullname);
					$('#uname').val(value.uname);
					$('#lvl').val(value.lvl);
					
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	function jsonUpdateData(){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonUpdateData',
		type: 'POST',
		data: {user_id:$('#user_id').val(),
				fullname:$('#fullname').val(),
				lvl:$('#lvl').val(),
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
					//var value=json['data'];
					$('#myModal').modal('hide');
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
	
	function jsonDeleteData(post_user_id){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonDeleteData',
		type: 'POST',
		data: {user_id:post_user_id,
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
					//var value=json['data'];
					//$('#myModal').modal('hide');
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
	
	function showModalCP(post_user_id){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonGetOneData',
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
					$('#password_div').show();
					$('#detil_div').hide();
					$('#btn_submit_div').hide();
					$('#btn_cp_div').show();
					$("#uname").prop("readonly",true);
					$('#myModal').modal('show');
					
					//console.log(value);
					$('#user_id').val(value.user_id);
					$('#pass').val('');
					$('#retype_pass').val('');
					
				}else{
					alert(json['data']);
				}
				
			},
			error: function() {
				alert("Error occured. Please try again or contact administrator");
				
			}
		});
		
	
	}
	
	function jsonCP(){
		$.ajax({
		url: '<?php echo base_url();?>admin/adm_user/jsonCP',
		type: 'POST',
		data: {user_id:$('#user_id').val(),
				pass:$('#pass').val(),
				retype_pass:$('#retype_pass').val(),
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
					//var value=json['data'];
					$('#myModal').modal('hide');
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
	
	
	
	
	
	</script>
	
	
	