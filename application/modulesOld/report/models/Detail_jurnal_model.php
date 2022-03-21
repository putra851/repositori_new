<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Detail_jurnal_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_Bulan($ds, $de, $period_id, $majors_id ,$paramBulan, $kasBulan)
    {
        if($majors_id == "all"){
            $data = $this->db->query("SELECT DISTINCT `bulan`.`bulan_id`, `bulan_bill`, `bulan_date_pay`, `bulan_number_pay`,
                                    `bulan_status`, `bulan_input_date`, `bulan_last_update`, `student_student_id`, `student_img`,
                                    `student_nis`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`,
                                    `student`.`class_class_id`, `student`.`majors_majors_id`, `majors_name`, `majors_short_name`,
                                    `class_name`, `payment_payment_id`, `period_period_id`, `period_status`, `period_start`, `period_end`,
                                    `pos_name`, `account_account_id`, `payment_type`, `user_user_id`, `user_full_name`, `account_id`,
                                    `account_code`, `month_month_id`, `month_name`, `bulan`.`student_student_id`, `bulan`.`student_student_id`
                                    FROM `bulan`
                                    LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` 
                                    LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` 
                                    LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` 
                                    LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` 
                                    LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` 
                                    LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` 
                                    LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` 
                                    LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` 
                                    LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` 
                                    JOIN `kas` ON `bulan`.`bulan_noref` = `kas`.`kas_noref`
                                    WHERE `payment`.`period_period_id` = '$period_id' AND account.account_code = '$paramBulan' 
                                    AND `bulan`.`bulan_status` = 1 AND `bulan`.`bulan_account_id` = '$kasBulan' 
                                    AND `bulan_date_pay` >= '$ds' AND `bulan_date_pay` <= '$de' 
                                    AND majors.majors_status = '1' 
                                    ORDER BY `payment_payment_id`, `bulan_date_pay` ASC")->result_array();
        } else {
            $data = $this->db->query("SELECT DISTINCT `bulan`.`bulan_id`, `bulan_bill`, `bulan_date_pay`, `bulan_number_pay`,
                                    `bulan_status`, `bulan_input_date`, `bulan_last_update`, `student_student_id`, `student_img`,
                                    `student_nis`, `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `student`.`class_class_id`,
                                    `student`.`majors_majors_id`, `majors_name`, `majors_short_name`, `class_name`, `payment_payment_id`,
                                    `period_period_id`, `period_status`, `period_start`, `period_end`, `pos_name`, `account_account_id`, `payment_type`,
                                    `user_user_id`, `user_full_name`, `account_id`, `account_code`, `month_month_id`, `month_name`,
                                    `bulan`.`student_student_id`, `bulan`.`student_student_id` 
                                    FROM `bulan` 
                                    LEFT JOIN `month` ON `month`.`month_id` = `bulan`.`month_month_id` 
                                    LEFT JOIN `student` ON `student`.`student_id` = `bulan`.`student_student_id` 
                                    LEFT JOIN `payment` ON `payment`.`payment_id` = `bulan`.`payment_payment_id` 
                                    LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` 
                                    LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` 
                                    LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` 
                                    LEFT JOIN `majors` ON `majors`.`majors_id` = `student`.`majors_majors_id` 
                                    LEFT JOIN `users` ON `users`.`user_id` = `bulan`.`user_user_id` 
                                    LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` 
                                    JOIN `kas` ON `bulan`.`bulan_noref` = `kas`.`kas_noref`
                                    WHERE `payment`.`period_period_id` = '$period_id' AND account.account_code = '$paramBulan' 
                                    AND majors.majors_id = '$majors_id' AND `bulan`.`bulan_status` = 1 
                                    AND `bulan`.`bulan_account_id` = '$kasBulan' AND `bulan_date_pay` >= '$ds' 
                                    AND `bulan_date_pay` <= '$de' AND majors.majors_status = '1' 
                                    ORDER BY `payment_payment_id`, `bulan_date_pay` ASC")->result_array();
        }
        
        return $data;
    }
    
    function get_Free($ds, $de, $period_id, $majors_id ,$paramFree, $kasFree)
    {
        if($majors_id == "all"){
            $data = $this->db->query("SELECT `bebas_pay`.`bebas_pay_id`, `bebas_pay_bill`, `bebas_pay_bill`, `bebas_pay_number`,
                                    `bebas_pay_desc`, `bebas_pay_input_date`, `bebas_pay_last_update`, `bebas_pay`.`bebas_bebas_id`,
                                    `bebas_bill`, `student_student_id`, `student_nis`, `student`.`class_class_id`, `class_name`, `student_full_name`,
                                    `student_name_of_mother`, `student_parent_phone`, `payment_payment_id`, `payment_type`, `period_start`, `period_end`,
                                    `payment`.`pos_pos_id`, `pos_name`, `user_user_id`, `user_full_name`, `account_id`, `account_code` 
                                    FROM `bebas_pay`
                                    LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` 
                                    LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` 
                                    LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` 
                                    LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` 
                                    LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` 
                                    LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` 
                                    LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` 
                                    LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` 
                                    LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` 
                                    JOIN `kas` ON `bebas_pay`.`bebas_pay_noref` = `kas`.`kas_noref` 
                                    WHERE `payment`.`period_period_id` = '$period_id' 
                                    AND account.account_code = '$paramFree' AND `bebas_pay_input_date` >= '$ds' 
                                    AND `bebas_pay_input_date` <= '$de' AND majors.majors_status = '1' 
                                    AND `bebas_pay`.`bebas_pay_account_id` = '$kasFree' 
                                    ORDER BY `bebas_pay_last_update` ASC")->result_array();    
        } else {
            $data = $this->db->query("SELECT `bebas_pay`.`bebas_pay_id`, `bebas_pay_bill`, `bebas_pay_bill`, `bebas_pay_number`,
                                    `bebas_pay_desc`, `bebas_pay_input_date`, `bebas_pay_last_update`, `bebas_pay`.`bebas_bebas_id`,
                                    `bebas_bill`, `student_student_id`, `student_nis`, `student`.`class_class_id`, `class_name`,
                                    `student_full_name`, `student_name_of_mother`, `student_parent_phone`, `payment_payment_id`,
                                    `payment_type`, `period_start`, `period_end`, `payment`.`pos_pos_id`, `pos_name`, `user_user_id`,
                                    `user_full_name`, `account_id`, `account_code` 
                                    FROM `bebas_pay` 
                                    LEFT JOIN `bebas` ON `bebas`.`bebas_id` = `bebas_pay`.`bebas_bebas_id` 
                                    LEFT JOIN `student` ON `student`.`student_id` = `bebas`.`student_student_id` 
                                    LEFT JOIN `payment` ON `payment`.`payment_id` = `bebas`.`payment_payment_id` 
                                    LEFT JOIN `period` ON `period`.`period_id` = `payment`.`period_period_id` 
                                    LEFT JOIN `pos` ON `pos`.`pos_id` = `payment`.`pos_pos_id` 
                                    LEFT JOIN `class` ON `class`.`class_id` = `student`.`class_class_id` 
                                    LEFT JOIN `users` ON `users`.`user_id` = `bebas_pay`.`user_user_id` 
                                    LEFT JOIN `account` ON `account`.`account_id` = `pos`.`account_account_id` 
                                    LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` 
                                    JOIN `kas` ON `bebas_pay`.`bebas_pay_noref` = `kas`.`kas_noref`
                                    WHERE `payment`.`period_period_id` = '$period_id' 
                                    AND account.account_code = '$paramFree' 
                                    AND `bebas_pay_input_date` >= '$ds' 
                                    AND `bebas_pay_input_date` <= '$de' 
                                    AND majors.majors_id = '$majors_id' 
                                    AND majors.majors_status = '1' 
                                    AND `bebas_pay`.`bebas_pay_account_id` = '$kasFree' 
                                    ORDER BY `bebas_pay_last_update` ASC")->result_array();
        }
        
        return $data;
    }
    
    function get_Debit($ds, $de, $period_id, $majors_id ,$paramDebit, $kasDebit)
    {
        if($majors_id == "all"){
            $data = $this->db->query("SELECT `debit_id`, `debit_date`, `debit_value`, `debit_desc`, `debit_account_id`, `account_id`, `account_code`, `account_description`, `debit_input_date`, `debit_last_update`, `user_user_id`, `user_full_name` FROM `debit` LEFT JOIN `users` ON `users`.`user_id` = `debit`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `debit`.`debit_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE account.account_code = '$paramDebit' AND `debit_date` >= '$ds' AND `debit_date` <= '$de' AND majors.majors_status = '1' AND `debit`.`debit_kas_account_id` = '$kasDebit' ORDER BY `debit_date` ASC, `debit_id` DESC")->result_array();    
        } else {
            $data = $this->db->query("SELECT `debit_id`, `debit_date`, `debit_value`, `debit_desc`, `debit_account_id`, `account_id`, `account_code`, `account_description`, `debit_input_date`, `debit_last_update`, `user_user_id`, `user_full_name` FROM `debit` LEFT JOIN `users` ON `users`.`user_id` = `debit`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `debit`.`debit_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE majors.majors_id = '$majors_id' AND account.account_code = '$paramDebit' AND `debit_date` >= '$ds' AND `debit_date` <= '$de' AND majors.majors_status = '1' AND `debit`.`debit_kas_account_id` = '$kasDebit' ORDER BY `debit_date` ASC, `debit_id` DESC")->result_array();
        }
        
        return $data;
	}
	
	function get_Kredit($ds, $de, $period_id, $majors_id ,$paramKredit, $kasKredit)
    {
        if($majors_id == "all"){
            $data = $this->db->query("SELECT `kredit_id`, `kredit_date`, `kredit_value`, `kredit_desc`, `kredit_account_id`, `account_id`, `account_code`, `account_description`, `kredit_input_date`, `kredit_last_update`, `user_user_id`, `user_full_name` FROM `kredit` LEFT JOIN `users` ON `users`.`user_id` = `kredit`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `kredit`.`kredit_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE account.account_code = '$paramKredit' AND `kredit_date` >= '$ds' AND `kredit_date` <= '$de' AND majors.majors_status = '1' AND `kredit`.`kredit_kas_account_id` = '$kasKredit' ORDER BY `kredit_date` ASC, `kredit_id` DESC")->result_array();    
        } else {
            $data = $this->db->query("SELECT `kredit_id`, `kredit_date`, `kredit_value`, `kredit_desc`, `kredit_account_id`, `account_id`, `account_code`, `account_description`, `kredit_input_date`, `kredit_last_update`, `user_user_id`, `user_full_name` FROM `kredit` LEFT JOIN `users` ON `users`.`user_id` = `kredit`.`user_user_id` LEFT JOIN `account` ON `account`.`account_id` = `kredit`.`kredit_account_id` LEFT JOIN `majors` ON `majors`.`majors_id` = `account`.`account_majors_id` WHERE majors.majors_id = '$majors_id' AND account.account_code = '$paramKredit' AND `kredit`.`kredit_kas_account_id` = '$kasKredit' AND `kredit_date` >= '$ds' AND `kredit_date` <= '$de' AND majors.majors_status = '1' ORDER BY `kredit_date` ASC, `kredit_id` DESC")->result_array();
        }
        
        return $data;
    }
}
