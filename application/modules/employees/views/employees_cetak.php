<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table style='border-bottom: 1px solid #000000; padding-bottom: 10px; width: 277mm;'>
        <tr valign='top'>
            <td style='width: 277mm;' valign='middle'>
                <div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value']; ?>
                </div>
                <span style='font-size: 8pt;'><?php echo $setting_address['setting_value']; ?>, Telp.
                    <?php echo $setting_phone['setting_value']; ?></span>
            </td>
        </tr>
    </table>
    <br>
    <table style='width: 277mm;'>
        <tr>
            <td style='width: 92mm; font-size: 8pt; text-align: center' valign='center'></td>
            <td style='width: 93mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Data Pegawai ' . $majors['majors_short_name']; ?></b></td>
            <td style='width: 92mm; font-size: 8pt;' align='right'></td>
        </tr>
    </table>
    <br>
    <table cellpadding='0' cellspacing='0' style='width: 277mm; padding-left: 20mm;'>
        <tr>
            <th align='center' style='font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>No.</th>
            <th align='center' style='font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>NIP</th>
            <th align='center' style='font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>Nama</th>
            <th align='center' style='font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>Unit Sekolah</th>
            <th align='center' style='font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>Jabatan</th>
            <th align='center' style='font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>Status Kepegawaian</th>
            <th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border: 1px solid #000000;'>No. Telp</th>
        </tr>
        <?php
        $i = 1;
        foreach ($employee as $row) {
        ?>
            <tr valign='top'>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $i++ ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['employee_nip'] ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['employee_name'] ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['majors_short_name'] ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['position_name'] ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php if ($row['employee_category'] == '1') {
                                                                                            echo 'Pegawai Tetap';
                                                                                        } else if ($row['employee_category'] == '2') {
                                                                                            echo 'Pegawai Tidak Tetap';
                                                                                        } else {
                                                                                            echo '-';
                                                                                        } ?></td>
                <td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['employee_phone'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>