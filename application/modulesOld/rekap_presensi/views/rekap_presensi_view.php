<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/rekap_presensi') ?>">Rekap Presensi Di Web</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<!-- /.box-header -->
					<div class="box-body">
    						<?php echo validation_errors(); ?>
    						<?php if (isset($rekap_presensi)) { ?>
    							<input type="hidden" name="id" value="<?php echo $rekap_presensi['id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>Pegawai </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['nama_pegawai'] ?>" placeholder="Pegawai" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Jenis Absen </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['jenis_absen'] ?>" placeholder="Jenis Absen" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Area Absen </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['area_absen_nama'] ?>" placeholder="Area Absen" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Tanggal </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['tanggal'] ?>" placeholder="Tanggal" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Time </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['time'] ?>" placeholder="Time" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Jam </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['jam'] ?>" placeholder="Jam" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Longi </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['longi'] ?>" placeholder="Longi" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Lati </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['lati'] ?>" placeholder="Lati" readonly="">
    						</div> 
    						<div class="form-group">
    							<label>Lokasi </label>
    							<input type="text" class="form-control" value="<?php echo $rekap_presensi['lokasi'] ?>" placeholder="Lokasi" readonly="">
    						</div>  
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary">
						<!-- /.box-header -->
						<div class="box-body">
								<?php echo validation_errors(); ?>
								
								<div class="form-group">
									<label>Catatan Absen </label>
									<textarea class="form-control" readonly="" placeholder="Catatan Absen"><?=$rekap_presensi['catatan_absen']?></textarea>
								</div> 
								<div class="form-group">
									<label>Remark </label>
									<textarea class="form-control" readonly="" placeholder="Remark"><?=$rekap_presensi['remark']?></textarea>
								</div> 
								<div class="form-group">
									<label>Created By </label>
									<input type="text" class="form-control" value="<?php echo $rekap_presensi['created_by'] ?>" placeholder="Created By" readonly="">
								</div> 
								<div class="form-group">
									<label>Created Date </label>
									<input type="text" class="form-control" value="<?php echo $rekap_presensi['created_date'] ?>" placeholder="Created Date" readonly="">
								</div> 
								<div class="form-group">
									<label>Updated By </label>
									<input type="text" class="form-control" value="<?php echo $rekap_presensi['updated_by'] ?>" placeholder="Updated By" readonly="">
								</div> 
								<div class="form-group">
									<label>Updated Date </label>
									<input type="text" class="form-control" value="<?php echo $rekap_presensi['updated_date'] ?>" placeholder="Updated Date" readonly="">
								</div> 
							<div class="form-group text-right">
								<a href="<?php echo site_url('manage/rekap_presensi'); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>&nbsp;Kembali</a>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
			<?php echo form_close(); ?>
			<!-- /.row -->
	</section>
</div>