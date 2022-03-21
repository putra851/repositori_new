<?php

if (isset($debit)) {
    $inputKasValue = $debit['accDesc'];
    $inputNorefValue = $debit['debit_kas_noref'];
	$inputDateValue = $debit['debit_date'];
	$inputValue = $debit['debit_value'];
	$inputDescValue = $debit['debit_desc'];
	$inputAccountValue = $debit['account_id'];
	$inputTaxValue = $debit['tax_id'];
	$inputItemValue = $debit['item_id'];
	$inputMajorsValue = $m;
} else {
    $inputKasValue = set_value('accDesc');
    $inputNorefValue = set_value('debit_kas_noref');
	$inputDateValue = set_value('debit_date');
	$inputValue = set_value('debit_value');
	$inputDescValue = set_value('debit_desc');
	$inputAccountValue = set_value('account_id');
	$inputTaxValue = set_value('tax_id');
	$inputItemValue = set_value('item_id');
	$inputAccountValue = set_value('majors_id');
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
			<li><a href="<?php echo site_url('manage/debit') ?>">Kas Masuk</a></li>
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
						<?php if (isset($debit)) { ?>
						<input type="hidden" name="debit_id" value="<?php echo $debit['debit_id']; ?>">
						<?php } ?>
						
						<div class="form-group">
							<label>Kas *</label>
							<input type="text" class="form-control" name="debit_kas" value="<?php echo '['.$inputKasValue.']' ?>" placeholder="kas" readonly="">
						</div>
						
						<div class="form-group">
							<label>No. Referensi *</label>
							<input type="text" class="form-control" name="debit_noref" value="<?php echo $inputNorefValue ?>" placeholder="No. Referensi" readonly="">
						</div>
						
						<div class="form-group">
							<label>Tanggal </label>
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" type="text" name="debit_date" readonly="readonly" placeholder="Tanggal Kas Masuk" value="<?php echo $inputDateValue; ?>">
							</div>
						</div>
						
						<div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input type="text" class="form-control" name="debit_majors_id" value="<?php foreach($majors as $row){ echo ($inputMajorsValue == $row['majors_id']) ? $row['majors_short_name'] : ''; } ?>" placeholder="Unit Sekolah" readonly="">
							<input type="hidden" class="form-control" name="majors_id" value="<?php echo $inputMajorsValue ?>" readonly="">
						</div>
						
						<div class="form-group">
						<div id="div_kode">
							<label>Kode Akun <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="debit_account_id" class="form-control">
							    <option value="">-Pilih Kode Akun-</option>
							    <?php foreach($account as $row){?>
							        <option value="<?php echo $row['account_id']; ?>" <?php echo ($inputAccountValue == $row['account_id']) ? 'selected' : '' ?>><?php echo $row['account_code'].' - '.$row['account_description'] ?></option>
							    <?php } ?>
							</select>
						</div>
						</div>

						<div class="form-group">
							<label>Keterangan *</label>
							<input type="text" class="form-control" name="debit_desc" value="<?php echo $inputDescValue ?>" placeholder="Keterangan Kas Masuk">
						</div>

						<div class="form-group">
							<label>Nominal (Rp) *</label>
							<input type="text" class="form-control" name="debit_value" value="<?php echo $inputValue ?>" placeholder="Jumlah">
						</div>
						
						<div class="form-group">
							<label>Pajak <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="debit_tax_id" class="form-control">
							    <option value="0" <?php echo ($inputTaxValue == '0') ? 'selected' : '' ?>>0 %</option>
							    <?php foreach($tax as $row){?>
							        <option value="<?php echo $row['tax_id']; ?>" <?php echo ($inputTaxValue == $row['tax_id']) ? 'selected' : '' ?>><?php echo $row['tax_number'] ?> %</option>
							    <?php } ?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Unit POS <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select required="" name="debit_item_id" class="form-control">
							    <option value="0" <?php echo ($inputItemValue == '0') ? 'selected' : '' ?>>Tidak Ada</option>
							    <?php foreach($item as $row){?>
							        <option value="<?php echo $row['item_id']; ?>" <?php echo ($inputItemValue == $row['item_id']) ? 'selected' : '' ?>><?php echo $row['item_name'] ?></option>
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
						<a href="<?php echo site_url('manage/debit'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
		<!-- /.row -->
	</section>
</div>

<script>
    function get_kode(){
        
	    var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/debit/cari_kode',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_kode").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>