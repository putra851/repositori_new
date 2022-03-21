<?php

if (isset($poshutang)) {

	$inputNameValue = $poshutang['poshutang_name'];
	$inputDescValue = $poshutang['poshutang_description'];
	$inputAccountValue = $poshutang['account_id'];
	
} else {
	$inputNameValue = set_value('poshutang_name');
	$inputDescValue = set_value('poshutang_description');
	$inputAccountValue = set_value('account_id');
	
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
			<li><a href="<?php echo site_url('manage/poshutang') ?>">Pos Bayar</a></li>
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
						<?php if (isset($poshutang)) { ?>
						<input type="hidden" name="poshutang_id" value="<?php echo $poshutang['poshutang_id']; ?>">
						<?php } ?>
						
						<div class="form-group">
							<label>Kode Akun <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="poshutang_account_id" class="form-control">
							    <option value="">-Pilih Kode Akun-</option>
							    <?php foreach($account as $row){?>
							        <option value="<?php echo $row['account_id']; ?>" <?php echo ($inputAccountValue == $row['account_id']) ? 'selected' : '' ?>><?php echo $row['account_code'].' - '.$row['account_description'] ?></option>
							    <?php } ?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Nama POS Hutang <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="poshutang_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="POS Bayar">
						</div>

						<div class="form-group">
							<label>Keterangan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="poshutang_description" type="text" class="form-control" value="<?php echo $inputDescValue ?>" placeholder="Keterangan">
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
						<a href="<?php echo site_url('manage/poshutang'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($poshutang['poshutang_id'])) { ?>
						<a href="#delModal<?php echo $poshutang['poshutang_id']; ?>" data-toggle="modal" class="btn btn-block btn-danger">Hapus</a>
						<?php } ?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
	<?php if (isset($poshutang['poshutang_id'])) { ?>
	<div class="modal modal-default fade" id="delModal<?php echo $poshutang['poshutang_id']; ?>">
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
						<?php echo form_open('manage/poshutang/delete/' . $poshutang['poshutang_id']); ?>
						<input type="hidden" name="delName" value="<?php echo $poshutang['poshutang_name']; ?>">
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