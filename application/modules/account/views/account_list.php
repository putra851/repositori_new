<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
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
	    <?php 
	        $majors_id = $this->session->userdata('umajorsid'); 
	    ?>
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
					    <?php if($majors_id == '0') { ?>
    					<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
    					<div class="box-body table-responsive">
							<table>
							    <tr>
							        <td>     
    								<select style="width: 200px;" id="m" name="m" class="form-control" required>
    								    <option value="">--- Pilih Unit Sekolah ---</option>
    								    <?php if($this->session->userdata('umajorsid') == '0') { ?>
    								    <option value="all" <?php echo (isset($s['m']) && $s['m']=='all') ? 'selected' : '' ?> >Semua Unit</option>
    								    <?php } ?>
            						    <?php foreach($majors as $row){?>
            						        <option value="<?php echo $row['majors_id']; ?>" <?php echo (isset($s['m']) && $s['m'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
            						    <?php } ?>
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
						</div>
						<?php echo form_close(); ?>
						<?php } ?>
					    </div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id='dtable' class='table table-hover table-responsive'>
                            <thead>
                                <tr>
    								<th>No</th>
    								<th>Kode Akun</th>
    								<th>Keterangan</th>
    								<th>Jenis Akun</th>
    								<th>Kategori</th>
    								<th>Unit Sekolah</th>
    								<th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($majors_id == 0){
                                if(isset($s['m'])){
                                    $majorsID = $s['m'];
                                    $piece = "account_majors_id = '$majorsID' AND";
                                } else {
                                    $piece = "";
                                }
                            } else {
                                $piece = "account_majors_id = '$majors_id' AND";
                            }
                            
                                $sql_main = "SELECT * FROM account LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE account_note = '0' ORDER BY account_code ASC";
                                $main_account = $this->db->query($sql_main)->result();
                                $no = 1;
                                foreach ($main_account as $main) {
                                
                                $main_id = $main->account_id;
                                $sql_sub = "SELECT * FROM account LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$main_id' ORDER BY account_code ASC";
                                $sub_account = $this->db->query($sql_sub)->result();
                                
                                if (count($sub_account) > 0) {
                            ?>        
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $main->account_code ?></td>
                                <td><?php echo $main->account_description ?></td>
                                <td>Akun Utama</td>
								<td>
									<?php 
										if($main->account_category=='1'){
										    echo "Pembayaran";
										} else if($main->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($main->account_majors_id != "0") ? $main->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addAccount<?php echo $main->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
    <div class="modal fade" id="addAccount<?php echo $main->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add_glob', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        $main_code = $this->db->query("SELECT MAX(account_code) as maxMain FROM account WHERE account_note = '$main_id'")->row();
						        $subParams = substr($main_code->maxMain,2);
						        if($subParams > 0){
						            $subFront = substr($main_code->maxMain,0,2);
						            $subBack = substr($main_code->maxMain,2);
						            $subAccount = $subBack + 100;
						        } else {
						            $subFront = substr($main->account_code,0,2);
						            $subBack = substr($main->account_code,2);
						            $subAccount = $subBack + 100;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" value="<?php echo $subFront.''.$subAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan">
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $main->account_id ?>">
    					    </div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
                            <?php
                                foreach($sub_account as $sub){
                            
                                $sub_id = $sub->account_id;
                                $sql_child = "SELECT * FROM account LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$sub_id' ORDER BY account_code ASC";
                                $child_account = $this->db->query($sql_child)->result();
                                
                                if (count($child_account) > 0) {
                            ?>        
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $sub->account_code ?></td>
                                <td><?php echo $sub->account_description ?></td>
                                <td>Sub Akun 1</td>
								<td>
									<?php 
										if($sub->account_category=='1'){
										    echo "Pembayaran";
										} else if($sub->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($sub->account_majors_id != "0") ? $sub->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addSubAccount<?php echo $sub->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
            						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editSubAccount<?php echo $sub->account_id ?>" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
            					</td>
                             </tr>                   
    <div class="modal fade" id="addSubAccount<?php echo $sub->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add_glob', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        $sub_code = $this->db->query("SELECT MAX(account_code) as maxSub FROM account WHERE account_note = '$sub_id'")->row();
						        $childParams = substr($sub_code->maxSub,2);
						        if($childParams > 0){
						            $childFront = substr($sub_code->maxSub,0,2);
						            $childBack = substr($sub_code->maxSub,2);
						            $childAccount = $childBack + 1;
						        } else {
						            $childFront = substr($sub->account_code,0,2);
						            $childBack = substr($sub->account_code,2);
						            $childAccount = $childBack + 1;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" value="<?php echo $childFront.''.$childAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan">
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $sub->account_id ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" >Pembayaran</option>
        						    <option value="2" >Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
    <div class="modal fade" id="editSubAccount<?php echo $sub->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <div class="form-group">
							<input type="hidden" required="" name="account_id" class="form-control" value="<?php echo $sub->account_id ?>">
							</div>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $sub->account_code ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" value="<?php echo $sub->account_description ?>" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $sub->account_note ?>">
    					    </div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($sub->account_majors_id==$row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
                        <?php
                            foreach($child_account as $child) {
                                
                            $child_id = $child->account_id;
                            $sql_grandchild = "SELECT * FROM account LEFT JOIN majors ON majors.majors_id = account.account_majors_id WHERE $piece account_note = '$child_id' ORDER BY account_code ASC";
                            $grandchild_account = $this->db->query($sql_grandchild)->result();
                            
                            if (count($grandchild_account) > 0) {
                        ?>
                        <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $child->account_code ?></td>
                                <td><?php echo $child->account_description ?></td>
                                <td>Sub Akun 2</td>
								<td>
									<?php 
										if($child->account_category=='1'){
										    echo "Pembayaran";
										} else if($child->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($child->account_majors_id != "0") ? $child->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addChildAccount<?php echo $child->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
            						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editChildAccount<?php echo $child->account_id ?>" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
                                </td>
                            </tr>
                            
    <div class="modal fade" id="addChildAccount<?php echo $child->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        //$childID = $child->account_id;
						        $child_code = $this->db->query("SELECT MAX(account_code) as maxChild FROM account WHERE account_note = '$child_id'")->row();
						        $grandchildParams = substr($child_code->maxChild,2);
						        if($grandchildParams > 0){
						            $grandchildFront = substr($child_code->maxChild,0,2);
						            $grandchildBack = substr($child_code->maxChild,2);
						            $grandchildAccount = $grandchildBack + 0.1;
						        } else {
						            $grandchildFront = substr($child->account_code,0,2);
						            $grandchildBack = substr($child->account_code,2);
						            $grandchildAccount = $grandchildBack + 0.1;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $grandchildFront.''.$grandchildAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $child->account_id ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" >Pembayaran</option>
        						    <option value="2" >Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>"><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
    <div class="modal fade" id="editChildAccount<?php echo $child->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <div class="form-group">
							<input type="hidden" required="" name="account_id" class="form-control" value="<?php echo $child->account_id ?>">
							</div>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $child->account_code ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" value="<?php echo $child->account_description ?>" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $child->account_note ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="" >-Pilih Kategori-</option>
        						    <option value="1" <?php echo ($child->account_category=='1') ? 'selected' : '' ?>>Pembayaran</option>
        						    <option value="2" <?php echo ($child->account_category=='2') ? 'selected' : '' ?>>Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($child->account_majors_id==$row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
                        <?php 
                            foreach($grandchild_account as $grandchild) {
                        ?>
                        
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $grandchild->account_code ?></td>
                                <td><?php echo $grandchild->account_description ?></td>
                                <td>Sub Akun 3</td>
								<td>
									<?php 
										if($grandchild->account_category=='1'){
										    echo "Pembayaran";
										} else if($grandchild->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($grandchild->account_majors_id != "0") ? $grandchild->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editGrandchildAccount<?php echo $grandchild->account_id ?>" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
            						<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteGrandchildAccount<?php echo $grandchild->account_id ?>" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            
    <div class="modal fade" id="editGrandchildAccount<?php echo $grandchild->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <div class="form-group">
							<input type="hidden" required="" name="account_id" class="form-control" value="<?php echo $grandchild->account_id ?>">
							</div>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $grandchild->account_code ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" value="<?php echo $grandchild->account_description ?>" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $grandchild->account_note ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" <?php echo ($grandchild->account_category=='1') ? 'selected' : '' ?>>Pembayaran</option>
        						    <option value="2" <?php echo ($grandchild->account_category=='2') ? 'selected' : '' ?>>Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($grandchild->account_majors_id==$row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
                            
    <div class="modal modal-default fade" id="deleteGrandchildAccount<?php echo $grandchild->account_id ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menghapus data ini?</p>
				</div>
				<div class="modal-footer">
					<?php echo form_open('manage/account/delete/' . $grandchild->account_id); ?>
					<input type="hidden" name="delCode" value="<?php echo $grandchild->account_code; ?>">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
					<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
					<?php echo form_close(); ?>
				</div>
			</div>
				<!-- /.modal-content -->
		</div>
			<!-- /.modal-dialog -->
	</div>
                        <?php    
                            }
                            } else { 
                        ?>
                        
                        	<tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $child->account_code ?></td>
                                <td><?php echo $child->account_description ?></td>
                                <td>Sub Akun 2</td>
								<td>
									<?php 
										if($child->account_category=='1'){
										    echo "Pembayaran";
										} else if($child->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($child->account_majors_id != "0") ? $child->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addChildAccount<?php echo $child->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
            						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editChildAccount<?php echo $child->account_id ?>" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
            						<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteChildAccount<?php echo $child->account_id ?>" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            
    <div class="modal fade" id="addChildAccount<?php echo $child->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        //$childID = $child->account_id;
						        $child_code = $this->db->query("SELECT MAX(account_code) as maxChild FROM account WHERE account_note = '$child_id'")->row();
						        $grandchildParams = substr($child_code->maxChild,2);
						        if($grandchildParams > 0){
						            $grandchildFront = substr($child_code->maxChild,0,2);
						            $grandchildBack = substr($child_code->maxChild,2);
						            $grandchildAccount = $grandchildBack + 0.1;
						        } else {
						            $grandchildFront = substr($child->account_code,0,2);
						            $grandchildBack = substr($child->account_code,2);
						            $grandchildAccount = $grandchildBack + 0.1;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $grandchildFront.''.$grandchildAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $child->account_id ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" >Pembayaran</option>
        						    <option value="2" >Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>"><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>                        
    
    <div class="modal fade" id="editChildAccount<?php echo $child->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <div class="form-group">
							<input type="hidden" required="" name="account_id" class="form-control" value="<?php echo $child->account_id ?>">
							</div>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $child->account_code ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" value="<?php echo $child->account_description ?>" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $child->account_note ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" <?php echo ($child->account_category=='1') ? 'selected' : '' ?>>Pembayaran</option>
        						    <option value="2" <?php echo ($child->account_category=='2') ? 'selected' : '' ?>>Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($child->account_majors_id==$row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	<div class="modal modal-default fade" id="deleteChildAccount<?php echo $child->account_id ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menghapus data ini?</p>
				</div>
				<div class="modal-footer">
					<?php echo form_open('manage/account/delete/' . $child->account_id); ?>
					<input type="hidden" name="delCode" value="<?php echo $child->account_code; ?>">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
					<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
					<?php echo form_close(); ?>
				</div>
			</div>
				<!-- /.modal-content -->
		</div>
			<!-- /.modal-dialog -->
	</div>
                        <?php
                            }
                            }
                            } else {
                        ?>
                      	    <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $sub->account_code ?></td>
                                <td><?php echo $sub->account_description ?></td>
                                <td>Sub Akun 1</td>
								<td>
									<?php 
										if($sub->account_category=='1'){
										    echo "Pembayaran";
										} else if($sub->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($sub->account_majors_id != "0") ? $sub->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addSubAccount<?php echo $sub->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
            						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editSubAccount<?php echo $sub->account_id ?>" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
            						<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteSubAccount<?php echo $sub->account_id ?>" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
    <div class="modal fade" id="addSubAccount<?php echo $sub->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add_glob', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        $sub_code = $this->db->query("SELECT MAX(account_code) as maxSub FROM account WHERE account_note = '$sub_id'")->row();
						        $childParams = substr($sub_code->maxSub,2);
						        if($childParams > 0){
						            $childFront = substr($sub_code->maxSub,0,2);
						            $childBack = substr($sub_code->maxSub,2);
						            $childAccount = $childBack + 1;
						        } else {
						            $childFront = substr($sub->account_code,0,2);
						            $childBack = substr($sub->account_code,2);
						            $childAccount = $childBack + 1;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" value="<?php echo $childFront.''.$childAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan">
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $sub->account_id ?>">
    					    </div>
        					<div class="form-group">
        						<label>Kategori <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
        						<select required="" name="account_category" class="form-control">
        						    <option value="">-Pilih Kategori-</option>
        						    <option value="1" >Pembayaran</option>
        						    <option value="2" >Keuangan</option>
        						</select>
        					</div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
    <div class="modal fade" id="editSubAccount<?php echo $sub->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <div class="form-group">
							<input type="hidden" required="" name="account_id" class="form-control" value="<?php echo $sub->account_id ?>">
							</div>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" placeholder="Masukkan Kode Akun" value="<?php echo $sub->account_code ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan" value="<?php echo $sub->account_description ?>" >
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $sub->account_note ?>">
    					    </div><!---->
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" <?php echo ($sub->account_majors_id==$row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	<div class="modal modal-default fade" id="deleteSubAccount<?php echo $sub->account_id ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menghapus data ini?</p>
				</div>
				<div class="modal-footer">
					<?php echo form_open('manage/account/delete/' . $sub->account_id); ?>
					<input type="hidden" name="delCode" value="<?php echo $sub->account_code; ?>">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
					<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
					<?php echo form_close(); ?>
				</div>
			</div>
				<!-- /.modal-content -->
		</div>
			<!-- /.modal-dialog -->
	</div>
                        <?php
                            }
                            }
                            } else {
                        ?>
                            <tr style="font-weight: bold;">
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $main->account_code ?></td>
                                <td><?php echo $main->account_description ?></td>
                                <td>Akun Utama</td>
								<td>
									<?php 
										if($main->account_category=='1'){
										    echo "Pembayaran";
										} else if($main->account_category=='2'){
										    echo "Keuangan";
										} else{
										    echo "#";
										} 
									?>
								</td>
                                <td><?php echo ($main->account_majors_id != "0") ? $main->majors_short_name : "Semua Unit" ?></td>
                                <td align='left'>
            						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addAccount<?php echo $main->account_id ?>" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>                  
	<div class="modal fade" id="addAccount<?php echo $main->account_id ?>" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Sub Akun</h4>
				</div>
				<?php echo form_open('manage/account/add_glob', array('method'=>'post')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						    <?php
						        $main_code = $this->db->query("SELECT MAX(account_code) as maxMain FROM account WHERE account_note = '$main_id'")->row();
						        $subParams = substr($main_code->maxMain,2);
						        if($subParams > 0){
						            $subFront = substr($main_code->maxMain,0,2);
						            $subBack = substr($main_code->maxMain,2);
						            $subAccount = $subBack + 100;
						        } else {
						            $subFront = substr($main->account_code,0,2);
						            $subBack = substr($main->account_code,2);
						            $subAccount = $subBack + 100;
						        }
						    ?>
						    <div class="form-group">
							<label>Kode Akun</label>
							<input type="text" required="" readonly="" name="account_code" class="form-control" value="<?php echo $subFront.''.$subAccount ?>">
							</div>
							<div class="form-group">
							<label>Keterangan</label>
							<input type="text" required="" name="account_description" class="form-control" placeholder="Masukkan Keterangan">
							</div>
							<div class="form-group">
    						<input type="hidden" required="" name="account_note" class="form-control" value="<?php echo $main->account_id ?>">
    					    </div>
    					    <div class="form-group">
    						<label>Unit Sekolah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
    						<select required="" name="account_majors_id" class="form-control">
    						    <option value="">-Pilih Unit Sekolah-</option>
    						    <?php foreach($majors as $row){?>
    						        <option value="<?php echo $row['majors_id']; ?>" ><?php echo $row['majors_short_name'] ?></option>
    						    <?php } ?>
    						</select>
    					    </div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
                        <?php
                                }
                            }
                        ?>
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
		</section>
		<!-- /.content -->
	</div>