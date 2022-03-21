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
						<h3 class="box-title">Filter Data Pembayaran Santri</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
						<div class="form-group">						
							<label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="th_ajar" required="">
									<?php foreach ($period as $row): ?>
										<option <?php if (isset($f['n']) AND $f['n'] == $row['period_id']) {
										    echo 'selected';
										} else if (empty($f['n']) AND $periodActive['period_id'] == $row['period_id']) {
										    echo 'selected';
										} else {
										    echo '';
										} ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<label for="" class="col-sm-2 control-label">Cari Santri</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control" name="r" id="student_nis" placeholder="NIS Santri" <?php echo (isset($f['r'])) ? 'value="'.$f['r'].'"' : 'value=""' ?> required>
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
                					    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSantri"><b>Data Santri</b></button>
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
    						<h3 class="box-title">Informasi Santri</h3>
    					</div><!-- /.box-header -->
    					<div class="box-body">
						<div class="col-md-9">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td width="200">Tahun Ajaran</td><td width="4">:</td>
										<?php foreach ($period as $row): ?>
											<?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
											'<td><strong>'.$row['period_start'].'/'.$row['period_end'].'<strong></td>' : '' ?> 
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
										<td>Nama Santri</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<td>'.$row['student_full_name'].'</td>' : '' ?> 
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
									<tr>
										<td>Kamar</td>
										<td>:</td>
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ?  
											'<td>'.$row['madin_name'].'</td>' : '' ?> 
										<?php endforeach; ?>
									</tr>
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


				<!-- List Tagihan Bulanan --> 
				<div class="box box-primary">
				    
                        <div class="payment">
					<div class="box-header with-border">
						<h3 class="box-title">Jenis Pembayaran</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
					    <div class="row">
                    		<div class="col-md-3">
                    		    <label>No. Referensi</label>
                    			<input required="" name="kas_noref" id="kas_noref" class="form-control" value="<?php echo $noref ?>" readonly="">
                    		</div>
                    		<div class="col-md-3">
                    		    <label>Akun Kas *</label>
                    			<select required="" name="kas_account_id" id="kas_account_id" onchange="change_kas_account()" class="form-control">
                    			    <option value="">-- Pilih Akun Kas --</option>
                    			    <?php
                    			    foreach($dataKas as $row){
                    			    ?>
                                		<option value="<?php echo $row['account_id'] ?>" <?php echo($dataKasActive==$row['account_id']) ? 'selected' : '' ?> > 
                                		<?php echo $row['account_code'].' - '.$row['account_description'];
                                		?>
                                		 </option>
                                	<?php	 
                        			 }
                    			    ?>
                    			</select>
                    		</div>
                    		<br>
					    </div>
					    <br>
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Bulanan</a></li>
								<li><a href="#tab_2" data-toggle="tab">Bebas</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="box-body table-responsive">
									    
										<table class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>Nama Pembayaran</th>
													<th>Sisa Tagihan</th>
            									<?php	
            									    foreach ($dataMonth as $bln)             { 
            									?>
                						            <th>
                						          <?php echo $bln->month_name ?>
                						            </th>
    							                <?php } ?>
												</tr>
											</thead>
											<tbody>
											 <?php 
											    $no = 1;
											    $num=count($pembayaran);
											    if ($num > 0){
											    foreach($pembayaran as $row){
											 ?>
											    <tr>
													<td>
													    <?php 
													        echo $no++
													    ?>
													</td>
													<td>
													    <?php 
													        echo $row->pos_name.' - T.A. '.$row->period_start.'/'.$row->period_end
													    ?>
													</td>
													<td><?php echo ( $row->total== $row->dibayar) ? 'Rp. -' : 'Rp. '.number_format($row->total - $row->dibayar,0,',','.') ?></td>
													<td class="<?php echo ($row->status_jul ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addJul<?php echo $row->payment_id?>">
													    <?php echo ($row->status_jul==1) ? number_format($row->bill_jul, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_jul,'d/m/y',false).')<br>
													    ['.$row->account_jul.']': number_format($row->bill_jul, 0, ',', '.') ?></a>
													<div class="modal fade" id="addJul<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_jul ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_jul<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					    <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_jul ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_jul != '0')?$row->date_pay_jul : date('Y-m-d') ?>">
            								</div>
            							</div>
                						<div class="form-group">
                							<label>Jumlah Bayar</label>
                							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_jul ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_jul == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_jul)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_agu ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addAgu<?php echo $row->payment_id?>">
													    <?php echo ($row->status_agu==1) ? number_format($row->bill_agu, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_agu,'d/m/y',false).')<br>
													    ['.$row->account_agu.']': number_format($row->bill_agu, 0, ',', '.') ?></a>
													<div class="modal fade" id="addAgu<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_agu ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_agu<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_agu ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_agu != '0')?$row->date_pay_agu : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_agu ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_agu == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_agu)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_sep ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addSep<?php echo $row->payment_id?>">
													    <?php echo ($row->status_sep==1) ? number_format($row->bill_sep, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_sep,'d/m/y',false).')<br>
													    ['.$row->account_sep.']': number_format($row->bill_sep, 0, ',', '.') ?></a>
													<div class="modal fade" id="addSep<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_sep ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_sep<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_sep ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_sep != '0')?$row->date_pay_sep : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_sep ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_sep == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_sep)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_okt ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addOkt<?php echo $row->payment_id?>">
													    <?php echo ($row->status_okt==1) ? number_format($row->bill_okt, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_okt,'d/m/y',false).')<br>
													    ['.$row->account_okt.']': number_format($row->bill_okt, 0, ',', '.') ?></a>
													<div class="modal fade" id="addOkt<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_okt ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_okt<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_okt ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_okt != '0')?$row->date_pay_okt : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_okt ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_okt == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_okt)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_nov ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addNov<?php echo $row->payment_id?>">
													    <?php echo ($row->status_nov==1) ? number_format($row->bill_nov, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_nov,'d/m/y',false).')<br>
													    ['.$row->account_nov.']': number_format($row->bill_nov, 0, ',', '.') ?></a>
													<div class="modal fade" id="addNov<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_nov ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_nov<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_nov ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_nov != '0')?$row->date_pay_nov : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_nov ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_nov == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_nov)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div></td>
                    		<td class="<?php echo ($row->status_des ==1) ? 'success' : 'danger' ?>">
							    <a data-toggle="modal" data-target="#addDes<?php echo $row->payment_id?>">
							    <?php echo ($row->status_des==1) ? number_format($row->bill_des, 0, ',', '.').'<br>
							    ('.pretty_date($row->date_pay_des,'d/m/y',false).')<br>
							    ['.$row->account_des.']': number_format($row->bill_des, 0, ',', '.') ?></a>
							<div class="modal fade" id="addDes<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_des ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_des<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_des ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_des != '0')?$row->date_pay_des : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_des ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_des == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_des)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_jan ==1) ? 'success' : 'danger' ?>">
													    <a data-toggle="modal" data-target="#addJan<?php echo $row->payment_id?>">
													    <?php echo ($row->status_jan==1) ? number_format($row->bill_jan, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_jan,'d/m/y',false).')<br>
													    ['.$row->account_jan.']': number_format($row->bill_jan, 0, ',', '.') ?></a>
													<div class="modal fade" id="addJan<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_jan ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_jan<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_jan ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_jan != '0')?$row->date_pay_jan : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_jan ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_jan == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_jan)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_feb ==1) ? 'success' : 'danger' ?>"><a data-toggle="modal" data-target="#addFeb<?php echo $row->payment_id?>">
													    <a data-toggle="modal" data-target="#addFeb<?php echo $row->payment_id?>">
													    <?php echo ($row->status_feb==1) ? number_format($row->bill_feb, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_feb,'d/m/y',false).')<br>
													    ['.$row->account_feb.']': number_format($row->bill_feb, 0, ',', '.') ?></a>
													<div class="modal fade" id="addFeb<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_feb ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_feb<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_feb ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_feb != '0')?$row->date_pay_feb : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_feb ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_feb == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_feb)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_mar ==1) ? 'success' : 'danger' ?>"><a data-toggle="modal" data-target="#addMar<?php echo $row->payment_id?>">
													    <a data-toggle="modal" data-target="#addMar<?php echo $row->payment_id?>">
													    <?php echo ($row->status_mar==1) ? number_format($row->bill_mar, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_mar,'d/m/y',false).')<br>
													    ['.$row->account_mar.']': number_format($row->bill_mar, 0, ',', '.') ?></a>
													<div class="modal fade" id="addMar<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_mar ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_mar<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_mar ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_mar != '0')?$row->date_pay_mar : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_mar ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_mar == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_mar)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_apr ==1) ? 'success' : 'danger' ?>"><a data-toggle="modal" data-target="#addApr<?php echo $row->payment_id?>">
													    <a data-toggle="modal" data-target="#addApr<?php echo $row->payment_id?>">
													    <?php echo ($row->status_apr==1) ? number_format($row->bill_apr, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_apr,'d/m/y',false).')<br>
													    ['.$row->account_apr.']': number_format($row->bill_apr, 0, ',', '.') ?></a>
													<div class="modal fade" id="addApr<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_apr ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_apr<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_apr ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_apr != '0')?$row->date_pay_apr : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_apr ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_apr == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_apr)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_mei ==1) ? 'success' : 'danger' ?>"><a data-toggle="modal" data-target="#addMei<?php echo $row->payment_id?>">
													    <a data-toggle="modal" data-target="#addMei<?php echo $row->payment_id?>">
													    <?php echo ($row->status_mei==1) ? number_format($row->bill_mei, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_mei,'d/m/y',false).')<br>
													    ['.$row->account_mei.']': number_format($row->bill_mei, 0, ',', '.') ?></a>
													<div class="modal fade" id="addMei<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_mei ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_mei<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_mei ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_mei != '0')?$row->date_pay_mei : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_mei ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_mei == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_mei)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
													<td class="<?php echo ($row->status_jun ==1) ? 'success' : 'danger' ?>"><a data-toggle="modal" data-target="#addJun<?php echo $row->payment_id?>">
													    <a data-toggle="modal" data-target="#addJun<?php echo $row->payment_id?>">
													    <?php echo ($row->status_jun==1) ? number_format($row->bill_jun, 0, ',', '.').'<br>
													    ('.pretty_date($row->date_pay_jun,'d/m/y',false).')<br>
													    ['.$row->account_jun.']': number_format($row->bill_jun, 0, ',', '.') ?></a>
													<div class="modal fade" id="addJun<?php echo $row->payment_id?>" role="dialog">
                    			<div class="modal-dialog modal-sm">
                    				<div class="modal-content">
                    					<div class="modal-header">
                    						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    						<h4 class="modal-title">Pembayaran Bulan <?php echo $row->month_name_jun ?></h4>
                    					</div>
                    					<?php echo form_open('manage/payout/pay', array('method'=>'post')); ?>
                    					<div class="modal-body">
                    					    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_jun<?php echo $row->payment_id?>" value="<?php echo $dataKasActive ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_id" value="<?php echo $row->student_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="student_nis" value="<?php echo $row->student_nis ?>">
                    					        <input class="form-control" required="" type="hidden" name="payment_period" value="<?php echo $row->period_id ?>">
                    					        <input class="form-control" required="" type="hidden" name="payout_id" value="<?php echo $row->month_id_jun ?>">
            							<div class="form-group">
            								<label>Tanggal</label>
            								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
            									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            									<input class="form-control" required="" type="text" name="payout_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo ($row->date_pay_jun != '0')?$row->date_pay_jun : date('Y-m-d') ?>">
            								</div>
            							</div>
                    						<div class="form-group">
                    							<label>Jumlah Bayar</label>
                    							<input class="form-control" <?php echo ($row->payment_mode == 'TETAP') ? 'readonly=""' : 'required=""'; ?> type="text" name="payout_value" placeholder="Jumlah Bayar" value="<?php echo $row->bill_jun ?>">
                    						</div>
                    					</div>
                    					<div class="modal-footer">
                    					    <?php if(($row->status_jun == '1')){ ?>
                    					    <a href="<?php echo site_url('manage/payout/not_pay/' . $row->payment_id.'/'.$row->student_id.'/'.$row->month_id_jun)?>"><button type="button" class="btn btn-danger">Hapus</button></a>
                    					    <?php } else { ?>
                    						<button type="submit" class="btn btn-success">Simpan</button>
                    						<?php } ?>
                    						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    					</div>
                    					<?php echo form_close(); ?>
                    				</div>
                    			</div>
                    		</div>
													</td>
												</tr>
											<?php }
											} ?>
											</tbody>
										</table>
									</div>
									</div>
									<div class="tab-pane" id="tab_2">
										<!-- End List Tagihan Bulanan -->

										<!-- List Tagihan Lainnya (Bebas) -->

										<div class="box-body">
										    <a data-toggle="modal" class="btn btn-success btn-xs" title="Bayar Banyak" href="#bayarBanyak" onclick="get_form()"><span class="fa fa-money"></span> Bayar Banyak</a>
											<a href="" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> Refresh</a>
										<div class="box-body table-responsive">
										<table class="table table-bordered" style="white-space: nowrap;">
												<thead>
													<tr class="info">
													    <th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
														<th>No.</th>
														<th>Jenis Pembayaran</th>
														<th>Total Tagihan</th>
														<th>Dibayar</th>
														<th>Status</th>
														<th>Bayar</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i =1;
													foreach ($bebasPay as $row):
														if ($f['n'] AND $f['r'] == $row['student_nis']) {
															$sisa = $row['bebas_bill']-$row['bebas_total_pay'];
															?>
															<tr class="<?php echo ($row['bebas_bill'] == $row['bebas_total_pay']) ? 'success' : 'danger' ?>">
															    <td style="background-color: #fff !important;">
															        <input type="checkbox" class="checkbox" name="msg[]" id="msg" value="<?php echo $row['bebas_id'] ?>" <?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'disabled="disabled"' : '' ?>>
															    </td>
																<td style="background-color: #fff !important;"><?php echo $i ?></td>
																<td style="background-color: #fff !important;"><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?></td>
																<td><?php echo 'Rp. ' . number_format($sisa, 0, ',', '.') ?></td>
																<td><?php echo 'Rp. ' . number_format($row['bebas_total_pay'], 0, ',', '.') ?></td>
																<td><a href="<?php echo site_url('manage/payout/payout_bebas/'. $row['payment_payment_id'].'/'.$row['student_student_id'].'/'.$row['bebas_id']) ?>" class="view-cicilan label <?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'label-success' : 'label-warning' ?>"><?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?></a></td>
																<td width="40" style="text-align:center">
																	<a data-toggle="modal" class="btn btn-success btn-xs <?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'disabled' : '' ?>" title="Bayar" href="#addCicilan<?php echo $row['bebas_id'] ?>"><span class="fa fa-money"></span> Bayar</a>
																</td>
															</tr>

															<div class="modal fade" id="addCicilan<?php echo $row['bebas_id'] ?>" role="dialog">
																<div class="modal-dialog modal-md">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal">&times;</button>
																			<h4 class="modal-title">Tambah Pembayaran/Cicilan</h4>
																		</div>
																		<div class="modal-body">
                                    										<?php echo form_open('manage/payout/payout_bebas/', array('method'=>'post')); ?>									
                                    										<input type="hidden" name="bebas_id" id="bebas_id" value="<?php echo $row['bebas_id'] ?>">
																			<input type="hidden" name="student_nis" id="student_nis" value="<?php echo $row['student_nis'] ?>">
                                										    <input class="form-control" required="" type="hidden" name="kas_noref" value="<?php echo $noref ?>">
                                                    					    <input class="form-control" required="" type="hidden" name="kas_account" id="kas_account_bebas<?php echo $row['payment_payment_id'] ?>" value="<?php echo $dataKasActive ?>">									
                                                    					    <input type="hidden" name="student_student_id" id="student_student_id" value="<?php echo $row['student_student_id'] ?>">
																			<input type="hidden" name="payment_payment_id" id="payment_payment_id" value="<?php echo $row['payment_payment_id'] ?>">
																			<div class="form-group">
																				<label>Nama Pembayaran</label>
																				<input class="form-control" readonly="" type="text" value="<?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?>">
																			</div>
																			<div class="form-group">
                                                								<label>Tanggal *</label>
                                                								<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                                                									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                									<input class="form-control" required="" type="text" name="bebas_pay_date" id="bebas_pay_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo date('Y-m-d') ?>">
                                                								</div>
                                                							</div>
                    														<div class="row">
                    															<div class="col-md-6">
                    																<label>Jumlah Bayar *</label>
                    																<input type="text" required="" name="bebas_pay_bill" id="bebas_pay_bill" class="form-control" placeholder="Jumlah Bayar">
                    															</div>
                    															<div class="col-md-6">
                    																<label>Keterangan *</label>
                    																<input type="text" required="" name="bebas_pay_desc" id="bebas_pay_desc" class="form-control" placeholder="Keterangan">
                    															</div>
                    														</div>
                    													</div>
                    													<div class="modal-footer">
                    														<button type="submit" class="btn btn-success">Simpan</button>
                    														<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    													</div>
                    													<?php echo form_close(); ?>
                    												</div>
                    											</div>
                    										</div>
																	<?php 
																}
																$i++;
															endforeach; 
															?>				
														</tbody>
													</table>
											</div>
											</div>
											</div>
                <div class="row">
                    
											<br>
											<br>
                    <div class="col-md-9">
					<div class="box box-primary">
    					<div class="box-header with-border">
    						<h3 class="box-title">Jenis Pembayaran</h3>
    					</div><!-- /.box-header -->
    					<div class="box-body">
						    
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
							    <li class="active"><a href="#tab_pay" data-toggle="tab">Transaksi Pembayaran</a></li>
								<li><a href="#tab_history" data-toggle="tab">History Pembayaran</a></a></li>
								<li><a href="#tab_tagihan" data-toggle="tab">Tagihan Pembayaran</a></a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_pay">
							
							<div class="box-body table-responsive">
								<table class="table table-responsive table-bordered" style="white-space: nowrap;">
									<tr class="info">
										<th>No</th>
										<th>No. Ref</th>
										<th>Tanggal</th>
										<th>Pembayaran</th>
										<th>Nominal</th>
									</tr>
									<?php 
									    if(count($trx)>0){ 
									        $nomor = 1;
    						                $sumBulan = 0;
    						                $sumBebas = 0;
									        foreach($trx as $row){
								    ?>
									<tr>
										<td><?php echo $nomor++ ?></td>
									    <td>
									        <?php echo ($row['bulan_bulan_id']!= NULL) ? $row['bulan_noref'] :  $row['bebas_pay_noref'] ?>
									    </td>
									    <td><?php echo pretty_date($row['log_trx_input_date'],'d/m/Y',false)  ?></td>
										<td><?php echo ($row['bulan_bulan_id']!= NULL) ? $row['posmonth_name'].' - T.A '.$row['period_start_month'].'/'.$row['period_end_month'].' ('.$row['month_name'].')' : $row['posbebas_name'].' - T.A '.$row['period_start_bebas'].'/'.$row['period_end_bebas'] ?></td>
										<td><?php echo ($row['bulan_bulan_id']!= NULL) ? 'Rp. '. number_format($row['bulan_bill'], 0, ',', '.') : 'Rp. '. number_format($row['bebas_pay_bill'], 0, ',', '.') ?></td>
									</tr>
									<?php
    						                $sumBulan += $row['bulan_bill'];
    						                $sumBebas += $row['bebas_pay_bill'];
									    } 
									    ?>
								    
									<tr style="background-color: #bcffc0">
										<td colspan="4"></td>
									    <td><?php echo 'Rp. '. number_format($sumBulan+$sumBebas, 0, ',', '.') ?></td>
									</tr>
									<tr>
										<td colspan=4></td>
										<td><button class="btn btn-primary btn-block" onclick="trxFinish()">Simpan Transaksi</button></td>
									</tr>
									<?php
									    } 
									?>
								</table>
								</div>
								</div>
							<div class="tab-pane" id="tab_history">
							<div class="box-body table-responsive">
							    <div class="over">
								<table class="table table-responsive table-bordered" style="white-space: nowrap;">
									<tr class="info">
										<th>Tanggal</th>
										<th>No. Ref</th>
										<th>Pembayaran</th>
										<th>Nominal</th>
										<th>Bayar Via</th>
									</tr>
									<?php 
									foreach ($log as $key) :
									?>
									<tr>
										<td><?php echo pretty_date($key['log_trx_input_date'],'d/m/Y',false)  ?></td>
									    <td>
									        <?php echo ($key['bulan_bulan_id']!= NULL) ? $key['bulan_noref'] :  $key['bebas_pay_noref'] ?>
									    </td>
										<td><?php echo ($key['bulan_bulan_id']!= NULL) ? $key['posmonth_name'].' - T.A '.$key['period_start_month'].'/'.$key['period_end_month'].' ('.$key['month_name'].')' : $key['posbebas_name'].' - T.A '.$key['period_start_bebas'].'/'.$key['period_end_bebas'] ?></td>
										<td><?php echo ($key['bulan_bulan_id']!= NULL) ? 'Rp. '. number_format($key['bulan_bill'], 0, ',', '.') : 'Rp. '. number_format($key['bebas_pay_bill'], 0, ',', '.') ?></td>
										<td><?php echo ($key['bulan_bulan_id']!= NULL) ? $key['accMonth'] : $key['accBebas'] ?></td>
									</tr>
								<?php endforeach ?>

								</table>
							    </div>
						    </div>
						    </div>
						    <div class="tab-pane" id="tab_tagihan">
						        <?php
						            if (isset($f['n']) AND isset($f['r'])) {
							            foreach ($siswa as $row): 
							         
									    $studentID = $row['student_id'];
									    $classID = $row['class_class_id'];
									    $majorsID = $row['majors_majors_id'];
									    endforeach; 
								    }
						        ?>
							<div class="box-body table-responsive">
						        <div class="pull-right">
						            <?php 
						                $dateM = date('m');
						                if($dateM == '01'){
						                    $till = '7';
						                } else if($dateM == '02'){
						                    $till = '8';
						                } else if($dateM == '03'){
						                    $till = '9';
						                } else if($dateM == '04'){
						                    $till = '10';
						                } else if($dateM == '05'){
						                    $till = '11';
						                } else if($dateM == '06'){
						                    $till = '12';
						                } else if($dateM == '07'){
						                    $till = '1';
						                } else if($dateM == '08'){
						                    $till = '2';
						                } else if($dateM == '09'){
						                    $till = '3';
						                } else if($dateM == '10'){
						                    $till = '4';
						                } else if($dateM == '11'){
						                    $till = '5';
						                } else if($dateM == '12'){
						                    $till = '6';
						                }
						            ?>
						            <a href="<?php echo site_url('manage/billing/print_bill/'.$f['n'].'/1/'.$till.'/'. $studentID) ?>" target="_blank"><button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>  Cetak Tagihan</button></a>
						        <br>
						        <br>
						        </div>
							    <div class="over">
							    <table class="table table-responsive table-bordered" style="white-space: nowrap;">
						            <thead>
						                <tr class="info">
    						                <th>
    						                   Rincian Tagihan
    						                </th>
    						                <th>
    						                     
    						                </th>
    						                <th>
    						                    Nominal
    						                </th>
						                </tr>
						            </thead>
						            <tbody>
								    <?php
    							    $billBulan = 0;
    							    $billBebas = 0;
    							    $month = pretty_date(date('Y-m-d'), 'F', false);
    							    $monthEnd = $this->db->query("SELECT month_id FROM month WHERE month_name = '$month'")->row_array();
    							    $params = array();
    							    $params['student_id']   = $studentID;
    							    $params['period_id']    = $f['n'];
    							    $params['class_id']     = $classID;
    							    $params['majors_id']    = $majorsID;
    							    $params['month_start']  = '1';
    							    $params['month_end']    = $monthEnd['month_id'];
    							    
    	                            $bulan = $this->Billing_model->get_tagihan_bulan($params);
    	                            $bebas = $this->Billing_model->get_tagihan_bebas($params);
								    foreach($bulan as $row): ?>
								    <tr>
                                        <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'] ?>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($row['bulan_bill'],0,",",".") ?>
                                        </td>
                                    <?php $billBulan += $row['bulan_bill']; ?>
                                    </tr>
							        <?php endforeach; ?>
								    <?php foreach($bebas as $row): ?>
								    <tr>
                                        <td><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($row['bebas_bill']-$row['bebas_total_pay'],0,",",".") ?>
                                        </td>
                                    <?php $billBebas += $row['bebas_bill']-$row['bebas_total_pay']; ?>
                                    </tr>
							        <?php endforeach ?>
                                    </tbody>
							    </table>
							    </div>
							    <table class="table table-responsive table-bordered" style="white-space: nowrap;">
							        <tbody>
                                    <tr style="background-color: #f0f0f0">
                                        <td>
                                            <b>Total Tagihan</b>
                                        </td>
                                        <td align="right">
                                            Rp
                                        </td>
                                        <td align="right">
                                        <?php echo number_format($billBulan+$billBebas,0,",",".") ?>
                                        </td>
                                    </tr>
                                    </tbody>
							    </table>
							</div>
						    </div>
						    </div>
						    </div>
						    </div>
						    <!--Tab1-->
						</div>
				    </div>
					
				    <div class="col-md-3">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Kalkulator</h3>
							</div>
							<div class="box-body">
								<form id="calcu" name="calcu" method="post" action="">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Total</label>
												<input type="text" class="form-control" value="<?php echo $cash+$cashb ?>" name="harga" id="harga" placeholder="Total Pembayaran" readonly="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Dibayar</label>
												<input type="text" class="form-control" value="0" name="bayar" id="bayar" placeholder="Jumlah Uang" onfocus="startCalculate()" onblur="stopCalc()">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Kembalian</label>
										<input type="text" class="form-control" readonly="" name="kembalian" id="kembalian" readonly="">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-9">
					</div>
					<div class="col-md-3">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Cetak Bukti Pembayaran</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<form action="<?php echo site_url('manage/payout/cetakBukti') ?>" method="GET" class="view-pdf">
									<input type="hidden" name="n" value="<?php echo $f['n'] ?>">
									<input type="hidden" name="r" value="<?php echo $f['r'] ?>">
									<div class="form-group">
										<label>Tanggal Transaksi</label>
										<div class="input-group date " data-date="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input class="form-control" readonly="" required="" type="text" name="d" id="trxDate" placeholder="Pilih Tanggal" onchange="cari_noref()">
										</div>
										<div id="div_noref">
										<label>No. Referensi</label>
                            			<select required="" name="f" id="no_ref" class="form-control" onchange="copy_data()">
                            			    <option value="">-- Pilih No. Referensi --</option>
                            			</select>
                            			</div>
									</div>
									<button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
								</form>
								<form action="<?php echo site_url('manage/payout/cetakThermal') ?>" method="GET" class="view-pdf">
									<input type="hidden" name="n" value="<?php echo $f['n'] ?>">
									<input type="hidden" name="r" value="<?php echo $f['r'] ?>">
									
									<input type="hidden" name="d" id="thermalDate" value="">
									<input type="hidden" name="f" id="thermalNoref" value="">
									<button class="btn btn-danger btn-block" formtarget="_blank" type="submit">Cetak Thermal</button>
								</form>
            						<?php if ($f['n'] AND $f['r'] != NULL) { ?>
            							<a href="<?php echo site_url('manage/payout/printBill' . '/?' . http_build_query($f)) ?>" target="_blank" class="btn btn-warning btn-block pull-right">Cetak Semua Transaksi</a>
            						<?php } ?>
							</div>
						</div>
					</div>
                </div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>	
						
				<div class="loader">
				    <br>
				    <br>
				    <br>
				    <br>
				    <center>
				        <img src="<?php echo base_url()?>uploads/loading/loading.gif" height="50" width="50">
				        <p>Simpan Pembayaran ...</p>
				    </center>
				    <br>
				    <br>
				    <br>
				    <br>
				</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="modal fade" id="bayarBanyak" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Bayar Banyak</h4>
					</div>
					<div class="modal-body">
		            <?php echo form_open('manage/payout/payout_bebas_batch/', array('method'=>'post')); ?>
						<div class="form-group">
            			<label>Tanggal *</label>
                			<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                				<input class="form-control" required="" type="text" name="bebas_pay_date" id="bebas_pay_date" readonly="" placeholder="Tanggal Bayar" value="<?php echo date('Y-m-d') ?>">
                			</div>
		                <input type="hidden" name="kas_noref" value="<?php echo $noref ?>">
		                <input type="hidden" name="kas_account" id="kas_account_bebas_batch" value="<?php echo $dataKasActive ?>">				
            		    </div>
            		    <div id="fbatch"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="dataSantri" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cari Data Santri</h4>
				</div>
				<div class="modal-body">
    <?php $dataSantri = $this->Student_model->get(array('status'=>'1'));
      
      echo '
            <div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>NIS</th>
									<th>Nama</th>
									<th>Unit Sekolah</th>
									<th>Semester</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>';
									if (!empty($dataSantri)) {
										$i = 1;
										foreach ($dataSantri as $row):
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

$(".loader").hide();

    function ambil_data(nis){
        var nisSantri    = nis;
        var thAjaran    = $("#th_ajar").val();
        
        window.location.href = '<?php echo base_url()?>manage/payout?n='+thAjaran+'&r='+nisSantri;
        
      }
      
      function get_form(){
        var bebas_id = $('#msg:checked');
        if(bebas_id.length > 0)
        {
            var bebas_id_value = [];
            $(bebas_id).each(function(){
                bebas_id_value.push($(this).val());
            });

            $.ajax({
                url: '<?php echo base_url();?>manage/payout/get_form/',
                method:"POST",
                data: {
                        bebas_id : bebas_id_value,
                },
                success: function(msg){
                        $("#fbatch").html(msg);
                },
        		error: function(msg){
        				alert('msg');
        		}
            });
        }
        else
        {
            alert("Belum ada pembayaran yang dipilih");
        }
      }
      
      <?php if ($f) { ?>
      
      function change_kas_account(){
          
            var kas = $("#kas_account_id").val();
            <?php if(count($pembayaran)>0){
                foreach($pembayaran as $row){ ?>
            
                $("#kas_account_jul<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_agu<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_sep<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_okt<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_nov<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_des<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_jan<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_feb<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_mar<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_apr<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_mei<?php echo $row->payment_id?>").val(kas);
                $("#kas_account_jun<?php echo $row->payment_id?>").val(kas);
                
            <?php }
                }
                if(count($bebasPay)>0){ 
                foreach ($bebasPay as $row){ ?>
                $("#kas_account_bebas<?php echo $row['payment_payment_id'] ?>").val(kas);
            <?php }
                    
                } ?>
                
                $("#kas_account_bebas_batch").val(kas);
      }
      
      <?php } ?>
      
      function cari_noref(){
          var trxDate = $("#trxDate").val();
          var nis     = $("#student_nis").val();
          
          $.ajax({ 
            url: '<?php echo base_url();?>manage/payout/cari_noref/',
            type: 'POST', 
            data: {
                    'trxDate': trxDate,
                    'nis': nis,
            },
            success: function(msg){
                    $("#div_noref").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
          });
    }
    
    function pay_bebas(){
        var nis                 = $("#student_nis").val();
        var period              = $("#th_ajar").val();
        var kas_account_id      = $("#kas_account_id").val();
        var kas_noref           = $("#kas_noref").val();
        var bebas_id            = $('#bebas_id').val();
        var student_nis         = $('#student_nis').val();
        var student_student_id  = $('#student_student_id').val();
        var payment_payment_id  = $('#payment_payment_id').val();
        var bebas_pay_date      = $('#bebas_pay_date').val();
        var bebas_pay_bill      = $('#bebas_pay_bill').val();
        var bebas_pay_desc      = $('#bebas_pay_desc').val();
        
        if(kas_noref != '' && kas_account_id != ''){
        if (bebas_pay_bill != '' && bebas_pay_desc != '') {
        $.ajax({ 
            url: '<?php echo base_url();?>manage/payout/payout_bebas/',
            type: 'POST', 
            data: {
                    'kas_account_id'        : kas_account_id,
                    'kas_noref'             : kas_noref,
                    'bebas_id'              : bebas_id,
                    'student_nis'           : student_nis,
                    'student_student_id'    : student_student_id,
                    'payment_payment_id'    : payment_payment_id,
                    'bebas_pay_date'        : bebas_pay_date,
                    'bebas_pay_bill'        : bebas_pay_bill,
                    'bebas_pay_desc'        : bebas_pay_desc,
            },    
            success: function(msg) {
                    window.location.href = '<?php echo base_url()?>manage/payout?n='+period+'&r='+nis;
            },
			error: function(msg){
					alert('msg');
			}
            
        });
      } else {
        alert("Jumlah Bayar atau Keterangan Belum Terisi");
      }
      } else {
        alert("Akun Kas Belum di Pilih");
      }
    }
    
    function trxFinish(){
        var nis                 = $("#student_nis").val();
        var period              = $("#th_ajar").val();
        var kas_account_id      = $("#kas_account_id").val();
        var kas_noref           = $("#kas_noref").val();
        
        if(kas_noref != '' && kas_account_id != ''){
        $.ajax({ 
            url: '<?php echo base_url();?>manage/payout/payout_finish/',
            type: 'POST', 
            data: {
                    'kas_account_id'        : kas_account_id,
                    'kas_noref'             : kas_noref,
                    'student_nis'           : nis,
                    'period'                : period,
            },    
            beforeSend: function () {
                $(".loader").fadeIn("slow");
                $(".payment").fadeOut("slow");
            },    
            success: function(msg) {
                    window.location.href = '<?php echo base_url()?>manage/payout?n='+period+'&r='+nis;
            },
			error: function(msg){
					alert('msg');
			}
            
        });
      } else {
        alert("Akun Kas Belum di Pilih");
      } 
    }
    
    function get_kelas(){
	    var id_majors    = $("#majors_id").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/payout/get_kelas',
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
            url: '<?php echo base_url();?>manage/payout/get_student',
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
	function copy_data() {
        var tanggal  = $("#trxDate").val();
        var noref    = $("#no_ref").val();
        
        
        $("#thermalDate").val(tanggal);
        $("#thermalNoref").val(noref);
	}
</script>

<script>
$(document).ready(function() {
	$("#selectall").change(function() {
		$('.checkbox:enabled').prop('checked', this.checked);
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
			html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>'
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

<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$('.checkbox:enabled').prop('checked', this.checked);
		});
	});
	
	$(document).ready(function() {
		$("#selectall2").change(function() {
			$('.checkbox:enabled').prop('checked', this.checked);
		});
	});
</script>

<style>
    div.over {
        width: 760px;
        height: 230px;
        overflow: scroll;
    }
</style>
