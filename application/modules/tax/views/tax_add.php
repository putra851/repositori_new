<?php

if (isset($tax)) {

	$inputTaxValue = $tax['tax_name'];
	$inputShortValue = $tax['tax_number'];
	
} else {
	
	$inputTaxValue = set_value('tax_name');
	$inputShortValue = set_value('tax_number');
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
			<li><a href="<?php echo site_url('manage/tax') ?>">Pajak</a></li>
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
						<?php if (isset($tax)) { ?>
						<input type="hidden" name="tax_id" value="<?php echo $tax['tax_id']; ?>">
						<?php } ?>
						

						<div class="form-group">
							<label>Nama Pajak <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="tax_name" type="text" class="form-control" value="<?php echo $inputTaxValue ?>" placeholder="Isi Nama Pajak">
						</div>

						<div class="form-group">
							<label>Singkatan Pajak <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="tax_number" type="text" class="form-control" value="<?php echo $inputShortValue ?>" placeholder="Isi Singkatan Pajak">
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
						<a href="<?php echo site_url('manage/tax'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>