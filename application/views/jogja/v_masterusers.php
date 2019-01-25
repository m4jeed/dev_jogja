<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/cssfoto/foto.css"> 

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
          <th>Fullname</th>
	        <th>Phone</th>
          <th>Email</th>
          <th>VA Number</th>
          <th>Balance</th>
          <th>Poin</th>
          <th>Mail Cnfrm</th>
          <th>Phone Cnfrm</th>
          <th>Created On</th>
	        <th class="no-sort" width="5px">Aksi</th>
	      </tr>
      </thead>
		</table>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detil Jogja Member</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <input type="text" class="form-control" id="user_id">
            <div class="form-group">
              <label>Fullname</label>
              <input type="text" class="form-control" id="fullname" readonly>
            </div>

            <div class="form-group">
              <label>My Code Referal</label>
              <input type="text" class="form-control" name='referral' id="my_referal_code" readonly>
            </div>
            
            <div class="form-group">
              <label>Code Referal</label>
              <input type="text" class="form-control" id="referal_code" readonly>
            </div>
            
            <div class="form-group">
              <label>Poin</label>
              <input type="text" class="form-control" name='amount' id="poin" readonly>
            </div>

            <div class="form-group">
              <label>Balance</label>
              <input type="text" class="form-control" name='balance' id="balance" readonly>
            </div>
            
            <div class="form-group">
              <label>Vacc Number</label>
              <input type="text" class="form-control" id="vacc_number" readonly>
            </div>

            <div class="form-group">
              <label>POB</label>
              <input type="text" class="form-control" id="pob" readonly>
            </div>

            <div class="form-group">
              <label>DOB</label>
              <input type="text" class="form-control" id="dob" readonly>
            </div>

            <div class="form-group">
              <label>KTP Number</label>
              <input type="text" class="form-control" id="id_card_number" readonly>
            </div>

            <div class="form-group">
              <label>MOM</label>
              <input type="text" class="form-control" id="mom" readonly>
            </div>

            <div class="form-group">
              <label>Address</label>
              <input type="text" class="form-control" id="address" readonly>
            </div>
            <!-- <div class="form-group">
              <label>Photo Id Card</label>
              <div class="" id="card_photo"></div> 
            </div> -->
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
              <label>Province</label>
              <input type="text" class="form-control" id="province" readonly>
            </div>

             <div class="form-group">
              <label>Kelurahan</label>
              <input type="text" class="form-control" id="village" readonly>
            </div>

            <div class="form-group">
              <label>Kecamatan</label>
              <input type="text" class="form-control" id="districts" readonly>
            </div>

            <div class="form-group">
              <label>City</label>
              <input type="text" class="form-control" id="city" readonly>
            </div>

            <div class="form-group">
              <label>Phone</label>
              <input type="text" class="form-control" id="phone" readonly>
            </div>

           

            <div class="form-group">
              <label>Is_Confirmed_Hp</label>
              <input type="text" class="form-control" id="is_confirmed_hp" readonly>
            </div>

            <div class="form-group">
              <label>Is_Confirmed_Email</label>
              <input type="text" class="form-control" id="is_confirmed_email" readonly>
            </div>

            <div class="form-group">
              <label>Created On</label>
              <input type="text" class="form-control" id="created_on" readonly>
            </div>

            <div class="form-group">
              <label>Massage Verifikasi</label>
              <textarea type="textarea" class="form-control" id="verifikasi_msg" require></textarea>
            </div>

            <div class="form-group">
              <label>Status Verifikasi</label>
              <?php 
                $options=array(
                        'proses'=>'proses',
                        'belum'=>'belum',
                        'berhasil'=>'berhasil');
                echo form_dropdown('status_verifikasi', $options, '','class="form-control" id="status_verifikasi"');
              
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="javascript:void(0)" class="btn btn-primary" onclick="jsonUpdateData()">Approval</a>
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
  function showModalData(user_id){
    jsonGetOneData(user_id)
    
  }
  
  function jsonGetOneData(post_user_id){
    $.ajax({
    url: '<?php echo base_url();?>jogja/masterusers/jsonGetOneData',
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
          $('#my_referal_code').val(value.my_referal_code);
          $('#referal_code').val(value.referal_code);
          $('#poin').val(value.poin);
          $('#balance').val(value.balance);
          $('#pob').val(value.pob);
          $('#dob').val(value.dob);
          $('#id_card_number').val(value.id_card_number);
          $('#address').val(value.address);
          $('#mom').val(value.mom);
          $('#created_on').val(value.created_on);
          $('#status_verifikasi').val(value.status_verifikasi);
          $('#phone').val(value.phone);
          $('#village').val(value.village);
          $('#is_confirmed_hp').val(value.is_confirmed_hp);
          $('#is_confirmed_email').val(value.is_confirmed_email);
          $('#verifikasi_msg').val(value.verifikasi_msg);
          $('#province').val(value.province);
          $('#city').val(value.city);
          $('#districts').val(value.districts);
          $('#vacc_number').val(value.vacc_number);
          // $('#domisili_postalcode_id').val(value.postalcode_id);
          //
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
    // var is_confirmed_hp=$('#is_confirmed_hp').val();
    // var is_confirmed_email=$('#is_confirmed_email').val();
    
    // if(is_confirmed_email!='1'){
    //   alert('EMail belum dikonfirmasi');
    //   return false
    // }
    
    // if(is_confirmed_hp!='1'){
    //   alert('Handphone belum dikonfirmasi');
    //   return false
    // }
    
    $.ajax({
    url: '<?php echo base_url();?>jogja/masterusers/jsonUpdateData',
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

