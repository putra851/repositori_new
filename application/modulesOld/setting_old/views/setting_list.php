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

        <!--<div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Tingkat Sekolah</label>
              <select name="level" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
                <option value="primary" <?php echo ($setting_level['setting_value'] == 'primary') ? 'selected' : '' ?>>SD/MI</option>
                <option value="junior" <?php echo ($setting_level['setting_value'] == 'junior') ? 'selected' : '' ?>>SMP/MTS</option>
                <option value="senior" <?php echo ($setting_level['setting_value'] == 'senior') ? 'selected' : '' ?>>SMK/SMA/SMU/MA</option>
              </select>
            </div>
          </div>
        </div>-->
        <input type="hidden" name="setting_level" value="<?php echo $setting_level['setting_value'] ?>" class="form-control" >

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Sekolah</label>
              <input type="text" name="school" value="<?php echo $setting_school['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
              <input type="hidden" name="setting_school" value="<?php echo $setting_school['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Alamat Sekolah</label>
              <input name="address" type="text" value="<?php echo $setting_address['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
              <input name="setting_address" type="hidden" value="<?php echo $setting_address['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Kecamatan</label>
              <input type="text" name="district" value="<?php echo $setting_district['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
              <input type="hidden" name="setting_district" value="<?php echo $setting_district['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Kota/Kab</label>
              <input type="text" name="city" value="<?php echo $setting_city['setting_value'] ?>" class="form-control" <?php if ($this->session->userdata('uroleid') != '3') { echo "disabled"; } ?> >
              <input type="hidden" name="setting_city" value="<?php echo $setting_city['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">NIP Kepsek</label>
              <input type="text" name="setting_nip_kepsek" value="<?php echo $setting_nip_kepsek['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Kepsek</label>
              <input type="text" name="setting_nama_kepsek" value="<?php echo $setting_nama_kepsek['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">NIP Ka. TU</label>
              <input type="text" name="setting_nip_katu" value="<?php echo $setting_nip_katu['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Ka. TU</label>
              <input type="text" name="setting_nama_katu" value="<?php echo $setting_nama_katu['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">NIP Bendahara</label>
              <input type="text" name="setting_nip_bendahara" value="<?php echo $setting_nip_bendahara['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Bendahara</label>
              <input type="text" name="setting_nama_bendahara" value="<?php echo $setting_nama_bendahara['setting_value'] ?>" class="form-control" >
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nomor Telepon</label>
              <input type="text" name="setting_phone" value="<?php echo $setting_phone['setting_value'] ?>" class="form-control" >
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
          <div class="">
            <input type="submit" value="Simpan" class="btn btn-success pull-left">
          </div>
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
          <?php if ($this->session->userdata('uroleid') == '3') { ?>
          <input type='file' id="setting_logo" name="setting_logo">
          <p>Ukuran Logo 50x50 pixel</p>
          <?php } ?>
        </div>
      </div>
      <!--<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#gateway"><i class="fa fa-arrow-down"></i> Set SMS Gateway</button>-->
      <div id="gateway" class="collapse">
        <div class="form-group label-floating">
          <label class="control-label">User SMS Gateway</label>
          <input type="text" name="setting_user_sms" value="<?php echo $setting_user_sms['setting_value'] ?>" class="form-control" >
        </div>
        <div class="form-group label-floating">
          <label class="control-label">Password SMS Gateway</label>
          <input type="password" name="setting_pass_sms" value="<?php echo $setting_pass_sms['setting_value'] ?>" class="form-control" >
        </div>
        <div class="form-group">
          <label>Aktifkan SMS Gateway</label>
          <div class="radio">
            <label>
              <input type="radio" name="setting_sms" value="Y" <?php echo ($setting_sms['setting_value'] == 'Y') ? 'checked' : ''; ?>> Ya
            </label>&nbsp;&nbsp;
            <label>
              <input type="radio" name="setting_sms" value="N" <?php echo ($setting_sms['setting_value'] == 'N') ? 'checked' : ''; ?>> Tidak
            </label>
          </div>
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
