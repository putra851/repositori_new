<section class="content">
  <div class="row"> 
    <div class="col-md-12">
      <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
        <div class="box-header backg with-border">
          <h3 class="box-title">Daftar KEPK</h3>
          <button type="button" class="btn btn-default navbar-btn pull-right"><i class="fa fa-pencil-square-o"></i> Pendaftaran KEPK</button>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <select class="form-control" name="n">
                <!-- <option value="">-- Tahun Ajaran --</option> -->
                <?php foreach ($period as $row): ?>
                  <option <?php echo (isset($f['n']) AND $f['n'] == $row['period_id']) ? 'selected' : '' ?> value="<?php echo $row['period_id'] ?>"><?php echo $row['period_start'].'/'.$row['period_end'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <label for="" class="col-sm-2 control-label">Cari Siswa</label>
            <div class="col-sm-2">
              <input type="text" autofocus name="r" <?php echo (isset($f['r'])) ? 'placeholder="'.$f['r'].'"' : 'placeholder="NIS Siswa"' ?> class="form-control" required>
            </div>

            <div class="col-sm-4">
              <button type="submit" class="btn btn-success"><i class="fa fa-search"> </i> Cari Siswa</button>
            </div>
          </div>
        </form>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </section><br><br>