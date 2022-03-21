<?php if (!defined('BASEPATH')) exit('NO direct script access allowed');

    function bulat_ratusan($uang) {
    $pembulat = substr($uang, -2);
     
    if($pembulat != '00'){
        $akhir = $uang + (100-$pembulat);
    } else {
        $akhir = $uang;
    }
     echo number_format($akhir, 0, '', '');
    }
    
    function bulat_ribuan($uang) {
    $pembulat = substr($uang, -3);
    if($pembulat != '000'){
        $akhir = $uang + (1000-$pembulat);
    } else {
        $akhir = $uang;
    }
     
     echo number_format($akhir, 0, '', '');
    }

?>