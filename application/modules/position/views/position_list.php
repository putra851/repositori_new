<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
			<small>List</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPosition"><i class="fa fa-plus"></i> Tambah</button>
						<br>
							<br>
							
					<div class="box-body table-responsive">
					<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
					<table>
					    <tr>
					        <td>     
							<select style="width: 200px;" id="m" name="m" class="form-control" required>
							    <option value="">--- Pilih Unit Sekolah ---</option>
							    <?php if($this->session->userdata('umajorsid') == '0') { ?>
							    <option value="all" <?php echo (isset($s['m']) && $s['m']=='all') ? 'selected' : '' ?> >Semua Unit</option>
							    <?php } ?>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						    <option value="99">Lainnya</option>
							</select>
					        </td>
					        <td>
					            &nbsp&nbsp
					        </td>
					        <td>
					        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
					        </td>
					    </tr>
					</table>
					<?php echo form_close(); ?>
					</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
					    <table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Kode Jabatan</th>
								<th>Nama Jabatan</th>
								<th>ID Jabatan</th>
								<th>Unit Sekolah</th>
								<th>ID Unit</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($position)) {
									$i = 1;
									foreach ($position as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['position_code']; ?></td>
											<td><?php echo $row['position_name']; ?></td>
											<td><?php echo $row['position_id']; ?></td>
											<td><?php echo $row['majors_short_name'] ?></td>
											<td><?php echo $row['majors_id'] ?></td>
											<td>
												<a href="<?php echo site_url('manage/position/edit/' . $row['position_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
												
												<a href="#delModal<?php echo $row['position_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
											</td>	
										</tr>
										<div class="modal modal-default fade" id="delModal<?php echo $row['position_id']; ?>">
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
															<?php echo form_open('manage/position/delete/' . $row['position_id']); ?>
															<input type="hidden" name="delName" value="<?php echo $row['position_name']; ?>">
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
											$i++;
										endforeach;
									} else {
										?>
										<tr id="row">
											<td colspan="6" align="center">Data Kosong</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<div>
							<?php echo $this->pagination->create_links(); ?>
						</div>
						<!-- /.box -->
					</div>
				</div>
			</section>
			<!-- /.content -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="addPosition" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Jabatan Pegawai</h4>
					</div>
					<?php echo form_open('manage/position/add_glob', array('method'=>'post')); ?>
					<div class="modal-body">
						<div id="p_scents_position">
								<div class="row">
									<div class="col-md-6">
										<label>Kode Jabatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
										<input type="text" required="" name="position_code" class="form-control" placeholder="Contoh: KSSD">
									</div>
									<div class="col-md-6">
										<label>Nama Jabatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
										<input type="text" required="" name="position_name" class="form-control" placeholder="Contoh: Kepala Sekolah SD">
									</div>
									<div class="col-md-6">
                						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                						<select required="" name="position_majors_id" class="form-control">
                						    <option value="">-Pilih Unit Sekolah-</option>
                						    <?php foreach($majors as $row){?>
                						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
                						    <?php } ?>
                    						<option value="99">Lainnya</option>
                						</select>
                					</div>
								</div>
							</div>
							<!--<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_position"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>-->
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success">Simpan</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>


		<script>
			$(function() {
				var scntDiv = $('#p_scents_position');
				var i = $('#p_scents_position .row').size() + 1;

				$("#addScnt_position").click(function() {
				$('<div class="row"><div class="col-md-6"><label>Nama Unit Sekolah</label><input type="text" required name="position_name[]" class="form-control" placeholder="Contoh: Sekolah Dasar Putra"><a href="#" class="btn btn-xs btn-danger remScnt_position">Hapus Baris</a></div><div class="col-md-6"><label>Singkatan</label><input type="text" required name="position_short_name[]" class="form-control" placeholder="Contoh: SD Putra"></div></div>').appendTo(scntDiv);
				i++;
				return false;
			});

				$(document).on("click", ".remScnt_position", function() {
					if (i > 2) {
						$(this).parents('.row').remove();
						i--;
					}
					return false;
				});
			});
		</script>