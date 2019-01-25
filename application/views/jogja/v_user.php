  <div class="box box-warning">
      <div class="box-header with-border">
          <h3 class="box-title">List</h3>
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
              <th width="5px">Fullname</th>
    	        <th width="5px">Email</th>
              <th width="5px">Gender</th>
              <!-- <th width="5px">Username</th>
              <th width="5px">Fullname</th>
              <th width="5px">Lvl</th> -->
    	        <th class="no-sort" width="5px">Aksi</th>
    	      </tr>
          </thead>
          <tbody>
          
          <!-- <td class="text-center">1</td>
          <td>admin</td>
          <td>admin</td>
          <td>ADMIN</td>
          <td class="text-left">
    				<a class="btn btn-info" href="">Edit</a>
            <a class="btn btn-danger" href="">Delete</a>
            <a class="btn btn-primary" href="">ChangePassword</a>
    		  </td> -->

          
          
    			</tbody>
    		</table>
    	</div>
    </div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add User</h4>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" class="form-control" id="user_id">
            <div id="detail_div">

              <div class="box-body"> 
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Fullnama</label>
                  <div class="col-sm-8">
                    <input name="fullname" id="fullname" class="form-control" placeholder="Fullname">
                    <span id="span_fullname" style="color:red"></span>
                  </div>
                </div>
              </div>

              <div class="box-body"> 
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input name="email" id="email" class="form-control" placeholder="Email">
                  <span id="span_email" style="color:red"></span>
                  </div>
                </div>
              </div>

              <div class="box-body"> 
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Gender</label>
                  <div class="col-sm-8">
                    <select name="gender" id="gender" class="form-control required">
                      <option value="LAKI-LAKI">LAKI-LAKI</option>
                      <option value="PEREMPUAN">PEREMPUAN</option>
                    </select>
                    <span id="span_gender" style="color:red"></span>
                  </div>
                </div>
              </div>

              <div class="box-body"> 
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Group id</label>
                  <div class="col-sm-8">
                    <!-- <input type="hidden" name="user_id"> -->
                    <select name="group_id" id="group_id" class="form-control required">
                      <?php 
                      foreach($groups as $row){  
                        echo '<option value="'.$row->group_id.'" selected>'.$row->group_name.
                        '</option>';
                      }
                      ?>
                    </select>
                    <span id="span_group_id" style="color:red"></span>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        
        </div>
      </div>
      <div class="modal-footer">
        <div id="btn_submit_div">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="javascript:void(0)" class="btn btn-primary" onclick="jsonSaveData()">Submit</a>
            <!-- <a href="javascript:void(0)" class="btn btn-primary"  id="btn_loading" style="display: none;" disabled >Loading....</a>  -->
        </div>
      </div>
      <!-- </form>   -->
    </div>
  </div>
</div>

<script>
  function showAddNew(){
    $('#user_id').val('');
    $('#fullname').val('');
    $('#email').val('');
    $('#gender').val('');
    $('#group_id').val('');
    $('#detail_div').val('');
    $("#group_id").prop("readonly",false);
    $("#email").prop("readonly",false);
    $('#btn_submit_div').show();
    $('#myModal').modal('show');
  }

</script>

<script>
  function showModalData(user_id){
    jsonGetOneData(user_id)
    
  }
</script>


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
        url: "<?php echo base_url('oi/user/ajax_list') ?>",
        type:'POST',
      }
    })
    })
</script>

<script>

  $('#span_fullname').html('');
  $('#span_email').html('');
  $('#span_gender').html('');
  $('#span_group').html('');

  function jsonSaveData(){
      var user_id=$('#user_id').val();
      if(user_id==''){
        jsonInsertData();
      }else{
        //alert('oke');
        jsonUpdateData();
      }
  }

    function jsonInsertData(){
    $.ajax({
    url: '<?php echo base_url();?>oi/user/jsonInsertData',
    type: 'POST',
    data: {fullname:$('#fullname').val(),
        email:$('#email').val(),
        gender:$('#gender').val(),
        group_id:$('#group_id').val(),
        //retype_pass:$('#retype_pass').val(),
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

  function jsonGetOneData(post_user_id){
    $.ajax({
    url: '<?php echo base_url();?>oi/user/jsonGetOneData',
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
          $('#detail_div').show();
          $('#btn_submit_div').show();
          $("#email").prop("readonly",true); //dimatiin nanti
          $("#gender").prop("selected",true);
          $("#group_id").prop("selected",true);
          $('#myModal').modal('show');
          
          //console.log(value);
          $('#user_id').val(value.user_id);
          $('#fullname').val(value.fullname);
          $('#email').val(value.email);
          $('#gender').val(value.gender);
          $('#group_id').val(value.group_name);
          
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
    url: '<?php echo base_url();?>oi/user/jsonUpdateData',
    type: 'POST',
    data: {user_id:$('#user_id').val(),
        fullname:$('#fullname').val(),
        //email:$('#email').val(),
        gender:$('#gender').val(),
        group_id:$('#group_name').val(),
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
    url: '<?php echo base_url();?>admin/user/jsonDeleteData',
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
</script>

