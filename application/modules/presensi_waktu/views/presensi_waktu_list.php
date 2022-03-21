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
						<table>
						    <tr>
						        <td>    
            						<a href="<?php echo site_url('manage/presensi_waktu/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
        					    </td>
						    </tr>      
						</table>
						
						
					</div>
						
						
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>Unit</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($majors)) {
										$i = 1;
										foreach ($majors as $row):
										$presensi_waktu = $this->Presensi_waktu_model->get(array('data_waktu_majors_id' => $row['majors_id']));
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><a data-toggle="collapse" href="#collapse<?php echo $row['majors_id']; ?>"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['majors_short_name']; ?></td>
											<td>
											    <?php if (!empty($presensi_waktu)) { ?>
        													<a href="<?php echo site_url('manage/presensi_waktu/edit_batch/' . $row['majors_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
        													<a href="#delModalBatch<?php echo $row['majors_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></a>
        										<?php } ?>
											</td>
											</tr>
											<tr id="collapse<?php echo $row['majors_id']; ?>" class="collapse">
								    <td colspan="5">
								        <table id="xtable" class="table table-hover">
								            <thead>
								                <tr>
                									<th>Hari</th>
                									<th>Jam Masuk</th>
                									<th>Jam Pulang</th>
                									<th>Aksi</th>
								                </tr>
								            </thead>
								            <tbody>
            								    <?php 
            								    if (!empty($presensi_waktu)) {
            								        foreach ($presensi_waktu as $baris):
            								    ?>
            								        <tr>
        												<td><?php echo $baris['day_name']; ?></td>
        												<td><?php echo $baris['data_waktu_masuk']; ?></td>
        												<td><?php echo $baris['data_waktu_pulang']; ?></td>
        												<td>
        													<a href="<?php echo site_url('manage/presensi_waktu/edit_one/' . $baris['data_waktu_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
        													<a href="#delModal<?php echo $baris['data_waktu_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></a>
        												</td>	
            								        </tr>
            								        <div class="modal modal-default fade" id="delModal<?php echo $baris['data_waktu_id']; ?>">
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
															<?php echo form_open('manage/presensi_waktu/delete/' . $baris['data_waktu_id']); ?>
															<input type="hidden" name="delName" value="<?php echo $baris['majors_short_name'] . ' - ' . $baris['day_name']; ?>">
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
            								        endforeach;
            								    } else {
            								    ?>
            								    <tr><td colspan="3" align="center">Belum Disetting</td></tr>
            								    <?php } ?>
								            </tbody>
								        </table>
								    </td>
								</tr>
									    <?php if (!empty($presensi_waktu)) { ?>
											<div class="modal modal-default fade" id="delModalBatch<?php echo $row['majors_id']; ?>">
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
															<?php echo form_open('manage/presensi_waktu/delete_batch/' . $row['majors_id']); ?>
															<input type="hidden" name="delName" value="<?php echo $row['majors_short_name']; ?>">
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
															<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
															<?php echo form_close(); ?>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
										<?php } ?>
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