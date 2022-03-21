<?php

if (isset($presensi_data_libur)) {
	$inputNameValue = $presensi_data_libur['hari'];
	$inputRemarkValue = $presensi_data_libur['keterangan'];
} else {
	$inputNameValue = set_value('hari');
	$inputRemarkValue = set_value('keterangan');
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
			<li><a href="<?php echo site_url('manage/presensi_data_libur') ?>">Manage Data Libur Presensi</a></li>
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
    						<?php if (isset($presensi_data_libur)) { ?>
    							<input type="hidden" name="id" value="<?php echo $presensi_data_libur['id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Hari <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<select name="hari" id="hari" class="form-control s2">
									<option value="">--Pilih Hari--</option>
									<?php
									foreach($day as $d):
									?>
									<option value="<?=$d['day_name']?>" <?php if($inputNameValue==$d['day_name']) echo "selected";?>><?=$d['day_name']?></option>
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
							<a href="<?php echo site_url('manage/presensi_data_libur'); ?>" class="btn btn-danger">Batal</a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>