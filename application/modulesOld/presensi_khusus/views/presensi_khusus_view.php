<?php

if (isset($presensi_khusus)) {
	$inputTanggalValue = $presensi_khusus['tanggal'];
	$inputIdegawaiValue = $presensi_khusus['id_pegawai'];
	$inputLokasiabsenValue = $presensi_khusus['lokasi_absen'];
	$inputRemarkValue = $presensi_khusus['remark'];
} else {
	$inputTanggalValue = set_value('tanggal');
	$inputIdegawaiValue = set_value('id_pegawai');
	$inputLokasiabsenValue = set_value('lokasi_absen');
	$inputRemarkValue = set_value('remark');
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
			<li><a href="<?php echo site_url('manage/presensi_khusus') ?>">Detail Presensi Khusus</a></li>
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
    						<?php if (isset($presensi_khusus)) { ?>
    							<input type="hidden" name="id" value="<?php echo $presensi_khusus['id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Tanggal </label>
    							<input name="tanggal" type="text" class="form-control" value="<?php echo $inputTanggalValue ?>" placeholder="Tanggal" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Pegawai </label>
    							<input name="id_pegawai" type="text" class="form-control" value="<?php echo $presensi_khusus['nama_pegawai'] ?>" placeholder="Pegawai" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Lokasi Absen </label>
    							<input name="lokasi_absen" type="text" class="form-control" value="<?php echo $presensi_khusus['nama_area'] ?>" placeholder="Lokasi Absen" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Keterangan</label>
								<textarea name="remark" class="form-control" placeholder="Keterangan" readonly=""><?=$inputRemarkValue?></textarea>
    						</div>
							<div class="form-group">
    							<label>Created By </label>
    							<input name="created_by" type="text" class="form-control" value="<?php echo $presensi_khusus['created_by'] ?>" placeholder="Created By" readonly="">
    						</div>
							<div class="form-group">
    							<label>Created Date </label>
    							<input name="created_date" type="text" class="form-control" value="<?php echo $presensi_khusus['created_date'] ?>" placeholder="Created Date" readonly="">
    						</div>
							<div class="form-group">
    							<label>Updated By </label>
    							<input name="updated_by" type="text" class="form-control" value="<?php echo $presensi_khusus['updated_by'] ?>" placeholder="Updated By" readonly="">
    						</div>
							<div class="form-group">
    							<label>Updated Date </label>
    							<input name="updated_date" type="text" class="form-control" value="<?php echo $presensi_khusus['updated_date'] ?>" placeholder="Updated Date" readonly="">
    						</div>
						<div class="form-group text-right">
							<a href="<?php echo site_url('manage/presensi_khusus'); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>&nbsp;Kembali</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>