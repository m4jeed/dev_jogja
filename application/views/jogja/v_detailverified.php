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

	<div class="box-body">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $ambil['data']['user_id'] ?>" class="form-control">

		<div class="row">
	        <div class="col-md-6">
	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Fullname</label>
			            <input name="fullname" id="fullname" value="<?php echo $ambil['data']['fullname'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>My Code Referal</label>
			            <input name="my_referal_code" id="my_referal_code" value="<?php echo $ambil['data']['my_referal_code'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Referal Code</label>
			            <input name="referal_code" id="referal_code" value="<?php echo $ambil['data']['referal_code'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Poin</label>
			            <input name="poin" id="poin" value="<?php echo $ambil['data']['poin'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Balance</label>
			            <input name="balance" id="balance" value="<?php echo $ambil['data']['balance'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Vacc Number</label>
			            <input name="vacc_number" id="vacc_number" value="<?php echo $ambil['data']['vacc_number'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Gerai Name</label>
			            <input name="gerai_name" id="gerai_name" value="<?php echo $ambil['data']['gerai_name'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>POB</label>
			            <input name="pob" id="pob" value="<?php echo $ambil['data']['pob'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>DOB</label>
			            <input name="dob" id="dob" value="<?php echo $ambil['data']['dob'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>KTP Number</label>
			            <input name="id_card_number" id="id_card_number" value="<?php echo $ambil['data']['id_card_number'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>MOM</label>
			            <input name="mom" id="mom" value="<?php echo $ambil['data']['mom'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Address</label>
			            <input name="address" id="address" value="<?php echo $ambil['data']['address'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Postalcode</label>
			            <input name="postalcode" id="postalcode" value="<?php echo $ambil['data']['postalcode'] ?>" class="form-control" readonly>
		            </div>
	        	</div>
			</div>

			<div class="col-md-6">
	            <div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Province</label>
			            <input name="province" id="province" value="<?php echo $ambil['data']['province'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Kelurahan</label>
			            <input name="village" id="village" value="<?php echo $ambil['data']['village'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Kecamatan</label>
			            <input name="districts" id="districts" value="<?php echo $ambil['data']['districts'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>City</label>
			            <input name="city" id="city" value="<?php echo $ambil['data']['city'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Phone</label>
			            <input name="phone" id="phone" value="<?php echo $ambil['data']['phone'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Is_Confirmed_Hp</label>
			            <input name="is_confirmed_hp" id="is_confirmed_hp" value="<?php echo $ambil['data']['is_confirmed_hp'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Is_Confirmed_Email</label>
			            <input name="is_confirmed_email" id="is_confirmed_email" value="<?php echo $ambil['data']['is_confirmed_email'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Created On</label>
			            <input name="created_on" id="created_on" value="<?php echo $ambil['data']['created_on'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Massage Verifikasi</label>
			            <input name="verifikasi_msg" id="verifikasi_msg" value="<?php echo $ambil['data']['verifikasi_msg'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="form-group">
	        		<div class="col-sm-12">
		        		<label>Status Verifikasi</label>
			            <input name="status_verifikasi" id="status_verifikasi" value="<?php echo $ambil['data']['status_verifikasi'] ?>" class="form-control" readonly>
		            </div>
	        	</div>

	        	<div class="col-md-6">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="col-md-6">
							<label>Foto KTP</label>
							<img src="<?php echo base_url(); ?>/assets/users_image/<?php echo $ambil['data']['id_card_number_photo'] ?>" width="100" hight="100">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="col-md-6">
							<label>Foto Selfi</label>
							<img src="<?php echo base_url(); ?>/assets/users_image/<?php echo $ambil['data']['id_card_number_selfi'] ?>" width="100" hight="100">
							</div>
						</div>
					</div>
				</div>

			</div>			
		</div>
		<div class="modal-footer">       
		      <a href="<?php echo base_url('jogja/verified_masterusers') ?>" class="btn btn-warning">Back to List</a>      
		  </div>
	</div>
</div>

<script>
	var modalImg1 = document.getElementById("img01");
          modalImg1.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_photo;
          
    var modalImg2 = document.getElementById("img02");
          modalImg2.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_selfi;
</script>