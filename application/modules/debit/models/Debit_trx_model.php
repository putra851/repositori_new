<?php
class Debit_trx_model extends CI_Model{
    
    function __construct() {
		parent::__construct();
	}
	
	function get_noref($id_majors, $like){
        $query_satu = $this->db->query("SELECT MAX(RIGHT(debit_temp_noref,4)) AS no_max FROM debit_temp WHERE DATE(debit_temp_date)=CURDATE() AND debit_temp_majors_id = '$id_majors' AND debit_temp_noref LIKE '$like%'");
        
        $query_dua = $this->db->query("SELECT MAX(RIGHT(kas_noref,4)) AS no_max FROM kas WHERE DATE(kas_input_date)=CURDATE() AND kas_majors_id = '$id_majors' AND kas_category = '1' AND kas_noref LIKE '$like%'");
        
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
		$hasil=$this->db->query("SELECT debit_temp_id, debit_temp_date, debit_temp_desc, debit_temp_value, IF(debit_temp_tax_id != 0, tax_number, 0) AS debit_temp_tax, IF(debit_temp_item_id != 0, item_name, 'Tidak Ada') as debit_temp_item, debit_temp_account_id, account_code, account_description FROM debit_temp LEFT JOIN account ON debit_temp.debit_temp_account_id = account.account_id LEFT JOIN tax ON debit_temp.debit_temp_tax_id = tax.tax_id LEFT JOIN item ON debit_temp.debit_temp_item_id = item.item_id WHERE debit_temp.debit_temp_noref = '$kas_noref'");
		return $hasil->result_array();
	}

	function add_trx($majors_id, $kas_noref, $kas_account_id, $kas_date, $debit_account_id, $debit_desc, $debit_value, $debit_tax_id, $debit_item_id){
	    $user_id = $this->session->userdata('uid');
	    
		$hasil=$this->db->query("INSERT INTO `debit_temp`(`debit_temp_id`, `debit_temp_majors_id`, `debit_temp_date`, `debit_temp_noref`, `debit_temp_kas_account_id`, `debit_temp_account_id`, `debit_temp_desc`, `debit_temp_value`, `debit_temp_tax_id`, `debit_temp_item_id`, `user_user_id`) VALUES ('','$majors_id', '$kas_date', '$kas_noref', '$kas_account_id', '$debit_account_id', '$debit_desc', '$debit_value', $debit_tax_id, $debit_item_id, '$user_id')");
		
		return $hasil;
	}

	function del_trx($id){
		$hasil=$this->db->query("DELETE FROM debit_temp WHERE debit_temp_id='$id'");
		return $hasil;
	}
	
	function save_trx($params, $kas_noref){
	    
		$this->db->insert('kas', $params);
		
	    $this->db->query("INSERT INTO debit (debit_date, debit_desc, debit_value, debit_tax_id, debit_item_id, debit_account_id, debit_kas_account_id, debit_kas_noref, user_user_id, debit_input_date, debit_last_update) SELECT debit_temp_date, debit_temp_desc, debit_temp_value, debit_temp_tax_id, debit_temp_item_id, debit_temp_account_id, debit_temp_kas_account_id, debit_temp_noref, user_user_id, debit_temp_input_date, debit_temp_last_update FROM debit_temp WHERE debit_temp_noref = '$kas_noref'");
		
		$this->db->query("DELETE FROM debit_temp WHERE debit_temp_noref = '$kas_noref'");
		
	}
	
	function cancel_trx($kas_noref){
		
		$this->db->query("DELETE FROM debit_temp WHERE debit_temp_noref = '$kas_noref'");
	    
	}
	
}