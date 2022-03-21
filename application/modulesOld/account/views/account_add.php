<?php

if (isset($account)) {

	$inputNameValue = $account['account_code'];
	$inputDescValue = $account['account_description'];
	$inputNoteValue = $account['account_note'];
	$inputCatValue = $account['account_category'];
	$inputMajorsValue = $account['account_majors_id'];
	
} else {
	$inputNameValue = set_value('account_code');
	$inputDescValue = set_value('account_description');
	$inputNoteValue = set_value('account_note');
	$inputCatValue = set_value('account_category');
	$inputMajorsValue = set_value('account_majors_id');
	
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
			<li><a href="<?php echo site_url('manage/account') ?>">Akun Biaya</a></li>
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
						<?php if (isset($account)) { ?>
						<input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
						<?php } ?>
						
						<div class="form-group">
							<label>Kode Akun <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="account_code" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Kode Akun">
						</div>

						<div class="form-group">
							<label>Keterangan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="account_description" type="text" class="form-control" value="<?php echo $inputDescValue ?>" placeholder="Keterangan">
						</div>

						<div class="form-group">
							<label>Jenis Akun <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="account_note" class="form-control">
        						    <option value="">-Pilih Jenis Akun-</option>
        						    <option value="1" <?php echo ($inputNoteValue == '1') ? 'selected' : '' ?>>Harta</option>
        						    <option value="2" <?php echo ($inputNoteValue == '2') ? 'selected' : '' ?>>Piutang</option>
        						    <option value="3" <?php echo ($inputNoteValue == '3') ? 'selected' : '' ?>>Inventaris</option>
        						    <option value="4" <?php echo ($inputNoteValue == '4') ? 'selected' : '' ?>>Hutang</option>
        						    <option value="5" <?php echo ($inputNoteValue == '5') ? 'selected' : '' ?>>Modal</option>
        						    <option value="6" <?php echo ($inputNoteValue == '6') ? 'selected' : '' ?>>Penerimaan</option>
        						    <option value="7" <?php echo ($inputNoteValue == '7') ? 'selected' : '' ?>>Biaya</option>
        						</select>
						</div>

						<div class="form-group">
							<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="account_category" class="form-control">
							    <option value="">-Pilih Kategori-</option>
							    <option value="1" <?php echo ($inputCatValue == '1') ? 'selected' : '' ?>>Pembayaran</option>
							    <option value="2" <?php echo ($inputCatValue == '2') ? 'selected' : '' ?>>Keuangan</option>
							    <option value="3" <?php echo ($inputCatValue == '3') ? 'selected' : '' ?>>Lainnya</option>
							</select>
						</div>

						<div class="form-group">
							<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="account_majors_id" class="form-control">
							    <option value="">-Pilih Unit Sekolah-</option>
							    <?php foreach($majors as $row){?>
							        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
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
						<a href="<?php echo site_url('manage/account'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($account['account_id'])) { ?>
						<a href="#delModal<?php echo $account['account_id']; ?>" data-toggle="modal" class="btn btn-block btn-danger">Hapus</a>
						<?php } ?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
	<?php if (isset($account['account_id'])) { ?>
	<div class="modal modal-default fade" id="delModal<?php echo $account['account_id']; ?>">
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
						<?php echo form_open('manage/account/delete/' . $account['account_id']); ?>
						<input type="hidden" name="delCode" value="<?php echo $account['account_code']; ?>">
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