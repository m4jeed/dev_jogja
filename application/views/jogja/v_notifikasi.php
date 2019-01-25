
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
       <a href="<?php echo base_url();?>jogja/notifikasi/add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a> 
  </div>
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
	      <tr>
	        <th class="no-sort" width="2%">No</th>
	        <th width="5px">Notifikasi</th>
	        <th width="5px">User</th>
  		    <th width="5px">Created On</th>
          <th class="no-sort" width="2px" style="text-align: center">Aksi</th>
	      </tr>
      </thead>
	</table>
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
  function showModalData(id){
    var page =window.location.href;
    window.location=page + '/jsonGetOneData/' + id;
    jsonGetOneData(id)
  }

</script>

<script>
  
   function jsonDeleteData(post_ids){
    var konfirmasi=confirm("Are You Sure Delete This Data?");
    if(!konfirmasi){
      return false;
    }else{
      $.ajax({
      url: '<?php echo base_url();?>jogja/notifikasi/hapus/'+post_ids,
      //console.log(post_ids);
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
</script>