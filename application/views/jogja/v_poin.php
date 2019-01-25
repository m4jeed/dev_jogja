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
	        <th width="5px">Fullname</th>
          <th width="5px">Vacc Number</th>
	        <th width="5px">Phone</th>
  		    <th width="5px">Poin</th>
          <th width="5px">Nominal</th>
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