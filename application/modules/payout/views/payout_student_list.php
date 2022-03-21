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
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
          <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <select class="form-control" name="n">
                <!-- <option value="">-- Tahun Ajaran --</option> -->
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
              <input type="hidden" name="r" class="form-control" value="<?php echo $student['student_nis']; ?>">
            </div>

            <div class="col-sm-4">
              <button type="submit" class="btn btn-success"><i class="fa fa-search"> </i> Cari Pembayaran</button>
            </div>
          </div>
        </form>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
    <?php if ($f) { ?>

    <div class="row">
      <div class="col-md-6">
        <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
          <div class="box-header backg with-border">
            <h3 class="box-title">Informasi Siswa</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td width="200">Tahun Ajaran</td><td width="4">:</td>
                  <?php foreach ($period as $row): ?>
                    <?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 
                    '<td><strong>'.$row['period_start'].'/'.$row['period_end'] .'<strong></td>' : '' ?> 
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
                    <td>Unit</td>
                    <td>:</td>
                    <?php foreach ($siswa as $row): ?>
                      <?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
                      '<td>'.$row['majors_name'].'</td>' : '' ?> 
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
                  <tr>
                    <td colspan="3"><br></td>
                  </tr>
                  <tr>
                    <td colspan="3">
		            <?php 
			            foreach ($siswa as $row): 
					    $studentID = $row['student_id'];
					    endforeach;
					    
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
		            <div class="pull-right">
		                <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#listHistory"><i class="fa fa-list"></i>  History Pembayaran</button>
		                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#listKwitansi"><i class="fa fa-list"></i>  Kwitansi Pembayaran</button>
		                <a href="<?php echo site_url('student/billing/print_bill/'.$f['n'].'/1/'.$till.'/'. $studentID) ?>" target="_blank"><button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>  Download Tagihan</button></a>
		            </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <!-- List Tagihan Bulanan --> 
          <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
            <div class="box-header backg with-border">
              <h3 class="box-title">Pembayaran Bulanan</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-hover" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>No.</th>
					<th>Nama Pembayaran</th>
                    <th>Total</th>
                    <th>Sudah Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i =1;	
    			  $num=count($pembayaran);
    			  if ($num > 0){
    			  foreach($pembayaran as $row):
                    $namePay = $row->pos_name.' - T.A. '.$row->period_start.'/'.$row->period_end;
                      ?>
                      <tr data-toggle="collapse" data-target="#demo<?php echo $row->payment_id?>" style="color:<?php echo ($row->total== $row->dibayar) ? '#00E640' : 'red' ?>">
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $namePay ?></td>
                        <td><?php echo 'Rp. ' . number_format($row->total, 0, ',', '.') ?></td>
                        <td><?php echo 'Rp. ' . number_format($row->dibayar, 0, ',', '.') ?></td>
                        <td><?php echo 'Rp. ' . number_format($row->total - $row->dibayar, 0, ',', '.') ?></td>
                        <td><label class="label <?php echo ($row->total== $row->dibayar) ? 'label-success' : 'label-warning' ?>"><?php echo ($row->total== $row->dibayar) ? 'Lengkap' : 'Belum Lengkap' ?></label></td>
                      </tr>
                      <?php
                  endforeach; 
    			  }
                  ?> 
                  </tbody>
                  <?php 
                    $c = count($pembayaran);
                    if($c > 0){
                    foreach($pembayaran as $detail){?>
                  <tbody id="demo<?php echo $detail->payment_id ?>" class="collapse">
                  <tr>
                     <td colspan='6' align='center' class='info'>
                        <h4><?php echo $detail->pos_name.' - T.A. '.$detail->period_start.'/'.$detail->period_end; ?></h4>
                     <td>        
                  </tr>
                  <tr>
                    <th>No.</th> 
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th colspan='2' style="text-align: center;">Status</th>
                  </tr>
                    <tr class="<?php echo ($detail->status_jul ==1) ? 'success' : 'danger' ?>">
                    <td>
                    1
                    </td>
                    <td>
                    <?php echo $detail->month_name_jul ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_jul, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_jul == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_agu ==1) ? 'success' : 'danger' ?>">
                    <td>
                    2
                    </td>
                    <td>
                    <?php echo $detail->month_name_agu ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_agu, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_agu == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_sep ==1) ? 'success' : 'danger' ?>">
                    <td>
                    3
                    </td>
                    <td>
                    <?php echo $detail->month_name_sep ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_sep, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_sep == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_okt ==1) ? 'success' : 'danger' ?>">
                    <td>
                    4
                    </td>
                    <td>
                    <?php echo $detail->month_name_okt ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_okt, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_okt == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_nov ==1) ? 'success' : 'danger' ?>">
                    <td>
                    5
                    </td>
                    <td>
                    <?php echo $detail->month_name_nov ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_nov, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_nov == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_des ==1) ? 'success' : 'danger' ?>">
                    <td>
                    6
                    </td>
                    <td>
                    <?php echo $detail->month_name_des ?>
                    </td>
                    <td>
                    <?php echo $detail->period_start ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_des, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_des == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_jan ==1) ? 'success' : 'danger' ?>">
                    <td>
                    7
                    </td>
                    <td>
                    <?php echo $detail->month_name_jan ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_jan, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_jan == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_feb ==1) ? 'success' : 'danger' ?>">
                    <td>
                    8
                    </td>
                    <td>
                    <?php echo $detail->month_name_feb ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_feb, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_feb == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_mar ==1) ? 'success' : 'danger' ?>">
                    <td>
                    9
                    </td>
                    <td>
                    <?php echo $detail->month_name_mar ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_mar, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_mar == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_apr ==1) ? 'success' : 'danger' ?>">
                    <td>
                    10
                    </td>
                    <td>
                    <?php echo $detail->month_name_apr ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_apr, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_apr == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_mei ==1) ? 'success' : 'danger' ?>">
                    <td>
                    11
                    </td>
                    <td>
                    <?php echo $detail->month_name_mei ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_mei, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_mei == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
                    <tr class="<?php echo ($detail->status_jun ==1) ? 'success' : 'danger' ?>">
                    <td>
                    12
                    </td>
                    <td>
                    <?php echo $detail->month_name_jun ?>
                    </td>
                    <td>
                    <?php echo $detail->period_end ?>
                    </td>
                    <td>
                    <?php echo number_format($detail->bill_jun, 0, ',', '.') ?>
                    </td>
                    <td colspan='2' align='center'>
                    <?php echo ($detail->status_jun == 1) ? 'Lunas' : 'Belum Lunas' ?>
                    </td>
                    </tr>
              </tbody>
              <?php } }?>
            </table>
          </div>
        </div>
        <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
          <div class="box-header backg with-border">
            <h3 class="box-title">Pembayaran Lainnya</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Jenis Pembayaran</th>
                  <th>Total</th>
                  <th>Dibayar</th>
                  <th>Kekurangan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i =1;
                foreach ($bebas as $row):
                  if (isset($f['n']) AND $f['r'] == $row['student_nis']) {
                    $sisa = $row['bebas_bill']-$row['bebas_total_pay'];
                    $namePay = $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
                    ?>
                    <tr style="color:<?php echo ($row['bebas_bill'] == $row['bebas_total_pay']) ? '#00E640' : 'red' ?>">
                      <td><?php echo $i ?></td>
                      <td><?php echo $namePay ?></td>
                      <td><?php echo 'Rp. ' . number_format($row['bebas_bill'], 0, ',', '.') ?></td>
                      <td><?php echo 'Rp. ' . number_format($row['bebas_total_pay'], 0, ',', '.') ?></td>
                      <td><?php echo 'Rp. ' . number_format($sisa, 0, ',', '.') ?></td>
                      <td><label class="label <?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'label-success' : 'label-warning' ?>"><?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?></label></td>
                    </tr>
                    <?php 
                  }
                  $i++;
                endforeach; 
                ?>        
              </tbody>
            </table> 
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

		<!-- Modal -->
		<div class="modal fade" id="listHistory" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">History Pembayaran</h4>
					</div>
					<div class="modal-body">
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
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="listKwitansi" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Kwitansi Pembayaran</h4>
					</div>
					<div class="modal-body">
					    <div class="box-body table-responsive">
					        <div class="over">
							<table class="table table-hover">
							    <thead>
								<tr>
									<th>No. Ref</th>
									<th>Tanggal</th>
									<th>Total Transaksi</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
								    <?php
									if (!empty($kwitansi)) {
										$i = 1;
										foreach ($kwitansi as $row):
								    ?>
									    <tr>
											<td>
											<?php echo $row['kas_noref'] ?>       </td>
											<td>
											    <?php echo pretty_date($row['kas_input_date'], 'd-m-Y', false) ?>
											</td>
											<td>
											<?php echo 'Rp ' . number_format($row['kas_debit'], 0, ',', '.') ?>
											</td>
									<td align="center">
                                            <a href="<?php echo base_url() . 'student/payout/cetakBukti?n=' . $f['n'] . '&r=' . $f['r'] . '&d=' . $row['kas_input_date'] . '&f=' . $row['kas_noref'] ?>" class="btn btn-danger btn-xs" target="_blank">Cetak</a>
                                        </td>
									    </tr>
							        <?php
										$i++;
									    endforeach;
									} else {
									echo '<tr>
											<td colspan="4" align="center">Belum Ada Transaksi</td>
										</tr>';
									    }
								    ?>
									    </tbody>
								</table>
						    </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
</div>



<style>
    div.over {
        width: auto;
        height: 400px;
        overflow: scroll;
    }
</style>
