<?php

if (isset($jam_pelajaran)) {

	$inputNameValue     = $jam_pelajaran['jam_pelajaran_name'];
	$inputStartValue    = $jam_pelajaran['jam_pelajaran_start'];
	$inputEndValue      = $jam_pelajaran['jam_pelajaran_end'];
	
} else {
	
	$inputNameValue     = set_value('jam_pelajaran_name');
	$inputStartValue    = set_value('jam_pelajaran_start');
	$inputEndValue      = set_value('jam_pelajaran_end');
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
			<li><a href="<?php echo site_url('manage/jam_pelajaran') ?>">Kelas</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-9">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
						<?php echo validation_errors(); ?>
						<?php if (isset($jam_pelajaran)) { ?>
						<input type="hidden" name="jam_pelajaran_id" value="<?php echo $jam_pelajaran['jam_pelajaran_id']; ?>">
						<?php } ?>

						<div class="form-group">
							<label>Keterangan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="jam_pelajaran_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Isi Keterangan">
						</div>

						<div class="form-group">
							<label>Jam Mulai <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="jam_pelajaran_start" type="time" class="form-control" value="<?php echo $inputStartValue ?>" placeholder="Isi Jam Mulai">
						</div>

						<div class="form-group">
							<label>Jam Berakhir <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="jam_pelajaran_end" type="time" class="form-control" value="<?php echo $inputEndValue ?>" placeholder="Isi Jam Berakhir">
						</div>
						
						<p class="text-muted">*) Kolom wajib diisi.</p>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
						<button type="submit" class="btn btn-block btn-success">Simpan</button>
						<a href="<?php echo site_url('manage/jam_pelajaran'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>