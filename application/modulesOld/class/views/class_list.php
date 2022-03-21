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
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addClass"><i class="fa fa-plus"></i> Tambah</button>
						
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
					    <div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required>
    								    <option value="">--- Pilih Unit Pesantren ---</option>
    								    <?php if($this->session->userdata('umajorsid') == '0') { ?>
    								    <option value="all" <?php echo (isset($s['m']) && $s['m']=='all') ? 'selected' : '' ?> >Semua Unit</option>
    								    <?php } ?>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>     
    								<select style="width: 200px;" id="g" name="g" class="form-control" required>
    								    <option value="">--- Pilih Tingkat ---</option>
    								    <option value="all" <?php echo (isset($s['g']) && $s['g']=='all') ? 'selected' : '' ?> >Semua Tingkat</option>
            						    <?php foreach($grade as $row){?>
            						        <option value="<?php echo $row['grade_id']; ?>" <?php echo (isset($s['g']) && $s['g'] == $row['grade_id']) ? 'selected' : '' ?>><?php echo $row['grade_name'] ?></option>
    								    <?php } ?>
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
							</div>
							<?php echo form_close(); ?>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-hover">
						    <thead>
							<tr>
								<th>No</th>
								<th>Nama Kelas</th>
								<th>ID Kelas</th>
								<th>Tingkat</th>
								<th>Unit Pesantren</th>
								<th>ID Unit</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($classes)) {
									$i = 1;
									foreach ($classes as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['class_name']; ?></td>
											<td><?php echo $row['class_id']; ?></td>
											<td><?php echo $row['grade_name']; ?></td>
											<td><?php echo $row['majors_short_name']; ?></td>
											<td><?php echo $row['majors_majors_id']; ?></td>
											<td>
												<a href="<?php echo site_url('manage/class/edit/' . $row['class_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
												
												<a href="#delModal<?php echo $row['class_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
											</td>	
										</tr>
										<div class="modal modal-default fade" id="delModal<?php echo $row['class_id']; ?>">
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
															<?php echo form_open('manage/class/delete/' . $row['class_id']); ?>
															<input type="hidden" name="delName" value="<?php echo $row['class_name']; ?>">
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
											<td colspan="4" align="center">Data Kosong</td>
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
		<div class="modal fade" id="addClass" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Kelas</h4>
					</div>
					<?php echo form_open('manage/class/add_glob', array('method'=>'post')); ?>
					<div class="modal-body">
					    <label>Unit Pesantren</label>
						<select required="" name="majors_majors_id" class="form-control">
						    <option value="">-Pilih Unit Pesantren-</option>
						    <?php foreach($majors as $row){?>
						        <option value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
						    <?php } ?>
						</select>
					    <label>Tingkat</label>
						<select required="" name="grade_grade_id" class="form-control">
						    <option value="">-Pilih Tingkat-</option>
						    <?php foreach($grade as $row){?>
						        <option value="<?php echo $row['grade_id'] ?>"><?php echo $row['grade_name'] ?></option>
						    <?php } ?>
						</select>
						<div id="p_scents_class">
							<p>
								<label>Nama Kelas</label>
								<input type="text" required="" name="class_name[]" class="form-control" placeholder="Contoh: X (A)">
							</p>
						</div>
						<h6 ><a href="#" class="btn btn-xs btn-success" id="addScnt_class"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
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
			var scntDiv = $('#p_scents_class');
			var i = $('#p_scents_class p').size() + 1;

			$("#addScnt_class").click(function() {
				$('<p><label>Nama Kelas</label><input required type="text" name="class_name[]" class="form-control" placeholder="Contoh: X (A)"><a href="#" class="btn btn-xs btn-danger remScnt_class">Hapus Baris</a></p>').appendTo(scntDiv);
				i++;
				return false;
			});

			$(document).on("click", ".remScnt_class", function() {
				if (i > 2) {
					$(this).parents('p').remove();
					i--;
				}
				return false;
			});
		});
	</script>