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
			<li><a href="<?php echo site_url('manage/presensi_khusus') ?>">Manage Presensi Khusus</a></li>
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
    							<label>Tanggal <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="tanggal" type="date" class="form-control date" value="<?php echo $inputTanggalValue ?>" placeholder="Tanggal">
    						</div> 
    						<div class="form-group">
    							<label>Pegawai <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<select name="id_pegawai" class="form-control s2">
									<option value="">--Pilih Pegawai--</option>
									<?php
									foreach($id_pegawai as $ip):
									?>
									<option value="<?=$ip['employee_id']?>" <?php if($ip['employee_id']==$inputIdegawaiValue) echo 'selected'; ?> ><?=$ip['employee_name']?></option>
									<?php
									endforeach;
									?>
								</select>
    						</div>
    						<div class="form-group">
    							<label>Lokasi Absen <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<select name="lokasi_absen" class="form-control s2">
									<option value="">--Pilih Lokasi Absen--</option>
									<?php
									foreach($lokasi_absen as $la):
									?>
									<option value="<?=$la['id_area']?>" <?php if($la['id_area']==$inputLokasiabsenValue) echo 'selected'; ?> ><?=$la['nama_area']?></option>
									<?php
									endforeach;
									?>
								</select>
    						</div>
    						<div class="form-group">
    							<label>Keterangan</label>
								<textarea name="remark" class="form-control" placeholder="Keterangan"><?=$inputRemarkValue?></textarea>
    						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/presensi_khusus'); ?>" class="btn btn-danger">Batal</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>