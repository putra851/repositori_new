<?php

if (isset($majors)) {

	$inputMajorsValue = $majors['majors_name'];
	$inputShortValue = $majors['majors_short_name'];
	$inputStatusValue = $majors['majors_status'];
	
} else {
	
	$inputMajorsValue = set_value('majors_name');
	$inputShortValue = set_value('majors_short_name');
	$inputStatusValue = set_value('majors_status');
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
			<li><a href="<?php echo site_url('manage/majors') ?>">Unit Sekolah</a></li>
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
						<?php if (isset($majors)) { ?>
						<input type="hidden" name="majors_id" value="<?php echo $majors['majors_id']; ?>">
						<?php } ?>
						

						<div class="form-group">
							<label>Nama Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="majors_name" type="text" class="form-control" value="<?php echo $inputMajorsValue ?>" placeholder="Isi Nama Unit Sekolah">
						</div>

						<div class="form-group">
							<label>Singkatan Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="majors_short_name" type="text" class="form-control" value="<?php echo $inputShortValue ?>" placeholder="Isi Singkatan Unit Sekolah">
						</div>

	                    <div class="form-group">
							<label>Status</label>
							<div class="radio">
								<label>
									<input type="radio" name="majors_status" value="1" <?php echo ($inputStatusValue == 1) ? 'checked' : ''; ?>> Aktif
								</label> &nbsp;&nbsp;&nbsp;&nbsp;
								<label>
									<input type="radio" name="majors_status" value="0" <?php echo ($inputStatusValue == 0) ? 'checked' : ''; ?>> Tidak Aktif
								</label>
							</div>
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
						<a href="<?php echo site_url('manage/majors'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>