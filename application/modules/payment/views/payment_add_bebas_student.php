

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
	<div ng-controller="studentCtrl">
		<section class="content">
			<div class="row">
				<div class="box-body">
					<?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>
					<?php echo validation_errors(); ?>

					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header">
								<h3 class="box-title">Informasi Pembayaran</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $payment['pos_name'].' - T.A '.$payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
									</div>
								</div>
								<div class="form-group">						
									<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
									</div>
								</div>
								<div class="form-group">						
									<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo ($payment['payment_type']=='BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
									</div>
								</div>						  

							</div>
						</div>

					</div>
					<div class="col-md-6">

						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title">Tarif Tagihan Per Kelas</h3>
							</div>
							<div class="box-body table-responsive">

								<table class="table">
									<tbody>
										<tr>
											<td><strong>Kelas</strong></td>
											<td>
										<select id="class_id" name="class_id" class="form-control" onchange="get_student()">
        								<option value="">-- Pilih Kelas --</option>
        								<?php foreach($class as $row) { ?>
        								<option value="<?php echo $row['class_id'] ?>"><?php echo $row['class_name'] ?></option>
        									<?php } ?>
        								</select>
											</td>
										</tr>
										<tr>
											<td><strong>Nama Santri</strong></td>
											<td>
											    <div id="show_student">
												<select name="student_id" class="form-control">
													<option value="">-- Pilih Santri --</option>
												</select>
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>Tarif (Rp.)</strong></td>
											<td><input autofocus="" type="text" name="bebas_bill" placeholder="Masukan Tarif" required="" class="form-control">
											</td>
										</tr>


									</tbody>
								</table>
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-success">Simpan</button>
								<a href="<?php echo site_url('manage/payment/view_bebas/'. $payment['payment_id']) ?>" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</div>					
					<?php echo form_close(); ?>
				</div>
			</div>		
		</section>
	</div>
</div>

<script>
    function get_student(){
    	var id_kelas = $('#class_id').val();
    	
    	$.ajax({
            url: '<?php echo base_url(); ?>manage/payment/get_student',
            type: 'POST',
            data: {
                    'id_kelas' : id_kelas,
                },
            success: function(msg){
                $("#show_student").html(msg);        
            },
            error: function(msg){
                alert('msg');
            }
        });
        
    }
</script>

<script>
	var studentApp = angular.module("studentApp", []);
	var SITEURL = "<?php echo site_url() ?>";

	studentApp.controller('studentCtrl', function($scope, $http) {
		$scope.classes = [];
		$scope.students = [];


		$scope.getClass = function() {

			var url = SITEURL + 'api/get_class2/';
			$http.get(url).then(function(response) {
				
				$scope.classes = response.data;
			});

		};

		$scope.getStudent = function(id) {
			var url = SITEURL + 'api/get_student_by_class/' + id;
			$http.get(url).then(function(response) {
				$scope.students = response.data;
			});

		};

		angular.element(document).ready(function() {
			$scope.getClass();
		});

	});

	$(document).ready(function () {
		$('#selector').bind('change', function (e) { 
			if( $('#selector').val() == '') {
				$('#selTask').hide();

			} else { $('#selTask').show();
		}         
	}).trigger('change');

	});
</script>


