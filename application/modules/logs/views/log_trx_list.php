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
						<h3 class="box-title"></h3>
                        <!--
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
						-->
						
				<div class="box-header">
				    
                <div class="row">
                    <?php echo form_open(current_url(), array('method' => 'get')) ?>
					<div class="col-md-2">  
						<div class="form-group">
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" type="text" name="d" id="dari_tanggal" readonly="readonly" placeholder="Dari" value="<?php echo (isset($q['d'])) ? $q['d'] : '' ?>">
							</div>
						</div>
					</div>
					<div class="col-md-2">  
						<div class="form-group">
							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" type="text" name="s" id="sampai_tanggal" readonly="readonly" placeholder="Sampai" value="<?php echo (isset($q['s'])) ? $q['s'] : '' ?>">	
							</div>
						</div>
					</div>
					<div class="col-md-3">  
						<div class="form-group">
							<select class="form-control" name="m">
								<option value="">Semua Modul</option>
								<option value="Pembayaran" <?php echo (isset($q['m']) AND $q['m'] == "Pembayaran") ? 'selected' : '' ?>>Pembayaran</option>
								<option value="Kas Masuk" <?php echo (isset($q['m']) AND $q['m'] == "Kas Masuk") ? 'selected' : '' ?>>Kas Masuk</option>
								<option value="Kas Keluar" <?php echo (isset($q['m']) AND $q['m'] == "Kas Keluar") ? 'selected' : '' ?>>Kas Keluar</option>
								<option value="Penggajian" <?php echo (isset($q['m']) AND $q['m'] == "Penggajian") ? 'selected' : '' ?>>Penggajian</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">  
						<div class="form-group">
						    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
						</div>
					</div>
					</form>
                </div>
				</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
					    <div class="table-responsive">
						    <table id="dtable" class="table table-hover">
							<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Modul</th>
								<th>Aksi</th>
								<th>Info</th>
								<th>Penulis</th>
								<th>Browser</th>
								<th>OS</th>
								<th>IP Address</th>
							</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($logs)) {
									$i = 1;
									foreach ($logs as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo pretty_date($row['ltrx_date'],'d M Y H:i:s',false) ?></td>
											<td><?php echo $row['ltrx_module']; ?></td>
											<td><?php echo $row['ltrx_action']; ?></td>
											<td><?php echo $row['ltrx_info']; ?></td>
											<td><?php echo $row['user_full_name']; ?></td>	
											<td><?php echo $row['ltrx_browser'] . ' ' . $row['ltrx_version']; ?></td>
											<td><?php echo $row['ltrx_os']; ?></td>
											<td><?php echo $row['ltrx_ip']; ?></td>
										</tr>
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
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>