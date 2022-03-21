<?php

if (isset($bulan)) {

	$inputClassValue = $bulan['class_id'];
	$inputBillValue = $bulan['bulan_bill'];
} else {
	$inputClassValue = set_value('class_class_id');
	$inputBillValue = set_value('bulan_bill');

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
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="box-body">
				<?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>
				<?php echo validation_errors(); ?>
				<?php if (isset($bulan)) { ?>
				<input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
				<?php } ?>

				<div class="col-md-5">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Pilih Kelas</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $payment['pos_name'].' - T.A '.$payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo ($payment['payment_type']=='BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
								</div>
							</div>						  
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Kelas</label>
								<div class="col-sm-8">
									<select name="class_id" class="form-control" required="">
										<option value="">---Pilih Kelas---</option>
										<?php foreach ($class as $row): ?> 
											<option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title">Update Tarif</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Tarif Bulanan Lama (Rp.)</label>
								<div class="col-sm-8">
									<input type="text" placeholder="Nominal Tarif Lama" name="tarif_lama" class="form-control" required>
									<br>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Tarif Bulanan Baru (Rp.)</label>
								<div class="col-sm-8">
									<input type="text" placeholder="Nominal Tarif Baru" name="bulan_bill" class="form-control" required>
									<br>
								</div>
								<label for="" class="col-sm-4 control-label">Untuk Bulan <input type="checkbox" id="selectall" value="checkbox" name="checkbox">
								</label>
								<div class="col-sm-8">
								    <div class="checkbox">
								    <?php foreach($month as $row){ ?>
								    <label><input type="checkbox" class="checkbox" name="bln[]" value="<?php echo $row['month_id']; ?>"><?php echo $row['month_name']; ?></label>
									<br>
									<?php } ?>
									</div>
								</div>
								<div class="col-sm-12">
								    <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								        1) Tarif yang diubah adalah tarif dengan tarif lama sesuai inputan dan bulan yang dipilih</h5>
									<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									    2) Tarif yang sudah dibayar tidak akan berubah</h5>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/payment/view_bulan/'. $payment['payment_id']) ?>" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</div>					
				<?php echo form_close(); ?>
			</div>
		</div>	
	</section>
</div>

<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>