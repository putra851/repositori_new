<?php

if (isset($semester)) {

	$inputSemesterValue = $semester['semester_name'];
	$inputPeriodValue = $semester['semester_period_id'];
	
} else {
	
	$inputSemesterValue = set_value('semester_name');
	$inputPeriodValue = set_value('semester_period_id');
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
			<li><a href="<?php echo site_url('manage/semester') ?>">Kelas</a></li>
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
						<?php if (isset($semester)) { ?>
						<input type="hidden" name="semester_id" value="<?php echo $semester['semester_id']; ?>">
						<?php } ?>
						

						<div class="form-group">
							<label>Semester <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="semester_name" type="text" class="form-control" value="<?php echo $inputSemesterValue ?>" placeholder="Isi Semester">
						</div>
						
						<div class="form-group">
							<label>Tahun Ajaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="semester_period_id" class="form-control">
							    <option value="">-Pilih Tahun Ajaran-</option>
							    <?php foreach($period as $row){?>
							        <option value="<?php echo $row['period_id']; ?>" <?php echo ($inputPeriodValue == $row['period_id']) ? 'selected' : '' ?>><?php echo $row['period_start'] . '/' . $row['period_end'] ?></option>
							    <?php } ?>
							</select>
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
						<a href="<?php echo site_url('manage/semester'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>