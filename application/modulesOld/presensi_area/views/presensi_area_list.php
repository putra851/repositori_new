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
						<table>
						    <tr>
						        <!-- <td>    
            						<a href="<?php echo site_url('manage/employees/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
        					    </td> -->
        					    <!-- <td>
            						<a href="<?php echo site_url('manage/employees/import_employees') ?>" class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Upload Pegawai</a>
            						<?php } ?>
        					    </td>
        					    <td>
        							<form action="#" method="post">
        								<input type="hidden" name="action" value="printPdf">
        								<button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-print"></span> Cetak</button>
        							<?php echo form_close(); ?>
        					    </td> -->
						    </tr>      
						</table>
						
						
					</div>
						
						
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'post')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required onchange="get_position()">
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id'] || !isset($s['m']) && $row['majors_id']==1) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
    								    <option value="99">Lainnya</option>
    								</select>
							        </td>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td id="td_position">
    								<select style="width: 200px;" id="p" name="p" class="form-control" required>
    								    <option value="">--- Pilih Jabatan ---</option>
							        <?php if(isset($s['m'])){?>
							        <option value="all" <?php echo (isset($s['p']) && $s['p']=='all') ? 'selected' : '' ?> >Semua Jabatan</option>
            						    <?php foreach($position as $row){?>
            						        <option value="<?php echo $row['position_id']; ?>" <?php echo (isset($s['p']) && $s['p'] == $row['position_id']) ? 'selected' : '' ?>><?php echo $row['position_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>
							        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
							        </td>
									<td>
							            &nbsp&nbsp
							        </td>
							        <td>
									<input type="submit" name="act_lock" id="lock" value="lock" style="display:none"/>
							        <button type="button" class="btn btn-danger" onclick="$('#lock').click()"><i class="fa fa-lock"></i> Lock</button>    
							        </td>
									<td>
							            &nbsp&nbsp
							        </td>
							        <td>
									<input type="submit" name="act_lock" id="unlock" value="unlock" style="display:none"/>
							        <button type="button" class="btn btn-success" onclick="$('#unlock').click()"><i class="fa fa-unlock"></i> Unlock</button>    
							        </td>
							    </tr>
							</table>
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="dtable" class="table table-hover">
							    <thead>
								<tr>
									<th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th> 
									<th>No</th>
									<th>NIP</th>
									<th>Nama</th>
									<th>Unit Sekolah</th>
									<th>Jabatan</th>
									<th>Area Absen</th>
									<th>Status Absen</th>
									<th>Jarak Radius</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($presensi_area)) {
										$i = 1;
										foreach ($presensi_area as $row):
											$status_absen="UNLOCK";
											if($row['status_absen']=='Y')
												$status_absen="LOCK";
											?>
											<tr>
												<td><input type="checkbox" class="checkbox" name="id_p[]" value="<?php echo $row['id_pegawai']; ?>"></td>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['nip']; ?></td>
												<td><?php echo $row['nama_pegawai']; ?></td>
												<td><?php echo $row['majors_short_name']; ?></td>
												<td><?php echo $row['position_name']; ?></td>
												<td>
													<?php 
														$ex_aa=explode(',',$row['area_absen']);
														$s="";
														$html="<ul>";
														foreach($ex_aa as $eaa):
															$aa=$this->db->query("select nama_area from area_absensi where id_area='$eaa'")->row()->nama_area;
															$html.="<li>".$aa."</li>";
														endforeach; 
														$html.="</ul>";
														echo $html;
													?>
												</td>
												<td><?php echo "Default : ".$status_absen."<br>TEMP : ".$row['status_absen_temp']; ?></td>
												<td><?php echo $row['jarak_radius']; ?> Meter</td>
												<td>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/presensi_area/edit/' . $row['id_pegawai']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
													<?php } ?>
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
							<?php echo form_close(); ?>
						</div>
						<div>
						<?php echo $this->pagination->create_links(); ?>
						</div>
						<!-- /.box -->
					</div>
				</div>
		</section>
		<!-- /.content -->
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
			title:'Cetak Kartu Pegawai',
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
	get_position();
    function get_position(){
        var id_majors    = $("#m").val();
        $.ajax({ 
            url: '<?php echo base_url();?>manage/presensi_area/searching_position',
            type: 'POST', 
            data: {
                    'id_majors': id_majors,
            },    
            success: function(msg) {
                    $("#td_position").html(msg);
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>