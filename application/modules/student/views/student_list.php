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
						<?php if ($this->session->userdata('uroleid') != USER) { ?>
						<a href="<?php echo site_url('manage/student/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
						<a href="<?php echo site_url('manage/student/import_student') ?>" class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Upload Siswa</a>
						<a href="<?php echo site_url('manage/student/update_whatsapp') ?>" class="btn btn-sm btn-success"><i class="fa fa-whatsapp"></i> Update No. WA Ortu</a>
						<?php } ?>
						
						<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#printStudent"><i class="fa fa-print"></i> Cetak</button>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#xlsStudent"><i class="fa fa-excel"></i> Export Xls</button>
						<div class="row">
						<div class="col-md-9"><br>
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required>
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td id="td_kelas">
    								<select style="width: 200px;" id="c" name="c" class="form-control" required>
    								    <option value="">--- Pilih Kelas ---</option>
							        <?php if(isset($s['m'])){?>
							        <option value="all" <?php echo (isset($s['c']) && $s['c']=='all') ? 'selected' : '' ?> >Semua Kelas</option>
            						    <?php foreach($class as $row){?>
            						        <option value="<?php echo $row['class_id']; ?>" <?php echo (isset($s['c']) && $s['c'] == $row['class_id']) ? 'selected' : '' ?>><?php echo $row['class_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
    								</td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td id="td_madin">
    								<select style="width: 200px;" id="d" name="d" class="form-control" required>
    								    <option value="">--- Pilih Kamar ---</option>
							        <?php if(isset($s['m'])){?>
							        <option value="all" <?php echo (isset($s['d']) && $s['d']=='all') ? 'selected' : '' ?> >Semua Kamar</option>
            						    <?php foreach($madin as $row){?>
            						        <option value="<?php echo $row['madin_id']; ?>" <?php echo (isset($s['d']) && $s['d'] == $row['madin_id']) ? 'selected' : '' ?>><?php echo $row['madin_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
    								</td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>     
    								<select style="width: 200px;" id="s" name="s" class="form-control">
    								  <option value="1" <?php echo (isset($s['s']) && $s['s'] == '1') ? 'selected' : '' ?>>Aktif</option>
            						  <option value="0" <?php echo (isset($s['s']) && $s['s'] == '0') ? 'selected' : '' ?>>Tidak Aktif</option>
            						  <option value="2" <?php echo (isset($s['s']) && $s['s'] == '2') ? 'selected' : '' ?>>Tamat</option>
            						  <option value="3" <?php echo (isset($s['s']) && $s['s'] == '3') ? 'selected' : '' ?>>Pindah Sekolah</option>
            						  <option value="4" <?php echo (isset($s['s']) && $s['s'] == '4') ? 'selected' : '' ?>>Drop Out</option>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>
							        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
							        </td>
							    </tr>
							</table>
						<?php echo form_close(); ?>
						</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th> 
									<th>No</th>
									<th>NIS</th>
									<th>Nama</th>
									<th>Unit</th>
									<th>Kelas</th>
									<th>Kamar</th>
									<th>WA Ortu</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($student)) {
										$i = 1;
										foreach ($student as $row):
											?>
											<tr>
												<td><input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['student_id']; ?>"></td>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['student_nis']; ?></td>
												<td><?php echo $row['student_full_name']; ?></td>
												<td><?php echo $row['majors_short_name']; ?></td>
												<td><?php echo $row['class_name']; ?></td>
												<td><?php echo $row['madin_name']; ?></td>
												<td><a href="https://wa.me/<?php echo substr($row['student_parent_phone'], 1); ?>" target="_blank"><?php echo str_replace('+62', '0', $row['student_parent_phone']); ?></a></td>
												<td><label class="label <?php echo ($row['student_status']==1) ? 'label-success' : 'label-danger' ?>"><?php echo ($row['student_status']==1) ? 'Aktif' : 'Tidak Aktif' ?></label></td>
												<td>
													<a href="<?php echo site_url('manage/student/rpw/' . $row['student_id']) ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Reset Password"><i class="fa fa-unlock"></i></a>
													<a href="<?php echo site_url('manage/student/view/' . $row['student_id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/student/edit/' . $row['student_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
													<?php } ?>
													<a href="<?php echo site_url('manage/student/printPdf/' . $row['student_id']) ?>" class="btn btn-success btn-xs view-pdf" data-toggle="tooltip" title="Cetak Kartu"><i class="fa fa-print"></i></a>
												</td>	
											</tr>
											<?php
											$i++;
										endforeach;
									} else {
										?>
										<tr id="row">
											<td colspan="8" align="center">Data Kosong</td>
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
					</div>
				</div>
			</form>
		</section>
		<!-- /.content -->
	</div>
	
	<div class="modal fade" id="printStudent" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Pilih Kelas</h4>
				</div>
				<form action="<?php echo base_url();?>manage/student/print_students" method="post" target="_blank">
				<div class="modal-body">
					<label>Unit Sekolah</label>
					<select required="" name="modal_majors" id="modal_majors" class="form-control">
					    <option value="">-Pilih Unit Sekolah-</option>
					    <?php foreach($majors as $row){?>
					        <option value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
					    <?php } ?>
					</select>
					<label>Kelas</label>
					<div id="div_class">
					<select required="" name="modal_class" id="modal_class" class="form-control">
					    <option value="">-Pilih Kelas-</option>
					</select>
					</div>
					<label>Kamar</label>
					<div id="div_madin">
					<select required="" name="modal_madin" id="modal_madin" class="form-control">
					    <option value="">-Pilih Kamar-</option>
					</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger"><i class="fa fa-print"></i> Cetak</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="xlsStudent" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Pilih Kelas</h4>
				</div>
				<form action="<?php echo base_url();?>manage/student/excel_students" method="post" target="_blank">
				<div class="modal-body">
					<label>Unit Sekolah</label>
					<select required="" name="xls_majors" id="xls_majors" class="form-control">
					    <option value="all">-Unit Sekolah-</option>
					    <?php foreach($majors as $row){?>
					        <option value="<?php echo $row['majors_id'] ?>"><?php echo $row['majors_short_name'] ?></option>
					    <?php } ?>
					</select>
					<label>Kelas</label>
					<div id="div_class_xls">
					<select required="" name="xls_class" id="xls_class" class="form-control">
					    <option value="">-Pilih Kelas-</option>
					</select>
					</div>
					<label>Kamar</label>
					<div id="div_madin_xls">
					<select required="" name="xls_madin" id="xls_madin" class="form-control">
					    <option value="">-Pilih Kamar-</option>
					</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa-excel-o"></i> Export</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				</form>
			</div>
		</div>
	</div>

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
	$('.view-pdf').on('click',function(){
		var pdf_link = $(this).attr('href');      
		var iframe = '<object type="application/pdf" data="'+pdf_link+'" width="100%" height="350">No Support</object>'
		$.createModal({
			title:'Cetak Kartu Pembayaran',
			message: iframe,
			closeButton:true,
			scrollable:false
		});
		return false;        
	});    
})
</script>
<script>
	$(document).ready(function() {
		$("#selectall").change(function() {
			$(".checkbox").prop('checked', $(this).prop("checked"));
		});
	});
</script>

<script>
    
    $("#m").change(function(e){
	    var id_majors    = $("#m").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/class_searching',
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
		e.preventDefault();
	});
    
    $("#m").change(function(e){
	    var id_majors    = $("#m").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/madin_searching',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#td_madin").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		e.preventDefault();
	});
	
	$("#modal_majors").change(function(e){
	    var id_majors    = $("#modal_majors").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/get_mclass',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_class").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		e.preventDefault();
	});
	
	$("#modal_majors").change(function(e){
	    var id_majors    = $("#modal_majors").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/get_mmadin',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_madin").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		e.preventDefault();
	});
	
	$("#xls_majors").change(function(e){
	    var id_majors    = $("#xls_majors").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/get_xls_class',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_class_xls").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		e.preventDefault();
	});
	
	$("#xls_majors").change(function(e){
	    var id_majors    = $("#xls_majors").val();
        //alert(id_jurusan+id_kelas);
        $.ajax({ 
            url: '<?php echo base_url();?>manage/student/get_xls_madin',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#div_madin_xls").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
		e.preventDefault();
	});
	
</script>