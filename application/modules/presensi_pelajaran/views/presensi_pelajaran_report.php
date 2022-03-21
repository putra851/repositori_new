
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
							<div class="col-md-2">  
								<div class="form-group">
									<label>Tahun Ajaran</label>
									<select class="form-control" name="p" id="period_id" required="">
										<option value="">-- Pilih Tahun Ajaran --</option>
										<?php foreach ($period as $row): ?>
											<option <?php echo (isset($q['p']) AND $q['p'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'] . '/' . $row['period_end'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<label>Bulan</label>
									<select class="form-control" name="m" id="month_id" required="">
										<option value="">-- Pilih Bulan --</option>
										<?php foreach ($month as $row): ?>
											<option <?php echo (isset($q['m']) AND $q['m'] == $row['month_id']) ? 'selected' : '' ?> value="<?php echo $row['month_id'] ?>"><?php echo $row['month_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<label>Unit Pesantren</label>
									<select class="form-control" name="k" id="majors_id" onchange="get_kelas()"  required="">
										<option value="">-- Pilih Unit --</option>
										<?php foreach ($majors as $row): ?>
											<option <?php echo (isset($q['k']) AND $q['k'] == $row['majors_id']) ? 'selected' : '' ?> value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div id="td_kelas">
							<div class="col-md-2">  
								<div class="form-group">
									<label>Kelas</label>
									<select class="form-control" name="c" id="class_id" required="">
										<option value="">-- Pilih Kelas --</option>
										<?php if(isset($q['k'])){?>
										<?php foreach ($class as $row): ?>
											<option <?php echo (isset($q['c']) AND $q['c'] == $row['class_id']) ? 'selected' : '' ?> value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
										<?php endforeach; ?>
										<?php } ?>
									</select>
								</div>
							</div>
							</div>
							<div id="td_pelajaran">
							<div class="col-md-2">  
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select class="form-control" name="l" id="lesson_id" required="">
										<option value="">-- Pilih Mata Pelajaran --</option>
										<?php if(isset($q['l'])){?>
										<?php foreach ($lesson as $row): ?>
											<option <?php echo (isset($q['c']) AND $q['l'] == $row['lesson_id']) ? 'selected' : '' ?> value="<?php echo $row['lesson_id'] ?>"><?php echo $row['lesson_code'] . ' - ' . $row['lesson_name'] ?></option>
										<?php endforeach; ?>
										<?php } ?>
									</select>
								</div>
							</div>
							</div>
							<div class="col-md-2">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
							<?php if ($q AND !empty($student)) { ?>
							<a class="btn btn-success" target="_blank" href="<?php echo site_url('manage/presensi_pelajaran/report_print' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel-o" ></i> Cetak</a>
							<?php } ?>
						    </div>
					        </div>
					</div>
					</form>
					</div>
				</div>
				
				<?php if ($q AND !empty($student)) { ?>
				<div class="box box-success">
					<div class="box-body table-responsive">
					    <?php $pelajaran = $this->Lesson_model->get(array('id' => $q['l'])) ?>
					    <table class="table">
					        <tr>
					            <td width="15%">Mata Pelajaran</td>
					            <td width="5%">:</td>
					            <td><?php echo $pelajaran['lesson_name'] ?></td>
					        </tr>
					        <tr>
					            <td>Guru/Pengajar</td>
					            <td>:</td>
					            <td><?php echo $pelajaran['lesson_teacher'] ?></td>
					        </tr>
					    </table>
    					<table class="table table-responsive table-bordered" style="white-space: nowrap;">
    						    <thead>
    							<tr>
    								<th width='5' rowspan='2'><center>No.</center></th> 
    								<th rowspan='2'><center>NIS</center></th> 
    								<th rowspan='2'><center>Nama</center></th>
    								<th colspan='<?php echo $interval->format("%a")?>'><center><?php echo $namaBulan . ' ' . $namaTahun ?></center></th>
    							</tr>
    							<tr>
    							    
                                <?php
                                    foreach ($daterange as $dt) {
                                        echo '<th>'.$dt->format("d").'</th>';
                                    }
                                ?>
    							</tr>
    							</thead>
    							<tbody>
    							<?php 
    							    $no = 1;
    							    foreach ($student as $row) :
    						    ?>
    						    <tr>
            									<td><?php echo $no++ ?></td>
            									<td><?php echo $row['student_nis']?></td> 
            									<td><?php echo $row['student_full_name']?></td>
                                    <?php
                                        foreach ($daterange as $dt) {
                                            $date = $dt->format("Y-m-d");
                                            $period_id = $q['p'];
                                            $month_id = $q['m'];
                                            $class_id = $q['c'];
                                            $lesson_id = $q['l'];
                                            $student_id = $row['student_id'];
                                            
                                            $presensi = $this->db->query("SELECT presensi_pelajaran_status FROM presensi_pelajaran WHERE presensi_pelajaran_date = '$date' AND presensi_pelajaran_period_id = '$period_id' AND presensi_pelajaran_month_id = '$month_id' AND presensi_pelajaran_class_id = '$class_id' AND presensi_pelajaran_lesson_id = '$lesson_id' AND presensi_pelajaran_student_id = '$student_id'")->row_array();
                                            echo (isset($presensi['presensi_pelajaran_status'])) ? '<td>'.$presensi['presensi_pelajaran_status'].'</td>' : '<td>-</td>';
                                        }
                                    ?>
            								</tr>
    							<?php endforeach ?>
                                </tbody>
    						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<?php 
				}
				?>
				
				
				
				
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<script>
    function get_kelas(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/presensi_pelajaran/class_searching',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#td_kelas").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>
<script>
    function get_pelajaran(){
        var class_id    = $("#class_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/presensi_pelajaran/lesson_searching',
            type: 'POST', 
            data: {
                    'class_id': class_id,
            },    
            success: function(msg) {
                    $("#td_pelajaran").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>
<script>
	$(document).ready(function() {
		$("#selectallhadir").click(function() {
            if ($(this).is(':checked'))
                $(".hadir").attr("checked", "checked");
            else
                $(".hadir").removeAttr("checked");
        });
		$("#selectallsakit").click(function() {
            if ($(this).is(':checked'))
                $(".sakit").attr("checked", "checked");
            else
                $(".sakit").removeAttr("checked");
        });
		$("#selectallizin").click(function() {
            if ($(this).is(':checked'))
                $(".izin").attr("checked", "checked");
            else
                $(".izin").removeAttr("checked");
        });
		$("#selectallalpha").click(function() {
            if ($(this).is(':checked'))
                $(".alpha").attr("checked", "checked");
            else
                $(".alpha").removeAttr("checked");
        });
	});
</script>