<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
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

	<!-- Main content -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
							<br>
							<div class="row">
								<div class="col-md-2">
									<?php if (!empty($student['student_img'])) { ?>
									<img src="<?php echo upload_url('student/'.$student['student_img']) ?>" class="img-responsive avatar">
									<?php } else { ?>
									<img src="<?php echo media_url('img/user.png') ?>" class="img-responsive avatar">
									<?php } ?>
								</div>
								<div class="col-md-10">
									<table class="table table-hover">
										<tbody>
											<tr>
												<td>NIS Siswa</td>
												<td>:</td>
												<td><?php echo $student['student_nis'] ?></td>
											</tr>
											<tr>
												<td>NISN Siswa</td>
												<td>:</td>
												<td><?php echo $student['student_nisn'] ?></td>
											</tr>
											<tr>
												<td>Nama lengkap</td>
												<td>:</td>
												<td><?php echo $student['student_full_name'] ?></td>
											</tr>
											<tr>
												<td>Jenis Kelamin</td>
												<td>:</td>
												<td><?php echo ($student['student_gender']=='L')? 'Laki-laki' : 'Perempuan' ?></td>
											</tr>
											<tr>
												<td>Tempat, Tanggal Lahir</td>
												<td>:</td>
												<td><?php echo $student['student_born_place'].', '. pretty_date($student['student_born_date'],'d F Y',false) ?></td>
											</tr>
											<tr>
												<td>Hobi</td>
												<td>:</td>
												<td><?php echo $student['student_hobby'] ?></td>
											</tr>
											<tr>
												<td>No. Handphone</td>
												<td>:</td>
												<td><?php echo $student['student_phone'] ?></td>
											</tr>
											<tr>
												<td>Alamat</td>
												<td>:</td>
												<td><?php echo $student['student_address'] ?></td>
											</tr>
											<tr>
												<td>Nama Ibu Kandung</td>
												<td>:</td>
												<td><?php echo $student['student_name_of_mother'] ?></td>
											</tr>
											<tr>
												<td>Nama Ayah Kandung</td>
												<td>:</td>
												<td><?php echo $student['student_name_of_father'] ?></td>
											</tr>
											<tr>
												<td>No. Handphone Orang Tua</td>
												<td>:</td>
												<td><?php echo $student['student_parent_phone'] ?></td>
											</tr>
											<tr>
												<td>Unit Sekolah</td>
												<td>:</td>
												<td><?php echo $student['majors_short_name'].' ('.$student['majors_name'].')' ?></td>
											</tr>
											<tr>
												<td>Kelas</td>
												<td>:</td>
												<td><?php echo $student['class_name'] ?></td>
											</tr>
											<tr>
												<td>Kamar</td>
												<td>:</td>
												<td><?php echo $student['madin_name'] ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-4">
									<a href="<?php echo site_url('manage/student') ?>" class="btn btn-default">
										<i class="fa fa-arrow-circle-o-left"></i> Kembali
									</a>
									<?php if ($this->session->userdata('uroleid') == SUPERUSER) { ?>
									<a href="<?php echo site_url('manage/student/edit/' . $student['student_id']) ?>" class="btn btn-success">
										<i class="fa fa-edit"></i> Edit
									</a>
									<a href="#delModal<?php echo $student['student_id']; ?>" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i> Hapus</a>
									<?php } ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
				<!-- /.row -->
				<div class="modal modal-default fade" id="delModal<?php echo $student['student_id']; ?>">
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
									<?php echo form_open('manage/student/delete/' . $student['student_id']); ?>
									<input type="hidden" name="delName" value="<?php echo $student['student_full_name']; ?>">
									<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
									<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
									<?php echo form_close(); ?>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>

				</section>
				
	
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-12 col-sm-12 col-xs-12">
					    <h3>Data Mahram</h3>
					    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addMahram<?php echo $student['student_id']; ?>"><i class="fa fa-plus"></i> Tambah Mahram</button>
							<table class="table table-bordered table-hover">
							    <thead>
							        <tr>
    							        <th>No</th>
    							        <th>Nama</th>
    							        <th>Hubungan</th>
    							        <th>Aksi</th>
							        </tr>
							    </thead>
							    <tbody>
							    <?php 
						            $no = 1;
						            foreach($guest as $row){
						        ?>
							        <tr>
    							        <td>
    							            <?php echo $no++ ?>
    							        </td>
    							        <td>
    							            <?php echo $row['guest_name'] ?>
    							        </td>
    							        <td>
    							            <?php echo $row['mahram_note'] ?>
    							        </td>
    							        <td>
    							            <a href="#delMahram<?php echo $row['guest_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
    							        </td>
                                    </tr>
                                    <div class="modal modal-default fade" id="delMahram<?php echo $row['guest_id']; ?>">
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
															<?php echo form_open('manage/student/delete_mahram/' . $row['guest_id']); ?>
															<input type="hidden" name="student_id" value="<?php echo $row['guest_student_id']; ?>">
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
															<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
															<?php echo form_close(); ?>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
                                <?php
						            }
                                ?>
							    </tbody>
							</table>
						</div>
					   </div>
				</div>
		    </div>
        </div>
	</section>
			</div>
			
<div class="modal fade" id="addMahram<?php echo $student['student_id'] ?>" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Tambah Data Mahram</h4>
			</div>
			<?php echo form_open('manage/student/add_mahram', array('method'=>'post')); ?>
			<div class="modal-body">
			    <input type="hidden" class="form-control" required="" name="student_id" value="<?php echo $student['student_id'] ?>">
				<div id="p_scents_family">
				    <div class="row">
					<div class="col-md-6">
						<label>Nama Mahram *</label>
							<input class="form-control" required="" type="text" name="guest_name[]" placeholder="Masukkan Nama Mahram">
					</div>
					<div class="col-md-4">
						<label>Hubungan dengan Santri*</label>
							<select class="form-control" required="" name="guest_mahram_id[]">
							    <option value="">-Pilih Hubungan-</option>
							    <?php foreach ($mahram as $m) : ?>
							    <option value="<?php echo $m['mahram_id']?>"><?php echo $m['mahram_note']?></option>
							    <?php endforeach; ?>
						    </select>
					</div>
					</div>
				</div>
				<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_family"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
				<span>*) Wajib Diisi</span>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>



	<script>
		$(function() {
			var scntDiv = $('#p_scents_family');
			var i = $('#p_scents_family p').size() + 1;

			$("#addScnt_family").click(function() {
				$('<div class="row"><div class="col-md-6"><label>Nama Mahram *</label><input class="form-control" required="" type="text" name="guest_name[]" placeholder="Masukkan Nama Mahram"></div><div class="col-md-4"><label>Hubungan dengan Santri*</label><select class="form-control" required="" name="guest_mahram_id[]"><option value="">-Pilih Hubungan-</option><?php foreach ($mahram as $m) : ?><option value="<?php echo $m['mahram_id']?>"><?php echo $m['mahram_note']?></option><?php endforeach; ?></select></div></div>').appendTo(scntDiv);
				i++;
				return false;
			});

			$(document).on("click", ".remScnt_family", function() {
				if (i > 2) {
					$(this).parents('p').remove();
					i--;
				}
				return false;
			});
		});
	</script>