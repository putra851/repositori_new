<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Saldo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
	function add($id, $value, $modul, $date, $updater){
	    
	    $data = array(
	        'saldo_awal_date' => $date,
	        'saldo_awal_user_id' => $updater,
	        'saldo_awal_account' => $id,
            $modul => $value
        );
        
        if($value != '0'){
    		$this->db->insert("saldo_awal",$data);
    		return $this->db->insert_id();
            
        }
	}
    
    function update($id, $value, $modul, $date, $updater){
        
        $this->db->where(array("saldo_awal_account"=>$id));
		$this->db->update("saldo_awal",array($modul=>$value, 'saldo_awal_date' => $date, 'saldo_awal_user_id' => $updater,));
		
		$saldo = $this->db->query("SELECT saldo_awal_debit, saldo_awal_kredit FROM saldo_awal WHERE saldo_awal_account = '$id'")->row_array();
		
		if($saldo['saldo_awal_debit'] == 0 && $saldo['saldo_awal_kredit'] == 0){
		    $this->db->delete('saldo_awal', array('saldo_awal_account' => $id)); 
		}
		
	}

}
