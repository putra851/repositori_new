<?php

if (isset($employee)) {

	$inputNameValue = $employee['employee_name'];
	$inputPositionValue = $employee['employee_position_id'];
	$inputMajorValue = $employee['employee_majors_id'];
	$inputNipValue = $employee['employee_nip'];
	$inputStrataValue = $employee['employee_strata'];
	$inputPlaceValue = $employee['employee_born_place'];
	$inputDateValue = $employee['employee_born_date'];
	$inputPhoneValue = $employee['employee_phone'];
	$inputStartValue = $employee['employee_start'];
	$inputEndValue = $employee['employee_end'];
	$inputAddressValue = $employee['employee_address'];
	$inputGenderValue = $employee['employee_gender'];
	$inputEmailValue = $employee['employee_email'];
	$inputStatusValue = $employee['employee_status'];
	$inputCategoryValue = $employee['employee_category'];
} else {
	$inputNameValue = set_value('employee_name');
	$inputPositionValue = set_value('employee_position_id');
	$inputMajorValue = set_value('employee_majors_id');
	$inputNipValue = set_value('employee_nip');
	$inputStrataValue = set_value('employee_strata');
	$inputPlaceValue = set_value('employee_born_place');
	$inputDateValue = set_value('employee_born_date');
	$inputPhoneValue = set_value('employee_phone');
	$inputStartValue = set_value('employee_start');
	$inputEndValue = set_value('employee_end');
	$inputAddressValue = set_value('employee_address');
	$inputGenderValue = set_value('employee_gender');
	$inputEmailValue = set_value('employee_email');
	$inputStatusValue = set_value('employee_status');
	$inputCategoryValue = set_value('employee_category');
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
			<li><a href="<?php echo site_url('manage/employees') ?>">Manage employees</a></li>
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
    						<?php if (isset($employee)) { ?>
    							<input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
    						<?php } ?>
    						
    						<div class="form-group">
    							<label>NIP <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="employee_nip" type="text" class="form-control" value="<?php echo $inputNipValue ?>" placeholder="NIP Pegawai">
    						</div> 
    						<div class="form-group">
    							<label>Nama lengkap <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    							<input name="employee_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Nama lengkap">
    						</div>
    						<div class="form-group">
    							<label>Jenis Kelamin</label>
    							<div class="radio">
    								<label>
    									<input type="radio" name="employee_gender" value="L" <?php echo ($inputGenderValue == 'L') ? 'checked' : ''; ?>> Laki-laki
    								</label>&nbsp;&nbsp;
    								<label>
    									<input type="radio" name="employee_gender" value="P" <?php echo ($inputGenderValue == 'P') ? 'checked' : ''; ?>> Perempuan
    								</label>
    							</div>
    						</div>
    
    						<div class="form-group">
    							<label>Tempat Lahir</label>
    							<input name="employee_born_place" type="text" class="form-control" value="<?php echo $inputPlaceValue ?>" placeholder="Tempat Lahir">
    						</div>
    
    						<div class="form-group">
    							<label>Tanggal Lahir </label>
    							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    								<input class="form-control" type="text" name="employee_born_date" readonly="readonly" placeholder="Tanggal" value="<?php echo $inputDateValue; ?>">
    							</div>
    						</div>
    						
    						<div class="form-group">
    							<label>Pendidikan Terakhir <small data-toggle="tooltip" title="Wajib diisi"></small></label>
								<select name="employee_strata" id="employee_strata" class="form-control">
								    <option value=""> -- Pilih Strata -- </option>
									<option value="SMA" <?php echo ($inputStrataValue == 'SMA') ? 'selected' : '' ?> > SMA </option>
									<option value="SMK"<?php echo ($inputStrataValue == 'SMK') ? 'selected' : '' ?>> SMK </option>
									<option value="D1"<?php echo ($inputStrataValue == 'D1') ? 'selected' : '' ?>> D1 </option>
									<option value="D2"<?php echo ($inputStrataValue == 'D2') ? 'selected' : '' ?>> D2 </option>
									<option value="D3"<?php echo ($inputStrataValue == 'D3') ? 'selected' : '' ?>> D3 </option>
									<option value="D4"<?php echo ($inputStrataValue == 'D4') ? 'selected' : '' ?>> D4 </option>
									<option value="S1"<?php echo ($inputStrataValue == 'S1') ? 'selected' : '' ?>> S1 </option>
									<option value="S2"<?php echo ($inputStrataValue == 'S2') ? 'selected' : '' ?>> S2 </option>
									<option value="S3"<?php echo ($inputStrataValue == 'S3') ? 'selected' : '' ?>> S3 </option>
								</select>
    						</div>
    						
    							<div class="form-group">
    								<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    								<select name="employee_majors_id" id="employee_majors_id" class="form-control" onchange="get_position()">
    									<option value=""> -- Pilih Unit Sekolah -- </option>
    									<?php foreach ($majors as $row): ?>
    										<option value="<?php echo $row['majors_id'] ?>" <?php echo ($inputMajorValue == $row['majors_id']) ? 'selected' : '' ?> ><?php echo $row['majors_short_name'] ?></option>
    									<?php endforeach ?>
    								    <option value="99" <?php echo ($inputMajorValue == '99') ? 'selected' : '' ?>>Lainnya</option>
    								</select>
    							</div> 
    						<div id="div_position">
    							<div class="form-group"> 
    								<label>Jabatan *</label>
    								<select name="employee_position_id" id="employee_position_id" class="form-control">
    									<option value=""> -- Pilih Jabatan -- </option><?php foreach ($position as $row): ?>
    								<option value="<?php echo $row['position_id'] ?>" <?php echo ($inputPositionValue == $row['position_id']) ? 'selected' : '' ?> ><?php echo $row['position_name'] ?>
    								</option>
    									<?php endforeach ?>
    								</select>
    						    </div>
    						</div>
    						    <div class="form-group">
    								<label>Status Kepegawaian <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    								<select name="employee_category" id="employee_category" class="form-control">
    									<option value=""> -- Pilih Status Kepegawaian -- </option>
    									<option value="1" <?php echo ($inputCategoryValue == 1) ? 'selected' : ''; ?>> Pegawai Tetap </option>
    									<option value="2" <?php echo ($inputCategoryValue == 2) ? 'selected' : ''; ?>> Pegawai Tidak Tetap </option>
    								</select>
    							</div>
    						<div class="form-group">
    							<label>Alamat</label>
    							<textarea class="form-control" name="employee_address" placeholder="Alamat Tempat Tinggal"><?php echo $inputAddressValue ?></textarea>
    						</div>
    
    						<?php if (!isset($employee)) { ?>
    							<div class="form-group">
    								<label>Password <small data-toggle="tooltip" title="Wajib diisi">Defaul :  <font color="red">123456</font></small></label>
    								<input name="employee_password" type="password" class="form-control" placeholder="Password">
    							</div>            
    
    							<div class="form-group">
    								<label>Konfirmasi Password <small data-toggle="tooltip" title="Wajib diisi">Kosongi jika password kosong</small></label>
    								<input name="passconf" type="password" class="form-control" placeholder="Konfirmasi Password">
    							</div>       
    						<?php } ?>
    						
    						
    						<div class="form-group">
    							<label>Telpon/HP <small data-toggle="tooltip" title="Wajib diisi"></small></label>
    							<input name="employee_phone" type="text" class="form-control" value="<?php echo $inputPhoneValue ?>" placeholder="Telpon/HP Pegawai">
    						</div>
    						<div class="form-group">
    							<label>Email <small data-toggle="tooltip" title="Wajib diisi"></small></label>
    							<input name="employee_email" type="email" class="form-control" value="<?php echo $inputEmailValue ?>" placeholder="Email Pegawai">
    						</div>
    
    						<div class="form-group">
    							<label>Tanggal Masuk </label>
    							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    								<input class="form-control" type="text" name="employee_start" readonly="readonly" placeholder="Tanggal Masuk" value="<?php echo ($inputStartValue=='0000-00-00') ? '':$inputStartValue; ?>">
    							</div>
    						</div>
    
    						<div class="form-group">
    							<label>Tanggal Keluar <small>Kosongi jika masih aktif</small></label>
    							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    								<input class="form-control" type="text" name="employee_end" readonly="readonly" placeholder="Tanggal Keluar" value="<?php echo ($inputEndValue=='0000-00-00') ? '':$inputEndValue; ?>">
    							</div>
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
						<div class="form-group">
							<label>Status</label>
							<div class="radio">
								<label>
									<input type="radio" name="employee_status" value="1" <?php echo ($inputStatusValue == 1) ? 'checked' : ''; ?>> Aktif
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="employee_status" value="0" <?php echo ($inputStatusValue == 0) ? 'checked' : ''; ?>> Tidak Aktif
								</label>
							</div>
						</div>
						<label >Foto</label>
						<a href="#" class="thumbnail">
							<?php if (isset($employee['employee_photo']) != NULL) { ?>
								<img src="<?php echo upload_url('employee/' . $employee['employee_photo']) ?>" class="img-responsive avatar">
							<?php } else { ?>
								<img src="<?php echo media_url('img/missing.png') ?>" id="target" alt="Choose image to upload">
							<?php } ?>
						</a>
						<input type='file' id="employee_photo" name="employee_photo">
						<br>
						<button type="submit" class="btn btn-block btn-success">Simpan</button>
						<a href="<?php echo site_url('manage/employees'); ?>" class="btn btn-block btn-info">Batal</a>
						<?php if (isset($employee)) { ?>
							<button type="button" onclick="getId(<?php echo $employee['employee_id'] ?>)" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteEmployee">Hapus
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
</div>
<?php if (isset($employee)) { ?>
	<div class="modal fade" id="deleteEmployee">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Konfirmasi Hapus</h4>
				</div>
				<form action="<?php echo site_url('manage/employees/delete') ?>" method="POST">
					<div class="modal-body">
						<p>Apakah anda akan menghapus data ini?</p>
						<input type="hidden" name="employee_id" id="employeeId">
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

<script>

	function getId(id) {
		$('#employeeId').val(id)
	}
</script>

<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#target').attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#employee_photo").change(function() {
		readURL(this);
	});
	
	function get_position(){
	    var id_majors    = $("#employee_majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/employees/get_position',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_position").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}


</script>