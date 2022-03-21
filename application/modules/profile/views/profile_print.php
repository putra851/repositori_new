<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
  <meta http-equiv="Content-Style-Type" content="text/css" /> 
  <title><?php echo $student['student_full_name'] ?></title>

  <style type="text/css">
  body {
    font-family: sans-serif;
  }
  @page {
    margin-top: 0.5cm;
    margin-bottom: 0.5cm;
    margin-left: 0.5cm; 
    margin-right: 0.5cm;
  } 
  .school{
    font-size: 7pt;
    font-weight: bold;
    text-align: left;
    padding-bottom: -5px;
    /*width: 50%;*/
  }
  .address{
    font-size: 4pt;
    text-align: left;
    padding-bottom: 1px;
    /*width: 50%;*/
  }
  .phone{
    font-size: 5pt;
    text-align: center;
    font-style: italic;
    padding-bottom:-10px;
    /*width: 50%;*/
  }

  hr {
    border: none;
    height: 1px;
    /* Set the hr color */
    color: #333; /* old IE */
    background-color: #333; /* Modern Browsers */
  }
  
  br {
   margin: 10px;
  }

  .container {
    position: relative;
  }

  .topright {
    margin-left: 10px;
    position: absolute;
  }

  .name{
    margin-left: 70px;
    font-size: 6pt;
  }
  .fieldset-auto-width {
   display: inline-block;
   width: 70%;
 }

.depan{
  background-image: url('media/background/kartu-depan-mini.jpg');
}

.belakang{
  background-image: url('media/background/kartu-belakang-mini.jpg');
}
</style>
</head>
<body>
  <fieldset class="fieldset-auto-width">
      <div class="depan">
     <table>
	    <tr>
	        <td width="15%" valign="top">
	            <img src="<?php echo 'uploads/school/' . logo() ?>" style="height: 47px;">
                <p class="address">NSPP : 510018720006</p>
	        </td>
	        <td valign="top">
            	<p class="school">KARTU TANDA SANTRI</p>
            	<p class="school">PONDOK PESANTREN ROUDLATUL QUR'AN</p>
            	<p class="school">METRO LAMPUNG</p>
            	<p class="school">(BOARDING SCHOOL)</p>
                <p class="address"></p>
                <p class="address">Jl. Pratama Praja Mulyojati 16 Metro Barat Kota Metro (0725) 7855 202 Wesbsite : pprqmetro.net</p>
        	</td>
	    </tr>
	</table>
    <div class="container">
      <div class="topright">
        <?php if (!empty($student['student_img'])) { ?>
        <img src="<?php echo upload_url('student/'.$student['student_img']) ?>" style="height: 100px; width: 70px; border:0px solid">
        <?php } else { ?>
        <img src="<?php echo media_url('img/missing.png') ?>" style="height: 100px; width: 70px; border:0px solid">
        <?php } ?>
      </div>

      <table class="name">
        <tr>
          <td widht='30%'>NAMA</td>
          <td widht='5%'>:</td>
          <td widht='65%'><?php echo strtoupper($student['student_full_name']) ?></td>
        </tr>
        <tr>
          <td>NIS</td>
          <td>:</td>
          <td><?php echo $student['student_nis'] ?></td>
        </tr>
        <tr>
          <td>TTL</td>
          <td>:</td>
          <td><?php echo strtoupper($student['student_born_place']).', '.pretty_date($student['student_born_date'],'d m Y',false) ?></td>
        </tr>
        <tr>
          <td>ALAMAT</td>
          <td>:</td>
          <td><?php echo strtoupper($student['student_address']) ?></td>
        </tr>
        <tr>
          <td colspan="3">
              <br>
            <img style="width:100pt;height:25pt;z-index:6;" src="<?php echo 'media/barcode_student/'.$student['student_nis'].'.png' ?>" alt="Image_4_0" />
          </td>
        </tr>
      </table>
      <br>
      </div>
      </div>
    </fieldset>
    <br>
  <fieldset class="fieldset-auto-width">
    <div class="belakang">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

    </fieldset>
    
  </body>
  </html>