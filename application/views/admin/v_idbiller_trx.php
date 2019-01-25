<!-- Default box -->
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ID Biller Trx</h3>

		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
				title="Collapse">
			<i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
			<i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="<?php echo site_url('admin/idbiller_trx/export_xls');?>">
				<table>
					<tr>
						<td><b>StartDate</b></td>
						<td>:</td>
						<td><input value="<?php echo date('Y-m-d');?>" readonly name="start_date" class="form-control tanggal"></td>
						<td width="20px"></td>
						<td><b>EndDate</b></td>
						<td>:</td>
						<td><input value="<?php echo date('Y-m-d');?>" readonly name="end_date" class="form-control tanggal"></td>
						
						<td width="20px"></td>
						<td><button class="btn btn-primary" type="submit">Export to Excel</button></td>
						
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	<!-- /.box-body -->

</div>
<!-- /.box -->


<!-- Default box -->
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">PPOB Wallet Trx</h3>

		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
				title="Collapse">
			<i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
			<i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="<?php echo site_url('admin/idbiller_trx/wallet_export_xls');?>">
				<table>
					<tr>
						<td><b>StartDate</b></td>
						<td>:</td>
						<td><input value="<?php echo date('Y-m-d');?>" readonly name="start_date2" class="form-control tanggal"></td>
						<td width="20px"></td>
						<td><b>EndDate</b></td>
						<td>:</td>
						<td><input value="<?php echo date('Y-m-d');?>" readonly name="end_date2" class="form-control tanggal"></td>
						
						<td width="20px"></td>
						<td><button class="btn btn-success" type="submit">Export to Excel</button></td>
						
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	<!-- /.box-body -->

</div>
<!-- /.box -->
	  
	
	