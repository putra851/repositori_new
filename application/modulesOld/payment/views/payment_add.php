<?php

if (isset($payment)) {

	$inputTypeValue     = $payment['payment_type'];
	$inputModeValue     = $payment['payment_mode'];
	$inputPeriodValue   = $payment['period_period_id'];
	$inputPosValue      = $payment['pos_pos_id'];
	$inputMajorsValue   = $payment['majors_id'];

} else {
	$inputTypeValue     = set_value('payment_type');
	$inputModeValue     = set_value('payment_mode');
	$inputPeriodValue   = set_value('period_id');
	$inputPosValue      = set_value('pos_id');
	$inputMajorsValue   = set_value('majors_id');
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
			<li><a href="<?php echo site_url('manage/payment') ?>">Manage payment</a></li>
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
						<?php if (isset($payment)) { ?>
							<input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
						<?php } ?>

						<div class="form-group">
							<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="majors_id" id="majors_id" class="form-control" onchange="get_pos()">
								<option value="">-Pilih Unit-</option>
								<?php foreach ($majors as $row): ?> 
									<option value="<?php echo $row['majors_id']; ?>" <?php echo ($inputMajorsValue == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
                        <div id="div_pos">
						<div class="form-group">
							<label>POS <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="pos_id" class="form-control">
								<option value="">-Pilih POS-</option>
								<?php foreach ($pos as $row): ?> 
									<option value="<?php echo $row['pos_id']; ?>" <?php echo ($inputPosValue == $row['pos_id']) ? 'selected' : '' ?>><?php echo $row['pos_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						</div>

						<div class="form-group">
							<label>Tahun Ajaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="period_id" class="form-control">
								<option value="">-Pilih Tahun-</option>
								<?php foreach ($period as $row): ?> 
									<option value="<?php echo $row['period_id']; ?>" <?php echo ($inputPeriodValue == $row['period_id']) ? 'selected' : '' ?>><?php echo $row['period_start'].'/'.$row['period_end']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label>Tipe <small data-toggle="tooltip" title="Wajib diisi">*</small></label><br>
							<select name="payment_type" class="form-control" required="">
								<option value="">-Pilih Tipe-</option>
								<option value="BULAN" <?php echo ($inputTypeValue == 'BULAN') ? 'selected' : '' ?>>Bulanan</option>
								<option value="BEBAS" <?php echo ($inputTypeValue == 'BEBAS') ? 'selected' : '' ?>>Bebas</option>
							</select>
						</div>
						
						<?php if(isset($payment['payment_id'])) { ?>
                        <div id="div_mode">
						<div class="form-group">
							<label>Model Pembayaran<small data-toggle="tooltip" title="Wajib diisi">*</small></label><br>
							<select name="payment_mode" class="form-control" required="">
								<option value="">-Pilih Mode-</option>
								<option value="TETAP" <?php echo ($inputModeValue == 'TETAP') ? 'selected' : '' ?>>TETAP</option>
								<option value="TIDAK TETAP" <?php echo ($inputModeValue == 'TIDAK TETAP') ? 'selected' : '' ?>>TIDAK TETAP</option>
							</select>
						</div>
						</div>
                        <?php } ?>

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
						<a href="<?php echo site_url('manage/payment'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($payment['payment_id'])) { ?>
							<button type="button" onclick="getId(<?php echo $payment['payment_id'] ?>)" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deletePayment">Hapus
							</button>
						<?php } ?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
	<?php if (isset($payment['payment_id'])) { ?>
		<div class="modal fade" id="deletePayment">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Konfirmasi Hapus</h4>
					</div>
					<form action="<?php echo site_url('manage/payment/delete') ?>" method="POST">
						<div class="modal-body">
							<p>Apakah anda akan menghapus data ini?</p>
							<input type="hidden" name="payment_id" id="paymentId">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Hapus</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<script>

	function getId(id) {
		$('#paymentId').val(id)
	}
	
	function get_pos(){
	    var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/payment/get_pos',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_pos").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
	
	function get_mode(){
	    var type    = $("#payment_type").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/payment/get_mode',
            type: 'POST', 
            data: {
                    'type': type,
            },    
            success: function(msg) {
                    $("#div_mode").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
</script>