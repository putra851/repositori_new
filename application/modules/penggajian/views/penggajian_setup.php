<?php

if (isset($employee)) {
    $inputAccountValue          = $employee['akun_account_id'];
	$inputNipValue              = $employee['employee_nip'];
	$inputNameValue             = $employee['employee_name'];
	$inputMajorsValue           = $employee['majors_short_name'];
	$inputPositionValue         = $employee['position_name'];
	$inputPokokValue            = $employee['premier_pokok'];
	$inputLainValue             = $employee['premier_lain'];
	$inputSimpananValue         = $employee['potongan_simpanan'];
	$inputBPJSTKValue           = $employee['potongan_bpjstk'];
	$inputSumbanganValue        = $employee['potongan_sumbangan'];
	$inputKoperasiValue         = $employee['potongan_koperasi'];
	$inputBPJSValue             = $employee['potongan_bpjs'];
	$inputPinjamanValue         = $employee['potongan_pinjaman'];
	$inputPotonganLainValue     = $employee['potongan_lain'];
	
} else {
    $inputAccountValue          = set_value('akun_account_id');
	$inputNipValue              = set_value('employee_nip');
	$inputNameValue             = set_value('employee_name');
	$inputMajorsValue           = set_value('majors_short_name');
	$inputPositionValue         = set_value('position_name');
	$inputPokokValue            = set_value('premier_pokok');
	$inputLainValue             = set_value('premier_lain');
	$inputSimpananValue         = set_value('potongan_simpanan');
	$inputBPJSTKValue           = set_value('potongan_bpjstk');
	$inputSumbanganValue        = set_value('potongan_sumbangan');
	$inputKoperasiValue         = set_value('potongan_koperasi');
	$inputBPJSValue             = set_value('potongan_bpjs');
	$inputPinjamanValue         = set_value('potongan_pinjaman');
	$inputPotonganLainValue     = set_value('potongan_lain');
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
			<li><a href="<?php echo site_url('manage/penggajian') ?>">Manage Penggajian</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<!-- Main content -->
	<section class="content">
	    <div class="row">
			<div class="col-md-9">
    	        <div class="box">
				<table class="table">
    	               <tr>
    	                   <td width="200">Unit</td>
    	                   <td width="4">:</td>
    	                   <td><?php echo $inputMajorsValue ?></td>
    	               </tr>
    	               <tr>
    	                   <td>NIP</td>
    	                   <td>:</td>
    	                   <td><?php echo $inputNipValue ?></td>
    	               </tr>
    	               <tr>
    	                   <td>Nama</td>
    	                   <td>:</td>
    	                   <td><?php echo $inputNameValue ?></td>
    	               </tr>
    	               <tr>
    	                   <td>Jabatan</td>
    	                   <td>:</td>
    	                   <td><?php echo $inputPositionValue ?></td>
    	               </tr>
    	           </table>
    	        </div>
	        </div>
	    </div>
		<?php echo form_open_multipart(current_url()); ?>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-9">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
					    		    
					    <div class="form-group">
    					    <div class="row">
    					    <div class="col-md-3">
    						<label>Akun Gaji<small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						</div>
    					    <div class="col-md-1"><label> = </label></div>
    					    <div class="col-md-4">
    					    <select required="" name="gaji_account_id" class="form-control">
        							    <option value="">-Pilih Kode Akun-</option>
        							    <?php foreach($account as $row){?>
        							        <option value="<?php echo $row['account_id']; ?>" <?php echo ($inputAccountValue == $row['account_id']) ? 'selected' : '' ?>><?php echo $row['account_code'].' - '.$row['account_description'] ?></option>
        							    <?php } ?>
        					</select>
    					    </div>
    					    <div class="col-md-1">
    					    </div>
    					    </div>
    					</div>
    					
					    <div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Gaji</a></li>
								<li><a href="#tab_2" data-toggle="tab">Potongan</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
								    
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						    <label>Gaji Pokok <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                					    </div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                					        <input name="premier_pokok" type="text" class="form-control" value="<?php echo $inputPokokValue ?>" required="" placeholder="Gaji Pokok">
                					    </div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Gaji Lain-lain <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="premier_lain" type="text" class="form-control" value="<?php echo $inputLainValue ?>" required="" placeholder="Gaji Lain-lain">
                						</div>
                					    </div>
                					</div>
                					
								</div>
								
								<div class="tab-pane" id="tab_2">
								    
								    <div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Simpanan Wajib & Pengajian <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_simpanan" type="text" class="form-control" value="<?php echo $inputSimpananValue ?>" required="" placeholder="Simpanan Wajib & Pengajian">
                						</div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>BPJS Tenaga Kerja <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_bpjstk" type="text" class="form-control" value="<?php echo $inputBPJSTKValue ?>" required="" placeholder="BPJS Tenaga Kerja">
                						</div>
                					    </div>
                					</div>
								    
								    <div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Sumbangan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_sumbangan" type="text" class="form-control" value="<?php echo $inputSumbanganValue ?>" required="" placeholder="Sumbangan">
                						</div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Belanja Koperasi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_koperasi" type="text" class="form-control" value="<?php echo $inputKoperasiValue ?>" required="" placeholder="Belanja Koperasi">
                						</div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>BPJS <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_bpjs" type="text" class="form-control" value="<?php echo $inputBPJSValue ?>" required="" placeholder="BPJS">
                						</div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Pinjaman <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_pinjaman" type="text" class="form-control" value="<?php echo $inputPinjamanValue ?>" required="" placeholder="Pinjaman">
                						</div>
                					    </div>
                					</div>
                
                					<div class="form-group">
                					    <div class="row">
                					    <div class="col-md-3">
                						<label>Lain-lain <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						</div>
                					    <div class="col-md-1"><label> = </label></div>
                					    <div class="col-md-4">
                						<input name="potongan_lain" type="text" class="form-control" value="<?php echo $inputPotonganLainValue ?>" required="" placeholder="Lain-lain">
                						</div>
                					    </div>
                					</div>
								    
								</div>
							</div>
						</div>
    					<?php if (isset($employee)) { ?>
    						<input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
    					<?php } ?>
    
						<p class="text-muted">*) Kolom wajib diisi.</p>
                	    <button type="submit" class="btn btn-md btn-success">Simpan</button>
                	    <a href="<?php echo site_url('manage/penggajian')?>" type="button" class="btn btn-md btn-info">Kembali</a>
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

	function getId(id) {
		$('#studentId').val(id)
	}
</script>