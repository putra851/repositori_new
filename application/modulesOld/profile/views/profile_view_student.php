<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('student') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
							<br>
							<div class="row">
								<div class="col-md-2">
									<?php if (!empty($student['student_img'])) { ?>
									<img src="<?php echo upload_url('student/'.$student['student_img']) ?>" class="img-responsive avatar">
									<?php } else { ?>
									<img src="<?php echo media_url('img/user.png') ?>" class="img-responsive avatar">
									<?php } ?>
								</div>
								<div class="col-md-10">
									<table class="table table-hover">
										<tbody>
											<tr>
												<td>NIS Siswa</td>
												<td>:</td>
												<td><?php echo $student['student_nis'] ?></td>
											</tr>
											<tr>
												<td>Nama lengkap</td>
												<td>:</td>
												<td><?php echo $student['student_full_name'] ?></td>
											</tr>
											<tr>
												<td>Jenis Kelamin</td>
												<td>:</td>
												<td><?php if ($student['student_gender']=='L') { echo 'Laki-laki'; } else if ($student['student_gender']=='P') { echo 'Perempuan'; } else { echo 'Belum Diisi'; } ?></td>
											</tr>
											<tr>
												<td>Kelas</td>
												<td>:</td>
												<td><?php echo $student['class_name'] ?></td>
											</tr>
											<tr>
												<td>Kamar</td>
												<td>:</td>
												<td><?php echo $student['madin_name'] ?></td>
											</tr>
											<tr>
												<td>Tempat, Tanggal Lahir</td>
												<td>:</td>
												<td><?php echo $student['student_born_place'].', '. pretty_date($student['student_born_date'],'d F Y',false) ?></td>
											</tr>
											<tr>
												<td>Alamat</td>
												<td>:</td>
												<td><?php echo $student['student_address'] ?></td>
											</tr>
											<tr>
												<td>Nama Ayah Kandung</td>
												<td>:</td>
												<td><?php echo $student['student_name_of_father'] ?></td>
											</tr>
											<tr>
												<td>Nama Ibu Kandung</td>
												<td>:</td>
												<td><?php echo $student['student_name_of_mother'] ?></td>
											</tr>
											<tr>
												<td>No. Whatsapp Orang Tua</td>
												<td>:</td>
												<td><?php echo ($student['student_parent_phone'] == '+62' OR $student['student_parent_phone'] == NULL) ? '' : $student['student_parent_phone'] ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-8">
									<a href="<?php echo site_url('student/profile/printPdf/' . $student['student_id']) ?>" class="btn btn-success view-pdf">
										<i class="fa fa-print"></i> Cetak Kartu
									</a>

								</div>
								<div class="col-md-4 pull-right">
									<a href="<?php echo site_url('student/profile/edit') ?>" class="btn btn-warning">
										<i class="fa fa-edit"></i> Edit
									</a>
									<a href="<?php echo site_url('student/profile/cpw'); ?>" class="btn btn-primary"><i class="fa fa-refresh"></i> Ganti Password</a>

								</div>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>

				</section>
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
			title:'Cetak Kartu Siswa',
			message: iframe,
			closeButton:true,
			scrollable:false
		});
		return false;        
	});    
})
</script>