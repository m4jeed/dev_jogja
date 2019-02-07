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
          <th>My Referal Code</th>
          <th>Referal Code</th>
          <th>Phone</th>
          <th>Email</th>
          <th>VA Number</th>
          <th>Balance</th>
          <th>Poin</th>
          <th>Created On</th>
          <th>Aksi</th>
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
  function showModalData(user_id){
    var page =window.location.href;
    window.location=page + '/jsonGetOneData/' + user_id;
    jsonGetOneData(user_id)
  }

  function showVaccNumber(vacc_number){
    var page =window.location.href;
    window.location=page + '/jsonGetVacc/' + vacc_number;
    jsonGetOneData(vacc_number)
  }
</script>

<script>
  success: function(json) {
        if(json['status']=='sukses'){
          var modalImg1 = document.getElementById("img01");
          modalImg1.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_photo;
          
          var modalImg2 = document.getElementById("img02");
          modalImg2.src = "<?php echo base_url();?>/assets/users_image/"+value.id_card_number_selfi;

        }else{
          alert(json['data']);
        }
        
      },
</script>

<!--update-->