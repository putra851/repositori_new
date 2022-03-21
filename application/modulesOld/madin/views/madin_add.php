<?php

if (isset($madin)) {

	$inputMadinValue = $madin['madin_name'];
	//$inputMajorsValue = $madin['madin_majors_id'];
	
} else {
	
	$inputMadinValue = set_value('madin_name');
	//$inputMajorsValue = set_value('madin_majors_id');
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
			<li><a href="<?php echo site_url('manage/madin') ?>">Jurusan</a></li>
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
						<?php if (isset($madin)) { ?>
						<input type="hidden" name="madin_id" value="<?php echo $madin['madin_id']; ?>">
						<?php } ?>
						

						<div class="form-group">
							<label>Nama Jurusan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="madin_name" type="text" class="form-control" value="<?php echo $inputMadinValue ?>" placeholder="Isi Nama Jurusan">
						</div>
						<!--
						<div class="form-group">
							<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="madin_majors_id" class="form-control">
							    <option value="">-Pilih Unit Sekolah-</option>
							    <?php foreach($majors as $row){?>
							        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
							    <?php } ?>
							</select>
						</div>
						-->
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
						<a href="<?php echo site_url('manage/madin'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>