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
  <!-- <?php 
  //echo $this->session->flashdata('fail');
  ?>  -->
    <?php require_once('tinymce.php') ?>
		<form action="<?php echo base_url('jogja/berita/execute/update/berita/').$ambil['data']['ids'] ?>" method="post" id="upload_form" align="left" enctype="multipart/form-data">
			<div class="box-body">
				<input type="hidden" name="ids" id="ids" value="<?php $ambil['data']['ids'] ?>" class="form-control">
		      <div class="form-group">
            <label>News Title</label>
            <!-- <input type="hidden" name="ids" id="ids" class="form-control"> -->
            <input name="news_title" id="news_title" value="<?php echo $ambil['data']['news_title'] ?>" class="form-control" placeholder="News Title" autocomplete="off">
            <span id="span_news_title" style="color:red"></span>
          </div>
          <div class="form-group">
            <label>News Image</label>
            <input type="file" name="image_file" id="image_file" value="" class="form-control">
            <img src="<?php echo base_url(); ?>/assets/berita/<?php echo $ambil['data']['news_image'] ?>" width="100" hight="100"><?php echo $ambil['data']['news_image'] ?> 
          </div>
          <div class="form-group">
            <label>News Content</label>
            <textarea class="textarea" id="news_content" name="news_content" value="" placeholder="Place some text here to Edit">
            <?php echo $ambil['data']['news_content'] ?>
            </textarea>
          </div>
			</div>
			<div class="modal-footer">
		      <input type="submit" value="Submit" class="btn btn-primary"/>      
		      <a href="<?php echo base_url('jogja/berita') ?>" class="btn btn-default">Back</a>       
		    </div>
		</form>
</div>



