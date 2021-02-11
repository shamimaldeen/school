<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mnran
 * Date: 9/6/2018
 * Time: 1:28 PM
 */

class Report_model extends RS_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTransfer($id){
        $q = $this->db
            ->select('student.*,enroll.*,parent.*,class.*, student.name as student_name, parent.name as fathers_name, class.name as class_name')
            ->from('enroll')
            ->join('student', 'enroll.student_id = student.student_id', 'left')
            ->join('parent', 'student.parent_id = parent.parent_id', 'left')
            ->join('class', 'enroll.class_id = class.class_id', 'left')
            ->where('student.student_id',$id)
            ->get();

        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }

    public function get_className_byClass($class_id)
    {
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $rows = $this->db->select('name')->from('subject')->where(['class_id' => $class_id, 'year'=>$year, 'vtype'=>$vtype])->order_by('name', 'asc')->get();
        return $rows->result('object');
    }
    public function getClassNameById($class_id)
    {
        $class = $this->db->select('name')->from('class')->where('class_id', $class_id)->order_by('name', 'asc')->get()->row();
        return ($class) ? $class->name : null;
    }
    public function getSectionNameById($section_id)
    {
        $section = $this->db->select('name, nick_name')->from('section')->where('section_id', $section_id)->order_by('name', 'asc')->get()->row();
        return ($section) ? $section->name . ' (' . $section->nick_name .')' : null;
    }
    /**************MANAGE EXAM SCHEDULE***************/
    public function addExamSchedule(){
        $running_year            = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $date = $this->input->post('exam_date', true);
//        $database_date= $date('F d, Y', strtotime($date));
        $data = [
                'exam_id'=>$this->input->post('exam_id', true),
                'class_id'=>$this->input->post('class_id', true),
                'schedule_date'=>$this->input->post('exam_date', true),
                'exam_from'=>$date,
                'exam_to'=>$this->input->post('to_time', true),
                'from_am_pm'=>$this->input->post('from_am_pm', true),
                'to_am_pm'=>$this->input->post('to_am_pm', true),
                'year'=>$running_year
            ];
        $this->db->insert('exam_schedule', $data);
    }
    public function getClass($class_id){
        $vtype = $this->session->userdata('vtype');
        $q= $this->db->get_where('class',['class_id'=>$class_id, 'vtype'=>$vtype]);
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return [];
    }
    public function getExamShedule($exam, $class){
        $year  = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $q= $this->db
            ->select('exam_schedule.*,class.name,subject.*, exam.name, class.name as class_name, subject.name as subject_name, exam.name as exam_name')
            ->from('exam_schedule')
            ->join('class', 'exam_schedule.class_id=class.class_id','left')
            ->join('exam', 'exam_schedule.exam_id=exam.exam_id','left')
            ->join('subject', 'exam_schedule.subject_id=subject.subject_id','left')
            ->where('exam_schedule.exam_id',$exam)
            ->where('exam_schedule.class_id',$class)
            ->where('exam_schedule.year',$year)
            ->get();
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }
   public function allSubject($class_id){
       $vtype = $this->session->userdata('vtype');
       $year = get_settings('running_year');
        $q = $this->db->get_where('subject',['class_id'=>$class_id, 'vtype'=>$vtype, 'year'=>$year]);
        if ($q->num_rows() >0){
            return $q->result();
        }
        return [];
    }
    public function exameName($exam_id){
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db->get_where('exam',['exam_id'=>$exam_id, 'year'=>$year, 'vtype'=>$vtype]);
        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }
    public function claseName($class_id){
        $q = $this->db->get_where('class',['class_id'=>$class_id]);
        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }
    public function get_exam_schedule_edit($exam_id, $class_id)
    {
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db
            ->select('exam_schedule.*,subject.name as subject_name')
            ->from('exam_schedule')
            ->join('subject', 'exam_schedule.subject_id=subject.subject_id', 'left')
            ->where('exam_schedule.exam_id', $exam_id)
            ->where('subject.vtype', $vtype)
            ->where('exam_schedule.class_id', $class_id)
            ->where('exam_schedule.year', $year)
            ->get();
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return null;
    }

    /**************** Model Test ********************/

    public function getStudentAdmitCard($class_id, $section_id ='', $Student_id = ''){
            $year = get_settings('running_year');
             $this->db->select('student.*, class.*, enroll.*, enroll.roll as roll_number, section.*, section.name as section_name, parent.name, student.name as student_name, parent.name as parent_name');
             $this->db->from('student');
             $this->db->join('enroll','student.student_id=enroll.student_id','left');
             $this->db->join('parent','student.parent_id=parent.parent_id','left');
             $this->db->join('section','enroll.section_id=section.section_id','left');
             $this->db->join('class','enroll.class_id=class.class_id','left');
             $this->db->where('enroll.year',$year);
             $this->db->where('class.class_id',$class_id);
            if (!empty($section_id)){
                $this->db->where('section.section_id',$section_id);
            }
            if (!empty($Student_id)){
                $this->db->where('student.student_id',$Student_id);
            }
            $q = $this->db->get();
            if ($q->num_rows() > 0){
                return $q->result();
            }
            return [];
    }
    public function get_Compulsory_Subject($class_id){
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db
            ->where('subject.subject_type',1)
            ->where('subject.class_id',$class_id)
            ->where('subject.year',$year)
            ->where('subject.vtype',$vtype)
            ->get('subject');
        if ($q->num_rows() >0){
            return $q->result();
        }
        return [];
    }
    public function get_elective_Subject($class_id){
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db
            ->where('subject.subject_type',2)
            ->where('subject.class_id',$class_id)
            ->where('subject.year',$year)
            ->where('subject.vtype',$vtype)
            ->get('subject');
        if ($q->num_rows() >0){
            return $q->result();
        }
        return [];
    }
    public function get_4th_Subject($class_id){
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db
            ->where('subject.subject_type',3)
            ->where('subject.class_id',$class_id)
            ->where('subject.year',$year)
            ->where('subject.vtype',$vtype)
            ->get('subject');
        if ($q->num_rows() >0){
            return $q->result();
        }
        return [];
    }
    public function get_roll($student_id){
        $q = $this->db->get_where('enroll',['student_id'=>$student_id]);
        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }

    public function getModelTestStudent($Student_id){
        $q= $this->db
            ->select('student.*,enroll.*,parent.*,class.*, student.name as student_name, parent.name as fathers_name, class.name as class_name')
            ->from('student')
            ->join('enroll','student.student_id=enroll.student_id','left')
            ->join('parent','student.parent_id=parent.parent_id','left')
            ->join('section','enroll.section_id=section.section_id','left')
            ->join('class','enroll.class_id=class.class_id','left')
            ->where('student.student_id',$Student_id)
            ->get();
        if ($q->num_rows() > 0){
            return $q->row;
        }
        return [];
    }

    /************************* Signature Sheet *****************************/
    public function get_signature_student($Student_id){
        $q= $this->db
            ->select('student.*,parent.name, student.name as student_name, parent.name as parent_name')
            ->from('student')
            ->join('parent','student.parent_id=parent.parent_id','left')
            ->where('student.student_id',$Student_id)
            ->get_where();
        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }

    /************************* Student Present Status *****************************/
    public function get_student_info($student_id){
        $q= $this->db
            ->select('student.*,parent.*, student.name as student_name, parent.name as parent_name, student.phone,student.address')
            ->from('student')
            ->join('parent','student.parent_id=parent.parent_id')
            ->where('student.student_id',$student_id)
            ->get();
        if ($q->num_rows() >0){
            return $q->row();
        }
        return [];
    }
    public function student_roll($student_id) {
        $q= $this->db->get_where('enroll', ['student_id'=>$student_id]);
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return [];
    }
    public function get_section($section_id){
        $q= $this->db->get_where('section', ['section_id'=>$section_id]);
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return [];
    }
    public function get_all_schoolingDay($class_id, $student_id){
        $data = array('year' => get_settings('running_year'), 'student_id' => $student_id);
        return $this->db->where($data)->from('attendance')->count_all_results();
//        echo $this->db->last_query(); exit;
//        return $this->db->count_all_results();
//        echo $this->db exit;
//        return $result->num_rows();
}
   public function get_all_studentDay($class_id, $student_id) {
        $data = array('year' => get_settings('running_year'), 'class_id' => $class_id, 'status' => 1, 'student_id' => $student_id);
        return $rows = $this->db->where($data)->from('attendance')->count_all_results();
   }
    // Accounts Information
    public function get_manthly_tuition_fees(){
        $q= $this->db->get('tuition_fee_settings');
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return[];
    }
    public function get_student_account($student_id){
        $year  = get_settings('running_year');
        $q = $this->db
            ->where('year',$year)
            ->where('student_id',$student_id)
            ->get('tuition_fee_collection');
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return[];
    }
    public function get_monthly_transport_fees(){
        $q= $this->db->get('transport');
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return[];
    }
    public function get_student_payment($payment_type, $student_id){
        $year  = get_settings('running_year');
        $q = $this->db
            ->select('SUM(amount_paid) as paid_amount, SUM(amount) as total_amount, SUM(discount) as total_discount, SUM(due) as total_due')
            ->where('year',$year)
            ->where('student_id',$student_id)
            ->where('payment_type',$payment_type)
            ->group_by('payment_type')
            ->get('invoice');
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return[];

    }
    /************************* Academic Transcript*****************************/
    public function get_exam($exam_id){
        $year  = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $q= $this->db
            ->where('year', $year)
            ->where('vtype', $vtype)
            ->where('exam.exam_id',$exam_id)
            ->get('exam');
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return[];
    }
    public function get_student_transcript_info($student_id){
        $q = $this->db->get_where('student', ['student_id'=>$student_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return [];
    }
    public function get_student_gpa($exam_id, $class_id, $student_id)
    {
        $data = array();
        $year  = get_settings('running_year');
        $q = $this->db
            ->select('subject.subject_id sub_id, subject.name subject_name')
            ->from('subject')
            ->join('class', 'subject.class_id=class.class_id', 'left')
            ->where('class.class_id', $class_id)
            ->where_in('subject.subject_type', [1,2])
            ->order_by('subject_type', 'asc')
            ->get();
//        echo $this->db->last_query(); exit();
        if ($q->num_rows() > 0) {
            $subs = $q->result();
            $index = 0;
            foreach ($subs as $sub){
                $data[$index]['subject_name'] = $sub->subject_name;
                $q2 = $this->db->select('mark.mark_obtained, mark.cw_marks, hw_marks')
                    ->from('mark')
                    ->join('student', 'mark.student_id=student.student_id')
                    ->where('student.student_id', $student_id)
                    ->where('mark.subject_id', $sub->sub_id)
                    ->where('mark.year', $year)
                    ->where('mark.exam_id', $exam_id)
                    ->get();
                $mark = $q2->row();
                $data[$index]['total_mark'] = (!empty($mark)) ? ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks) : 0;
                $index++;
            }
        }
        return $data;
    }
    public function optional_subject_transcript($exam_id, $class_id, $student_id)
    {
        $data = array();
        $year  = get_settings('running_year');
        $q = $this->db
            ->select('subject.subject_id sub_id, subject.name subject_name')
            ->from('subject')
            ->join('class', 'subject.class_id=class.class_id', 'left')
            ->where('class.class_id', $class_id)
            ->where('subject.subject_type', 3)
            ->order_by('subject_type', 'asc')
            ->get();
        if ($q->num_rows() > 0) {
            $subs = $q->result();
            $index = 0;
            foreach ($subs as $sub){
                $data[$index]['subject_name'] = $sub->subject_name;
                $q2 = $this->db->select('mark.mark_obtained')
                    ->from('mark')
                    ->join('student', 'mark.student_id=student.student_id', 'left')
                    ->where('student.student_id', $student_id)
                    ->where('mark.subject_id', $sub->sub_id)
                    ->where('mark.year', $year)
                    ->where('mark.exam_id', $exam_id)
                    ->get();
                $mark = $q2->row();
                $data[$index]['total_mark'] = (!empty($mark) && $mark->mark_obtained != NULL) ? $mark->mark_obtained : 0;
                $index++;
            }

        }
        return $data;
    }

    public function get_grade_byMark($mark)
    {
        $vtype = $this->session->userdata('vtype');
        $qg =$this->db->select('grade_point, name')
            ->from('grade')
            ->where('mark_from <=', $mark)
            ->where('mark_upto >=',  $mark)
            ->where('vtype',  $vtype)
            ->get();
//        $this->db->last_query();
        $grade = $qg->row();
        return ($grade) ? $grade : null;
    }

    /************************* Tabulation Sheet*****************************/
    public function get_tabulation_student($class_id) {
        $vtype = $this->session->userdata('vtype');
        $year  = get_settings('running_year');
        $q = $this->db->select('student.*, class.*, enroll.*, student.name as student_name')
            ->from('student')
            ->join('enroll','student.student_id=enroll.student_id','left')
            ->join('parent','student.parent_id=parent.parent_id','left')
            ->join('section','enroll.section_id=section.section_id','left')
            ->join('class','enroll.class_id=class.class_id','left')
            ->where('class.class_id',$class_id)
            ->where('student.vtype',$vtype)
            ->where('enroll.year', $year)
            ->get();
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }
    public function get_tabulation_student_bySection($class_id, $section_id)
    {
        $vtype = $this->session->userdata('vtype');
        $year  = get_settings('running_year');
        $q = $this->db->select('student.*, class.*, enroll.*, student.name as student_name')
            ->from('student')
            ->join('enroll','student.student_id=enroll.student_id','left')
            ->join('parent','student.parent_id=parent.parent_id','left')
            ->join('section','enroll.section_id=section.section_id','left')
            ->join('class','enroll.class_id=class.class_id','left')
            ->where('class.class_id',$class_id)
            ->like('enroll.sections', ",".$section_id, "before")
            ->or_like('enroll.sections', $section_id.",", "after")
            ->or_like('enroll.sections', $section_id)
            ->where('enroll.year', $year)
            ->where('student.vtype',$vtype)
            ->get();
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }
    public function get_tabulation_student_byShift($class_id, $shift)
    {
        $vtype = $this->session->userdata('vtype');
        $year  = get_settings('running_year');
        $q = $this->db->select('student.*, class.*, enroll.*, student.name as student_name')
            ->from('student')
            ->join('enroll','student.student_id=enroll.student_id','left')
            ->join('parent','student.parent_id=parent.parent_id','left')
            ->join('section','enroll.section_id=section.section_id','left')
            ->join('class','enroll.class_id=class.class_id','left')
            ->where('class.class_id',$class_id)
            ->where('student.shift', $shift)
            ->where('enroll.year', $year)
            ->where('student.vtype',$vtype)
            ->get();
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }

    public function get_tabulation_sub($class_id, $enroll = null) {
        $vtype = $this->session->userdata('vtype');
        $year = get_settings('running_year');
        $q = $this->db->where('year', $year);
        $q->where('vtype', $vtype);
        if ((!empty($enroll)) &&($enroll->opt_sub_id != 0)) {
            $q->where('subject_id !=', $enroll->opt_sub_id);
        }
//            $q->where_in('subject.subject_type', [1,2]);
        $q = $q->get_where('subject', ['class_id'=>$class_id]);
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }
    public function get_tabulation_opt($class_id, $enroll = null){
        if ((!empty($enroll)) && ($enroll->opt_sub_id != 0)) {
            $vtype = $this->session->userdata('vtype');
            $year = get_settings('running_year');
            $q = $this->db->where('year', $year);
            $q->where('vtype', $vtype);
            $q->where_in('subject_type', 3);
            $q->where('subject_id', $enroll->opt_sub_id);
            $q = $q->get_where('subject', ['class_id' => $class_id]);
//            echo $this->db->last_query(); exit;
            if ($q->num_rows() > 0) {
                return $q->result();
            }
            return [];
        }
        return [];
    }

    public function get_all_subject_byClassId($class_id) {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $q = $this->db
            ->where('year', $year)
            ->where('vtype', $vtype)
            ->get_where('subject', ['class_id'=>$class_id]);
        if ($q->num_rows() > 0){
            return $q->result();
        }
        return [];
    }

    function get_tabulation_mark($exam_id, $student_id, $subject_id)
    {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $q=$this->db
            ->where('subject_id',$subject_id)
            ->where('exam_id',$exam_id)
            ->where('year', $year)
            ->where('vtype', $vtype)
            ->get_where('mark', ['student_id'=>$student_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return [];
    }
    public function get_grade_point_Mark($mark)
    {
        $vtype = $this->session->userdata('vtype');
        $q =$this->db->select('grade_point, name')
            ->from('grade')
            ->where('mark_from <=', $mark)
            ->where('vtype', $vtype)
            ->where('mark_upto >=',  $mark)
            ->get();
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return [];
    }

    public function get_passOrFail($mark)
    {

    }
    public function getMeritPosition($exam_id, $class_id, $student_id, $section_id = null)
    {
        $passed = array();
        $failed = array();

        $subjects   = $this->get_all_subject_byClassId($class_id);
        if ($section_id==null) {
            $students = $this->get_tabulation_student($class_id);
        }else{
            $students = $this->get_tabulation_student_bySection($class_id, $section_id);
        }
        foreach ($students as $student):
            $total_marks = 0;
            $is_failed = 0;
            foreach ($subjects as $sub):
                $mark = get_tabulation_mark($exam_id, $student->student_id, $sub->subject_id);
                if (!empty($mark) && ($mark->mark_obtained)) {
                    $each_mark = ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks);
                    $each_mark = ($each_mark>99) ? 100 : $each_mark;
                    $each_mark = ($each_mark<0) ? 0 : $each_mark;
                    $grade  = get_grade_point_Mark($each_mark);
                    if ($grade->grade_point == 0) {
                        $total_marks += $each_mark;
                        $is_failed = 1;
                    }else{
                        $total_marks += $each_mark;
                    }
                }else{
                    $is_failed = 1;
                }
            endforeach;

            if ($is_failed == 0)
            {
                $passed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }else{
                $failed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }
            /***************************** OPTIONAL ********************************/
        endforeach;
        usort($passed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });
        usort($failed, function($a, $b) {
                    return $b['marks'] - $a['marks'];
        });

//        echo '<pre>';
//        var_dump($passed);
//        echo '</pre>';
//
//        echo '<pre>';
//        var_dump($failed);
//        echo '</pre>';
//        exit();

        $key = array_search($student_id, array_column($passed, 'std_id'));
        if ($key != false || is_int($key))
        {
            return $key+1;
        }else{
            $tt_pass = count($passed);
            $key = array_search($student_id, array_column($failed, 'std_id'));
            if ($key != false || is_int($key))
                return ($tt_pass+$key+1);
            else
                return null;
        }
    }

    public function get_exam_name($exam_id) {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $q= $this->db
            ->where('exam.exam_id', $exam_id)
            ->where('exam.year', $year)
            ->where('exam.vtype', $vtype)
            ->get('exam');
        if ($q->num_rows() > 0){
            return $q->row();
        }
        return [];
    }


    /*************************Student Due Report *****************************/
    public function get_student_due_report($class_id, $section_id = '') {
        $year = get_settings('running_year');
        $this->db->select('student.*, student.name as student_name, parent.name as parent_name, enroll.roll');
        $this->db->from('student');
        $this->db->join('enroll', 'enroll.student_id=student.student_id');
        $this->db->join('parent', 'student.parent_id=parent.parent_id');
//        $this->db->join('tuition_fee_collection','enroll.student_id=tuition_fee_collection.student_id');
        $this->db->where('enroll.year', $year);
        $this->db->where('enroll.class_id', $class_id);
        if ($section_id != '') {
            $this->db->where('enroll.section_id', $section_id);
        }
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }

//    public function get_tuition_fee_byClass($class_id)
//    {
//        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
//        $settings = $this->db->get_where('tuition_fee_settings' , array('class_id' => $class_id, 'year' => $year))->row();
//        return ($settings == null) ? null : $settings->tuition_fee;
//    }
    public function get_tuition_fee_byClass($class_id){
        $year = get_settings('running_year');
        $query = $this->db
            ->where('year', $year)
            ->where('class_id',$class_id)
            ->get('tuition_fee_settings');
        if ($query -> num_rows() > 0) {
            return $query->row();
        }
        return [];
    }


    public function get_studentDue_tk($student_id){
        $year = get_settings('running_year');
        $query = $this->db
            ->where('year', $year)
            ->where('student_id',$student_id)
            ->get('tuition_fee_collection');
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    /************************* Income Report *****************************/
    public function get_income_report($type, $date, $class_id = '', $section_id = '') {
        $year = get_settings('running_year');
        $this->db->select('invoice.invoice_id, invoice.amount_paid, invoice.payment_date, enroll.class_id');
        $this->db->from('invoice');
//        $this->db->join('tuition_fee_collection', 'invoice.payment_type = tuition_fee_collection.payment_type', 'left');
        $this->db->join('enroll', 'enroll.student_id=invoice.student_id');
        $this->db->where("invoice.payment_date", $date);
        $this->db->where('invoice.payment_type', $type);
        $this->db->where('invoice.year', $year);
        $this->db->where('enroll.year', $year);
//        $this->db->where('enroll.class_id', $class_id);
        if ($section_id != '') {
            $this->db->where('enroll.section_id', $section_id);
        }
        if ($class_id != '') {
            $this->db->where('enroll.class_id', $class_id);
        }
        $this->db->group_by('invoice.invoice_id');
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];

    }
    /************************* Expense Report *****************************/
    public function get_expense_report($date, $expense_ct_id ='') {
        $year = get_settings('running_year');
        $this->db->select('payment.*,expense_category.name');
        $this->db->from('payment');
        $this->db->join('expense_category', 'payment.expense_category_id = expense_category.expense_category_id','left');
        $this->db->where('payment.year', $year);
        $this->db->where('payment.income_expense_date', $date);
        $this->db->where('payment.expense_category_id != ', 99999);
        $this->db->where('payment.payment_type', 'expense');
        if ($expense_ct_id != '') {
            $this->db->where('payment.expense_category_id', $expense_ct_id);
        }
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    public function get_expense_category($id){
        $query= $this->db
            ->where('expense_category_id',$id)
            ->get('expense_category');
        return($query->num_rows() > 0)?$query->row() : [];
    }
    public function get_expense_report_by_date($date) {
        $year = get_settings('running_year');
        $this->db->select('payment.*, SUM(amount) AS amount, expense_category.name');
        $this->db->from('payment');
        $this->db->join('expense_category', 'payment.expense_category_id = expense_category.expense_category_id','left');
        $this->db->where('payment.year', $year);
        $this->db->where('payment.expense_category_id != ', 99999);
        $this->db->where('payment.income_expense_date', $date);
        $this->db->where('payment.payment_type', 'expense');
        $this->db->group_by('payment.income_expense_date');
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    public function get_occasional_expense_report($date) {
        $year = get_settings('running_year');
        $this->db->select('payment.*, SUM(amount) AS amount, expense_category.name');
        $this->db->from('payment');
        $this->db->join('expense_category', 'payment.expense_category_id = expense_category.expense_category_id','left');
        $this->db->where('payment.year', $year);
        $this->db->where('payment.income_expense_date', $date);
        $this->db->where('payment.expense_category_id', 99999);
        $this->db->where('payment.payment_type', 'expense');
        $this->db->group_by('payment.income_expense_date');
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }

    /************************* Other Income *****************************/
    public function get_other_income_report($date) {
        $year = get_settings('running_year');
        $this->db->select('payment.*, SUM(payment.amount) AS amount, income_category.name');
        $this->db->from('payment');
        $this->db->join('income_category', 'payment.income_category_id = income_category.income_category_id','left');
        $this->db->join('invoice', 'payment.invoice_id = invoice.invoice_id','left');
        $this->db->where('payment.year', $year);
        $this->db->where('payment.income_expense_date', $date);
        $this->db->where('invoice.payment_type', 11);
        $this->db->group_by('payment.income_expense_date');
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }

    /************************* Tuition Fee Sheet *****************************/
    public function get_tution_feeBy_student_info($class, $section ='', $shift = ''){
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $this->db->select('student.*');
        $this->db->from('student');
        $this->db->join('enroll', 'enroll.student_id = student.student_id');
        $this->db->where('enroll.year', $year);
        $this->db->where('student.vtype', $vtype);
        $this->db->where('enroll.class_id', $class);
        if (!empty($section)){
            $this->db->where('enroll.section_id', $section);
        }
        if (!empty($shift)){
            $this->db->where('student.shift', $shift);
        }
        $query = $this->db->get();
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    public function get_payment_fee($student_id, $payment_type){
        $year = get_settings('running_year');
        $query= $this->db
            ->where('year',$year)
            ->where('student_id',$student_id)
            ->where('payment_type',$payment_type)
            ->get('invoice');
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    public function get_tuition_fee($student_id){
        $year = get_settings('running_year');
        $query= $this->db
            ->select('month, amount')
            ->where('year',$year)
            ->where('student_id',$student_id)
            ->get('tuition_fee_collection');
        if ($query -> num_rows() > 0) {
            return $query->result_array();
        }
        return [];
    }
    public function get_exam_fee($student_id, $exam_id){
        $year = get_settings('running_year');
        $query= $this->db
            ->select('exam_fee_collection.paid_amount')
            ->where('year',$year)
            ->where('student_id',$student_id)
            ->where('exam_id',$exam_id)
            ->order_by('exam_fee_collection.id', 'DESC')
            ->get('exam_fee_collection');
        if ($query -> num_rows() > 0) {
            return $query->row();
        }
        return [];
    }
    public function get_exam_names_byClass() {
        $year = get_settings('running_year');
        $query= $this->db
            ->select('exam.*')
//            ->where('class_id',$class_id)
            ->where('year',$year)
            ->order_by('exam_id', 'DESC')
            ->limit(2)
            ->get('exam');
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    /************************* Progress Report *****************************/
    public function get_grade_point(){
        $vtype = $this->session->userdata('vtype');
        $query= $this->db
            ->order_by('mark_upto','DESC')
            ->get_where('grade', ['vtype', $vtype]);
        if ($query->num_rows() >  0){
            return $query->result();
        }
        return [];
    }
    public function get_all_curriculum($group_id){
        $query= $this->db
            ->where('group_id', $group_id)
            ->get('extra_curriculum_settings');
        if ($query->num_rows() >  0){
            return $query->result();
        }
        return [];
    }
    public function get_enroll($student_id){
        $year = get_settings('running_year');
        $query= $this->db
            ->where('student_id', $student_id)
            ->where('year', $year)
            ->get('enroll');
        if ($query->num_rows() >  0){
            return $query->row();
        }
        return [];
    }
    public function get_progress_subjects_result($exam_id, $sub_id, $student_id){
        $year = get_settings('running_year');
        $query = $this->db->select('mark.*')
            ->from('mark')
            ->join('student', 'mark.student_id=student.student_id')
            ->where('student.student_id', $student_id)
            ->where('mark.subject_id', $sub_id)
            ->where('mark.year', $year)
            ->group_by('subject_id')
            ->where('mark.exam_id', $exam_id)
            ->get();
            if ($query->num_rows() >  0){
            return $query->row();
        }
        return [];
    }

    public function get_grandTotalMarksForResult($exam_id, $student_id){
        $year = get_settings('running_year');
        $query = $this->db->select('SUM(mark.mark_obtained) + SUM(mark.cw_marks) + SUM(mark.hw_marks) AS totalmark, SUM(subject.full_marks) AS fullmark')
            ->from('mark')
            ->join('subject', 'mark.subject_id=subject.subject_id')
            ->where('mark.student_id', $student_id)
            ->where('mark.year', $year)
            ->group_by( 'mark.student_id')
            ->where('mark.exam_id', $exam_id)
            ->get();
        if ($query->num_rows() >  0) {
            return $query->row();
        }
        return [];
    }

    public function check_all_subject_pass($exam_id, $student_id, $opt_sub_id=0) {
        $year = get_settings('running_year');
        $query = $this->db->select('subject.subject_id AS sub_id, (mark.mark_obtained + mark.cw_marks + mark.hw_marks) AS totalmarks, subject.full_marks, subject.pass_marks')
            ->from('mark')
            ->join('subject', 'mark.subject_id=subject.subject_id')
            ->where('mark.student_id', $student_id)
            ->where('mark.year', $year)
            ->where('mark.exam_id', $exam_id)
            ->get();
        $grand_total_full_marks = 0;
        $grand_obtained_marks = 0;
        $grand_total_grade = 0;
        $subject_count = 0;
        $pass_status = 1;
        if ($query->num_rows() > 0) {
//            dd($query->result());
            foreach ($query->result() as $row)
            {
                $each_mark = ($row->totalmarks>99) ? 100 : $row->totalmarks;
                $each_mark = (($each_mark<0) || ($each_mark==NULL)) ? 0 : $each_mark;
                $grand_obtained_marks += $each_mark;
                $grand_total_full_marks += $row->full_marks;
                if ($row->full_marks==50)
                {
                    $grade = $this->get_grade_point_Mark(($each_mark*2));
                }else{
                    $grade = $this->get_grade_point_Mark($each_mark);
                }
                if (($row->sub_id==$opt_sub_id) && ($grade->grade_point>2))
                {
                    $grand_total_grade += ($grade->grade_point-2);
                }else{
                    $subject_count++;
                    $grand_total_grade += $grade->grade_point;
                    if ($row->totalmarks<$row->pass_marks){
                        $pass_status = 0;
                    }
                }
            }
//            echo $grand_total_grade . '-' . $subject_count . ' - '. ($grand_total_grade/$subject_count); exit;
            return array(
                'all_full_marks' => $grand_total_full_marks,
                'all_obtained_marks' => $grand_obtained_marks,
                'all_grade_point' => round(($grand_total_grade/$subject_count), 2),
                'all_grade_name' => $this->get_gradeName_byPoint(($grand_total_grade/$subject_count)),
                'pass_status' => $pass_status,
            );
        }
        return array(
            'all_full_marks' => $grand_total_full_marks,
            'all_obtained_marks' => $grand_obtained_marks,
            'all_grade_point' => $grand_total_grade,
            'all_grade_name' => 'F',
            'pass_status' => $pass_status,
        );

    }
    public function get_gradeName_byPoint($point)
    {
        $vtype = $this->session->userdata('vtype');
        $point = floor($point);
        $point = ($point>5) ? 5 : floor($point);
        $point = ($point<0) ? 0 : $point;
        $qg =$this->db->select('name')
            ->from('grade')
            ->where('grade_point', $point)
            ->where('vtype',  $vtype)
            ->get();
//        echo $this->db->last_query();
        $grade = $qg->row();
//        dd($grade);
        return ($grade) ? $grade->name : null;
    }
    public function get_totalFullMarksForResult($exam_id, $student_id){
        $year = get_settings('running_year');
        $query = $this->db->select('SUM(full_marks) AS fullmark')
            ->from('subject')
            ->where('year', $year)
            ->group_by( 'student_id')
            ->where('exam_id', $exam_id)
            ->get();
        if ($query->num_rows() >  0){
            return $query->row();
        }
        return [];
    }
    public function get_progress_height_marks($class_id, $exam_id, $sub_id) {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $query = $this->db->select('(mark.mark_obtained + mark.cw_marks + mark.hw_marks) AS total_mark')
            ->from('mark')
            ->where('mark.subject_id', $sub_id)
            ->where('mark.year', $year)
            ->where('mark.class_id', $class_id)
            ->where('mark.exam_id', $exam_id)
            ->where('mark.vtype', $vtype)
            ->group_by('student_id')
            ->order_by('total_mark', 'DESC')
            ->get();
        if ($query->num_rows() >  0) {
            $data = array();
            foreach ($query->result() as $row)
            {
                $data[] = $row->total_mark;
            }
            return max($data);
        }
        return null;
    }

    /*************************************GET STUDENT MERIT POSITION************************************/
    public function getMeritPosition_forResultCard($exam_id, $class_id, $student_id, $section_id = null)
    {
        $passed = array();
        $failed = array();
        $subjects   = $this->get_all_subject_byClassId($class_id);
        if ($section_id==null) {
            $students = $this->get_tabulation_student($class_id);
        }else{
            $students = $this->get_tabulation_student_bySection($class_id, $section_id);
        }
        foreach ($students as $student):
            $total_marks = 0;
            $is_failed = 0;
            foreach ($subjects as $sub):
                $mark   = get_tabulation_mark($exam_id, $student->student_id, $sub->subject_id);
                if (!empty($mark)) {
                    $totalMark = ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks);
                    $totalMark = ($totalMark>100) ? 100 : $totalMark;
                    $grade  = get_grade_point_Mark($totalMark);
                    if ($grade->grade_point == 0) {
                        $total_marks += $totalMark;
                        $is_failed = 1;
                    }else{
                        $total_marks += $totalMark;
                    }
                }elseif($sub->subject_id != $student->opt_sub_id) {
                    $is_failed = 1;
                }
            endforeach;
            if ($is_failed == 0)
            {
                $passed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }else{
                $failed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }
            /***************************** OPTIONAL ********************************/

        endforeach;


        usort($passed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });
        usort($failed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });

        $key = array_search($student_id, array_column($passed, 'std_id'));
        if ($key != false || is_int($key))
        {
            return $key+1;
        }else{
            $tt_pass = count($passed);
            $key = array_search($student_id, array_column($failed, 'std_id'));
            if ($key != false || is_int($key))
                return ($tt_pass+$key+1);
            else
                return null;
        }
    }
    public function getClassWiseHeightMarksList($exam_id, $class_id, $section_id = null)
    {
        $marks = array();
        $subjects   = $this->get_all_subject_byClassId($class_id);
        if ($section_id==null) {
            $students = $this->get_tabulation_student($class_id);
        }else{
            $students = $this->get_tabulation_student_bySection($class_id, $section_id);
        }
        foreach ($students as $student):
            $total_marks = 0;
            foreach ($subjects as $sub):
                $mark   = get_tabulation_mark($exam_id, $student->student_id, $sub->subject_id);
                if (!empty($mark)) {
                    $totalMark = ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks);
                    $totalMark = ($totalMark>100) ? 100 : $totalMark;
                    $totalMark = ($totalMark<0) ? 0 : $totalMark;
                    $total_marks += $totalMark;
                }
            endforeach;
            $marks[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
        endforeach;

        usort($marks, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });
        /*
        $key = array_search($student_id, array_column($passed, 'std_id'));
        if ($key != false || is_int($key))
        {
            return $key+1;
        }else{
            return null;
        }
        */
        return $marks;
    }

    /*************************************GET STUDENT MERIT POSITION************************************/
    public function getMeritPosition_forAnnualExam_resultCard($exam_id1, $exam_id2, $class_id, $student_id, $section_id = null)
    {
        $passed = array();
        $failed = array();

        $subjects   = $this->get_all_subject_byClassId($class_id);
        if ($section_id==null) {
            $students = $this->get_tabulation_student($class_id);
        }else{
            $students = $this->get_tabulation_student_bySection($class_id, $section_id);
        }

        foreach ($students as $student):

            $total_marks = 0;
            $is_failed = 0;
            foreach ($subjects as $sub):
                $mark1   = get_tabulation_mark($exam_id1, $student->student_id, $sub->subject_id);
                $mark2   = get_tabulation_mark($exam_id2, $student->student_id, $sub->subject_id);
                if (!empty($mark1)) {
                    $totalMark = ($mark1->mark_obtained+$mark1->cw_marks+$mark1->hw_marks);
                    $totalMark = ($totalMark>99) ? 100 : $totalMark;
                    $grade  = get_grade_point_Mark($totalMark);
                    if ($grade->grade_point == 0) {
                        $total_marks += ($totalMark*0.4);
                        $is_failed = 1;
                    }else{
                        $total_marks += ($totalMark*0.4);
                    }
                }else{
                    $is_failed = 1;
                }
                if (!empty($mark2)) {
                    $subMark = ($mark2->mark_obtained+$mark2->cw_marks+$mark2->hw_marks+$mark2->h_writing_marks+$mark2->ct_marks);
                    $grade2  = get_grade_point_Mark($subMark);
                    if ($grade2->grade_point == 0) {
                        $total_marks += ($subMark * 0.6);
                        $is_failed = 1;
                    }else{
                        $total_marks += ($subMark * 0.6);
                    }
                }else{
                    $is_failed = 1;
                }
            endforeach;

            if ($is_failed == 0)
            {
                $passed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }else{
                $failed[] = array('std_id' => $student->student_id, 'marks' => $total_marks);
            }
            /***************************** OPTIONAL ********************************/

        endforeach;


        usort($passed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });
        usort($failed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });


        $key = array_search($student_id, array_column($passed, 'std_id'));
        if ($key != false || is_int($key))
        {
            return $key+1;
        }else{
            $tt_pass = count($passed);
            $key = array_search($student_id, array_column($failed, 'std_id'));
            if ($key != false || is_int($key))
                return ($tt_pass+$key+1);
            else
                return null;
        }
    }
    public function get_exam_names_progress() {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $query= $this->db
            ->select('exam.exam_id,exam.name')
//            ->where('class_id',$class_id)
            ->where('year',$year)
            ->where('vtype',$vtype)
            ->limit(2)
            ->get('exam');
        if ($query -> num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
    public function get_singleStudentAttendance($exam_id, $class_id, $student_id, $type=1)
    {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
//        var_dump($exam_id); exit();
        $examDate = $this->db->get_where('exam', ['exam_id'=>$exam_id, 'vtype'=>$vtype, 'year' => $year])->row();
        if(empty($examDate)){
            return null;
        }
        $date = $examDate->exam_end_date;

        $this->db->select('attendance.status,');
        $this->db->from('attendance');
        $this->db->where('class_id',$class_id);
        $this->db->where('status',1);
        $this->db->where('year',$year);
        $this->db->where('student_id', $student_id);
        if($type==1):
            $this->db->where('timestamp <=',$date);
        else:
            $this->db->where('timestamp >',$date);
        endif;
        //$this->db->group_by('timestamp');
        return $this->db->count_all_results();
        //echo $this->db->last_query(); exit();

    }
    public function get_total_attendance($exam_id, $class_id, $type=1)
    {
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $examDate = $this->db->get_where('exam', ['exam_id'=>$exam_id, 'vtype'=>$vtype, 'year' => $year])->row();
        if(empty($examDate)){
            return null;
        }
        $date = $examDate->exam_end_date;

        $this->db->select('attendance.status');
        $this->db->from('attendance');
        $this->db->where('class_id',$class_id);
//        $this->db->where('status',1);
        $this->db->where('year',$year);
        if($type==1):
            $this->db->where('timestamp <=',$date);
        else:
            $this->db->where('timestamp >',$date);
        endif;
        $this->db->group_by('timestamp');
        return $this->db->count_all_results();
        //echo $this->db->last_query(); exit();

    }
    public function get_curriculum_grade($student_id, $setting_id){
        $year = get_settings('running_year');
        $query = $this->db
            ->where('student_id', $student_id)
            ->where('setting_id', $setting_id)
            ->where('year', $year)
            ->get('extra_curriculum_grade');
        return($query->num_rows() > 0)?$query->row() : [];
    }
    /*************************Employee salary sheet *****************************/
    public function get_employee (){
        $query = $this->db->get('teacher');
        return($query->num_rows() > 0)?$query->result() : [];
    }
    public function get_working_days($month, $year){
        $data = $this->db->select('working_day')->get_where('working_days', array('month' => $month, 'year' => $year))->row();
        return $data->working_day;
    }
    public function get_present_days($employee_id, $month, $year, $number){
        $from = $year.'-'.$month.'-01';
        $to   = $year.'-'.$month.'-'.$number;
        $this->db->from('employee_attendance')
            ->where('working_date >=', $from)
            ->where('working_date <=', $to)
            ->where('emp_id',$employee_id)->where('status',1);
        return $this->db->count_all_results();
    }
    public function get_employeeLeaveDaysByMonth($emp_id, $month, $year)
    {
        $session = get_settings('running_year');
        $data = $this->db->select('SUM(leavecount) as tt_leave')->where('month_id', $month)
                ->where('year_id', $year)->where('year', $session)
                ->where('employee_id', $emp_id)->group_by('month_id')->get('leave_apply_form')->row();
        return ($data==null) ? 0 : $data->tt_leave;
    }
    public function get_signature(){
        $query = $this->db
            ->order_by('id', 'DECS')
            ->limit(5)
            ->get('designation');
        return($query->num_rows() > 0)?$query->result() : [];
    }


    /***************************Attendance Late Mark Count***************08/11/2018****By::Jobayeer*******/
    public function employeeAttendanceLateMark_count($employee_id, $month, $year, $number)
    {
        $year2 = get_settings('running_year');
        $start = get_settings('start_time');
        $max_time = get_settings('max_late_time');
        $max_late_time = date("H:i:s", strtotime("+".$max_time." minutes", strtotime($start)));
        $from = $year.'-'.$month.'-01';
        $to   = $year.'-'.$month.'-'.$number;
        $data = $this->db->select('start_time')
            ->where('working_date >=', $from)
            ->where('working_date <=', $to)
            ->where('year', $year2)
            ->where('emp_id',$employee_id)->where('status',1)
            ->get('employee_attendance')->result();
        $late_count = 0;
        foreach ($data as $row)
        {
            if (strtotime($row->start_time)>strtotime($max_late_time))
                $late_count++;
        }
//        echo ($late_count/3).'<br>';
//        echo floor($late_count/3); exit;
        return floor($late_count/3);
    }

    public function employeeAdvanceSalary($employee_id, $month, $year)
    {
        $year2 = get_settings('running_year');
        $data = $this->db->select('advance')
            ->where('month_id', $month)
            ->where('year_id', $year)
            ->where('year', $year2)
            ->where('emp_id',$employee_id)
            ->get('advance_salary')->row();
        return (empty($data)) ? 0 : $data->advance;
    }
    public function check_payment_status($std_id, $sec_id, $course_type)
    {
        $total_pay = 0; $total_discount = 0; $due = null;
        $year = get_settings('running_year');
        $vtype = $this->session->userdata('vtype');
        $settings = $this->db->get_where('tuition_fee_settings' , array('section_id' => $sec_id, 'year' => $year))->row();
        $where = array('student_id' => $std_id, 'section_id' => $sec_id, 'year' => $year);
        $pay = $this->db->get_where('tuition_fee_collection' , $where)->result();
        if ($course_type==1) {         //Monthly Fee
            $tuition_fee = ($settings == null) ? 0 : $settings->tuition_fee;
            $admissionDate = getStudentAdmissionDate($std_id);
            if ($admissionDate) {
                $d1 = new DateTime($admissionDate);
                $d2 = new DateTime(date('Y-m-d'));
                $use_month = $d1->diff($d2)->m;
                for ($i = 1; $i <= 36; $i++) {
                    foreach ($pay as $value) {
                        if ($i == $value->month) {
                            $total_pay += $value->amount;
                            $total_discount += $value->discount;
                        }
                    }
                }
                $due = ($tuition_fee * $use_month) - ($total_pay + $total_discount);
            }else{
                return false;
            }
        }elseif($course_type==2) {       //Contractual Course
            $tuition_fee = ($settings == null) ? 0 : $settings->course_fee;
            foreach ($pay as $value) {
                $total_pay += $value->amount;
                $total_discount += $value->discount;
            }
            $due = $tuition_fee - ($total_discount + $total_pay);
        }
        if ($due<1){
            return true;
        } else {
//            return false;
            return $due;
        }
    }// End of the function..

    public function result_for_sms($exam_id, $subject_id, $class_id, $student_id, $section_id)
    {
        $passed = array();
        $students = $this->get_tabulation_student_bySection($class_id, $section_id);
        $total = count($students);
        foreach ($students as $student):
            $mark = get_tabulation_mark($exam_id, $student->student_id, $subject_id);
            if (!empty($mark)) {
                $totalMark = ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks);
                $totalMark = ($totalMark>100) ? 100 : $totalMark;
                $passed[] = array('std_id' => $student->student_id, 'marks' => $totalMark);
            }else{
                $passed[] = array('std_id' => $student->student_id, 'marks' => 0);
            }
        endforeach;
        usort($passed, function($a, $b) {
            return $b['marks'] - $a['marks'];
        });
        $key = array_search($student_id, array_column($passed, 'std_id'));
        if ($key != false || is_int($key))
        {
            $position = $key+1;
            $obtained_mark = $passed[$key]['marks'];
        } else {
            $position      = null;
            $obtained_mark = null;
        }
        return array('obtained_mark' => $obtained_mark, 'position' => $position, 'total' => $total);
    }

    function getBatchStartTime($student_id)
    {
        $year = get_settings('running_year');
        $enroll = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $year))->first_row();
        $text_time = '';
        if ($enroll)
        {
            $sections = $enroll->sections;
            $sec_slice = explode(',', trim($sections, ','));
            foreach ($sec_slice as $batch_id)
            {
                $section = $this->db->get_where('section', array('section_id' => $batch_id))->first_row();
                $text_time .= ($section && ($section->start_time != null)) ? $section->name.': '.$section->start_time.'\n' : '';
            }
        }
        return $text_time;
    }
    function getGuestStudentData($class, $section, $from_date, $to_date)
    {
        $this->db->where('class_id', $class);
        $this->db->where('section_id', $section);
        if ($from_date && $to_date)
        {
            $this->db->where('attn_date >=', $from_date);
            $this->db->where('attn_date <=', $to_date);
        }
        $this->db->order_by('attn_date', 'asc');
        return $this->db->get('student_temp')->result();
    }

}