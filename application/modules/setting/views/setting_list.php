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
  <section class="content">
      <div class = "row">
      <?php echo form_open_multipart(current_url()); ?>
    <div class="col-md-6">

      <div class="box-body">
          
      <div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Info Lembaga</a></li>
			<li><a href="#tab_2" data-toggle="tab">Kepengurusan</a></li>
			<li><a href="#tab_3" data-toggle="tab">WA Center</a></li>
			<li><a href="#tab_4" data-toggle="tab">Media Sosial</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">

            <input type="hidden" name="setting_level" value="<?php echo $setting_level['setting_value'] ?>" class="form-control" >
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Sekolah</label>
                  <input type="text" name="setting_school" value="<?php echo $setting_school['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
                </div>
              </div>
            </div>
    
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Alamat Sekolah</label>
                  <input name="setting_address" type="text" value="<?php echo $setting_address['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Kecamatan</label>
                  <input type="text" name="setting_district" value="<?php echo $setting_district['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
                </div>
              </div>
            </div>
    
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Kota/Kab</label>
                  <input type="text" name="setting_city" value="<?php echo $setting_city['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nomor Telepon</label>
                  <input type="text" name="setting_phone" value="<?php echo $setting_phone['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            </div>					
			<div class="tab-pane" id="tab_2">
        
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">NIP Kepsek</label>
                  <input type="text" name="setting_nip_kepsek" value="<?php echo $setting_nip_kepsek['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Kepsek</label>
                  <input type="text" name="setting_nama_kepsek" value="<?php echo $setting_nama_kepsek['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">NIP Ka. TU</label>
                  <input type="text" name="setting_nip_katu" value="<?php echo $setting_nip_katu['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Ka. TU</label>
                  <input type="text" name="setting_nama_katu" value="<?php echo $setting_nama_katu['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">NIP Bendahara</label>
                  <input type="text" name="setting_nip_bendahara" value="<?php echo $setting_nip_bendahara['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Nama Bendahara</label>
                  <input type="text" name="setting_nama_bendahara" value="<?php echo $setting_nama_bendahara['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            </div>
			<div class="tab-pane" id="tab_3">
        
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">WA Center</label>
                  <input type="text" name="setting_wa_center" value="<?php echo $setting_wa_center['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <?php if($this->session->userdata('uroleid') == '3') { ?>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Notifikasi WA</label>
                  <input type="checkbox" class="checkbox" <?php echo ($setting_notif['setting_value'] == 'active') ? 'checked' : ''; ?> onchange="changeAct('<?php echo ($setting_notif['setting_value'] == 'active') ? 'inactive' : 'active'; ?>')">
                </div>
              </div>
            </div>
            
            <?php } else { ?>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Notifikasi WA</label>
                  <input type="text" value="<?php echo ucwords($setting_notif['setting_value']) ?>" class="form-control" readonly>
                </div>
              </div>
            </div>
            
            <?php } ?>
            
            </div>
			<div class="tab-pane" id="tab_4">
        
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Alamat Email</label>
                  <input type="text" name="setting_email" value="<?php echo $setting_email['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Website</label>
                  <input type="text" name="setting_website" value="<?php echo $setting_website['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Whatsapp</label>
                  <input type="text" name="setting_whatsapp" value="<?php echo $setting_whatsapp['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Facebook</label>
                  <input type="text" name="setting_facebook" value="<?php echo $setting_facebook['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Instagram</label>
                  <input type="text" name="setting_instagram" value="<?php echo $setting_instagram['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="">
                <div class="col-md-12">
                  <label class="control-label">Youtube</label>
                  <input type="text" name="setting_youtube" value="<?php echo $setting_youtube['setting_value'] ?>" class="form-control" >
                </div>
              </div>
            </div>
            </div>
		</div>
	</div>
	
        <?php if($this->session->userdata('uroleid') == '3') { ?>
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label>Aktifkan ePesantren</label>
              <div class="radio">
                <label>
                  <input type="radio" name="setting_aktivasi" value="Y" <?php echo ($setting_aktivasi['setting_value'] == 'Y') ? 'checked' : ''; ?>> Ya
                </label>&nbsp;&nbsp;
                <label>
                  <input type="radio" name="setting_aktivasi" value="N" <?php echo ($setting_aktivasi['setting_value'] == 'N') ? 'checked' : ''; ?>> Tidak
                </label>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
	
        <div class="row">
            <input type="submit" value="Simpan" class="btn btn-success btn-block">
        </div>
      </div>
    </div>
    <br>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-3">
          <label >Logo Sekolah</label>
          <a href="#" class="thumbnail">
            <?php if (isset($setting_logo) AND $setting_logo['setting_value'] != NULL) { ?>
            <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" style="height: 50px" >
            <?php } else { ?>
            <img src="<?php echo media_url('img/missing_logo.gif') ?>" id="target" alt="Choose image to upload">
            <?php } ?>
          </a>
          <input type='file' id="setting_logo" name="setting_logo">
          <p>Ukuran Logo 50x50 pixel</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label >Kartu Depan</label>
          <a href="#" class="thumbnail">
            <?php if (isset($setting_kartu_depan) AND $setting_kartu_depan['setting_value'] != NULL) { ?>
            <img src="<?php echo upload_url('kartu/' . $setting_kartu_depan['setting_value']) ?>" style="height: 203px; width: 321px;" >
            <?php } else { ?>
            <img src="<?php echo media_url('img/missing_logo.gif') ?>" id="target_depan" alt="Choose image to upload">
            <?php } ?>
          </a>
          <input type='file' id="setting_kartu_depan" name="setting_kartu_depan">
          <p>Ukuran Gambar 321x203 pixel</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label >Kartu Belakang</label>
          <a href="#" class="thumbnail">
            <?php if (isset($setting_kartu_belakang) AND $setting_kartu_belakang['setting_value'] != NULL) { ?>
            <img src="<?php echo upload_url('kartu/' . $setting_kartu_belakang['setting_value']) ?>" style="height: 203px; width: 321px;" >
            <?php } else { ?>
            <img src="<?php echo media_url('img/missing_logo.gif') ?>" id="target_belakang" alt="Choose image to upload">
            <?php } ?>
          </a>
          <input type='file' id="setting_kartu_belakang" name="setting_kartu_belakang">
          <p>Ukuran Gambar 321x203 pixel</p>
        </div>
      </div>
    </div>
    <?php echo form_close() ?>
    </div>
  </section>
</div>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#setting_logo").change(function() {
    readURL(this);
  });

</script>

<script type="text/javascript">
  function readDepan(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target_depan').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#setting_kartu_depan").change(function() {
    readDepan(this);
  });

</script>

<script type="text/javascript">
  function readBelakang(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target_belakang').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#setting_kartu_belakang").change(function() {
    readBelakang(this);
  });

</script>
<script>
    function changeAct(act){
        var actValue    = act;
        
        $.ajax({ 
            url: '<?php echo base_url();?>manage/setting/active/',
            type: 'POST', 
            data: {
                    'act_value'      : actValue,
            },    
            success: function(msg) {
                    window.location.href = '<?php echo base_url()?>manage/setting/act_val?=' + act;
            },
			error: function(msg){
					alert('msg');
			}
            
        });
    }
</script>