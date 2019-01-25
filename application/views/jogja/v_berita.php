
<?php 
  echo $this->session->flashdata('success'); 
  echo $this->session->flashdata('failed');
?>

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
  <div class="box-header">
      <a href="<?php echo base_url();?>jogja/berita/add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a> 
      <!-- <a href="javascript:void(0)" onclick="showAddNew()" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a> -->
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
          <th width="5px">News Title</th>
	        <th class="no-sort" width="10px"><center>Aksi</center></th>
	      </tr>
      </thead>
		</table>
	</div>
</div>

<div id="info"></div>


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

<script>
  function showAddNew(){
    $('#ids').val('');
    $('#news_title').val('');
    $('#news_content').val('');
    $('#image_file').val('');
    //$('.textarea').wysihtml5();
    $('#myModal').modal('show');
    $('.modal-title').text('Add Berita');
  }
</script>


<script>
  function showEditData(ids){
    var page =window.location.href;
    window.location=page + '/jsonGetOneData/' + ids;
    jsonGetOneData(ids)
  }

</script>

<script>
  function jsonDeleteData(post_ids){
    var konfirmasi=confirm("Are You Sure Delete This Data?");
    if(!konfirmasi){
      return false;
    }else{
      $.ajax({
      url: '<?php echo base_url();?>jogja/berita/jsonDeleteData',
      type: 'POST',
      data: {ids:post_ids,
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
            //getDataTable();
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

