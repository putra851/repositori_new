<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('student') ?>"><i class="fa fa-th"></i> Home</a></li>
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
												<td>NIS</td>
												<td>:</td>
												<td><?php echo $student['student_nis'] ?></td>
											</tr>
											<tr>
												<td>Nama lengkap</td>
												<td>:</td>
												<td><?php echo $student['student_full_name'] ?></td>
											</tr>
											<tr>
												<td>Unit</td>
												<td>:</td>
												<td><?php echo $student['majors_short_name'] ?></td>
											</tr>
											<tr>
												<td>Kelas</td>
												<td>:</td>
												<td><?php echo $student['class_name'] ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
				<div class="box box-info">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
							<br>
							
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Riwayat Transfer</a></li>
								<li><a href="#tab_2" data-toggle="tab">Kirim Bukti Transfer</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
								    <div class="box-body table-responsive">
            							<table id="dtable" class="table table-hover">
            							    <thead>
            								<tr>
            									<th>No</th>
            									<th>Tanggal Kirim</th>
            									<th>Bukti Bayar</th>
            									<th>Keterangan</th>
            									<th>Status Pembayaran</th>
            									<th>Aksi</th>
            								</tr>
            								</thead>
            								<tbody>
            									<?php
            									if (!empty($prove)) {
            										$i = 1;
            										foreach ($prove as $row):
                									$date=date_create($row['prove_date']);
            											?>
            											<tr>
            												<td><?php echo $i; ?></td>
            												<td><?php echo date_format($date,"d-m-Y H:i:s"); ?></td>
            												<td><a href="<?php echo base_url() . 'uploads/prove/' . $row['prove_img']; ?>" target="_blank"><img src="<?php echo base_url() . 'uploads/prove/' . $row['prove_img']; ?>" width="70"></a></td>
            												<td><?php echo $row['prove_note']; ?></td>
            												<td><label class="label <?php if ($row['prove_status']==1) { echo 'label-success'; } else if ($row['prove_status']==0) { echo 'label-danger'; } else if ($row['prove_status']==2) { echo 'label-warning'; } else if ($row['prove_status']==3) { echo 'label-danger'; } ?>"><?php if ($row['prove_status']==1) { echo 'DIVERIFIKASI [Sudah Diverifikasi Admin]'; } else if ($row['prove_status']==0) { echo 'DIBATALKAN [Dibatalkan oleh Pengirim]'; } else if ($row['prove_status']==2) { echo 'DIBAYAR [Menunggu Verifikasi Admin]'; } else if ($row['prove_status']==3) { echo 'DITOLAK [Bukti Transfer Ditolak Admin]'; } ?></label></td>
            												<td>
            												    <?php if($row['prove_status'] == '2') { ?>
            												    <a href="#cancelProve<?php echo $row['prove_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger">Batalkan Transaksi</a>
            												    <?php } ?>
            												</td>	
            											</tr>
										<div class="modal modal-default fade" id="cancelProve<?php echo $row['prove_id']; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span></button>
															<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi Pembatalan</h3>
														</div>
														<div class="modal-body">
															<p>Masukkan alasan kenapa dibatalkan</p>
														</div>
														<div class="modal-footer">
															<?php echo form_open('student/prove/cancel/'); ?>
															<input type="hidden" name="prove_id" value="<?php echo $row['prove_id']; ?>">
                        					<textarea class="form-control" name="prove_note" placeholder="Masukkan keterangan mengapa pengkiriman bukti transfer dibatalkan [WAJIB DIISI]" required></textarea>
                        					<br>
															<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Batalkan Transaksi</button>
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
								</div>
								<div class="tab-pane" id="tab_2">
								    <form action="<?php echo base_url(); ?>student/prove/add" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								        
								        <input type="hidden" name="prove_student_id" value="<?php echo $student['student_id'] ?>">
								        
								        
                        				<div class="col-md-6">
                        				    <br>
                        				    <div class="form-group">
                        					<label>Keterangan *</label>
                        					<textarea class="form-control" name="prove_note" placeholder="Masukkan dengan nama tagihan yang dibayarkan" required></textarea>
                        					</div>
                        					
                        				    <div class="form-group">
                        					<label>Screeanshot atau Foto Struk Transfer *</label>
                        					<input name="prove_img" type="file" class="form-control" value="" placeholder="Masukkan screeanshot atau foto struk transfer" required>
                        					</div>
                        					
                        		        
                        				    <br>
                        				    <p>*) Wajib Diisi</p>
                        					
                        					<br>
                        					
                        				    <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button>
                        				    <a href="<?php echo base_url() . 'student'; ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Batal</a>
                        				</div>
                        			</form>
								</div>
						    </div>
					    </div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
            </div>
        </div>
	</section>
</div>