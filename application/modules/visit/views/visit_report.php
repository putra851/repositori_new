
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
									<select class="form-control" name="p" >
										<option value="">-- Pilih T.A. --</option>
										<option <?php echo (isset($q['p']) AND $q['p'] == '0') ? 'selected' : '' ?> value="0">Semua T.A.</option>
										<?php foreach ($period as $row): ?>
											<option <?php echo (isset($q['p']) AND $q['p'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<label>Unit Sekolah</label>
									<select class="form-control" name="k" id="majors_id" onchange="get_kelas()"  >
										<option value="">-- Pilih Unit --</option>
										<option <?php echo (isset($q['k']) AND $q['k'] == '0') ? 'selected' : '' ?> value="0">Semua Unit</option>
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
									<select class="form-control" name="c" id="class_id" onchange="get_siswa()" >
										<option value="">-- Pilih Kelas --</option>
										<?php if(isset($q['k'])){?>
										<option <?php echo (isset($q['c']) AND $q['c'] == '0') ? 'selected' : '' ?> value="0">Semua Kelas</option>
										<?php foreach ($class as $row): ?>
											<option <?php echo (isset($q['c']) AND $q['c'] == $row['class_id']) ? 'selected' : '' ?> value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
										<?php endforeach; ?>
										<?php } ?>
									</select>
								</div>
							</div>
							</div>
							
							<div id="td_siswa">
							<div class="col-md-2">  
								<div class="form-group">
									<label>Santri</label>
									<select class="form-control" name="m" id="student_id" >
										<option value="">-- Pilih Santri --</option>
										<?php if(isset($q['c'])){?>
										<option <?php echo (isset($q['m']) AND $q['m'] == '0') ? 'selected' : '' ?> value="0">Semua Santri</option>
										<?php foreach ($student as $row): ?>
											<option <?php echo (isset($q['m']) AND $q['m'] == $row['student_id']) ? 'selected' : '' ?> value="<?php echo $row['student_id'] ?>"><?php echo $row['student_full_name'] ?></option>
										<?php endforeach; ?>
										<?php } ?>
									</select>
								</div>
							</div>
							</div>
							
							<div class="col-md-2">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary">Cari</button>
							<?php if ($q AND !empty($visit)) { ?>
							<a class="btn btn-success" target="_blank" href="<?php echo site_url('manage/visit/visit_excel' . '/?' . http_build_query($q)) ?>"><i class="fa fa-file-excel-o" ></i> Excel</a>
							<?php } ?>
						    </div>
					        </div>
					</div>
					</form>
					</div>
				</div>
				<?php if ($q AND !empty($student)) { ?>
				<div class="box box-info">
					<div class="box-body table-responsive">
						<table id="dtable" class="table table-responsive table-bordered" style="white-space: nowrap;">
						    <thead>
							<tr>
								<th>No. </th> 
								<th>NIS</th> 
								<th>Nama</th>
								<th>Kelas</th>
								<th>Unit</th>
								<th>Total </th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							<?php 
							
							    $no = 1;
							    foreach ($visit as $row) : 
							?>
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo $row['student_nis']?></td> 
									<td><?php echo $row['student_full_name']?></td>
									<td><?php echo $row['class_name']?></td>
									<td><?php echo $row['majors_short_name'] ?></td>
									<td><?php echo $row['guestlistSum'] . ' Kali' ?></td>
									<td><a href="<?php echo base_url() . 'manage/visit/printBook/?n='.$row['period_id'].'&r=' . $row['student_nis']; ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak Buku</a></td>
								</tr>
							<?php endforeach ?>
                            </tbody>
						</table>
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
    function get_kelas(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/visit/class_searching',
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
    
    function get_siswa(){
        var id_majors    = $("#majors_id").val();
        var id_class     = $("#class_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/visit/student_searching',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
                    'id_class': id_class,
            },    
            success: function(msg) {
                    $("#td_siswa").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>
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