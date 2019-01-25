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
          <th width="5px">Requset ON</th>
          <th width="5px">Status</th>
	        <th class="no-sort" width="10px"><center>Aksi</center></th>
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
        <h4 class="modal-title">Detil Withdraw</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama Pemilik</label>
              <input type="text" class="form-control" id="nama_pemilik" readonly>
            </div>
            
            <input type="hidden" class="form-control" id="ids">
            <div class="form-group">
              <label>Saldo Jogjaaccess</label>
              <input type="text" class="form-control" id="balance" readonly>
            </div>

            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" class="form-control" id="nama_bank" readonly>
            </div>

          </div>
          <div class="col-md-6">

            <div class="form-group">
              <label>Nominal Withdraw</label>
              <input type="text" class="form-control" id="nominal" readonly>
            </div>

            <div class="form-group">
              <label>No. Rekening</label>
              <input type="text" class="form-control" id="no_rekening" readonly>
            </div>

            <div class="form-group">
              <label>user id</label>
              <input type="text" class="form-control" id="user_id" readonly>
            </div>

            <div class="form-group">
              <label>Status</label>
              <?php 
                $options=array(
                        'On Process'=>'On Process',
                        'Berhasil'=>'Berhasil');
                echo form_dropdown('status', $options, '','class="form-control" id="status"');
              
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
        // success:function(data){
        //  console.log(data)
        // }
      }
      
    });
   
    })
</script>

<!-- <script>
  <-fungsi buat load halaman lain js->
  function showEditData(ids){
    var page =window.location.href;
    window.location=page + '/jsonGetOneData/' + ids;
    jsonGetOneData(ids)
  }
</script> -->

<script>
  function showEditData(ids){
    // var page =window.location.href;
    // window.location=page + '/jsonGetOneData/' + ids;
    jsonGetOneData(ids)
    // $('#myModal').modal('show');
  }
</script>

<script>
  function jsonGetOneData(post_id){ //ambil data sesui idnya
    $.ajax({
    url: '<?php echo base_url();?>jogja/withdraw/jsonGetOneData',
    type: 'POST',
    data: {ids:post_id,
      
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
          $('#ids').val(value.ids);
          $('#user_id').val(value.user_id);
          $('#nama_pemilik').val(value.nama_pemilik);
          $('#nominal').val(value.nominal);
          $('#balance').val(value.balance);
          $('#no_rekening').val(value.no_rekening);
          $('#nama_bank').val(value.nama_bank);
          $('#approve_by').val(value.approve_by);
          $('#status').val(value.status);
          // $('#selfi_photo').html('<img src="<?php //echo base_url();?>assets/users_image/'+value.id_card_number_photo+'" width="300" height="200">');
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

<script>
  function jsonUpdateData(){
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
    url: '<?php echo base_url();?>jogja/withdraw/jsonUpdateData', 
    type: 'POST',
    data: {ids:$('#ids').val(),
    // nominal:$('#nominal').val(),
    // balance:$('$balance').val(),
        status:$('#status').val(),
        //console.log()
        //verifikasi_msg:$('#verifikasi_msg').val(),
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
          //alert($('#nominal').val(value.nominal));
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
    
    // alert($('#nominal').val(value.nominal));
    // alert("MAJID");
  
  }
</script>


