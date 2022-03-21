<?php
class Kredit_trx_model extends CI_Model{
    
    function __construct() {
		parent::__construct();
	}
	
	function get_noref($id_majors, $like){
        
        $query_satu = $this->db->query("SELECT MAX(RIGHT(kredit_temp_noref,4)) AS no_max FROM kredit_temp WHERE DATE(kredit_temp_date)=CURDATE() AND kredit_temp_majors_id = '$id_majors' AND kredit_temp_noref LIKE '$like%'");
        
        $query_dua = $this->db->query("SELECT MAX(RIGHT(kas_noref,4)) AS no_max FROM kas WHERE DATE(kas_input_date)=CURDATE() AND kas_majors_id = '$id_majors' AND kas_category = '2' AND kas_noref LIKE '$like%'");
        
        $satu  = $query_satu->row_array();
        $dua   = $query_dua->row_array();
        $noref = "";
        $tmp   = "";
        
        if (count($satu)>1){
            $tmp = ((int)$satu['no_max'])+1;
            $noref = sprintf("%04s", $tmp);
        } else {
            if (count($dua)>0){
                $tmp = ((int)$dua['no_max'])+1;
                $noref = sprintf("%04s", $tmp);
            } else {
                $noref = "0001";
            }
        }
        return date('dmy').$noref;
    }

	function trx_list($kas_noref){
		$hasil=$this->db->query("SELECT kredit_temp_id, kredit_temp_date, kredit_temp_desc, kredit_temp_value, IF(kredit_temp_tax_id != 0, tax_number, 0) AS kredit_temp_tax, IF(kredit_temp_item_id != 0, item_name, 'Tidak Ada') as kredit_temp_item, kredit_temp_account_id, account_code, account_description FROM kredit_temp LEFT JOIN account ON kredit_temp.kredit_temp_account_id = account.account_id LEFT JOIN tax ON kredit_temp.kredit_temp_tax_id = tax.tax_id LEFT JOIN item ON kredit_temp.kredit_temp_item_id = item.item_id WHERE kredit_temp.kredit_temp_noref = '$kas_noref'");
		return $hasil->result_array();
	}

	function add_trx($majors_id, $kas_noref, $kredit_kas_account_id, $kas_date, $kredit_account_id, $kredit_desc, $kredit_value, $kredit_tax_id, $kredit_item_id){
	    $user_id = $this->session->userdata('uid');
	    
		$hasil=$this->db->query("INSERT INTO `kredit_temp`(`kredit_temp_id`, `kredit_temp_majors_id`, `kredit_temp_date`, `kredit_temp_noref`, `kredit_temp_kas_account_id`, `kredit_temp_account_id`, `kredit_temp_desc`, `kredit_temp_value`, `kredit_temp_tax_id`, `kredit_temp_item_id`, `user_user_id`) VALUES ('','$majors_id', '$kas_date', '$kas_noref', '$kredit_kas_account_id', '$kredit_account_id', '$kredit_desc', '$kredit_value', $kredit_tax_id, $kredit_item_id, '$user_id')");
		
		return $hasil;
	}

	function del_trx($id){
		$hasil=$this->db->query("DELETE FROM kredit_temp WHERE kredit_temp_id='$id'");
		return $hasil;
	}
	
	function save_trx($params, $kas_noref){
	    
		$this->db->insert('kas', $params);
		
	    $this->db->query("INSERT INTO kredit (kredit_date, kredit_desc, kredit_value, kredit_tax_id, kredit_item_id, kredit_account_id, kredit_kas_account_id, kredit_kas_noref, user_user_id, kredit_input_date, kredit_last_update) SELECT kredit_temp_date, kredit_temp_desc, kredit_temp_value, kredit_temp_tax_id, kredit_temp_item_id, kredit_temp_account_id, kredit_temp_kas_account_id, kredit_temp_noref, user_user_id, kredit_temp_input_date, kredit_temp_last_update FROM kredit_temp WHERE kredit_temp_noref = '$kas_noref'");
		
		$this->db->query("DELETE FROM kredit_temp WHERE kredit_temp_noref = '$kas_noref'");
		
	}
	
	function cancel_trx($kas_noref){
		
		$this->db->query("DELETE FROM kredit_temp WHERE kredit_temp_noref = '$kas_noref'");
	    
	}
	
}