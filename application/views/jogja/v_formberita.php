<link rel="stylesheet" type="text/css" href="assets/tinymce/tests/manual/css/development.css">
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>

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
	<!-- <div id="load"> -->
    <?php require_once('tinymce.php') ?>
		<form method="post" id="upload_form" align="left" enctype="multipart/form-data">
			<div class="box-body">
				<!-- <input type="hidden" name="ids" id="ids" class="form-control"> -->
				<div class="form-group">
	              <label>News Title</label>
	              <input name="news_title" id="news_title" class="form-control" placeholder="News Title" autocomplete="off">
	              <span id="span_news_title" style="color:red"></span>
	            </div>
	            <div class="form-group">
	              <label>News Image</label>
	              <input type="file" name="image_file" id="image_file" value="" class="form-control">
	            </div><div id="ambil_foto"></div>
	            <div class="form-group">
	              <label>News Content</label>
	              <textarea class="textarea" id="news_content" name="news_content" value="" placeholder="Place some text here to Edit">
	                          
	              </textarea>
	              </div>
	              <span id="span_news_content" style="color:red"></span>
			</div>
			<div class="modal-footer">
		      <input type="submit" value="Submit" class="btn btn-primary" id="btn_submit" />
		      <a href="javascript:void(0)" class="btn btn-primary"  id="btn_loading" style="display: none;" disabled >Loading....</a>       
		      <a href="<?php echo base_url('jogja/berita') ?>" class="btn btn-default">Back</a>       
		    </div>
		</form>
	<!-- </div> -->
</div>

<script>
	$(document).ready(function(){
    $('#upload_form').on('submit', function(e){
      e.preventDefault();
      $('#span_news_title').html('');
      $('#span_news_content').html('');

      var ids=$('#ids').val();
      if(ids==''){
        if($('#image_file').val() == '')  
        {  
          alert("Please Select the File"); 
          return;
        }  
      }
      
      $.ajax({
        url:"<?php echo base_url() ?>jogja/berita/jsonSaveData/",
        method:"POST",
        data:new FormData(this),  
        contentType: false,  
        cache: false,  
        processData:false,
         beforeSend: function() {
          $('#btn_submit').hide();
          $('#btn_loading').show();
          
         },
         complete: function() {
  
          $('#btn_submit').show();
          $('#btn_loading').hide();
          
         },
         success:function(json){
          console.log(json);
            if(json['status']=='sukses'){
              alert(json['data']);
              //$('#myModal').modal('hide');
              window.location.href="<?php echo site_url();?>jogja/berita";
            }else if(json['status']=='error_val'){
              $('#span_news_title').html(json['data']['news_title']);
              $('#span_news_content').html(json['data']['news_content']);
            }else{
              alert(json['data']);
              
            }
         }
      });
    });
  });
</script>

