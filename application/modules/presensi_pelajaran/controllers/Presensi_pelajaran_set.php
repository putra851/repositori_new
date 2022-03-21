<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_pelajaran_set extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('presensi_pelajaran/Presensi_pelajaran_model', 'student/Student_model', 'lesson/Lesson_model', 'period/Period_model', 'bulan/Bulan_model', 'setting/Setting_model', 'logs/Logs_model'));
        $this->load->library('upload');
    }

    // pos view in list
    public function index($offset = NULL) {
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$param = array();
		$params = array();
		$class_id = NULL;
		
		
	    $day        = pretty_date(date('Y-m-d'), 'l' ,false);

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$param['period_id']  = $q['p'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
			$param['month_id'] = $q['m'];
		}

		if (isset($q['d']) && !empty($q['d']) && $q['d'] != '') {
			$param['date'] = $q['d'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id']  = $q['c'];
			$param['class_id']  = $q['c'];
			$class_id  = $q['c'];
		}

		if (isset($q['l']) && !empty($q['l']) && $q['l'] != '') {
			$params['lesson_id']  = $q['l'];
			$param['lesson_id']  = $q['l'];
		}
		
		$data['check']      = $this->Presensi_pelajaran_model->check($param);
		
		$data['class']      = $this->Student_model->get_class($params);
		$data['majors']     = $this->Student_model->get_majors($params);
		$data['student']    = $this->Student_model->get($params);
		$data['lesson']     = $this->db->query("SELECT lesson_id, lesson_code, lesson_name FROM schedule JOIN lesson ON lesson_id = schedule_lesson_id JOIN day ON day.day_id = schedule.schedule_day WHERE schedule_class_id = '$class_id' AND day_name = '$day' ORDER BY schedule_time ASC")->result_array();
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
        $data['period'] = $this->db->query("SELECT period_id, period_start, period_end FROM period WHERE period_status = '1'")->row_array();
        
        $date = date('Y-m-d');
        $this_month = pretty_date($date, 'F', false);
        
        $data['bulan'] = $this->db->query("SELECT * FROM month WHERE month_name = '$this_month'")->row_array();
        
        $data['title'] = 'Presensi Pelajaran Santri';
        $data['main'] = 'presensi_pelajaran/presensi_pelajaran_list';
        $this->load->view('manage/layout', $data);
    }
    
    public function report($offset = NULL) {
        
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$param = array();
		$params = array();
		$class_id = NULL;
		
		
	    $day        = pretty_date(date('Y-m-d'), 'l' ,false);
		
		$namaBulan  = NULL;
		$bulan      = date('m');
		$period     = NULL;
		$tahun      = date('Y');
		

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$param['period_id']  = $q['p'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
			$param['month_id'] = $q['m'];
		}

		if (isset($q['d']) && !empty($q['d']) && $q['d'] != '') {
			$param['date'] = $q['d'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id']  = $q['c'];
			$param['class_id']  = $q['c'];
			$class_id  = $q['c'];
		}

		if (isset($q['l']) && !empty($q['l']) && $q['l'] != '') {
			$params['lesson_id']  = $q['l'];
			$param['lesson_id']  = $q['l'];
		}
		
		
		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
		    
		    
            $namaBulan = $this->db->query("SELECT month_name FROM month WHERE month_id = ".$q['m']."")->row_array();
            
		    if($q['m'] == 1) {
                $bulan = '07';
		    } else if($q['m'] == 2) {
                $bulan = '08';
		    } else if($q['m'] == 3) {
                $bulan = '09';
		    } else if($q['m'] == 4) {
                $bulan = '10';
		    } else if($q['m'] == 5) {
                $bulan = '11';
		    } else if($q['m'] == 6) {
                $bulan = '12';
		    } else if($q['m'] == 7) {
                $bulan = '01';
		    } else if($q['m'] == 8) {
                $bulan = '02';
		    } else if($q['m'] == 9) {
                $bulan = '03';
		    } else if($q['m'] == 10) {
                $bulan = '04';
		    } else if($q['m'] == 11) {
                $bulan = '05';
		    } else if($q['m'] == 12) {
                $bulan = '06';
		    }
		    
            $period = $this->db->query("SELECT period_id, period_start, period_end FROM period WHERE period_id = ".$q['p']."")->row_array();
            
            if($q['m'] < 7){
               $tahun               = $period['period_start'] ;
               $data['namaTahun']   = $period['period_start'] ;
            } else {
               $tahun               = $period['period_end'] ; 
               $data['namaTahun']   = $period['period_end'] ; 
            }
            
            $data['namaBulan']      = $namaBulan['month_name'];
		}
		
		$data['check']      = $this->Presensi_pelajaran_model->check($param);
		
		$data['class']      = $this->Student_model->get_class($params);
		$data['majors']     = $this->Student_model->get_majors($params);
		$data['student']    = $this->Student_model->get($params);
		$data['lesson']     = $this->db->query("SELECT lesson_id, lesson_code, lesson_name FROM schedule JOIN lesson ON lesson_id = schedule_lesson_id JOIN day ON day.day_id = schedule.schedule_day WHERE schedule_class_id = '$class_id' AND day_name = '$day' ORDER BY schedule_time ASC")->result_array();
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
        $data['period'] = $this->db->query("SELECT period_id, period_start, period_end FROM period")->result_array();
        
        $awalbulan = $tahun . '-' . $bulan . '-01';
        $akhirbulan = date('Y-m-d', strtotime("+1 month", strtotime($awalbulan)));
        
        $begin = new DateTime($awalbulan);
        $end = new DateTime($akhirbulan);
        
        $interval = DateInterval::createFromDateString('1 day');
        $data['daterange']  = new DatePeriod($begin, $interval, $end);
        
        $data['interval']   = date_diff(date_create($awalbulan),date_create($akhirbulan));
        
        $data['month'] = $this->db->query("SELECT * FROM month")->result_array();
        
        $data['title'] = 'Laporan Presensi Pelajaran Santri';
        $data['main'] = 'presensi_pelajaran/presensi_pelajaran_report';
        $this->load->view('manage/layout', $data);
    }
	
	function report_print(){
        
        $q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$param = array();
		$params = array();
		
		$namaBulan  = NULL;
		$bulan      = date('m');
		$period     = NULL;
		$tahun      = date('Y');
		$class_id = NULL;
		
		
	    $day        = pretty_date(date('Y-m-d'), 'l' ,false);
		

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$param['period_id']  = $q['p'];
		}

		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
			$param['month_id'] = $q['m'];
		}

		if (isset($q['d']) && !empty($q['d']) && $q['d'] != '') {
			$param['date'] = $q['d'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id']  = $q['c'];
			$param['class_id']  = $q['c'];
			$class_id  = $q['c'];
			$data['namaKelas'] = $this->db->query("SELECT class_name FROM class WHERE class_id = ".$q['c']."")->row_array();
		}

		if (isset($q['l']) && !empty($q['l']) && $q['l'] != '') {
			$params['lesson_id']  = $q['l'];
			$param['lesson_id']  = $q['l'];
			$data['namaPelajaran'] = $this->db->query("SELECT lesson_name FROM lesson WHERE lesson_id = ".$q['l']."")->row_array();
		}
		
		if (isset($q['m']) && !empty($q['m']) && $q['m'] != '') {
		    
		    
            $namaBulan = $this->db->query("SELECT month_name FROM month WHERE month_id = ".$q['m']."")->row_array();
            
		    if($q['m'] == 1) {
                $bulan = '07';
		    } else if($q['m'] == 2) {
                $bulan = '08';
		    } else if($q['m'] == 3) {
                $bulan = '09';
		    } else if($q['m'] == 4) {
                $bulan = '10';
		    } else if($q['m'] == 5) {
                $bulan = '11';
		    } else if($q['m'] == 6) {
                $bulan = '12';
		    } else if($q['m'] == 7) {
                $bulan = '01';
		    } else if($q['m'] == 8) {
                $bulan = '02';
		    } else if($q['m'] == 9) {
                $bulan = '03';
		    } else if($q['m'] == 10) {
                $bulan = '04';
		    } else if($q['m'] == 11) {
                $bulan = '05';
		    } else if($q['m'] == 12) {
                $bulan = '06';
		    }
		    
            $period = $this->db->query("SELECT period_id, period_start, period_end FROM period WHERE period_id = ".$q['p']."")->row_array();
            
            if($q['m'] < 7){
               $tahun               = $period['period_start'] ;
               $data['namaTahun']   = $period['period_start'] ;
            } else {
               $tahun               = $period['period_end'] ; 
               $data['namaTahun']   = $period['period_end'] ; 
            }
            
            $data['namaBulan']      = $namaBulan['month_name'];
		}
		
		$data['check']      = $this->Presensi_pelajaran_model->check($param);
		
		$data['class']      = $this->Student_model->get_class($params);
		$data['majors']     = $this->Student_model->get_majors($params);
		$data['student']    = $this->Student_model->get($params);
		$data['lesson']     = $this->db->query("SELECT lesson_id, lesson_code, lesson_name FROM schedule JOIN lesson ON lesson_id = schedule_lesson_id JOIN day ON day.day_id = schedule.schedule_day WHERE schedule_class_id = '$class_id' AND day_name = '$day' ORDER BY schedule_time ASC")->result_array();
        
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
        $data['period'] = $this->db->query("SELECT period_id, period_start, period_end FROM period")->result_array();
        
        $awalbulan = $tahun . '-' . $bulan . '-01';
        $akhirbulan = date('Y-m-d', strtotime("+1 month", strtotime($awalbulan)));
        
        $begin = new DateTime($awalbulan);
        $end = new DateTime($akhirbulan);
        
        $interval = DateInterval::createFromDateString('1 day');
        $data['daterange']  = new DatePeriod($begin, $interval, $end);
        
        $data['interval']   = date_diff(date_create($awalbulan),date_create($akhirbulan));
        
        $data['month'] = $this->db->query("SELECT * FROM month")->result_array();
        
        $data['title'] = 'Laporan Presensi Pelajaran Santri';
		
		$data['setting_nip_bendahara']  = $this->Setting_model->get(array('id' => 15));
        $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
        $data['setting_city']           = $this->Setting_model->get(array('id' => SCHOOL_CITY));
        $data['setting_district']       = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
        $data['setting_school']         = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
        $data['setting_address']        = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
        $data['setting_phone']          = $this->Setting_model->get(array('id' => SCHOOL_PHONE));  
	    
	    $this->load->view('presensi_pelajaran/presensi_pelajaran_report_print', $data);
        
	}
    
    public function add_glob(){
        if ($_POST == TRUE) {
            
            $periodID     = $_POST['period_id'];
            $monthID      = $_POST['month_id'];
            $presensiDate = $_POST['presensi_date'];
            $majorsID     = $_POST['majors_id'];
            $classID      = $_POST['class_id'];
            $lessonID     = $_POST['lesson_id'];
            $studentID    = $_POST['student_id'];
            
            $cpt = count($studentID);
          
            for ($i = 0; $i < $cpt; $i++) {
              
                $student_id         = $studentID[$i];
                $status_kehadiran   = 'presensi_pelajaran_status' . $student_id;
                
                $status             = $_POST[$status_kehadiran];
                
                $params['presensi_pelajaran_period_id']    = $periodID;
                $params['presensi_pelajaran_month_id']     = $monthID;
                $params['presensi_pelajaran_date']         = $presensiDate;
                $params['presensi_pelajaran_class_id']     = $classID;
                $params['presensi_pelajaran_lesson_id']    = $lessonID;
                $params['presensi_pelajaran_student_id']   = $student_id;
                $params['presensi_pelajaran_status']       = $status[0];
                
                $this->Presensi_pelajaran_model->add($params);
            }
          
        }
        
        $this->session->set_flashdata('success',' Input Presensi Berhasil');
        redirect('manage/presensi_pelajaran?p=' . $periodID . '&m=' . $monthID . '&d=' . $presensiDate . '&k=' . $majorsID . '&c=' . $classID . '&l=' . $lessonID);
    }
    
    function class_searching(){
	    $id_majors = $this->input->post('id_majors');
        $dataKelas  = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors' ORDER BY class_name ASC")->result_array();
    
        echo '<div class="col-md-2">  
				<div class="form-group">
				    <label>Kelas</label>
		            <select name="c" id="class_id" class="form-control" required="" onchange="get_pelajaran()">
                    <option value="">-- Pilih Kelas --</option>';
                      foreach($dataKelas as $row){ 
        
                        echo '<option value="'.$row['class_id'].'">';
                            
                        echo $row['class_name'];
                            
                        echo '</option>';
                    
                        }
            echo '</select>
				</div>
			</div>';
	}
    
    function lesson_searching(){
	    $class_id   = $this->input->post('class_id');
	    $day        = pretty_date(date('Y-m-d'), 'l' ,false);
        $dataKelas  = $this->db->query("SELECT lesson_id, lesson_code, lesson_name FROM schedule JOIN lesson ON lesson_id = schedule_lesson_id JOIN day ON day.day_id = schedule.schedule_day WHERE schedule_class_id = '$class_id' AND day_name = '$day' ORDER BY schedule_time ASC")->result_array();
    
        echo '<div class="col-md-2">  
				<div class="form-group">
				    <label>Mata Pelajaran</label>
		            <select name="l" id="lesson_id" class="form-control" required="">
                    <option value="">-- Pilih Mata Pelajaran --</option>';
                      foreach($dataKelas as $row){ 
        
                        echo '<option value="'.$row['lesson_id'].'">';
                            
                        echo $row['lesson_code'] . ' - ' .$row['lesson_name'];
                            
                        echo '</option>';
                    
                        }
            echo '</select>
				</div>
			</div>';
	}
	
}