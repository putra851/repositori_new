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
	<section class="content">
		<div class="row"> 
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Filter Data  Santri</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
						<div class="form-group">						
							<label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
							<div class="col-sm-2">
								<select class="form-control" name="n" id="th_ajar">
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
									<input type="text" class="form-control" autofocus name="r" id="student_nis" <?php echo (isset($f['r'])) ? 'value="'.$f['r'].'"' : 'placeholder="NIS Santri"' ?> required>
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
						    <center>
						    <a href="<?php echo base_url() . 'manage/visit/printBook/?n='.$f['n'].'&r=' . $f['r']; ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak Riwayat </a>
						    </center>
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
				
				<!-- List Tagihan Bulanan --> 
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Mengunjungi Santri</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Laporan Mengunjungi Santri</a></li>
								<li><a href="#tab_2" data-toggle="tab">Tambah Kunjungan</a></li>
								<li><a href="#tab_3" data-toggle="tab">Rekap Laporan Mengunjungi Santri</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="box-body table-responsive">
										<table id="xtable" class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>Tanggal</th>
													<th>Jam</th>
													<th>Daftar Pengunjung</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i =1;
												foreach ($visit as $row):
												    $tamu = $this->Visit_model->get_tamu(array('list_tamu_kode' => $row['guest_list_code']));
												?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo pretty_date($row['guest_list_date'], 'd F Y', false) ?></td>
													<td><?php echo $row['guest_list_time'] ?></td>
													<td>
													    <?php
													        foreach ($tamu as $baris) :
													            echo $baris['guest_name'] . ' (' . $baris['mahram_note'] . ')'  . '<br>';
													        endforeach;
													    ?>
													</td>
													<td>
												<a href="<?php echo base_url() .  'manage/visit/cetakThermal/' . $row['guest_list_id']; ?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-print" data-toggle="tooltip" title="Cetak"></i></a>
												<a href="#delVisit<?php echo $row['guest_list_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
													</td>
												</tr>
		
										<div class="modal modal-default fade" id="delVisit<?php echo $row['guest_list_id']; ?>">
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
															<?php echo form_open('manage/visit/delete/' . $row['guest_list_id']); ?>
															
                                					<?php foreach ($period as $p): ?>
                                    					<?php echo (isset($f['n']) AND $f['n'] == $p['period_id']) ? 
                                    					'<input type="hidden" name="period_id" value="'.$p['period_id'].'">' : '' ?> 
                                    				<?php endforeach; ?>
                                					<?php foreach ($siswa as $s): ?>
                                					<?php echo (isset($f['n']) AND $f['r'] == $s['student_nis']) ? 
                                					'<input type="hidden" name="student_nis" value="'.$s['student_nis'].'">' : '' ?> 
                                				    <?php endforeach; ?>
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
                					<div class="row">
                					    
									    <?php echo form_open('manage/visit/add', array('method'=>'post')); ?>
                					
                    					<?php if(isset($f['n'])){ ?>
                    					<input type="hidden" name="guest_list_period_id" value="<?php echo $f['n']?>">
                    					<input type="hidden" name="guest_list_student_nis" value="<?php echo $f['r']?>">
                    					<?php } ?>
                    					
                					
										<?php foreach ($siswa as $row): ?>
											<?php echo (isset($f['n']) AND $f['r'] == $row['student_nis']) ? 
											'<input type="hidden" name="guest_list_student_id" value='.$row['student_id'].'><input type="hidden" name="guest_list_code" value='.$row['student_nis'].date('Ymdhis').'>' : '' ?> 
										<?php endforeach; ?>
										
                					    <div class="col-md-6">
                    						<div class="form-group">
                    							<label>Tanggal</label>
                    							<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
                    								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    								<input class="form-control md-3" required="" type="text" name="guest_list_date" value="<?php echo date("Y-m-d") ?>" placeholder="Tanggal Setor">
                    							</div>
                    						</div>
                					    </div>
                					    
                					    <div class="col-md-6">
                						<div class="form-group">
                							<label>Jam</label>
                							<input type="text" class="form-control" required="" name="guest_list_time" class="form-control" placeholder="Contoh 12.00" minlength="5" maxlength="5">
                						</div>
                						</div>
                						
                						<div class="col-md-12">
                						<div class="form-group">
                							<label>Penjenguk/Mahram 
                						    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addMahram<?php foreach ($siswa as $student): echo $student['student_id']; endforeach; ?>"><i class="fa fa-plus"></i> Tambah Mahram</button></label>
                							<table>
                							    <tr>
                							        <td>
                							<input type="checkbox" id="selectall" value="checkbox" name="checkbox">    
                							        </td>
                							        <td>
                							            <b>Pilih Semua</b>
                							        </td>
                							    </tr>
                							    <?php foreach($guest as $row) : ?>
                							    <tr>
                							        <td>
                							            <input type="checkbox" class="checkbox" name="list_tamu_guest_id[]" value="<?php echo $row['guest_id']; ?>">
                							        </td>
                							        <td>
                							            <?php echo $row['guest_name'] . ' (' . $row['mahram_note'] . ')'; ?>
                							        </td>
                							        <td>
                							             <a href="#delMahram<?php echo $row['guest_id'] ?>" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
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
															<?php echo form_open('manage/visit/delete_mahram/' . $row['guest_id']); ?>
															<input type="hidden" name="student_id" value="<?php echo $row['guest_student_id']; ?>">
															<input type="hidden" name="period" value="<?php echo $f['n']?>">
															<input type="hidden" name="nis" value="<?php echo $f['r']?>">
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
															<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
															<?php echo form_close(); ?>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
                							    <?php endforeach ?>
                							</table>
                						</div>
                						</div>
                						
                					    <div class="col-md-12">
            						        <button type="submit" class="btn btn-success">Simpan</button>
            						        <button type="reset" class="btn btn-default">Kosongkan</button>
            						    </div>
                					</div>    
                					</div>
                					<?php echo form_close(); ?>
								</div>
								<div class="tab-pane" id="tab_3">
									<div class="box-body table-responsive">
										<table class="table table-bordered" style="white-space: nowrap;">
											<thead>
												<tr class="info">
													<th>No.</th>
													<th>NIS</th>
													<th>Nama</th>
													<th>Unit</th>
													<th>Kelas</th>
													<th>Total Kunjungan</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i =1;
												foreach ($visitSum as $row):
												?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo $row['student_nis'] ?></td>
													<td><?php echo $row['student_full_name'] ?></td>
													<td><?php echo $row['majors_name'] ?></td>
													<td><?php echo $row['class_name'] ?></td>
													<td><?php echo $row['guestlistSum'] . ' Kali' ?></td>
												</tr>
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
									<th>Kelas</th>
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
			
<div class="modal fade" id="addMahram<?php foreach ($siswa as $student): echo $student['student_id']; endforeach; ?>" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Tambah Data Mahram</h4>
			</div>
			<?php echo form_open('manage/visit/add_mahram', array('method'=>'post')); ?>
			<div class="modal-body">
			    <input type="hidden" name="period" value="<?php echo $f['n']?>">
				<input type="hidden" name="nis" value="<?php echo $f['r']?>">
			    <input type="hidden" class="form-control" required="" name="student_id" value="<?php foreach ($siswa as $student): echo $student['student_id']; endforeach; ?>">
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

<script>
    function ambil_data(nis){
            var nisSantri = nis;
            var thAjaran    = $("#th_ajar").val();
            
            window.location.href = '<?php echo base_url();?>manage/visit?n='+thAjaran+'&r='+nisSantri;
      }
    
    function get_kelas(){
	    var id_majors    = $("#majors_id").val();
	    
        $.ajax({ 
            url: '<?php echo base_url();?>manage/visit/get_kelas',
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

<script>
	$(document).ready(function(){
		$('#xtable').DataTable();
	});
</script>

<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>