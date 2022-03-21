

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

				<div class="col-sm-6">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Informasi Hutang</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $settinghutang['poshutang_name'].' - T.A '.$settinghutang['period_start'].'/'.$settinghutang['period_end'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $settinghutang['period_start'].'/'.$settinghutang['period_end'] ?>" readonly="">
								</div>
							</div>					  

						</div>
					</div>

				</div>
				<div class="col-md-6">

					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title">Hutang kepada Kreditur</h3>
						</div>
						<div class="box-body table-responsive">

							<table class="table">
								<tbody>
								    <tr>
										<td><strong>No. Ref Hutang</strong></td>
										<?php foreach ($hutang as $row) { ?>
										<td><input type="text" name="hutang_noref" id="hutang_noref" readonly="" class="form-control" value="<?php echo $row['hutang_noref'] ?>">
										</td>
										<?php } ?>
									</tr>
									<tr>
										<td><strong>Nama Kreditur</strong></td>
										<?php foreach ($hutang as $row) { ?>
										<td><input type="text" class="form-control" value="<?php echo $row['employee_name'] ?>" readonly>
										</td>
										<?php } ?>
									</tr>
									<tr>
										<td><strong>Posisi</strong></td>
										<?php foreach ($hutang as $row) { ?>
										<td><input type="text" class="form-control" value="<?php echo $row['position_name'] ?>" readonly>
										</td>
										<?php } ?>
									</tr>
									<tr>
										<td><strong>Tarif (Rp.)</strong></td>
										<?php foreach ($hutang as $row) { ?>
										<td><input autofocus="" type="text" id="hutang_bill" name="hutang_bill" placeholder="Masukan Tarif" value="<?php echo $row['hutang_bill'] ?>" class="form-control" onchange="count_hutang()">
										</td>
										<?php } ?>
									</tr>
									<tr>
										<td><strong>Dicicil (berapa kali)</strong></td>
										<td><input type="text" name="cicil" id="cicil" placeholder="Masukan Jumlah Hutang" value="<?php echo $row['hutang_cicil'] ?>" required="" class="form-control" onkeyup="count_hutang()">
										</td>
									</tr>
									<tr>
										<td><strong>Nominal per Cicilan (Rp.)</strong></td>
										<td><input type="text" name="hutang_pay_bill" id="hutang_pay_bill" placeholder="Masukan Jumlah Hutang" value="<?php echo $row['hutang_pay_bill'] ?>" readonly="" class="form-control">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/settinghutang/view_hutang/'. $settinghutang['settinghutang_id']) ?>" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</div>					
				<?php echo form_close(); ?>
			</div>
		</div>		
	</section>
</div>

<script>
    function get_employee(){
    	var id_position = $('#position_id').val();
    	
    	$.ajax({
            url: '<?php echo base_url(); ?>manage/settinghutang/get_people',
            type: 'POST',
            data: {
                    'id_position' : id_position,
                },
            success: function(msg){
                $("#show_employee").html(msg);        
            },
            error: function(msg){
                alert('msg');
            }
        });
        
    }
    
    function count_hutang(){
        
        var hutang_bill     = $('#hutang_bill').val();
        var cicil           = $('#cicil').val();
        
        if(hutang_bill != '' && cicil != ''){
            if(cicil != '0'){
                var hutang_pay_bill = hutang_bill/cicil;
                $('#hutang_pay_bill').val(hutang_pay_bill);
            }
        }
    }
    
</script>