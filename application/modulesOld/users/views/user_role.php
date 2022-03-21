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

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-4">

				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body">
						
						<div class="form-group">
							<label>Hak Akses <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<select name="role_id" id="role_id" class="form-control" onchange="loadData()">
								<option value="">-Pilih Hak Akses-</option>
								<?php foreach ($roles as $row): ?> 
									<option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
													
						<a href="<?php echo site_url('manage/users/') ?>" class="btn btn-info btn-block"><b>Kembali</b></a>

						
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

			</div>
			<div class="col-md-8">
				<!-- About Me Box -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Hak Akses</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					    <div id="tabel"></div>	
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
    $(document ).ready(function() {
        //loadData();
    });
</script>

<script type="text/javascript">
    function loadData(){
        var role_id = $("#role_id").val();
        $.ajax({
            type:'GET',
            url :'<?php echo base_url() ?>manage/users/modul',
            data:'role_id='+role_id,
            success:function(html){
                $("#tabel").html(html);
            }
        })
    }
    
    function addRule(id_modul){
        var role_id = $("#role_id").val();
        $.ajax({
            type:'GET',
            url :'<?php echo base_url() ?>manage/users/addrule',
            data:'role_id='+role_id+'&menu_id='+id_modul,
            success:function(html){
                //alert('suksess mengubah akses');
            }
        })
    }
</script>