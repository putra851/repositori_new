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
						        <td>    
            						<a href="<?php echo site_url('manage/employees/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
        					    </td>
        					    <td>
            						<a href="<?php echo site_url('manage/employees/import_employees') ?>" class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Upload Pegawai</a>
            						<?php } ?>
        					    </td>
        					    <td>
        							<form action="#" method="post">
        								<input type="hidden" name="action" value="printPdf">
        								<button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-print"></span> Cetak</button>
        							<?php echo form_close(); ?>
        					    </td>
						    </tr>      
						</table>
						
						
					</div>
						
						
						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required onchange="get_position()">
    								    <option value="">--- Pilih Unit Sekolah ---</option>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
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
            						    <?php foreach($class as $row){?>
            						        <option value="<?php echo $row['class_id']; ?>" <?php echo (isset($s['p']) && $s['p'] == $row['jabatan_id']) ? 'selected' : '' ?>><?php echo $row['jabatan_name'] ?></option>
            						    <?php } ?>
    								</select>
    								<?php } ?>
							        <td>
							            &nbsp&nbsp
							        </td>
							        <td>
							        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
							        </td>
							    </tr>
							</table>
						</div>
						<?php echo form_close(); ?>
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
									<th>Status Kepegawaian</th>
									<th>No. Telpon/HP</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($employee)) {
										$i = 1;
										foreach ($employee as $row):
											?>
											<tr>
												<td><input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['employee_id']; ?>"></td>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['employee_nip']; ?></td>
												<td><?php echo $row['employee_name']; ?></td>
												<td><?php echo $row['majors_short_name']; ?></td>
												<td><?php echo $row['position_name']; ?></td>
												<td><?php if( $row['employee_category']=='1') {
												    echo 'Pegawai Tetap';
												} else if( $row['employee_category']=='2') {
												    echo 'Pegawai Tidak Tetap';
												} else {
												    echo '-';
												} ?></td>
												<td><?php echo $row['employee_phone']; ?></td>
												<td><label class="label <?php echo ($row['employee_status']==1) ? 'label-success' : 'label-danger' ?>"><?php echo ($row['employee_status']==1) ? 'Aktif' : 'Tidak Aktif' ?></label></td>
												<td>
													<a href="<?php echo site_url('manage/employees/rpw/' . $row['employee_id']) ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Reset Password"><i class="fa fa-unlock"></i></a>
													<a href="<?php echo site_url('manage/employees/view/' . $row['employee_id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>
													<?php if ($this->session->userdata('uroleid') != USER) { ?>
													<a href="<?php echo site_url('manage/employees/edit/' . $row['employee_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
													<?php } ?>
													<a href="<?php echo site_url('manage/employees/printPdf/' . $row['employee_id']) ?>" class="btn btn-success btn-xs view-pdf" data-toggle="tooltip" title="Cetak Kartu"><i class="fa fa-print"></i></a>
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
    function get_position(){
        var id_majors    = $("#m").val();
        $.ajax({ 
            url: '<?php echo base_url();?>manage/employees/searching_position',
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