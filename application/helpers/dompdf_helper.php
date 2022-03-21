<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE, $paper = 'Letter', $orientation = 'portrait') 
{

    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);

    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.'.pdf', array("Attachment" => 0));
    } else {
        return $dompdf->output(); 
    }
}

function pdf_create_landscape($html, $filename='', $stream=TRUE) 
{

    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('A4', 'landscape');

    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.'.pdf', array("Attachment" => 0));
    } else {
        return $dompdf->output(); 
    }
}

function pdf_create_thermal($html, $filename='', $stream=TRUE) 
{

    require_once("dompdf/dompdf_config.inc.php");
    
    $customPaper = array(0,0,215,841);
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($customPaper, 'portrait');

    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.'.pdf', array("Attachment" => 0));
    } else {
        return $dompdf->output(); 
    }
}
/* End of file dompdf_helper.php */
/* Location: ./application/helpers/dompdf_helper.php */
