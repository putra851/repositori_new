<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Neraca_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_aktiva_unit($period_id, $majors_id, $start, $end){
        $data = $this->db->query("SELECT account_code, account_description, (saldo_awal_debit + SUM(kas_debit) - SUM(kas_kredit)) as saldo FROM account JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN kas ON account.account_id = kas.kas_account_id LEFT JOIN month ON kas.kas_month_id = month.month_id WHERE account.account_majors_id = '$majors_id' AND account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_note != '0' AND account_majors_id = '$majors_id' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%') AND kas_period = '$period_id' AND month.month_id BETWEEN '$start' AND '$end' GROUP BY kas_account_id ORDER BY account_majors_id ASC, account_code ASC")->result_array();
        
        return $data;
    }
    
    function get_aktiva_all($period_id, $start, $end){
        $data = $this->db->query("SELECT account_code, account_description, (saldo_awal_debit + SUM(kas_debit) - SUM(kas_kredit)) as saldo FROM account JOIN saldo_awal ON saldo_awal.saldo_awal_account = account.account_id LEFT JOIN kas ON account.account_id = kas.kas_account_id LEFT JOIN month ON kas.kas_month_id = month.month_id WHERE account_note IN (SELECT account_id FROM account WHERE account_category = '0' AND account_note != '0' AND account_code LIKE '1%' AND account_description LIKE '%Aktiva%') AND kas_period = '$period_id' AND month.month_id BETWEEN '$start' AND '$end' GROUP BY kas_account_id ORDER BY account_majors_id ASC, account_code ASC")->result_array();
        
        return $data;
    }
    
    function get_piutang_unit($period_id, $majors_id, $start, $end, $start_id, $end_id){
        $data = $this->db->query("SELECT account_id, account_code, account_description, sum(total) as total FROM (
        SELECT
        account.account_id,
        account.account_code, account.account_description,
        SUM(bulan.bulan_bill) AS total
        FROM account
        LEFT JOIN pos ON account.account_id = pos.piutang_account_id
        LEFT JOIN payment ON pos.pos_id = payment.pos_pos_id
        LEFT JOIN bulan ON payment.payment_id = bulan.payment_payment_id 
        WHERE account.account_majors_id = '$majors_id' 
        AND payment.period_period_id = '$period_id'
        AND bulan.month_month_id BETWEEN '$start' AND '$end'
        AND bulan.bulan_status= '0'
        GROUP BY account_id
        UNION
        SELECT
        account.account_id,
        account.account_code, account.account_description,
        (SUM(bebas.bebas_bill)-SUM(bebas.bebas_total_pay)) AS total
        FROM account
        LEFT JOIN pos ON account.account_id = pos.piutang_account_id
        LEFT JOIN payment ON pos.pos_id = payment.pos_pos_id
        LEFT JOIN bebas ON payment.payment_id = bebas.payment_payment_id
        WHERE account.account_majors_id = '$majors_id' 
        AND payment.period_period_id = '$period_id'
        AND bebas.bebas_last_update >= '$start_id' AND bebas.bebas_last_update < '$end_id'
        GROUP BY account_id        
        ) account
        GROUP BY account_id")->result_array();
        
        return $data;
    }
    
    function get_piutang_all($period_id, $start, $end, $start_id, $end_id){
        $data = $this->db->query("SELECT account_id, account_code, account_description, sum(total) as total FROM (
        SELECT
        account.account_id,
        account.account_code, account.account_description,
        SUM(bulan.bulan_bill) AS total
        FROM account
        LEFT JOIN pos ON account.account_id = pos.piutang_account_id
        LEFT JOIN payment ON pos.pos_id = payment.pos_pos_id
        LEFT JOIN bulan ON payment.payment_id = bulan.payment_payment_id 
        WHERE payment.period_period_id = '$period_id'
        AND bulan.month_month_id BETWEEN '$start' AND '$end'
        AND bulan.bulan_status= '0'
        GROUP BY account_id
        UNION
        SELECT
        account.account_id,
        account.account_code, account.account_description,
        (SUM(bebas.bebas_bill)-SUM(bebas.bebas_total_pay)) AS total
        FROM account
        LEFT JOIN pos ON account.account_id = pos.piutang_account_id
        LEFT JOIN payment ON pos.pos_id = payment.pos_pos_id
        LEFT JOIN bebas ON payment.payment_id = bebas.payment_payment_id
        WHERE payment.period_period_id = '$period_id'
        AND bebas.bebas_last_update >= '$start_id' AND bebas.bebas_last_update < '$end_id'
        GROUP BY account_id        
        ) account
        GROUP BY account_id")->result_array();
        
        return $data;
    }
    
}

?>