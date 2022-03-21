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
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Filter Data Tabungan Siswa</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
						<div class="form-group">						
							<label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="th_ajar">
									<option value="">-- Pilih T.A. --</option>
									<option <?php echo (isset($f['n']) AND $f['n'] == '0') ? 'selected' : '' ?> value="0">Semua T.A.</option>
									<?php foreach ($period as $row): ?>
										<option <?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<label for="" class="col-sm-2 control-label">Cari Siswa</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control" autofocus name="r" id="student_nis" <?php echo (isset($f['r'])) ? 'placeholder="'.$f['r'].'"' : 'placeholder="NIS Siswa"' ?> required>
									<span class="input-group-btn">
										<button class="btn btn-success" type="submit">Cari</button>
									</span>
									<span class="input-group-btn">
									</span>
									<span class="input-group-btn">
									</span>
									<span class="input-group-btn">
									</span>
                					<span class="input-group-btn">
                					    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSiswa"><b>Data Siswa</b></button>
                					</span>
								</div>
							</div>
						</div>
					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<?php if ($f) { ?>

				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Informasi Siswa</h3>
						<?php if (isset($f['n']) AND isset($f['r'])) { ?>
							<a href="<?php echo site_url('manage/banking/printBook' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Buku Tabungan</a>
						<?php } ?>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-9">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td width="200">Tahun Ajaran</td><td width="4">:</td>
										<?php foreach ($period as $row): ?>
											<?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
											'<td><strong>'.$row['period_start'].'/'.$row['period_end'].'<strong></td>' : '<td><strong>Semua Tahun Ajaran</strong></td>' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>NIS</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['student_nis'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Nama Siswa</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['student_full_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Unit Sekolah</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['majors_short_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<tr>
										<td>Kelas</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['class_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
									<?php if (majors() == 'senior') { ?>
										<tr>
											<td>Program Keahlian</td>
											<td>:</td>
											<?php foreach ($siswa as $row): ?>
												<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
												'<td>'.$row['majors_name'].'</td>' : '' ?> 
											<?php endforeach; ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="col-md-3">
							<?php foreach ($siswa as $row): ?>
								<?php if (isset($f['n']) AND $f['r'] == $row['student_nis']) { ?> 
									<?php if (!empty($row['student_img'])) { ?>
										<img src="<?php echo upload_url('student/'.$row['student_img']) ?>" class="img-thumbnail img-responsive">
									<?php } else { ?>
										<img src="<?php echo media_url('img/user.png') ?>" class="img-thumbnail img-responsive">
									<?php } 
								} ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-md-5">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Transaksi Terakhir</h3>
							</div><!-- /.box-header -->
							
							<div class="box-body table-responsive">
							    <div class="over">
								<table class="table table-responsive table-bordered" style="white-space: nowrap;">
									<tr class="info">
										<th>Tanggal</th>
										<th>Nominal</th>
										<th>Keterangan</th>
									</tr>
									<?php 
									foreach ($history as $row) :
									?>
									<tr>
										<td><?php echo pretty_date($row['banking_date'], 'd F Y', false) ?></td>
										<td>Rp <?php echo ($row['banking_debit'] != '0') ? number_format($row['banking_debit'],'0', ',', '.') : number_format($row['banking_kredit'],'0', ',', '.') ?></td>
										<td><?php echo ($row['banking_code'] == '1') ? 'SETORAN' : 'PENARIKAN' ?></td>
									</tr>
								<?php endforeach ?>

								</table>
							</div>
						</div>
						</div>
						</div>
					
					<div class="col-md-4">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Rekap Tabungan</h3>
							</div>
							<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Total Setoran</label>
												<input type="text" class="form-control" name="total_setor" id="total_setor" value="<?php echo 'Rp '.number_format($sumDebit, '0', ',', '.') ?>" placeholder="Total Setoran" readonly="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Total Penarikan</label>
												<input type="text" class="form-control" name="total_tarik" id="total_tarik" value="<?php echo 'Rp '.number_format($sumKredit, '0', ',', '.') ?>" placeholder="Total Penarikan" readonly="">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Saldo</label>
										<input type="text" class="form-control" readonly="" name="saldo" id="saldo"  value="<?php echo 'Rp '.number_format($sumDebit-$sumKredit, '0', ',', '.') ?>" placeholder="Saldo Tabungan">
									</div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Cetak Bukti Transaksi</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<form action="<?php echo site_url('manage/banking/cetakBukti') ?>" method="GET" class="view-pdf">
									<input type="hidden" name="n" value="<?php echo $f['n'] ?>">
									<input type="hidden" name="r" value="<?php echo $f['r'] ?>">
									<div class="form-group">
										<label>Tanggal Transaksi</label>
										<div class="input-group date " data-date="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input class="form-control" readonly="" required="" type="text" name="d" value="<?php echo date('Y-m-d') ?>">
										</div>
									</div>
									<button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<!-- List Tagihan Bulanan --> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Jenis Transaksi</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Setoran</a></li>
								<li><a href="#tab_2" data-toggle="tab">Penarikan</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="box-body">
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addDebit"><i class="fa fa-plus"></i> Setor</button>
									</div>
									<div class="box-body table-responsive">
										<table class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>Tanggal</th>
													<th>Kode</th>
													<th>Nominal</th>
													<th>Catatan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i =1;
												foreach ($setor as $row):
												?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo pretty_date($row['banking_date'], 'd F Y', false) ?></td>
													<td><?php echo ($row['banking_code'] == '1') ? 'SETORAN' : '-' ?></td>
													<td>Rp <?php echo number_format($row['banking_debit'], 0, ',', '.') ?></td>
													<td><?php echo $row['banking_note'] ?></td>
													<td>
												<a href="#editDebit<?php echo $row['banking_id']; ?>" data-toggle="modal" class="btn btn-xs btn-warning"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
												<a href="#delDebit<?php echo $row['banking_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
													</td>
												</tr>
                                		<div class="modal fade" id="editDebit<?php echo $row['banking_id']?>" role="dialog">
                                			<div class="modal-dialog modal-sm">
                                				<div class="modal-content">
                                					<div class="modal-header">
                                						<button type="button" class="close" data-dismiss="modal">&times;</button>
                                						<h4 class="modal-title">Edit Setoran</h4>
                                					</div>
                                					<div class="modal-body">
                                					    
                                					<?php echo form_open('manage/banking/add_debit', array('method'=>'post')); ?>
                                					<?php foreach ($period as $p): ?>
                                    					<?php echo (isset($f['n']) AND $f['n'] == $p['period_id']) ? 
                                    					'<input type="hidden" name="debit_period_id" value="'.$p['period_id'].'">' : '' ?> 
                                    				<?php endforeach; ?>
                                					<?php foreach ($siswa as $s): ?>
                                					<?php echo (isset($f['n']) AND $f['r'] == $s['student_nis']) ? 
                                					'<input type="hidden" name="debit_student_id" value="'.$s['student_id'].'">
                                					<input type="hidden" name="debit_student_nis" value="'.$s['student_nis'].'">' : '' ?> 
                                				    <?php endforeach; ?>
                                					<input type="hidden" name="debit_id" value="<?php echo $row['banking_id'] ?>">    
                                					<input type="hidden" name="debit_code" value="<?php echo $row['banking_code'] ?>">
					                                <input type="hidden" name="debit_period_id" value="<?php echo $row['banking_period_id']?>">
                                					
                                						<div class="form-group">
                                							<label>Tanggal</label>
                                							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                                								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                								<input class="form-control" required="" type="text" name="debit_date" value="<?php echo $row['banking_date'] ?>" placeholder="Tanggal Setor">
                                							</div>
                                						</div>
                                						<div class="form-group">
                                							<label>Jumlah Setoran</label>
                                							<input type="text" class="form-control" required="" name="debit_val" class="form-control" placeholder="Jumlah Setoran" value="<?php echo $row['banking_debit'] ?>">
                                						</div>
                                						<div class="form-group">
                                							<label>Catatan</label>
                                							<input type="text" class="form-control" required="" name="debit_note" class="form-control" placeholder="Catatan" value="<?php echo $row['banking_note'] ?>">
                                						</div>
                                					</div>
                                					<div class="modal-footer">
                                						<button type="submit" class="btn btn-info">Edit Setoran</button>
                                						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                					</div>
                                					<?php echo form_close(); ?>
                                				</div>
                                			</div>
                                		</div>
		
										<div class="modal modal-default fade" id="delDebit<?php echo $row['banking_id']; ?>">
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
															<?php echo form_open('manage/banking/delete/' . $row['banking_id']); ?>
															
                                					<?php foreach ($period as $p): ?>
                                    					<?php echo (isset($f['n']) AND $f['n'] == $p['period_id']) ? 
                                    					'<input type="hidden" name="period_id" value="'.$p['period_id'].'">' : '' ?> 
                                    				<?php endforeach; ?>
                                					<?php foreach ($siswa as $s): ?>
                                					<?php echo (isset($f['n']) AND $f['r'] == $s['student_nis']) ? 
                                					'<input type="hidden" name="student_nis" value="'.$s['student_nis'].'">' : '' ?> 
                                				    <?php endforeach; ?>
                                				    
                                				    <input type="hidden" name="code" value="<?php echo $row['banking_code']; ?>">
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
											?>				
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="tab_2">
									<div class="box-body">
										<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addKredit"><i class="fa fa-minus"></i> Tarik</button>
									</div>
									<div class="box-body table-responsive">
										<table class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>Tanggal</th>
													<th>Kode</th>
													<th>Nominal</th>
													<th>Catatan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i =1;
												foreach ($tarik as $row):
												?>
												<tr>
													
													<td><?php echo $i ?></td>
													<td><?php echo pretty_date($row['banking_date'], 'd F Y', false) ?></td>
													<td><?php echo ($row['banking_code'] == '2') ? 'PENARIKAN' : '-' ?></td>
													<td>Rp <?php echo number_format($row['banking_kredit'], 0, ',', '.') ?></td>
													<td><?php echo $row['banking_note'] ?></td>
													<td>
												<a href="#editKredit<?php echo $row['banking_id']; ?>" data-toggle="modal" class="btn btn-xs btn-warning"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
												<a href="#delKredit<?php echo $row['banking_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
													</td>
												</tr>
                                	    <div class="modal fade" id="editKredit<?php echo $row['banking_id']?>" role="dialog">
                                			<div class="modal-dialog modal-sm">
                                				<div class="modal-content">
                                					<div class="modal-header">
                                						<button type="button" class="close" data-dismiss="modal">&times;</button>
                                						<h4 class="modal-title">Edit Penarikan</h4>
                                					</div>
                                					<div class="modal-body">
                                					    
                                					<?php echo form_open('manage/banking/add_kredit', array('method'=>'post')); ?>
                                					<?php foreach ($period as $p): ?>
                                    					<?php echo (isset($f['n']) AND $f['n'] == $p['period_id']) ? 
                                    					'<input type="hidden" name="kredit_period_id" value="'.$p['period_id'].'">' : '' ?> 
                                    				<?php endforeach; ?>
                                					<?php foreach ($siswa as $s): ?>
                                					<?php echo (isset($f['n']) AND $f['r'] == $s['student_nis']) ? 
                                					'<input type="hidden" name="kredit_student_id" value="'.$s['student_id'].'">
                                					<input type="hidden" name="kredit_student_nis" value="'.$s['student_nis'].'">' : '' ?> 
                                				    <?php endforeach; ?>
                                					<input type="hidden" name="kredit_id" value="<?php echo $row['banking_id'] ?>">    
                                					<input type="hidden" name="kredit_code" value="<?php echo $row['banking_code'] ?>">
					                                <input type="hidden" name="kredit_period_id" value="<?php echo $row['banking_period_id']?>">
                                					
                                						<div class="form-group">
                                							<label>Tanggal</label>
                                							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                                								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                								<input class="form-control" required="" type="text" name="kredit_date" value="<?php echo $row['banking_date'] ?>" placeholder="Tanggal Setor">
                                							</div>
                                						</div>
                                						<div class="form-group">
                                							<label>Jumlah Setoran</label>
                                							<input type="text" class="form-control" required="" name="kredit_val" class="form-control" placeholder="Jumlah Setoran" value="<?php echo $row['banking_kredit'] ?>">
                                						</div>
                                						<div class="form-group">
                                							<label>Catatan</label>
                                							<input type="text" class="form-control" required="" name="kredit_note" class="form-control" placeholder="Catatan" value="<?php echo $row['banking_note'] ?>">
                                						</div>
                                					</div>
                                					<div class="modal-footer">
                                						<button type="submit" class="btn btn-warning">Edit Penarikan</button>
                                						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                					</div>
                                					<?php echo form_close(); ?>
                                				</div>
                                			</div>
                                		</div>
                                		
                                		<div class="modal modal-default fade" id="delKredit<?php echo $row['banking_id']; ?>">
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
															<?php echo form_open('manage/banking/delete/' . $row['banking_id']); ?>
															
                                					<?php foreach ($period as $p): ?>
                                    					<?php echo (isset($f['n']) AND $f['n'] == $p['period_id']) ? 
                                    					'<input type="hidden" name="period_id" value="'.$p['period_id'].'">' : '' ?> 
                                    				<?php endforeach; ?>
                                					<?php foreach ($siswa as $s): ?>
                                					<?php echo (isset($f['n']) AND $f['r'] == $s['student_nis']) ? 
                                					'<input type="hidden" name="student_nis" value="'.$s['student_nis'].'">' : '' ?> 
                                				    <?php endforeach; ?>
                                				    
                                				    <input type="hidden" name="code" value="<?php echo $row['banking_code']; ?>">
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
											?>				
											</tbody>
										</table>
									</div>
								</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="addDebit" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Setoran</h4>
					</div>
					<div class="modal-body">
					    
					<?php echo form_open('manage/banking/add_debit', array('method'=>'post')); ?>
					<?php foreach ($period as $row): ?>
    					<?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
    					'<input type="hidden" name="debit_period_id" value="'.$row['period_id'].'">' : '' ?> 
    				<?php endforeach; ?>
					<?php foreach ($siswa as $row): ?>
					<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
					'<input type="hidden" name="debit_student_id" value="'.$row['student_id'].'">
					<input type="hidden" name="debit_student_nis" value="'.$row['student_nis'].'">' : '' ?> 
				    <?php endforeach; ?>
					    
					<input type="hidden" name="debit_code" value="1">
					<input type="hidden" name="debit_period_id" value="<?php echo $f['n']?>">
					
						<div class="form-group">
							<label>Tanggal</label>
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" required="" type="text" name="debit_date" value="<?php echo date("Y-m-d") ?>" placeholder="Tanggal Setor">
							</div>
						</div>
						<div class="form-group">
							<label>Jumlah Setoran</label>
							<input type="text" class="form-control" required="" name="debit_val" class="form-control" placeholder="Jumlah Setoran">
						</div>
						<div class="form-group">
							<label>Catatan</label>
							<input type="text" class="form-control" required="" name="debit_note" class="form-control" placeholder="Catatan">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info">Setor</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="addKredit" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> Buat Penarikan</h4>
					</div>
					<div class="modal-body">
					<?php echo form_open('manage/banking/add_kredit', array('method'=>'post')); ?>
					    
					<?php foreach ($period as $row): ?>
    					<?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
    					'<input type="hidden" name="kredit_period_id" value="'.$row['period_id'].'">' : '' ?> 
    				<?php endforeach; ?>
					<?php foreach ($siswa as $row): ?>
					<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
					'<input type="hidden" name="kredit_student_id" value="'.$row['student_id'].'">
					<input type="hidden" name="kredit_student_nis" value="'.$row['student_nis'].'">' : '' ?> 
				    <?php endforeach; ?>
				    
					<input type="hidden" name="kredit_code" value="2">
					<input type="hidden" name="kredit_period_id" value="<?php echo $f['n']?>">
					
						<div class="form-group">
							<label>Tanggal</label>
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" required="" type="text" name="kredit_date" value="<?php echo date("Y-m-d") ?>" placeholder="Tanggal Setor">
							</div>
						</div>
						<div class="form-group">
							<label>Jumlah Penarikan</label>
							<input type="text" class="form-control" required="" name="kredit_val" class="form-control" placeholder="Jumlah Penarikan">
						</div>
						<div class="form-group">
							<label>Catatan</label>
							<input type="text" class="form-control" required="" name="kredit_note" class="form-control" placeholder="Catatan">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning">Tarik</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="dataSiswa" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cari Data Siswa</h4>
				</div>
				<div class="modal-body">
    <?php $dataSiswa = $this->Student_model->get(array('status'=>'1'));
      
      echo '
            <div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>NIS</th>
									<th>Nama</th>
									<th>Unit Sekolah</th>
									<th>Kelas</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>';
									if (!empty($dataSiswa)) {
										$i = 1;
										foreach ($dataSiswa as $row):
						               echo '<tr>
												<td>'.
												$i
												.'</td>
												<td>'.
												$row['student_nis']
												.'</td>
												<td>'.
												$row['student_full_name']
												.'</td>
												<td>'.
												$row['majors_short_name']
												.'</td>
												<td>'.
												$row['class_name']
												.'</td>';
										echo '<td align="center">';
                                        echo '<button type="button" data-dismiss="modal" class="btn btn-primary btn-xs" onclick="ambil_data(';
                                        echo "'".$row['student_nis']."'";
                                        echo ')">Pilih</button>';
                                        echo '</td>';
										echo '</tr>';
											$i++;
										endforeach;
									} else {
									echo '<tr id="row">
											<td colspan="8" align="center">Data Kosong</td>
										</tr>';
									    }
							echo	'</tbody>
								</table>
							</div>
      '; ?>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>

<script>
    function ambil_data(nis){
            var nisSiswa = nis;
            var thAjaran    = $("#th_ajar").val();
            
            window.location.href = '<?php echo base_url();?>manage/payout?n='+thAjaran+'&r='+nisSiswa;
      }
    
    function get_kelas(){
	    var id_majors    = $("#majors_id").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/banking/get_kelas',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_kelas").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
	
	function get_student(){
	    var id_majors       = $("#majors_id").val();
	    var id_kelas        = $("#class_id").val();
	    var student_name    = $("#student_name").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/banking/get_student',
            type: 'POST', 
            data: {
                    'id_majors'   : id_majors,
                    'id_kelas'    : id_kelas,
                    'student_name': student_name,
            },    
            success: function(msg) {
                    $("#div_data").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
	}
</script>

<script type="text/javascript">
function startCalculate(){
    interval=setInterval("Calculate()",10);
}

function Calculate() {
	var numberHarga = $('#harga').val(); // a string
	numberHarga = numberHarga.replace(/\D/g, '');
	numberHarga = parseInt(numberHarga, 10);

	var numberBayar = $('#bayar').val(); // a string
	numberBayar = numberBayar.replace(/\D/g, '');
	numberBayar = parseInt(numberBayar, 10);

	var total = numberBayar - numberHarga;
	$('#kembalian').val(total);
}

function stopCalc(){
	clearInterval(interval);
}
</script>

<script>
$(document).ready(function() {
	$("#selectall").change(function() {
		$(".checkbox").prop('checked', $(this).prop("checked"));
	});
});
</script>

<script type="text/javascript">
(function(a){
	a.createModal=function(b){
		defaults={
			title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
		};
		var b=a.extend({},defaults,b);
		var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";
		html='<div class="modal fade" id="myModal">';
		html+='<div class="modal-dialog">';
		html+='<div class="modal-content">';
		html+='<div class="modal-header">';
		html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
		if(b.title.length>0){
			html+='<h4 class="modal-title">'+b.title+"</h4>"
		}
		html+="</div>";
		html+='<div class="modal-body" '+c+">";
		html+=b.message;
		html+="</div>";
		html+='<div class="modal-footer">';
		if(b.closeButton===true){
			html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'
		}
		html+="</div>";
		html+="</div>";
		html+="</div>";
		html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
			a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){    
	$('.view-cicilan').on('click',function(){
		var link = $(this).attr('href');      
		var iframe = '<object type="text/html" data="'+link+'" width="100%" height="350">No Support</object>'
		$.createModal({
			title:'Lihat Pembayaran/Cicilan',
			message: iframe,
			closeButton:true,
			scrollable:false
		});
		return false;        
	});    
});
</script>
<style>
    div.over {
        width: 425px;
        height: 165px;
        overflow: scroll;
    }
    
    div.extended {
        width: 900px;
        height: 200px;
        overflow: scroll;
    }
</style>