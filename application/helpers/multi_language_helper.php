<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


if ( ! function_exists('get_phrase'))
{
	function get_phrase($phrase = '') {
		$CI	=&	get_instance();
		$CI->load->database();
		$current_language	=	$CI->db->get_where('settings' , array('type' => 'language'))->row()->description;

		if ( $current_language	==	'') {
			$current_language	=	'english';
			$CI->session->set_userdata('current_language' , $current_language);
		}


		/** insert blank phrases initially and populating the language db ***/
		$check_phrase	=	$CI->db->get_where('language' , array('phrase' => $phrase))->row()->phrase;
		if ( $check_phrase	!=		$phrase)
			$CI->db->insert('language' , array('phrase' => $phrase));


		// query for finding the phrase from `language` table
		$query	=	$CI->db->get_where('language' , array('phrase' => $phrase));
		$row   	=	$query->row();

		// return the current sessioned language field of according phrase, else return uppercase spaced word
		if (isset($row->$current_language) && $row->$current_language !="")
			return $row->$current_language;
		else
			return ucwords(str_replace('_',' ',$phrase));
	}

}


    if ( ! function_exists('get_grade_by_mark'))
    {
        function get_grade_by_mark($mark)
        {
            $CI = get_instance();
            $CI->load->model('report_model');
            return $CI->report_model->get_grade_byMark($mark);
        }
    }

    function get_tabulation_mark($exam_id, $student_id, $subject_od)
    {
        $CI = get_instance();
        $CI->load->model('report_model');
        return $CI->report_model->get_tabulation_mark($exam_id, $student_id, $subject_od);
    }
    function get_grade_point_Mark($mark)
    {
        $CI = get_instance();
        $CI->load->model('report_model');
        return $CI->report_model->get_grade_point_Mark($mark);
    }
    /*************************Student Due Report *****************************/
    if (!function_exists('get_studentDue_tk')) {
        function get_studentDue_tk($student_id)
        {
            $CI = get_instance();
            $CI->load->model('report_model');
            return $CI->report_model->get_studentDue_tk($student_id);
        }
    }

    if (!function_exists('get_month_name')) {

        function get_month_name($num)
        {
            $dateObj = DateTime::createFromFormat('!m', $num);
            return $dateObj->format('F');
        }
    }

    if (!function_exists('get_leaveNameById'))
    {
        function get_leaveNameById($id)
        {
            $CI = get_instance();
            $CI->load->model('Leave_model');
            return $CI->Leave_model->get_leaveName_byId($id);
        }
    }
// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */
/*Email function*/

function mycontroller(){
    $CI = get_instance();
    $CI->load->library('email');
    $CI->email->from('nutrientbd.bakery@gmail.com', 'Your Name');
    $CI->email->to('raselhossainb@gmail.com');
    $CI->email->subject('This is my subject');
    $CI->email->message('This is my message');
    $CI->email->send();
}
function email_send(){
    $CI = get_instance();
    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' =>'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_user' => 'nutrientbd.bakery@gmail.com',
        'smtp_pass' => 'nutrient@agemark',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
    );

    $CI->load->library('email', $config);

    $CI->email->set_newline("\r\n");

    $CI->email->from('nutrientbd.bakery@gmail.com', 'Rasel Hossain');
    $CI->email->to('joabyerfx09@gmail.com');
    $CI->email->subject('Email Test');
    $CI->email->message('Testing the email class.');
    if($CI->email->send())
    {
        echo 'your email was sent';
    }
    else
    {
        echo $CI->email->print_debugger();
    }

}

if (!function_exists('dd')){
    function dd($var)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        exit();
    }
}

if (!function_exists('get_monthName')){
    function get_monthName($monthNum)
    {
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        return $dateObj->format('F'); // March
    }
}
if (!function_exists('get_singleSignature')){
    function get_singleSignature($desig)
    {
        $CI	=&	get_instance();
        $CI->load->database();
        return $CI->db
            ->where('short_slug', $desig)
            ->order_by('id', 'DECS')
            ->get('designation')
            ->row();
    }
}
if (!function_exists('getStudentAdmissionDate')){
    function getStudentAdmissionDate($std_id)
    {
        $CI	=&	get_instance();
        $CI->load->database();
        $std = $CI->db->select('admission_date')
            ->where('student_id', $std_id)
            ->get('student')
            ->first_row();
        return ($std) ? $std->admission_date : null;
    }
}