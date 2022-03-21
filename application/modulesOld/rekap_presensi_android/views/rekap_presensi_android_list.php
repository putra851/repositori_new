<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
			<small>List</small>
		</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title">Filter Rekap Presensi</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
							<div class="form-group">						
								<input type="hidden" name="id_pegawai" value="<?=$f['id_pegawai']?>" />
								<label for="" class="col-sm-2 control-label">Periode</label>
								<div class="col-sm-2">
									<select id="periode" name="periode" onchange="this.form.submit()" class="form-control" required="">
    								    <option value="">--- Pilih Periode ---</option>
										<?php
										$tahun_ini = date("Y");
										$bulane=array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
										for ($i=$tahun_ini;$i<=$tahun_ini;$i++)
										  {    
											for ($j=1;$j<=12;$j++)
											  {    
										  $bulan = str_pad($j, 2, '0', STR_PAD_LEFT );
										  $periode_ok = $i."-".$bulan;
										  $periode_ok_ok = $bulane[$j-1]." - ".$i;
										  ?>    
										  <option value="<?=$periode_ok?>" <?php echo ($periode == $periode_ok) ? 'selected' : '' ?> ><?=$periode_ok_ok?> </option>  
										  <?php
											  }
										  }
										  ?> 
    								</select>
								</div>
							</div>
						</form>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				<?php
				if($f){
				?>
				<div class="box"> 
						
						
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable2" class="table table-hover">
							    <thead>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Status</th>
									<th>Jam Datang</th>
									<th>Jam Pulang</th>
									<th>Lokasi</th>
									<th>Catatan</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($rekap_presensi_android)) {
										$i = 1;
										foreach ($rekap_presensi_android as $row):
											$ja=$row['jenis_absen'];
											if($ja=='DATANG'){
												$st="HADIR";
											}elseif($ja=='PULANG'){
												$st="-";
											}else{
												$st=$ja;
											}
											$lokasi = getValue("max(lokasi)","data_absensi","id_pegawai='".$f['id_pegawai']."' and tanggal='".$row['tanggal']."'");
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['tanggal']; ?></td>
												<td><?php echo $st; ?></td>
												<td><?php echo $row['jam_datang']; ?></td>
												<td><?php echo $row['jam_pulang']; ?></td>
												<td><?php echo $lokasi; ?></td>
												<td><?php echo $row['catatan_absen']; ?></td>
											</tr>
											<?php
											$i++;
										endforeach;
									} else {
										?>
										<tr id="row">
											<td colspan="7" align="center">Data Kosong</td>
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
						<?php }?>
					</div>
				</div>
		</section>
		<!-- /.content -->
	</div>