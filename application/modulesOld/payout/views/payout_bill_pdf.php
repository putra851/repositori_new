<html>
<head>
  <?php foreach ($siswa as $row): ?>
    <title>Cetak Surat Tagihan - <?php echo $row['student_full_name'] ?></title>
  <?php endforeach ?>
  <style type="text/css">
  .upper { text-transform: uppercase; }
  .lower { text-transform: lowercase; }
  .cap   { text-transform: capitalize; }
  .small { font-variant:   small-caps; }
</style>
<style type="text/css">
@page {
  margin-top: 1cm;
  margin-bottom: 1cm;
  margin-left: 1cm;
  margin-right: 1cm;
  } .style12 {font-size: 10px}
  .style13 {
   font-size: 14pt;
   font-weight: bold;
 }
.name-school{
	font-size: 15pt;
	font-weight: bold;
	padding-bottom: -15px;
}

.unit{
	font-size: 8pt;
	font-weight: bold;
	margin-bottom: -10px;
}

.alamat{
	font-size: 8pt;
	margin-bottom: -10px;
}
 .title{
  font-size: 14pt;
  text-align: center;
  font-weight: bold;
  padding-bottom: -10px;
}
.tp{
  font-size: 12pt;
  text-align: center;
  font-weight: bold;
}
.unit-siswa{
  font-size: 10pt;
  text-align: center;
  font-weight: bold;
}
hr {
	border: none;
	height: 1px;
	/* Set the hr color */
	color: #333; /* old IE */
	background-color: #333; /* Modern Browsers */
}
body {
  font-family: sans-serif;
}
table {
  border-collapse: collapse;
  font-size: 9pt;
  width: 100%;
}
</style>
</head>
<body>
    
	<p class="name-school"><?php echo $setting_school['setting_value'] ?></p>
	<p class="unit">
	<?php
	$num = count($unit);
	if($num > 1){
	foreach($unit as $row){
	    $data  = $row['majors_short_name'];
	    $Pecah = explode( " ", $data );
        for ( $i = 0; $i < count( $Pecah ); $i++ ) {
            echo $Pecah[$i] . " ";
        } 
      }
    } ?></p>
	<p class="alamat"><?php echo $setting_address['setting_value'] ?><br>
		<?php echo $setting_phone['setting_value'] ?></p>
		<hr>
  <p class="title">RINCIAN PEMBAYARAN ADMINISTRASI</p>
  <p class="tp"> TAHUN PELAJARAN <?php foreach ($period as $row):?> <?php echo ($f['n'] == $row['period_id']) ? $row['period_start'].'/'.$row['period_end'] : '' ?><?php endforeach; ?></p>
  <?php
    $num = count($unit);
	if($num > 1){ ?>
    <p class="unit-siswa">
        Unit Sekolah : 
      <?php foreach ($siswa as $row): ?>
        <?php echo $row['majors_short_name'] ?>
      <?php endforeach; ?>
    </p>
  <?php } ?>
  <table style="font-size: 10pt;" width="100%" border="0">
    <tr>
      <td width="100">NIS</td>
      <td width="5">:</td>
      <?php foreach ($siswa as $row): ?>
        <td width=""><?php echo $row['student_nis'] ?></td>
      <?php endforeach; ?>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <?php foreach ($siswa as $row): ?>
        <td><?php echo $row['student_full_name'] ?></td>
      <?php endforeach; ?>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <?php foreach ($siswa as $row): ?>
        <td><?php echo $row['class_name'] ?></td>
      <?php endforeach; ?>
    </tr>
    </table><br>
    <?php if ($f['n'] AND $f['r'] != NULL) { ?> 

      <table width="100%" border="1" style="white-space: nowrap;">
        <tr>
          <th style="height: 30px;">NO</th>
          <th>NAMA PEMBAYARAN</th>
          <th>TANGGAL BAYAR</th>
          <th>NOMINAL</th>
          <th>KETERANGAN</th>
          <th>DIBAYAR VIA</th>
        </tr>
        <?php 
        $i = 1;
        foreach ($bulan as $row) :
          $namePay = $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
          $mont = ($row['month_month_id']<=6) ? $row['period_start'] : $row['period_end'];
          ?>
          <tr>
            <td style="text-align: center;"><?php echo $i ?></td>
            <td><?php echo $namePay .' - ('.$row['month_name'].' '.$mont.')' ?></td>
            <td style="text-align: <?php echo ($row['bulan_status']==1) ? 'center' : ''; ?>;"><?php echo ($row['bulan_status']==1) ? pretty_date($row['bulan_date_pay'],'d F Y',false) : '-' ?></td>
            <td><?php echo ($row['bulan_status']==0) ? 'Rp. '. number_format($row['bulan_bill'], 0, ',', '.') : 'Rp. -' ?></td>
            <td><?php echo ($row['bulan_status']==1) ? 'Lunas' : 'Belum Lunas' ?></td>
            <td><?php echo (isset($row['account_description'])) ? $row['account_description'] : '-' ?></td>
          </tr>
          <?php 
          $i++;
        endforeach
        ?>
        <?php 
        $j = $i;
        foreach ($bebas as $row) :
          $namePayFree = $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
          ?>
          <tr>
            <td style="text-align: center;"><?php echo $j ?></td>
            <td><?php echo $namePayFree ?></td>
            <td style="text-align: <?php echo ($row['bebas_total_pay']>0) ? 'center' : ''?>"><?php echo ($row['bebas_total_pay']>0) ? pretty_date($row['bebas_last_update'],'d F Y',false) : '-'  ?></td>
            <td><?php echo ($row['bebas_bill']-$row['bebas_total_pay']!=0) ? 'Rp. '. number_format($row['bebas_bill']-$row['bebas_total_pay'], 0, ',', '.') : 'Rp. -' ?></td>
            <td><?php echo ($row['bebas_bill']==$row['bebas_total_pay']) ? 'Lunas' : 'Belum Lunas' ?></td>
            <td>-</td>
          </tr>
          <?php 
          $j++;
        endforeach
        ?>

      </table>
      <?php } else redirect('manage/payout?n='.$f['n'].'&r='.$f['r'])  ?>


      <table style="width:100%; margin-top: 50px; font-size: 10pt; ">
        <tr>
        <td><td>
          <td><span class="cap"><?php echo $setting_city['setting_value'] ?></span>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
        </tr>
        <tr>
            <td><td>
          <td>Bendahara</td>
        </tr>

      </table>
      <br><br>
      <table width="100%" style="font-size: 10pt;">
        <tr>
            <td><td>
          <td><strong><span class="upper"> <?php echo ucfirst($setting_nama_bendahara['setting_value']); ?> </span></strong></td>
        </tr>
        <tr>
            <td><td>
          <td><span class="upper">NIP. <?php echo ucfirst($setting_nip_bendahara['setting_value']); ?> </span></td>
        </tr>
      </table>


    </body>
    </html>