<?php

if (isset($presensi_data_libur)) {
	$inputNameValue = $presensi_data_libur['hari'];
	$inputRemarkValue = $presensi_data_libur['keterangan'];
	$inputCreatedbyValue = $presensi_data_libur['created_by'];
	$inputCreateddateValue = $presensi_data_libur['created_date'];
	$inputUpdateddateValue = $presensi_data_libur['updated_date'];
	$inputUpdatedbyValue = $presensi_data_libur['updated_by'];
} else {
	$inputNameValue = set_value('hari');
	$inputRemarkValue = set_value('keterangan');
	$inputCreatedbyValue = set_value('created_by');
	$inputCreateddateValue = set_value('created_date');
	$inputUpdateddateValue = set_value('updated_date');
	$inputUpdatedbyValue = set_value('updated_by');
}
?>

<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/presensi_data_libur') ?>">Detail Data Libur Presensi</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
    						<?php echo validation_errors(); ?>
    						<?php if (isset($presensi_data_libur)) { ?>
    							<input type="hidden" name="id_area" value="<?php echo $presensi_data_libur['id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Hari </label>
    							<input name="hari" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Hari" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Keterangan</label>
								<textarea name="remark" class="form-control" placeholder="Keterangan" readonly=""><?=$inputRemarkValue?></textarea>
    						</div>
							<div class="form-group">
    							<label>Created By </label>
    							<input name="created_by" type="text" class="form-control" value="<?php echo $inputCreatedbyValue ?>" placeholder="Created By" readonly="">
    						</div>
							<div class="form-group">
    							<label>Created Date </label>
    							<input name="created_date" type="text" class="form-control" value="<?php echo $inputCreateddateValue ?>" placeholder="Created Date" readonly="">
    						</div>
							<div class="form-group">
    							<label>Updated By </label>
    							<input name="updated_by" type="text" class="form-control" value="<?php echo $inputUpdatedbyValue ?>" placeholder="Updated By" readonly="">
    						</div>
							<div class="form-group">
    							<label>Updated Date </label>
    							<input name="updated_date" type="text" class="form-control" value="<?php echo $inputUpdateddateValue ?>" placeholder="Updated Date" readonly="">
    						</div>
						<div class="form-group text-right">
							<a href="<?php echo site_url('manage/presensi_data_libur'); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>&nbsp;Kembali</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>