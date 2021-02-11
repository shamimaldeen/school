<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: JobayerH
 * Date: 9/5/2019
 * Time: 7:14 PM
 */
class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Barcode_model');
        $this->load->model('Report_model');
        $this->load->model(array('Ajaxdataload_model' => 'ajaxload'));
        $this->load->library('form_validation');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    public function transfer()
    {
        $page_data['page_name']  = 'report/transfer/transfer-page';
        $page_data['page_title'] = get_phrase('transfer-certificate');
//        $page_data['transfer'] = $this->Report_model->getTransfer();
        $this->load->view('backend/index', $page_data);
    }
    public function tcertificate_serialNo($std_id)
    {
        return str_pad($std_id, 4, '0', STR_PAD_LEFT );
    }
    public function transfer_certificate()
    {
        if (!empty($_POST)){
            $this->form_validation->set_rules('class_id','Class','required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','Section','required');
            if ($this->form_validation->run()){
                $student_id = $this->input->post('student_id');
                $class_id = $this->input->post('class_id');

                $class_arr = $this->Report_model->get_className_byClass($class_id);
                $clsArr = array();
                foreach ($class_arr as $cls):
                    $clsArr[] = $cls->name;
                endforeach;
                $data['class_name'] = implode(', ', $clsArr);
                $data['sudentdata'] = $this->Report_model->getTransfer($student_id);
                $data['sl'] = $this->tcertificate_serialNo($student_id);
                $html=$this->load->view('backend/admin/report/transfer/transfer-certificate', $data, true);
                $pdfFilePath = "transfer-certificate.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
        redirect('Report/transfer');
    }
    // ------------------
    //tcertificate Certificate End

    public function testimonial()
    {
        $page_data['page_name']  = 'report/testimonial/testimonial-page';
        $page_data['page_title'] = get_phrase('testimonial-certificate');
        $this->load->view('backend/index', $page_data);
    }
    public function testimonial_certificate()
    {

        if (!empty($_POST)){
            $this->form_validation->set_rules('class_id','Class','required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','student','required');
            $this->form_validation->set_rules('passing_year','passing_yer','required');
            if ($this->form_validation->run()){
                $student_id = $this->input->post('student_id');
                $class_id = $this->input->post('class_id');
                $class_arr = $this->Report_model->get_className_byClass($class_id);
                $clsArr = array();
                foreach ($class_arr as $cls):
                    $clsArr[] = $cls->name;
                endforeach;
                $data['class_name'] = implode(', ', $clsArr);
                $data['sudentdata'] = $this->Report_model->getTransfer($student_id);
                $data['sl'] = $this->tcertificate_serialNo($student_id);
                $data['passing_year'] = $this->input->post('passing_year');
                $data['registration'] = $this->input->post('registration');
                $data['group'] = $this->input->post('group');
                $data['result'] = $this->input->post('result');

                $html=$this->load->view('backend/admin/report/testimonial/testimonial_certificate', $data, true);
                $pdfFilePath = "testimonial-certificate-".time().".pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
        redirect('Report/transfer');
    }
    function get_sections_for_ssph($class_id) {
        $vtype = $this->session->userdata('vtype');
        $sections = $this->db->get_where('section', array('class_id' => $class_id, 'vtype'=>$vtype))->result_array();
        $options = '<option value="">Select A Section</option>';
        foreach ($sections as $row) {
            $options .= '<option value="'.$row['section_id'].'">'.$row['name'].'</option>';
        }
        echo $options;
    }
    function get_student_for_ssph($class_id, $section_id) {
        $vtype = $this->session->userdata('vtype');
        $enrolls = $this->db
            ->select('enroll.*')
            ->join('student','enroll.student_id = student.student_id', 'left')
            ->where('student.vtype',$vtype)
            ->like('enroll.sections', ",".$section_id, "before")->or_like('enroll.sections', $section_id.",", "after")
            ->or_like('enroll.sections', $section_id)
            ->get_where('enroll', array('class_id' => $class_id))->result_array();
        $options = '';
        foreach ($enrolls as $row) {
            $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row();
            $options .= '<option value="'.$row['student_id'].'">'.$name->name .'  _  '. $name->student_code.'</span> </option>';
        }
        echo '<select class="" name="student_id[]" id="student_id" multiple="multiple">'.$options.'</select>';
    }
    function get_student_for_time_message($class_id, $section_id) {
        $vtype = $this->session->userdata('vtype');
        $enrolls = $this->db
            ->select('enroll.*')
            ->join('student','enroll.student_id = student.student_id', 'left')
            ->where('student.vtype',$vtype)
            ->where('enroll.section_id', $section_id)
            ->get_where('enroll', array('enroll.class_id' => $class_id, 'enroll.section_id' => $section_id))->result_array();
        $options = '';
        foreach ($enrolls as $row) {
            $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row();
            $options .= '<option value="'.$row['student_id'].'">'.$name->name .'  _  '. $name->student_code.'</span> </option>';
        }
        echo '<select class="" name="student_id[]" id="student_id" multiple="multiple">'.$options.'</select>';
    }




    /**************MANAGE EXAM SCHEDULE***************/
    // Search Exam Schedule add page
    public function exam_schedule(){
        $page_data['page_name']  = 'report/exam_schedule/examschedule';
        $page_data['page_title'] = get_phrase('exam_schedule');
        if ($this->input->method() == 'post'):
            $page_data['class_id'] = $this->input->post('class_id', true);
            $page_data['exam_id'] = $this->input->post('exam_id', true);
            if (!empty($page_data['class_id']) && !empty($page_data['exam_id'])){
                $page_data['exam_schedule'] =  $this->Report_model->get_exam_schedule_edit($page_data['exam_id'], $page_data['class_id']);
//                var_dump($page_data['exam_schedule']); exit();
                if ($page_data['exam_schedule'] == null){
                    $page_data['all_subject'] = $this->Report_model->allSubject($page_data['class_id']);
                    unset($page_data['exam_schedule']);
                }

                $page_data['examname'] = $this->Report_model->exameName($page_data['exam_id']);
                $page_data['classname'] = $this->Report_model->claseName($page_data['class_id']);
            }else{
                $this->session->set_flashdata('error_message', get_phrase('please_put_class/exam'));
                redirect(site_url('report/exam_schedule'));
            }
        endif;

        $this->load->view('backend/index', $page_data);
    }

    // add Exam shedule
    public function save_examSchedule(){
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('class_id', 'Class Name', 'required');
            $this->form_validation->set_rules('exam_id', 'Exam Name', 'required');
            if ($this->form_validation->run() == true){
                $running_year  = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                $class_id = $this->input->post('class_id', true);
                $exam_id = $this->input->post('exam_id', true);
                $exam_date = $this->input->post('exam_date', true);
                $from_time = $this->input->post('from_time', true);
                $from_am_pm = $this->input->post('from_am_pm', true);
                $to_time = $this->input->post('to_time', true);
                $to_am_pm = $this->input->post('to_am_pm', true);
                $subject_id = $this->input->post('subject_id', true);
                $data = array();
                foreach ($exam_date as $key  => $value):
                    $data['class_id']   = $class_id;
                    $data['exam_id']    = $exam_id;
                    $data['year']       = $running_year;
                    $data['subject_id'] = $subject_id[$key];
                    $data['exam_date']  = date_format(date_create($exam_date[$key]), 'Y-m-d');
                    $data['from_time']  = $from_time[$key];
                    $data['from_am_pm'] = $from_am_pm[$key];
                    $data['to_time']    = $to_time[$key];
                    $data['to_am_pm']   = $to_am_pm[$key];
                    $this->db->insert('exam_schedule', $data);
                endforeach;
                $this->session->set_flashdata('flash_message', get_phrase('exam_schedule_data_successfully_added'));
                redirect(site_url('report/print_exam_schedule'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('please_fill_the_required_fields!'));
                redirect(site_url('report/exam_schedule'));
            }
        }
    }
    // Update Exam Schedule

    public function update_examSchedule_data(){
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('class_id', 'Class Name', 'required');
            $this->form_validation->set_rules('exam_id', 'Exam Name', 'required');
            if ($this->form_validation->run() == true){
                $running_year  = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                $class_id = $this->input->post('class_id', true);
                $exam_id = $this->input->post('exam_id', true);
                $exam_date = $this->input->post('exam_date', true);
                $from_time = $this->input->post('from_time', true);
                $from_am_pm = $this->input->post('from_am_pm', true);
                $to_time = $this->input->post('to_time', true);
                $to_am_pm = $this->input->post('to_am_pm', true);
                $subject_id = $this->input->post('subject_id', true);
                $data = array();
                foreach ($exam_date as $key  => $value):
                    $data['exam_id']    = $exam_id;
                    $data['class_id']   = $class_id;
                    $data['year']       = $running_year;
                    $data['subject_id'] = $subject_id[$key];
                    $data['exam_date']  = date_format(date_create($exam_date[$key]), 'Y-m-d');
                    $data['from_time']  = $from_time[$key];
                    $data['from_am_pm'] = $from_am_pm[$key];
                    $data['to_time']    = $to_time[$key];
                    $data['to_am_pm']   = $to_am_pm[$key];
                    $this->db->where('id', $key);
                    $this->db->update('exam_schedule', $data);
                endforeach;
                $this->session->set_flashdata('flash_message', get_phrase('exam_schedule_data_successfully_update'));
                redirect(site_url('report/print_exam_schedule'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('please_fill_the_required_fields!'));
                redirect(site_url('report/exam_schedule'));
            }
        }

    }
// Print Exam Schedule search
    public function print_exam_schedule(){
        $page_data['page_name']  = 'report/exam_schedule/examschedule';
        $page_data['page_title'] = get_phrase('search_Schedule');
        $this->load->view('backend/index', $page_data);
    }

    //Print exam Schedule
    public function sheet_exam_schedule(){
        $class_id = $this->input->post('class_id', true);
        $exam_id = $this->input->post('exam_id', true);
        $input_data=  $this->Report_model->get_exam_schedule_edit($exam_id, $class_id);

        if (!empty($_POST) && !empty($input_data)){
            $this->form_validation->set_rules('class_id','Class','required');
            $this->form_validation->set_rules('exam_id','Section','required');
            if ($this->form_validation->run()){
                $class_id = $this->input->post('class_id', true);
                $page_data['exam_id']= $this->input->post('exam_id');
                $exam_id = $this->input->post('exam_id', true);
                $page_data ['session']= $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                $page_data ['class_name']= $this->Report_model->getClass($class_id);
                $page_data['exam_shedule']= $this->Report_model->getExamShedule($exam_id, $class_id);
                $html = $this->load->view('backend/admin/report/exam_schedule/sheet_examshedule', $page_data, true);
                $pdfFilePath = "exam_schedule.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }else{
            $this->session->set_flashdata('error_message', get_phrase('please_add_the_exam_schedule'));
            $this->load->view('backend/admin/report/window_close');
//            redirect(site_url('report/exam_schedule'));
        }
    }

    public function check_exam_schedule($class_id, $exam_id)       //AJAX FUNCTION TO CHECK EXAM SCHEDULE
    {
        $input_data=  $this->Report_model->get_exam_schedule_edit($exam_id, $class_id);
        return ($input_data != null) ? 1 : 0;
    }




   function allSubject($class_id){
        $q = $this->db->get_where('subject',['class_id'=>$class_id]);
        if ($q->num_rows() >0){
            return $q->result();
        }
        return [];
    }

    /******************** Model Test  *****************/
    public function admit_card(){
        $page_data['page_name']  = 'report/admit_card/admit_card_page';
        $page_data['page_title'] = get_phrase('Admit_card');
        $this->load->view('backend/index', $page_data);
    }
    public function admit_card_View(){
        if (!empty($_POST)){
            $this->form_validation->set_rules('exam','Exam','required');
            $this->form_validation->set_rules('class_id','Class','required');
//            $this->form_validation->set_rules('section_id','Section','required');
//            $this->form_validation->set_rules('student_id','student','required');
            if ($this->form_validation->run()){
                $class_id= $this->input->post('class_id');
                $section_id= $this->input->post('section_id');
                $page_data['exam_id']= $this->input->post('exam');
                $page_data['student_id']= $this->input->post('student_id');
                $page_data ['classRoll']=$this->Report_model->get_roll($page_data['student_id']);
                $page_data ['exam_name']=$this->Report_model->get_exam_name($page_data['exam_id']);
                $page_data ['className']=$this->Report_model->claseName($class_id);
                $page_data ['all_compulsor_subject']=$this->Report_model->get_Compulsory_Subject($class_id);
                $page_data ['all_4th_subject']=$this->Report_model->get_4th_Subject($class_id);
                $page_data ['all_elective_subject'] = $this->Report_model->get_elective_Subject($class_id);
                $page_data ['student_admit']=$this->Report_model->getStudentAdmitCard($class_id, $section_id,$page_data['student_id']);
//                $page_data ['student_admit']=$this->Report_model->get_admit_card($page_data['exam_id']);


//                $this->load->view('backend/admin/report/admit_card/admit_card', $page_data);
                $html=$this->load->view('backend/admin/report/admit_card/admit_card', $page_data, true);
                $pdfFilePath = "admit_card.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
    }

    /************************* Signature Sheet *****************************/

    public function signature_sheet(){
        $page_data['page_name']  = 'report/signature_sheet/signature_sheet_page';
        $page_data['page_title'] = get_phrase('signature_sheet');
        $this->load->view('backend/index', $page_data);
    }
    public function signature_sheet_print(){
        if (!empty($_POST)){
            $this->form_validation->set_rules('exam','Exam','required');
            $this->form_validation->set_rules('class_id','Class','required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','student','required');
            if ($this->form_validation->run()) {
                $class_id = $this->input->post('class_id', true);
                $exam_id = $this->input->post('exam', true);
                $page_data['student_id'] = $this->input->post('student_id');
                $page_data['section_id'] = $this->input->post('section_id');
                $page_data['exam_id'] = $this->input->post('exam');
                $page_data ['session'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                $page_data ['class_name'] = $this->Report_model->getClass($class_id);
                $page_data['exam_shedule'] = $this->Report_model->getExamShedule($exam_id, $class_id);
                $page_data ['classRoll'] = $this->Report_model->get_roll($page_data['student_id']);
                $page_data ['className'] = $this->Report_model->claseName($class_id);
                $page_data ['all_compulsor_subject'] = $this->Report_model->get_Compulsory_Subject($class_id);
                $page_data ['all_4th_subject'] = $this->Report_model->get_4th_Subject($class_id);
                $page_data ['all_elective_subject'] = $this->Report_model->get_elective_Subject($class_id);
                $page_data ['studentinfo'] = $this->Report_model->get_signature_student($page_data['student_id']);
//                $this->load->view('backend/admin/report/signature_sheet/signature_sheet_print', $page_data);
                $html=$this->load->view('backend/admin/report/signature_sheet/signature_sheet_print', $page_data, true);
                $pdfFilePath = "signature_sheet.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
    }
    /************************* Student Present Status *****************************/
    public function student_status(){
        $page_data['page_name']  = 'report/student_status/student_status_page';
        $page_data['page_title'] = get_phrase('student_present_status');
        $this->load->view('backend/index', $page_data);
    }
    public function student_status_print(){
        if (!empty($_POST)) {
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','student','required');
            if ($this->form_validation->run()) {
                $page_data['student_id'] = $this->input->post('student_id');
                $section_id = $this->input->post('section_id');

                $class_id = $this->input->post('class_id', true);
                $page_data ['section'] = $this->Report_model->get_section($section_id);
                $page_data ['className'] = $this->Report_model->claseName($class_id);
//        $page_data ['schoolingDay']=$this->Report_model->get_total_schooling_days($class_id);
                $page_data ['schoolingDay'] = $this->Report_model->get_all_schoolingDay($class_id, $page_data['student_id']);
                $page_data ['studentAttand'] = $this->Report_model->get_all_studentDay($class_id, $page_data['student_id']);
                $page_data ['student_roll'] = $this->Report_model->student_roll($page_data ['student_id']);
                $page_data ['studentinfo'] = $this->Report_model->get_student_info($page_data['student_id']);
                $page_data ['manthly_t_fees'] = $this->Report_model->get_manthly_tuition_fees();
                $page_data ['all_tuition_fee'] = $this->Report_model->get_student_payment(2, $page_data['student_id']);

                $page_data ['all_admission_fee'] = $this->Report_model->get_student_payment(8, $page_data['student_id']);
                $page_data ['all_session_fee'] = $this->Report_model->get_student_payment(9, $page_data['student_id']);
                $page_data ['all_exam_fee'] = $this->Report_model->get_student_payment(1, $page_data['student_id']);
                $page_data ['all_dress_fee'] = $this->Report_model->get_student_payment(10, $page_data['student_id']);
                $page_data ['all_books_fee'] = $this->Report_model->get_student_payment(4, $page_data['student_id']);
                $page_data ['all_copies_fee'] = $this->Report_model->get_student_payment(5, $page_data['student_id']);
                $page_data ['all_stationeries_fee'] = $this->Report_model->get_student_payment(6, $page_data['student_id']);
                $page_data ['others_remarks_fee'] = $this->Report_model->get_student_payment(7, $page_data['student_id']);
                $page_data ['all_transport_fee'] = $this->Report_model->get_student_payment(3, $page_data['student_id']);
                $page_data ['transport_fees_s'] = $this->Report_model->get_monthly_transport_fees();
//                 $this->load->view('backend/admin/report/student_status/student_status_print.php', $page_data);

                $html=$this->load->view('backend/admin/report/student_status/student_status_print.php', $page_data, true);
                $pdfFilePath = "student_status.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
    }
    /************************* Academic Trancript *****************************/
    public function academic_transcript(){
        $page_data['page_name']  = 'report/academic_transcript/academic_transcript_page';
        $page_data['page_title'] = get_phrase('academic_transcript');
        $this->load->view('backend/index', $page_data);
    }
    public function academic_transcript_print(){
        $exam_id = $this->input->post('exam');
        $class_id= $this->input->post('class_id', true);
        $section_id = $this->input->post('section_id', true);
        $student_id = $this->input->post('student_id', true);
        if (!empty($_POST)) {
             $this->form_validation->set_rules('exam', 'exam', 'required');
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','student','required');
            if ($this->form_validation->run()) {
                $page_data =[
                    'exam_name'=> $this->Report_model->get_exam($exam_id),
                    'student_transcript_info'=> $this->Report_model->get_student_transcript_info($student_id),
                    'section' => $this->Report_model->get_section($section_id),
                    'className' => $this->Report_model->claseName($class_id),
                    'student_roll'=>$this->Report_model->student_roll($student_id),
                    'student_gpa'=>$this->Report_model->get_student_gpa($exam_id, $class_id, $student_id),
                    'optinal_sub'=>$this->Report_model->optional_subject_transcript($exam_id, $class_id, $student_id),

                ];
//                $this->load->view('backend/admin/report/academic_transcript/academic_transcript_print',$page_data );

                $html = $this->load->view('backend/admin/report/academic_transcript/academic_transcript_print', $page_data, true);
                $pdfFilePath = "academic_trancript.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }

    }


    public function tabulation_sheet(){
        $page_data['page_name']  = 'report/tabulation_sheet/tabulation_sheet_page';
        $page_data['page_title'] = get_phrase('tabulation_sheet');
        $this->load->view('backend/index', $page_data);
    }
    public function tabulation_sheet_print()
    {
        $exam_id    = $this->input->post('exam');
        $class_id   = $this->input->post('class_id', true);

        if (!empty($_POST)) {
            $this->form_validation->set_rules('exam', 'exam', 'required');
            $this->form_validation->set_rules('class_id','Section','required');
            if ($this->form_validation->run()) {
                $page_data  = [
                    'tabulation_all_student'    =>$this->Report_model->get_tabulation_student($class_id),
                    'tabulation_all_sub'        =>$this->Report_model->get_tabulation_sub($class_id),
                    'exam_id'                   => $this->input->post('exam'),
                    'exam_name'                 => $this->Report_model->get_exam_name($exam_id),
                    'class_name'                => $this->Report_model->getClass($class_id),
                    'class_id'                  => $class_id,
//                    'tabulation_all_opt'        =>$this->Report_model->get_tabulation_opt($class_id),
                ];
//                $this->load->view('backend/admin/report/tabulation_sheet/tabulation_sheet_print', $page_data);
                $html=$this->load->view('backend/admin/report/tabulation_sheet/tabulation_sheet_print', $page_data, true);
                $pdfFilePath = "tabulation_sheet.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
    }
    /*************************Student Due Report *****************************/
    public function student_due_report(){
        $page_data['page_name']  = 'report/due_report/due_report';
        $page_data['page_title'] = get_phrase('due_report');
        $this->load->view('backend/index', $page_data);
    }
    public function student_due_report_print(){
        $class_id   = $this->input->post('class_id', true);
        $section_id = $this->input->post('section_id', true);
        if (!empty($_POST)) {
            $this->form_validation->set_rules('class_id','class','required');
            if ($this->form_validation->run()) {
                $page_data = [
                    'all_student_dueReport' => $this->Report_model->get_student_due_report($class_id, $section_id),
                    'tuitionFeeByClass'     => $this->Report_model->get_tuition_fee_byClass($class_id),
                    'class_name'            => $this->Report_model->getClass($class_id),
                    'section_name'          => $this->Report_model->get_section($section_id)
                ];
//                $this->load->view('backend/admin/report/due_report/due_report_print', $page_data);

                $html=$this->load->view('backend/admin/report/due_report/due_report_print', $page_data, true);
                $pdfFilePath = "student_due_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            } else{
                redirect('report/student_due_report');
            }
        }
    }
    /*************************Student Income report *****************************/
    public function income_report(){
        $page_data['page_name']  = 'report/income_report/income_report';
        $page_data['page_title'] = get_phrase('income_report');
        $this->load->view('backend/index', $page_data);
    }
    public function income_report_print()
    {
        if (!empty($_POST)) {
            $class_id = $this->input->post('class_id', true);
            $section_id = $this->input->post('section_id', true);
            $from_date = $this->input->post('from_date', true);
            $to_date = $this->input->post('to_date', true);
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'class_name' => $this->Report_model->getClass($class_id),
                    'section_name' => $this->Report_model->get_section($section_id),
                    'class_id' => $this->input->post('class_id', true),
                    'section_id' => $this->input->post('section_id', true),
                    'from_date' => $this->input->post('from_date', true),
                    'to_date' => $this->input->post('to_date', true),
                ];
//                $this->load->view('backend/admin/report/income_report/income_report_print', $page_date);
                $html=$this->load->view('backend/admin/report/income_report/income_report_print', $page_date, true);
                $pdfFilePath = "income_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        } else{
            redirect('report/income_report');
        }
    }
    /*************************Student Income report *****************************/

    public function expense_report(){
        $page_data['page_name']  = 'report/expense_report/expense_report';
        $page_data['page_title'] = get_phrase('expense_report');
        $this->load->view('backend/index', $page_data);
    }
    public function expense_report_print(){
        if (!empty($_POST)) {
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'from_date' => $this->input->post('from_date', true),
                    'to_date' => $this->input->post('to_date', true),
                    'expense_ct_id' => $this->input->post('expense_category_id', true),
                ];
//                $this->load->view('backend/admin/report/expense_report/expense_report_print', $page_date);
                $html=$this->load->view('backend/admin/report/expense_report/expense_report_print', $page_date, true);
                $pdfFilePath = "expense_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        } else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/expense_report'), 'refresh');
        }
    }


    public function expense_reportBydate(){
        $page_data['page_name']  = 'report/expense_report_by_date/expense_report_by_date';
        $page_data['page_title'] = get_phrase('expense_report');
        $this->load->view('backend/index', $page_data);
    }
    public function expense_reportBy_date_print(){
        if (!empty($_POST)) {
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'from_date' => $this->input->post('from_date', true),
                    'to_date' => $this->input->post('to_date', true),
                ];
//                $this->load->view('backend/admin/report/expense_report_by_date/expense_report_by_date_print', $page_date);
                $html=  $this->load->view('backend/admin/report/expense_report_by_date/expense_report_by_date_print', $page_date, true);
                $pdfFilePath = "expense_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        } else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/expense_report'), 'refresh');
        }
    }

    /*************************Other Income report *****************************/

    public function other_income_report(){
        $page_data['page_name']  = 'report/other_income_report/other_income';
        $page_data['page_title'] = get_phrase('other_income_report');
        $this->load->view('backend/index', $page_data);
    }
    public function other_income_report_print(){
        if (!empty($_POST)) {
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'from_date' => $this->input->post('from_date', true),
                    'to_date' => $this->input->post('to_date', true),
                ];
//                $this->load->view('backend/admin/report/other_income_report/other_income_print', $page_date);
                $html=  $this->load->view('backend/admin/report/other_income_report/other_income_print', $page_date, true);
                $pdfFilePath = "other_income_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        } else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/expense_report'), 'refresh');
        }
    }

    /*************************Occasional Expense report *****************************/
    public function occasional_expense_report(){
        $page_data['page_name']  = 'report/occasional_expense_report/occasional_expense';
        $page_data['page_title'] = get_phrase('occasional_expense_report');
        $this->load->view('backend/index', $page_data);
    }
    public function occasional_expense_report_print(){
        if (!empty($_POST)) {
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'from_date' => $this->input->post('from_date', true),
                    'to_date' => $this->input->post('to_date', true),
                ];
//                $this->load->view('backend/admin/report/occasional_expense_report/occasional_expense_print', $page_date);
                $html=  $this->load->view('backend/admin/report/occasional_expense_report/occasional_expense_print', $page_date, true);
                $pdfFilePath = "expense_report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        } else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/expense_report'), 'refresh');
        }
    }

    /*************************Tuition Fee Sheet *****************************/
    public function tuition_fee(){
        $page_data['page_name']  = 'report/tuition_fee/tuition_fee_search';
        $page_data['page_title'] = get_phrase('student_fee_collection');
        $this->load->view('backend/index', $page_data);
    }
    public function tuition_fee_sheet_print(){
        $class_id   = $this->input->post('class_id', true);
        $section_id = $this->input->post('section_id', true);
        $shift      = $this->input->post('shift', true);
        if (!empty($_POST)) {
               $this->form_validation->set_rules('class_id','class','required');
            if ($this->form_validation->run()) {
                $page_date = [
                    'exams' => $this->Report_model->get_exam_names_byClass(),
                    'class_name' => $this->Report_model->getClass($class_id),
                    'section_name' => $this->Report_model->get_section($section_id),
                    'shift_name' => $this->input->post('shift', true),
                    'all_student_info' => $this->Report_model->get_tution_feeBy_student_info($class_id, $section_id, $shift),
                ];
                $this->load->view('backend/admin/report/tuition_fee/tuition_fee_sheet_print', $page_date);
                $html = $this->load->view('backend/admin/report/tuition_fee/tuition_fee_sheet_print', $page_date, true);
                $pdfFilePath = "student_fee_collection.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }

        } else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/expense_report'), 'refresh');
        }
    }

    /*************************Progress Report *****************************/
    public function progress_report(){
        $page_data['page_name']  = 'report/progress_report/progress_report';
        $page_data['page_title'] = get_phrase('progress_report');
        $this->load->view('backend/index', $page_data);
    }
    public function progress_report_print(){
        $exam_id= $this->input->post('exam_id', true);
        $class_id= $this->input->post('class_id', true);
        $section_id = $this->input->post('section_id', true);
        $student_id = $this->input->post('student_id', true);
        if (!empty($_POST)) {
            $this->form_validation->set_rules('class_id', 'Class', 'required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('student_id','student','required');
            if ($this->form_validation->run()) {
                $roll_enroll = $this->Report_model->get_enroll($student_id);
                $page_data = [
                    'all_grade_point'           =>$this->Report_model->get_grade_point(),
//                    'all_general'               =>$this->Report_model->get_all_curriculum(1),
//                    'all_written'               =>$this->Report_model->get_all_curriculum(2),
//                    'all_team_work'             =>$this->Report_model->get_all_curriculum(3),
//                    'all_music'                 =>$this->Report_model->get_all_curriculum(4),
                    'tabulation_all_sub'        => $this->Report_model->get_tabulation_sub($class_id, $roll_enroll),
                    'tabulation_all_opt'        => $this->Report_model->get_tabulation_opt($class_id, $roll_enroll),
//                    'exam_id'                   => $this->input->post('exam'),
                    'student_id'                => $this->input->post('student_id'),
                    'student_transcript_info'   => $this->Report_model->get_student_transcript_info($student_id),
                    'class_name'                => $this->Report_model->getClass($class_id),
                    'class_id'                  => $class_id,
                    'section_name'              => $this->Report_model->get_section($section_id),
                    'roll_enroll'               => $roll_enroll,
                    'exam'                      => $this->Report_model->get_exam_name($exam_id),
                ];
                $this->load->view('backend/admin/report/progress_report/progress_report_print', $page_data );
//                $html = $this->load->view('backend/admin/report/progress_report/progress_report_print', $page_data, true);
//                $pdfFilePath = "academic_trancript.pdf";
//                $mpdf = new \Mpdf\Mpdf();
//                $mpdf->WriteHTML($html);
//                $mpdf->Output($pdfFilePath, "I");
            }else{
                $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
                redirect(site_url('report/progress_report'), 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/progress_report'), 'refresh');
        }
    }

    /*************************Employee salary sheet *****************************/

    public function employee_salary_sheet(){
        $page_data['month'] = date('m');
        $page_data['running_year'] = get_settings('running_year');
        $page_data['page_name']  = 'report/employee_salary/salary_report';
        $page_data['page_title'] = get_phrase('generate_employee_salary_sheet');
        $this->load->view('backend/index', $page_data);
    }

    public function employee_salary_sheet_print(){

        $page_data['month'] = $this->input->post('month', true);
        $year1 = $this->input->post('year1', true);
        $page_data['session'] = get_settings('running_year');

        $holidays = 0;
        $number = cal_days_in_month(CAL_GREGORIAN, $page_data['month'], $year1);
        /*
        for ($i=1; $i<=$page_data['number']; $i++)
        {
            $c_d = str_pad($i, 2, 0, STR_PAD_LEFT);
            $cdate =  $page_data['year1'] .'-'. $page_data['month'] . '-' . $c_d;
            if (date('D', strtotime($cdate)) == 'Fri')
            {
                $holidays++;
            }
        }
        */

        if (!empty($_POST)) {
            $this->form_validation->set_rules('month', 'month', 'required');
            $this->form_validation->set_rules('year1','year1','required');
            if ($this->form_validation->run()) {
                $page_data = [
                    'all_employee'          => $this->Report_model->get_employee(),
                    'all_working_days'      => $this->Report_model->get_working_days($page_data['month'], $year1),
                    'all_signature'         => $this->Report_model->get_signature(),
                    'holiday'               => $holidays,
                    'month'                 => $this->input->post('month', true),
                    'year1'                 => $year1,
                    'session'               => get_settings('running_year'),
                    'number'                => $number

                ];
//                $this->load->view('backend/admin/report/employee_salary/employee_salary_print', $page_data );
                $html = $this->load->view('backend/admin/report/employee_salary/employee_salary_print', $page_data, true);
                $pdfFilePath = "employee_salary_sheet.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }else{
            $this->session->set_flashdata('error_message' , get_phrase('something_wrong!_try_again'));
            redirect(site_url('report/employee_salary_sheet'), 'refresh');
        }
    }
    public function get_examAndSubjectField($class)
    {
        $vtype = $this->session->userdata('vtype');
        $html = '<div class="form-group">';
        $html .= '<label>' . get_phrase('exam') . '</label>';
        $html .= '<select class="" name="exam_id" id="exam_id" required>';
        $html .= '<option value="">' . get_phrase('select_a_exam') . '</option>';
        $exams = $this->db->get_where('exam',['vtype'=>$vtype])->result_array();
        foreach($exams as $row):
            $html .= '<option value="' . $row["exam_id"] . '">' . $row['name'] . '</option>';
        endforeach;
        $html .= '</select></div>';
        $html .= '<div class="form-group">';
        $html .= '<label>' . get_phrase('subject') . '</label>';
        $html .= '<select class="" name="subject_id" id="subject_id" required>';
        $html .= '<option value="" disabled>' . get_phrase('select_a_subject') . '</option>';
        $subjects = $this->db->get_where('subject',['class_id' => $class, 'vtype'=>$vtype])->result();
        foreach($subjects as $row):
            $html .= '<option value="' . $row->subject_id . '">' . $row->name . '</option>';
        endforeach;
        $html .= '</select></div>';
        echo $html; exit;
    }
    public function guest_student()
    {
        $page_data['page_name']  = 'report/guest_student/form';
        $page_data['page_title'] = get_phrase('guest_student_information');
//        $page_data['transfer'] = $this->Report_model->getTransfer();
        $this->load->view('backend/index', $page_data);
    }
    public function get_guest_student()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('class_id','Class','required');
            $this->form_validation->set_rules('section_id','Section','required');
            $this->form_validation->set_rules('from_date','From Date','required');
            $this->form_validation->set_rules('to_date','To Date','required');
            if ($this->form_validation->run()){
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $data['from_date'] = date('Y-m-d', strtotime($this->input->post('from_date')));
                $data['to_date'] = date('Y-m-d', strtotime($this->input->post('to_date')));
                $data['className'] = $this->Report_model->getClassNameById($class_id);
                $data['sectionName'] = $this->Report_model->getSectionNameById($section_id);
                $data['temp_students'] = $this->Report_model->getGuestStudentData($class_id, $section_id, $data['from_date'], $data['to_date']);
                $html=$this->load->view('backend/admin/report/guest_student/report-pdf', $data, true);
                $pdfFilePath = "guest-student-report.pdf";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath, "I");
            }
        }
        redirect('Report/guest_student');
    }
}