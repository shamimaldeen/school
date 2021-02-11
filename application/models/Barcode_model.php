<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

	/*	
	   *	Developed by: DBCinfotech
       *	Date	: 20 November, 2015
       *	Bizpro Stock Manager ERP
       *	http://codecanyon.net/user/dbcinfotech
    */

class Barcode_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// DECLARATION: CREATES BARCODE OF A PARTICULAR PRODUCT USING SERIAL NUMBER OF THE PRODUCT
	function create_barcode($serial_number)
	{
		// side effect: includes the font file for barcodes
		require_once('assets/barcode/class/BCGFontFile.php');

		// side effect: includes the color classes for barcodes
		require_once('assets/barcode/class/BCGColor.php');

		// side effect: includes the drawing classes for barcodes
		require_once('assets/barcode/class/BCGDrawing.php');

		// side effect: includes the barcode technology
		require_once('assets/barcode/class/BCGcode39.barcode.php');
		
		// Loading Font
		$font          = new BCGFontFile('assets/barcode/font/Arial.ttf', 18);
		// Don't forget to sanitize user inputs
		$text          = $serial_number;
		// The arguments are R, G, B for color.
		$color_black   = new BCGColor(0, 0, 0);
		$color_white   = new BCGColor(255, 255, 255);
		$drawException = null;
		try {
			$code = new BCGcode39();
			$code->setScale(2); // Resolution
			$code->setThickness(30); // Thickness
			$code->setForegroundColor($color_black); // Color of bars
			$code->setBackgroundColor($color_white); // Color of spaces
			$code->setFont($font); // Font (or 0)
			$code->parse($text); // Text
            $code->clearLabels();
		}
		catch (Exception $exception) {
			$drawException = $exception;
		}
		/* Here is the list of the arguments
		1 - Filename (empty : display on screen)
		2 - Background color */
		$drawing = new BCGDrawing('', $color_white);
		if ($drawException) {
			$drawing->drawException($drawException);
		} else {
			$drawing->setBarcode($code);
			$drawing->draw();
		}
		// Header that says it is an image (remove it if you save the barcode to a file)
		header('Content-Type: image/png');
		header('Content-Disposition: inline; filename="barcode.png"');
		// Draw (or save) the image into PNG format.
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}

	/*************************************************** Rasel hossain Cord Stard ************************************/

	/************************ Student Search **********************/
	public function student_search($search_key){
//        $student_identifier = $this->input->post('student_identifier');
        $query  = $this->db
            ->select('student.*')
//            ->join('enroll', 'enroll.student_id=student.student_id')
            ->like('student.name', $search_key, 'both')
            ->or_where('student.student_code', $search_key )
            ->get('student');
            if ($query-> num_rows() > 0){
                return $query->result();
            }
            return[];
    }

    public function get_search_student($student_search_key){
        $year = get_settings('running_year');
        $query  = $this->db
            ->select('student.*,student.name as std_name, student.phone as student_phone, parent.*, parent.phone as parent_phone, parent.name as parent_name, enroll.roll, enroll.sections, class.name as class_name,class.class_id as class_id')
            ->where('year', $year)
            ->join('parent', 'student.parent_id=parent.parent_id')
            ->join('enroll', 'enroll.student_id=student.student_id')
            ->join('class', 'enroll.class_id=class.class_id')
            ->like('student.name', $student_search_key, 'both')
            ->or_where('student.student_code', $student_search_key )
            ->get('student');
        if ($query-> num_rows() > 0){
            return $query->row();
        }
        return[];
    }
    public function get_parentBy_student($parent_id){
        $query  = $this->db
            ->select('student.parent_id')
            ->where('parent_id', $parent_id )
            ->get('student');
        if ($query-> num_rows() > 0){
            return $query->row_array();
        }
        return[];
    }
    public function get_exam_fees($student_id){
        $year = get_settings('running_year');
        $query  = $this->db
                ->where('year', $year)
                ->where('payment_type',1)
                ->where('student_id',$student_id)
                ->get('invoice');
        if ($query-> num_rows() > 0){
            return $query->result();
        }
        return[];
    }
    public function get_all_schoolingDay($class_id, $student_id, $section_id){
        $data = array('year' => get_settings('running_year'), 'student_id' => $student_id, 'section_id' => $section_id);
        $this->db
            ->where($data)
//            ->where('status',1)
//            ->group_by('class_id')
            ->get('attendance');
        return $this->db->count_all_results();
    }
    public function get_all_studentDay($student_id, $class_id, $section_id){
        $data = array('year' => get_settings('running_year'), 'class_id', $class_id, 'section_id' => $section_id, 'status' => 1, 'student_id' => $student_id);
        $this->db
            ->where($data)
            ->select('*')
            ->from('attendance');
        return $this->db->count_all_results();
    }

    public function check_working_day($month, $year) {
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('working_days');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function entry_working_day($entry_working_day_data = array()) {
        $insert_success = $this->db->insert('working_days', $entry_working_day_data);
        //echo $this->db->last_query();die();
        if ($insert_success) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function get_studentSingleInvoiceData($inv_id, $payment_type)
    {
        $data = $this->db->from('invoice')
                ->where('root_id', $inv_id)
                ->where('payment_type', $payment_type)
                ->get();
        if ($payment_type==2)
        {
            return $data->result();
        }else {
            return $data->row();
        }
    }

    public function get_rootInvoiceInfo($root_id)
    {
        $data = $this->db->from('student_payment_invoices')
            ->where('id', $root_id)
            ->get();
        return $data->row();
    }

    public function get_examInfo_byInvoiceId($invoice_id){
	    return $this->db->from('exam_fee_collection')->select('exam_id')->where('invoice_id', $invoice_id)->get()->row();
    }

    public function get_student_enrolled_section_edit($std_id, $selected_section = array())
    {
        $year = get_settings('running_year');
        $enroll = $this->db->get_where('enroll' , array( 'student_id' => $std_id , 'year' => $year) )->row();
        $section_array = explode(',', trim($enroll->sections, ','));
        $sections = $this->db->where_in('section_id', $section_array)->get('section')->result();
        $html = '<label class="col-sm-3 control-label">Section</label>
                    <div class="col-sm-9">
                        <select name="section_id" class="form-control" id="section_id" onchange="return getTuitionFeeViewData(this.value);" required=""><option value="">--Please Select Section--</option>';
        foreach ($sections as $sec)
        {
            $html .= '<option value="'.$sec->section_id.'" '.(($sec->section_id == $selected_section) ? 'selected':'').'>'.$sec->name.'</option>';
        }
        $html .= '</select></div><div class="clar"></div>';
        return $html;
    }

    public function search_student_payment_status_for_update($std_id, $invoice_id, $section_id, $type)     //AJAX FUNCTION
    {
        $year = get_settings('running_year');
        $class = $this->db->get_where('enroll' , array( 'student_id' => $std_id , 'year' => $year) )->row();
        $class_id = $class->class_id;
        $settings = $this->db->get_where('tuition_fee_settings' , array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $year))->row();
        $tuition_fee = ($settings == null) ? null : ($type==2) ? $settings->course_fee : $settings->tuition_fee;
        $where =  array('student_id' => $std_id, 'year' => $year, 'section_id' => $section_id, 'invoice_id !=' => $invoice_id);
        $payments = $this->db->get_where('tuition_fee_collection', $where)->result();
//        dd($settings);
//        echo $this->db->last_query(); exit;
        $total_paid = 0;
        $total_discount = 0;
        foreach ($payments as $pay) {
            $total_paid += $pay->amount;
            $total_discount += $pay->discount;
        }
        $paid = 0;
        $data = "";
        if ($tuition_fee == null)
        {
            $data = "<h4 style='color: red; padding-left: 20px;'>Please set tuition fee for the section/batch</h4>";
        }else{
            if ($type==2)
            {
                $due = ($tuition_fee) - ($total_discount+$total_paid);
                $data .= '<h4 style="padding-left: 20px;">Your Due: '.number_format($due, 2).'</h4>';
            }else{
                $use_month = (date('m')-1);
                $due = ($tuition_fee*$use_month) - ($total_discount+$total_paid);
                $data .= '<h4 style="padding-left: 20px;">Your Due: '.number_format($due, 2).'</h4>';
            }
        }
        return $data;
    }

}

/* End of file Barcode_model.php */
/* Location: ./application/models/Barcode_model.php */

