<?php
class Payout_model extends CI_Model{
    
    function __construct() {
		parent::__construct();
	}
	
	function get_noref($like, $id_majors){
        
        $query = $this->db->query("SELECT MAX(RIGHT(kas_noref,2)) AS no_max FROM kas WHERE DATE(kas_input_date)=CURDATE() AND kas_majors_id = '$id_majors' AND kas_noref LIKE '$like%' AND kas_category = '1'")->row();
        
        if (count($query)>0){
            $tmp = ((int)$query->no_max)+1;
            $noref = sprintf("%02s", $tmp);
        } else {
            $noref = "01";
        }
        
        return date('dmy').$noref;
    }
    
    function cari_noref($params = array()) {
        
        if (isset($params['student_id'])) {
            $student_id = $params['student_id'];
        }
        
        if (isset($params['date'])) {
            $date = $params['date'];
        }

        $res = $this->db->query("SELECT DISTINCT `kas_noref` FROM `kas` LEFT JOIN `bulan` ON `bulan`.`bulan_noref` = `kas`.`kas_noref` 
        LEFT JOIN `bebas_pay` ON `bebas_pay`.`bebas_pay_noref` = `kas`.`kas_noref` 
        LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` 
        WHERE (`kas_date` = '$date' AND `bebas`.`student_student_id` = '$student_id') 
        OR (`kas_date` = '$date' AND `bulan`.`student_student_id` = '$student_id') ORDER BY kas_noref ASC");
        
        return $res->result_array();
    }
    
    function get_bcode($kas=array()){
        
        if(isset($kas['date'])){
            $this->db->where('kas_date', $kas['date']);
        }
        
        if(isset($kas['noref'])){
            $this->db->where('kas_noref', $kas['noref']);
        }
        
        $this->db->select('kas_noref, kas_date, account_code, account_description');

        $this->db->join('account', 'account.account_id = kas.kas_account_id', 'left');

        $res = $this->db->get('kas');
        
        return $res->row_array();
        
    }
	
}