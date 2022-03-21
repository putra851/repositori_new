<?php
        $db         = $this->db->database;
        $db_host    = '103.41.204.234';
    	$db_user    = 'epesantr_semua';
        $db_pass    = '5[RB*SpX,X0)p#mXn2';
        $db_name    = 'epesantr_mobile';
        $koneksi    = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        
        $sql = "SELECT kode_sekolah FROM sekolahs WHERE db = '$db'";
        $result_get_value = mysqli_query($koneksi,$sql);
        $row_get_value = mysqli_fetch_row($result_get_value);
        $kode_sekolah = $row_get_value[0];

?>
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
									<label>Unit Sekolah</label>
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
							<div class="col-md-6">
							<div style="margin-top:25px;">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
							<?php if ($q AND !empty($student)) { ?>
					        <a data-toggle="modal" class="btn btn-success" title="Pastikan Sudah Ada Siswa yang Dicentang" href="#kirimPemberitahuan" onclick="get_form_blast()"><span class="fa fa-whatsapp"></span> Kirim Pemberitahuan</a>
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
								<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th>
								<th>No. </th> 
								<th>NIS</th> 
								<th>Nama</th>
								<th>Kelas</th>
								<th>WA Ortu</th>
							</tr>
							</thead>
							<tbody>
							<?php 
                                
                                $no = 1;
							    foreach ($student as $row) :
							?>
								<tr>
									<td>
									    <input type="checkbox" class="checkbox" name="msg[]" id="msg" value="<?php echo $row['student_id']; ?>">
									</td>
									<td><?php echo $no++ ?></td>
									<td><?php echo $row['student_nis']?></td> 
									<td><?php echo $row['student_full_name']?></td>
									<td><?php echo $row['class_name']?></td>
									<td><?php echo $row['student_parent_phone']?></td>
								</tr>
							<?php endforeach ?>
                            </tbody>
						</table>
					</div>
		
	                <div class="modal fade" id="kirimPemberitahuan" role="dialog">
            			<div class="modal-dialog modal-md">
            				<div class="modal-content">
            					<div class="modal-header">
            						<button type="button" class="close" data-dismiss="modal">&times;</button>
            						<h4 class="modal-title">Kirim Pemberitahuan</h4>
            					</div>
            					<div class="modal-body">
            		            <?php echo form_open_multipart('manage/pengumuman/blast/', array('method'=>'post')); ?>
            		            <input type="hidden" name="kode_sekolah" value="<?= $kode_sekolah; ?>">
                        		    <div id="fbatchblast"></div>
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
    function get_kelas(){
        var id_majors    = $("#majors_id").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/pengumuman/class_searching',
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

  function get_form_blast(){
    var student_id = $('#msg:checked');
    if(student_id.length > 0)
    {
        var student_id_value = [];
        $(student_id).each(function(){
            student_id_value.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url();?>manage/pengumuman/get_form/',
            method:"POST",
            data: {
                    student_id : student_id_value,
            },
            success: function(msg){
                    $("#fbatchblast").html(msg);
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