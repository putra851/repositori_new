<?php

if (isset($presensi_area)) {
	$inputNameValue = $presensi_area['nama_pegawai'];
	$inputNipValue = $presensi_area['nip'];
	$inputStatusAbsenValue = $presensi_area['status_absen'];
	$inputStatusAbsenTempValue = $presensi_area['status_absen_temp'];
	$inputAreaAbsenValue = $presensi_area['area_absen'];
	$inputJarakRadiusValue = $presensi_area['jarak_radius'];
} else {
	$inputNameValue = set_value('nama_pegawai');
	$inputNipValue = set_value('nip');
	$inputStatusAbsenValue = set_value('status_absen');
	$inputStatusAbsenTempValue = set_value('status_absen_temp');
	$inputAreaAbsenValue = set_value('area_absen');
	$inputJarakRadiusValue = set_value('jarak_radius');
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
			<li><a href="<?php echo site_url('manage/presensi_area') ?>">Manage Area Presensi Pegawai</a></li>
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
    						<?php if (isset($presensi_area)) { ?>
    							<input type="hidden" name="employee_id" value="<?php echo $presensi_area['id_pegawai']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>NIP <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="employee_nip" type="text" class="form-control" value="<?php echo $inputNipValue ?>" placeholder="NIP Pegawai" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Nama lengkap <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="employee_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Nama lengkap" readonly="">
    						</div>
    						
    						<div class="form-group">
    							<label>Area Absen <small data-toggle="tooltip" title="Wajib diisi"></small></label>
								<select name="area_absen[]" id="area_absen" class="form-control s2" multiple="">
								    <option value=""> -- Pilih Area Absen -- </option>
									<?php
									foreach($area_absen as $aa):
										$ex_aa=explode(',',$inputAreaAbsenValue);
										$s="";
										foreach($ex_aa as $eaa):
											if($eaa==$aa['id_area']){
												$s="selected";
											}
										endforeach;

									?>
										<option value="<?php echo $aa['id_area']?>" <?php echo $s ?> > <?php echo $aa['nama_area']?> </option>
									<?php
									endforeach;
									?>
								</select>
    						</div>
    						
							<div class="form-group">
								<label>Status Absen <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<select name="status_absen" id="status_absen" class="form-control">
									<option value=""> -- Pilih Status Absen -- </option>
									<option value="Y" <?php echo ($inputStatusAbsenValue == 'Y') ? 'selected' : ''; ?>> Absen Sesuai Radius </option>
									<option value="N" <?php echo ($inputStatusAbsenValue == 'N') ? 'selected' : ''; ?>> Absen Bebas </option>
								</select>
							</div>
    						<div class="form-group">
    							<label>Jarak Radius Absen (Meter) <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="jarak_radius" type="number" class="form-control" value="<?php echo $inputJarakRadiusValue ?>" placeholder="Jarak Radius Absen (Meter)">
    						</div>
						<p class="text-muted">*) Kolom wajib diisi.</p>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/presensi_area'); ?>" class="btn btn-danger">Batal</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>