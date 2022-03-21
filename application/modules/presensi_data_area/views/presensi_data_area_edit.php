<?php

if (isset($presensi_data_area)) {
	$inputNameValue = $presensi_data_area['nama_area'];
	$inputLongiValue = $presensi_data_area['longi'];
	$inputLatiValue = $presensi_data_area['lati'];
	$inputRemarkValue = $presensi_data_area['remark'];
} else {
	$inputNameValue = set_value('nama_area');
	$inputLongiValue = set_value('longi');
	$inputLatiValue = set_value('lati');
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
			<li><a href="<?php echo site_url('manage/presensi_data_area') ?>">Manage Data Area Presensi</a></li>
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
    						<?php if (isset($presensi_data_area)) { ?>
    							<input type="hidden" name="id_area" value="<?php echo $presensi_data_area['id_area']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Nama Area <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="nama_area" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Nama Area">
    						</div> 
    						<div class="form-group">
    							<label>Longi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="longi" type="text" class="form-control" value="<?php echo $inputLongiValue ?>" placeholder="Longi">
    						</div>
    						<div class="form-group">
    							<label>Lati <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="lati" type="text" class="form-control" value="<?php echo $inputLatiValue ?>" placeholder="Lati">
    						</div>
    						<div class="form-group">
    							<label>Keterangan</label>
								<textarea name="remark" class="form-control" placeholder="Keterangan"><?=$inputRemarkValue?></textarea>
    						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/presensi_data_area'); ?>" class="btn btn-danger">Batal</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>