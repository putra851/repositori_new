
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
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-header">
						<?php echo form_open(current_url(), array('method' => 'get')) ?>
						<div class="row">
							<div class="col-md-3">  
								<div class="form-group">
									<label>Tahun Ajaran</label>
									<select class="form-control" name="p" required="">
										<option value="">-- Pilih T.A. --</option>
										<?php foreach ($period as $row): ?>
											<option <?php echo (isset($q['p']) AND $q['p'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group">
									<label>Bulan</label>
            						<select class="form-control" name="m" id="month_id" required="">
            								<option value="">--Pilih Bulan--</option>
            								<?php foreach ($month as $row): ?>
            								<option <?php echo (isset($q['m']) AND $q['m'] == $row['month_id']) ? 'selected' : '' ?> value="<?php echo $row['month_id'] ?>"><?php echo $row['month_name'] ?></option>
            							    <?php endforeach; ?>
    							    </select>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group">
									<label>Unit Sekolah</label>
									<select class="form-control" name="k" id="majors_id" required="">
										<option value="">-- Pilih Unit --</option>
            						    <?php if($this->session->userdata('umajorsid') == '0') { ?>
            						    <option value="all">Semua Unit</option>
            						    <?php } ?>
										<?php foreach ($majors as $row): ?>
											<option <?php echo (isset($q['k']) AND $q['k'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
							<?php if ($q AND !empty($employee)) { ?>
					        <a data-toggle="modal" class="btn btn-success" title="Pastikan Sudah Ada Siswa yang Dicentang" href="#kirimNotif" onclick="get_form()"><span class="fa fa-whatsapp"></span> Kirim Notif</a>
							<?php } ?>
						    </div>
					        </div>
					</div>
					</form>
					</div>
				</div>
				<?php if ($q AND isset($employee)) { ?>
				<div class="box box-info">
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-responsive table-bordered" style="white-space: nowrap;">
						    <thead>
							<tr>
								<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
								<th>No</th>
								<th>Nama</th>
							    <th>Jabatan</th>
								<th>Bulan</th>
								<th>Gaji</th>
								<th>Jumlah Potongan</th>
								<th>Gaji Diterima</th>
							</tr>
							</thead>
							<tbody>
						    <?php 
        						$no             = 1;
        						$sumGaji        = 0;
        						$sumPotongan    = 0;
        						$sumDiterima    = 0;
        						
        					    foreach ($employee as $row) {
        					        
    					        $gaji = $row['gaji_pokok'];
    					        
							    if($row['gaji_month_id']<7){
                                    $tahun = $row['period_start'];   
							    } else {
							        $tahun = $row['period_end'];
							    }
						    ?>
								<tr>  
									<td>
									    <input type="checkbox" class="checkbox" name="msg[]" id="msg" value="<?php echo $row['employee_id']; ?>">
									</td>
    				                <td><?php echo $no++ ?></td>
    				                <td>
    				                    <?php echo$row['employee_name']?>
    				                </td>
    				                <td>
    				                    <?php echo $row['position_name']?>
    				                </td>
    				                <td>
    				                    <?php echo $row['month_name'] . ' ' . $tahun ?>
    				                </td>
    				                <td>
    				                    <?php echo 'Rp ' . number_format($gaji, 0, ",", ".") ?>
    				                </td>
    				                <td>
    				                    <?php echo 'Rp ' . number_format($row['gaji_potongan'], 0, ",", ".") ?>
    				                </td>
    				                <td>
    				                    <?php echo 'Rp ' . number_format($row['gaji_jumlah'], 0, ",", ".") ?>
    				                </td>
    						    </tr>
        					    <?php 
        						    $sumGaji        += $gaji;
            						$sumPotongan    += $row['gaji_potongan'];
            						$sumDiterima    += $row['gaji_jumlah'];
        					    }
        					    ?>
        						    </tbody>
        						    <tr style="background-color: #E2F7FF;">
        				                <td align="center" colspan="4"><b>Total</b></td>
        				                <td></td>
        				                <td><?php echo 'Rp '.number_format($sumGaji, 0, ",", ".") ?></td>
        				                <td><?php echo 'Rp '.number_format($sumPotongan, 0, ",", ".") ?></td>
        				                <td><?php echo 'Rp '.number_format($sumDiterima, 0, ",", ".")?></td>
        						    </tr>
        				        </table>
					</div>
					
	
	<div class="modal fade" id="kirimNotif" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Kirim Notif</h4>
					</div>
					<div class="modal-body">
		            <?php echo form_open('manage/slip/send/', array('method'=>'post')); ?>
		                <p>Anda Yakin Mau Mengirim Notif Gaji ke Pegawai Tersebut?</p>
		                <input type="hidden" class="form-group" name="period_id" value="<?php echo $q['p'] ?>">
		                <input type="hidden" class="form-group" name="majors_id" value="<?php echo $q['k'] ?>">
		                <input type="hidden" class="form-group" name="month_id" value="<?php echo $q['m'] ?>">
            		    <div id="fbatch"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Kirim</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
					<!-- /.box-body -->
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
	$(document).ready(function() {
		$("#selectall2").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>
		
<script>

  function get_form(){
    var employee_id = $('#msg:checked');
    if(employee_id.length > 0)
    {
        var employee_id_value = [];
        $(employee_id).each(function(){
            employee_id_value.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url();?>manage/slip/get_form/',
            method:"POST",
            data: {
                    employee_id : employee_id_value,
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
        alert("Belum ada siswa yang dipilih");
    }
  }
  
</script>