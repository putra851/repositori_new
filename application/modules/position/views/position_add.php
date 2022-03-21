<?php

if (isset($position)) {

	$inputNameValue = $position['position_code'];
	$inputDescValue = $position['position_name'];
	$inputMajorsValue = $position['position_majors_id'];
	
} else {
	$inputNameValue = set_value('position_code');
	$inputDescValue = set_value('position_name');
	$inputMajorsValue = set_value('position_majors_id');
	
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
			<li><a href="<?php echo site_url('manage/position') ?>"> Jabatan Pegawai</a></li>
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
						<?php if (isset($position)) { ?>
						<input type="hidden" name="position_id" value="<?php echo $position['position_id']; ?>">
						<?php } ?>
						
						<div class="form-group">
							<label>Kode Jabatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="position_code" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Kode Jabatan">
						</div>

						<div class="form-group">
							<label>Nama Jabatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="position_name" type="text" class="form-control" value="<?php echo $inputDescValue ?>" placeholder="Nama Jabatan">
						</div>

						<div class="form-group">
							<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="position_majors_id" class="form-control">
							    <option value="">-Pilih Unit Sekolah-</option>
							    <?php foreach($majors as $row){?>
							        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
							    <?php } ?>
							    <option value="99" <?php echo ($inputMajorsValue == '99') ? 'selected' : '' ?>>Lainnya</option>
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
						<a href="<?php echo site_url('manage/position'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($position['position_id'])) { ?>
						<a href="#delModal<?php echo $position['position_id']; ?>" data-toggle="modal" class="btn btn-block btn-danger">Hapus</a>
						<?php } ?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
	<?php if (isset($position['position_id'])) { ?>
	<div class="modal modal-default fade" id="delModal<?php echo $position['position_id']; ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
					</div>
					<div class="modal-body">
						<p>Apakah anda yakin akan menghapus data ini?</p>
					</div>
					<div class="modal-footer">
						<?php echo form_open('manage/position/delete/' . $position['position_id']); ?>
						<input type="hidden" name="delCode" value="<?php echo $position['position_name']; ?>">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
						<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<?php } ?>
	</div>