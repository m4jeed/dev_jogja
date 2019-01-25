<?php 
echo $this->session->flashdata('validasi');
echo $this->session->flashdata('success');
echo $this->session->flashdata('failed');
?>

<div class="box box-warning">
  <div class="box-header with-border">
      <h3 class="box-title"><?php echo $box_title;?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
  </div>
  <div class="box-header">
    <a href="javascript:void(0)" onclick="showAddNew()" class="btn btn-success pull-left"><i class="fa fa-plus"></i> Add New</a>
       <!-- <a href="<?php //echo base_url();?>jogja/notifikasi/add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>  -->
  </div>
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
	        <th width="5px">Poin Reward</th>
          <th width="5px">Nominal</th>
          <th class="no-sort" width="2px" style="text-align: center">Aksi</th>
	      </tr>
      </thead>
	</table>
  </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Reward</h4>
        </div>
        <form method="post" id="upload_form" align="left" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="ids" id="ids" class="form-control">
                <div id="detail_div">
                  <div class="col-md-6"> 
                    <div class="form-group">
                      <label>Poin Reward</label>
                        <input type="text" class="form-control" name="poin_reward" id="poin_reward" placeholder="Poin Reward">
                        <span id="span_poin_reward" style="color:red"></span>
                    </div>
                  </div>
                  <div class="col-md-6"> 
                    <div class="form-group">
                      <label>Nominal</label>
                        <input type="text" class="form-control" name="nominal_reward" id="nominal_reward" placeholder="Nominal Reward">
                        <span id="span_nominal_reward" style="color:red"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" value="Submit" class="btn btn-primary" id="btn_submit" />
            <a href="javascript:void(0)" class="btn btn-primary"  id="btn_loading" style="display: none;" disabled >Loading....</a>       
            <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>       
          </div>
        </form>
        
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

  <script type="text/javascript">
  function showAddNew(){
    $('#ids').val('');
    $('#poin_reward').val('');
    $('#nominal_reward').val('');
    $('#myModal').modal('show');
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#upload_form').on('submit', function(e){  
        e.preventDefault(); 

    $('#span_poin_reward').html('');
    $('#span_nominal_reward').html('');
    
    // var ids=$('#ids').val();
    // if (ids='') {
    //    if($('#image_file').val() == ''){
    //         alert("Please Select the File"); 
    //         return;
    //    } 
    // }
    $.ajax({
      url:"<?php echo base_url(); ?>jogja/poin_reward/jsonSaveData/",
      type:"POST",
      data:new FormData(this),
      contentType: false,  
          cache: false, 
          processData:false,
          beforeSend:function(){
            $('#btn_submit').hide();
            $('#btn_loading').show();
          },
          complete: function(){ 
            $('#btn_submit').show();
            $('#btn_loading').hide();
            
           },
          success:function(json){
            console.log(json);
            if (json['status']=='sukses'){
              //getDataTable();
                alert(json['data']);
                $('#myModal').modal('hide');
                window.location.href="<?php echo site_url(uri_string());?>";
              }else if(json['status']=='hasil_error'){
                $('#span_poin_reward').html(json['data']['poin_reward']);
                $('#span_nominal_reward').html(json['data']['nominal_reward']);
              }else{
            alert(json['data']);    
          }
            } 
      });
    });
  });
</script>

<script type="text/javascript">
  function showModalData(ids){
    jsonGetOneData(ids)
    
  }
</script>

<script type="text/javascript">
  function jsonGetOneData(post_id){
    $.ajax({
    url: '<?php echo base_url();?>jogja/poin_reward/jsonGetOneData',
    type: 'POST',
    data: {ids:post_id
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
          console.log(value);
          
          $('#myModal').modal('show');
          
          $('#ids').val(value.ids);
          $('#poin_reward').val(value.poin_reward);
          $('#nominal_reward').val(value.nominal_reward);
          // $('#div_logo').html('<img src="<?php echo base_url();?>assets/images/logo_jogja/'+value.logo+'" width="100">');
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

<script type="text/javascript">
  function jsonDeleteData(post_id){
    var konfirmasi=confirm("Are You Sure Delete This Data?");
    if(!konfirmasi){
      return false;
    }else{
      $.ajax({
      url: '<?php echo base_url();?>jogja/poin_reward/jsonDeleteData',
      type: 'POST',
      data: {ids:post_id,
          },
      dataType: 'json',
      
        beforeSend: function() {
          $.LoadingOverlay("show");
          
        },
        complete: function() {
          $.LoadingOverlay("hide");
          window.location.href="<?php echo site_url(uri_string());?>";
        },
      });
      
    }
    
  }   
</script>