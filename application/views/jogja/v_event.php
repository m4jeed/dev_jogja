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
  </div>
  
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
          <th width="5px">Image</th>
          <th width="5px">Filename</th>
	        <th width="5px">Create On</th>
          <th width="5px">Created By</th>
	        <th class="no-sort" width="5px">Aksi</th>
	      </tr>
      </thead>
		</table>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Banner</h4>
      </div>
      <form method="post" id="upload_form" align="left" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="ids" id="ids" class="form-control">
              <div id="detail_div">
                <div class="box-body"> 
                  <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Filename</label>
                    <div class="col-sm-8">
                      <input type="file" class="form-control" name="image_file" id="image_file">
                      <span id="span_filename" style="color:red"></span>
                    </div>
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
  getDataTable();
})
</script>

<script>
function getDataTable(){
  $('#example2').DataTable({
  'processing': true,
  'serverSide': true,
  'destroy': true,
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
}
</script>

<script>
  function showAddNew(){
    //alert('oke');
    $('#ids').val('');
    $('#event_image').val('');
    $('#myModal').modal('show');
  }

</script>

<script>  
  $(document).ready(function(){  
    $('#upload_form').on('submit', function(e){  
      e.preventDefault();  
      //$('#span_filename').html('');
      
      var event_id=$('#ids').val();
      if(event_id==''){
        if($('#image_file').val() == '')  
        {  
          alert("Please Select the File"); 
          return;
        }  
      }
      $.ajax({  
         url:"<?php echo base_url(); ?>jogja/event/jsonSaveData/",   
         method:"POST",  
         data:new FormData(this),  
         contentType: false,  
         cache: false,  
         processData:false,
         beforeSend: function(){
          $('#btn_submit').hide();
          $('#btn_loading').show();
          
         },
         complete: function() 
          {$('#btn_submit').show();
          $('#btn_loading').hide();
          
         },
         success:function(json)  
         {  
          console.log(json);
          if(json['status']=='sukses'){
            getDataTable();
              alert(json['data']);
            $('#myModal').modal('hide');
             window.location.href="<?php echo site_url(uri_string());?>";
        
          }else if(json['status']=='error_val'){
            $('#span_filename').html(json['data']['event_image']);
          }else{
            //alert('oke');
            alert(json['data']);
            
          }
          
         }  
      });  
         
      });  
  });

  function jsonDeleteData(post_id){
    var konfirmasi=confirm("Are You Sure Delete This Data?");
    if(!konfirmasi){
      return false;
    }else{
      $.ajax({
      //Request URL: http://localhost/dev_jogja/jogja/event/jsonDeleteData
      url: '<?php echo base_url();?>jogja/event/jsonDeleteData',
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



