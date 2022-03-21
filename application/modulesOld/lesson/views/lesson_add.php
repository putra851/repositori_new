<?php

if (isset($lesson)) {

	$inputCodeValue     = $lesson['lesson_code'];
	$inputLessonValue   = $lesson['lesson_name'];
	$inputTeacherValue  = $lesson['lesson_teacher'];
	$inputMajorsValue   = $lesson['lesson_majors_id'];
	
} else {
	
	$inputCodeValue     = set_value('lesson_code');
	$inputLessonValue   = set_value('lesson_name');
	$inputTeacherValue  = set_value('lesson_teacher');
	$inputMajorsValue   = set_value('lesson_majors_id');
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
			<li><a href="<?php echo site_url('manage/lesson') ?>">Mata Pelajaran</a></li>
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
						<?php if (isset($lesson)) { ?>
						<input type="hidden" name="lesson_id" value="<?php echo $lesson['lesson_id']; ?>">
						<?php } ?>
						
						<div class="form-group">
    					    <label>Unit Pesantren</label>
        					<select id="lesson_majors_id" name="lesson_majors_id" class="form-control" required>
							    <option value="">--- Pilih Unit Pesantren ---</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
							</select>
						</div>
						
                        <div class="form-group">
							<label>Kode Mapel <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="lesson_code" type="text" class="form-control" value="<?php echo $inputCodeValue ?>" placeholder="Isi Kode Mapel">
						</div>
                        
						<div class="form-group">
							<label>Nama Mapel <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="lesson_name" type="text" class="form-control" value="<?php echo $inputLessonValue ?>" placeholder="Isi Nama Mapel">
						</div>
						<?php
						    $employee = $this->Employees_model->get(array('majors_id' => $inputMajorsValue));
						?>
                        <div class="form-group">
							<label>Pengajar <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<select id="lesson_teacher" name="lesson_teacher" class="form-control" required>
            					    <option value="">--- Pilih Pengajar ---</option>
            					    <?php foreach($employee as $row){?>
            					        <option value="<?php echo $row['employee_id']; ?>" <?php echo ($inputTeacherValue == $row['employee_id']) ? 'selected' : '' ?>><?php echo $row['employee_name'] ?></option>
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
						<a href="<?php echo site_url('manage/lesson?m='.$inputMajorsValue); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>