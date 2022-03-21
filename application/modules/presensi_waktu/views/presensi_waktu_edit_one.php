<?php

if (isset($presensi_waktu)) {
    $inputMajorsValue = $presensi_waktu['majors_short_name'];
	$inputDayValue = $presensi_waktu['day_name'];
	$inputMasukValue = $presensi_waktu['data_waktu_masuk'];
	$inputPulangValue = $presensi_waktu['data_waktu_pulang'];
} else {
    $inputMajorsValue = set_value('majors_short_name');
	$inputDayValue = set_value('day_name');
	$inputMasukValue = set_value('data_waktu_masuk');
	$inputPulangValue = set_value('data_waktu_pulang');
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
			<li><a href="<?php echo site_url('manage/presensi_waktu') ?>">Manage Data Libur Presensi</a></li>
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
    						<?php if (isset($presensi_waktu)) { ?>
    							<input type="hidden" name="data_waktu_id" value="<?php echo $presensi_waktu['data_waktu_id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Unit</label>
    							<input type="text" class="form-control" value="<?=$inputMajorsValue?>" disabled>
            				</div>
    						
    						<div class="form-group">
    							<label>Hari</label>
    							<input type="text" class="form-control" value="<?=$inputDayValue?>" disabled>
            				</div>
            				
    						<div class="form-group">
    							<label>Jam Masuk</label>
								<input type="time" name="data_waktu_masuk" class="form-control" placeholder="Jam Masuk" value="<?=$inputMasukValue?>">
    						</div>
    						
    						<div class="form-group">
    							<label>Jam Pulang</label>
								<input type="time" name="data_waktu_pulang" class="form-control" placeholder="Jam Pulang" value="<?=$inputPulangValue?>">
    						</div>
    						
    						<div class="form-group">
    							<button type="submit" class="btn btn-success">Simpan</button>
    							<a href="<?php echo site_url('manage/presensi_waktu'); ?>" class="btn btn-danger">Batal</a>
    						</div>
    						
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>