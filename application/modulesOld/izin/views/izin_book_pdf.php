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
  <p class="title">RINCIAN TABUNGAN SISWA</p>
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

      <table width="100%" border="1" style="white-space: nowrap;">
        <tr>
          <th>TANGGAL</th>
          <th>KODE</th>
          <th>CATATAN</th>
          <th>DEBIT</th>
          <th>KREDIT</th>
          <th>SALDO</th>
        </tr>
        <?php 
        foreach ($book as $row) :
          ?>
          <tr>
            <td><?php echo pretty_date($row['date'], 'd/m/Y', false) ?></td>
            <td style="text-align: left;"><?php echo ($row['code']=='1') ? 'SETORAN' : 'PENARIKAN' ?></td>
            <td><?php echo $row['note'] ?></td>
            <td style="text-align: right;"><?php echo number_format($row['debit'],'0',',','.') ?></td>
            <td style="text-align: right;"><?php echo number_format($row['kredit'],'0',',','.') ?></td>
            <td style="text-align: right;"><?php echo number_format($row['saldo'],'0',',','.') ?></td>
          </tr>
          <?php 
        endforeach
        ?>
      </table>


    </body>
    </html>