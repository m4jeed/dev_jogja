<!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><a href="javascript:void(0)" onclick="jsonUpdateHarga()" class="btn btn-primary">UPDATE DATA</a></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
			<b>PULSA AXIS</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1AXIS){
					$number=1;
					foreach($res1AXIS as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>PULSA INDOSAT</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1INDOSAT){
					$number=1;
					foreach($res1INDOSAT as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>PULSA TELKOMSEL</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1TELKOMSEL){
					$number=1;
					foreach($res1TELKOMSEL as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>PULSA THREE</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1THREE){
					$number=1;
					foreach($res1THREE as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>PULSA XL</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1XL){
					$number=1;
					foreach($res1XL as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			
			<b>PULSA SMARTFREN</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res1SMARTFREN){
					$number=1;
					foreach($res1SMARTFREN as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			
			
			<br/>
			<br/>
			<br/>
			<b>DATA AXIS</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2AXIS){
					$number=1;
					foreach($res2AXIS as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA INDOSAT</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2INDOSAT){
					$number=1;
					foreach($res2INDOSAT as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA TELKOMSEL</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2TELKOMSEL){
					$number=1;
					foreach($res2TELKOMSEL as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA THREE</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2THREE){
					$number=1;
					foreach($res2THREE as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA XL</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2XL){
					$number=1;
					foreach($res2XL as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA SMARTFREN</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2SMARTFREN){
					$number=1;
					foreach($res2SMARTFREN as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
			<b>DATA BOLT</b>
			<table id="example2" class="table table-bordered table-condensed table-striped" >
                <thead>
                <tr>
                  <th class="no-sort" width="10">No</th>
                  <th class="no-sort" >product_code</th>
                  <th class="no-sort" >product_name</th>
                  <th class="no-sort" >product_price</th>
                  <th class="no-sort" >product_saleprice</th>
                  <th class="no-sort" >product_status</th>
                  <th class="no-sort" >updated_on</th>
                  
                  </tr>
                </thead>
              <tbody>
				<?php 
				if($res2BOLT){
					$number=1;
					foreach($res2BOLT as $row1){
				?>
				<tr>
					<td><?php echo $number++;?></td>
					<td><?php echo $row1['product_code'];?></td>
					<td><?php echo $row1['product_name'];?></td>
					<td><?php echo $row1['product_price'];?></td>
					<td><?php echo $row1['product_saleprice'];?></td>
					<td><?php echo $row1['product_status'];?></td>
					<td><?php echo $row1['updated_on'];?></td>
				</tr>
				
				<?php
					}
				}
				?>
			  </tbody>
			</table>
			
		
		
		</div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->
	  
	  
	<script>
	function jsonUpdateHarga(){
		var r = confirm("Are you Sure??");
		if (r == false) {
			return false;
		}
		
		$.ajax({
		url: '<?php echo base_url();?>admin/ppob_harga/jsonUpdateHarga',
		type: 'POST',
		data: {},
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
	
	
	