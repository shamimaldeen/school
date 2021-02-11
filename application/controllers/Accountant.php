<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author 	: Creativeitem
 *	date		: 14 september, 2017
 *	Ekattor School Management System Pro
 *	http://codecanyon.net/user/Creativeitem
 *	http://support.creativeitem.com
 */

class Accountant extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->model(array('Ajaxdataload_model' => 'ajaxload'));
        $this->load->model('Barcode_model');

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default functin, redirects to login page if no accountant logged in yet***/
    public function index()
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('accountant_login') == 1)
            redirect(site_url('accountant/dashboard'), 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('accountant_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $paid_tuition   = ($this->input->post('amount_paid_tuition')==null) ? 0 : $this->input->post('amount_paid_tuition');
        $paid_exam      = ($this->input->post('amount_paid_exam')==null) ? 0 : $this->input->post('amount_paid_exam');
        $paid_session   = ($this->input->post('amount_paid_session')==null) ? 0 : $this->input->post('amount_paid_session');
        $paid_transport = ($this->input->post('amount_paid_transport')==null) ? 0 : $this->input->post('amount_paid_transport');
        $paid_dress     = ($this->input->post('amount_paid_dress')==null) ? 0 : $this->input->post('amount_paid_dress');
        $paid_others    = ($this->input->post('amount_paid_others')==null) ? 0 : $this->input->post('amount_paid_others');

        /****************************** Discount **************************/

        $discount_tuition    = ($this->input->post('discount_tuition')==null) ? 0 : $this->input->post('discount_tuition');
        $discount_exam       = ($this->input->post('discount_exam')==null) ? 0 : $this->input->post('discount_exam');
        $discount_session    = ($this->input->post('discount_session')==null) ? 0 : $this->input->post('discount_session');
        $discount_transport  = ($this->input->post('discount_transport')==null) ? 0 : $this->input->post('discount_transport');
        $discount_dress      = ($this->input->post('discount_dress')==null) ? 0 : $this->input->post('discount_dress');
        $discount_others     = ($this->input->post('discount_others')==null) ? 0 : $this->input->post('discount_others');

        if(($param1 == 'create') && ( !empty($paid_tuition) || !empty($paid_exam) || !empty($paid_session) || !empty($paid_transport) || !empty($paid_dress) || !empty($paid_others))){

            $this->db->trans_start();
            $student_id     = $this->input->post('student_id');
            $class_id       = $this->input->post('class_id');
            $title          = $this->input->post('title');
            $description    = $this->input->post('description');
            $method         = $this->input->post('method');
            $date           = $this->input->post('date');
            $invoiceNo = $this->getStudentPaymentInvoiceNo(6, 1);

            $data['invoice_no']     = $invoiceNo;
            $data['student_id']     = $student_id;
            $data['class_id']       = $class_id;
            $data['grand_total']    = $paid_tuition + $paid_exam + $paid_session + $paid_transport + $paid_dress + $paid_others;
            $data['title']          = $title;
            $data['description']    = $description;
            $data['payment_method'] = $method;
            $data['user_info']      = $this->session->userdata('login_type').','.$this->session->userdata('login_user_id');
            $data['invoice_date']   = date('Y-m-d', strtotime($date));
            $data['year']           = $year;
            $this->db->insert('student_payment_invoices', $data);
            $root_id = $this->db->insert_id();


            $month_tui  = $this->input->post('month');
            if (!empty($paid_tuition) && $month_tui != null) {
                $settings       = $this->db->get_where('tuition_fee_settings' , array('class_id' => $class_id, 'year' => $year))->row();
                $tuition_fee    = ($settings == null) ? null : $settings->tuition_fee;
                $discount       = (int) $discount_tuition;
                $ttm = count($month_tui);
                $amount = ($ttm*$tuition_fee);
                if($tuition_fee==null)
                {
                    $this->session->set_flashdata('error_message' , get_phrase('please_set_tuition_fee_for_the_class!'));
                }else {
                    $data2['root_id'] = $root_id;
                    $data2['student_id'] = $student_id;
                    $data2['title'] = "Tuition Fee";
                    $data2['amount'] = $amount;
                    $data2['amount_paid'] = $paid_tuition;
                    $data2['due'] = (($amount - ($paid_tuition + $discount_tuition))>0) ? ($amount - ($paid_tuition + $discount_tuition)) : 0;
                    $data2['discount'] = $discount;
                    $data2['payment_type'] = 2;
                    $data2['payment_date'] = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year'] = $year;
                    if ($description != null) {
                        $data2['description'] = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();
                    $data3['invoice_id'] = $invoice_id;
                    $data3['student_id'] = $student_id;
                    $data3['title'] = "Tuition Fee";
                    $data3['payment_type'] = 'income';
                    $data3['method'] = $method;
                    $data3['amount'] = $paid_tuition;
                    $data3['timestamp'] = strtotime($date);
                    $data3['year'] = $year;
                    if ($description != null) {
                        $data3['description'] = $description;
                    }
                    $this->db->insert('payment', $data3);

                    /****************@MonthWisePaymentDataStore@************ */
                    $oneMonthPayment = $data2['amount_paid'] / $ttm;
                    $singleDiscount = ($discount > 0) ? $discount / $ttm : 0;
                    $fee = array(
                        'invoice_id' => $invoice_id,
                        'student_id' => $student_id,
                        'amount' => $oneMonthPayment,
                        'discount' => $singleDiscount,
                        'year' => $year,
                    );
                    foreach ($month_tui as $m) {
                        $fee['month'] = $m;
                        $this->db->insert('tuition_fee_collection', $fee);
                    }
                }

            }

            /************************************* Exam fee ********************************/
            if (!empty($paid_exam)) {
                $data2 = array();
                $exam_id = $this->input->post('exam_id');
                $amount                      = $this->input->post('exam_fee');
                $data2['root_id']            = $root_id;
                $data2['student_id']         = $student_id;
                $data2['title']              = "Exam Fee";
                $data2['amount']             = $amount;
                $data2['amount_paid']        = $paid_exam;
                $data2['due']                = (($amount - ($paid_exam + $discount_exam))>0) ? ($amount - ($paid_exam + $discount_exam)) : 0;
                $data2['discount']           = $discount_exam;
                $data2['payment_type']       = 1;
                $data2['payment_date']       = date('Y-m-d', strtotime($date));
                $data2['creation_timestamp'] = strtotime($date);
                $data2['year']               = $year;
                if ($description != null) {
                    $data2['description']    = $description;
                }
                $this->db->insert('invoice', $data2);
                $invoice_id = $this->db->insert_id();
                $data3 = array();
                $data3['invoice_id']        =   $invoice_id;
                $data3['student_id']        =   $student_id;
                $data3['title']             =   "Exam Fee";
                $data3['payment_type']      =  'income';
                $data3['method']            =   $method;
                $data3['amount']            =   $paid_exam;
                $data3['timestamp']         =   strtotime($date);
                $data3['year']              =   $year;
                if ($description != null) {
                    $data3['description']    = null;
                }
                $this->db->insert('payment' , $data3);
                $examSett = $this->db->select('ef_id')->where('exam_id', $exam_id)->where('class_id', $class_id)->where('year', $year)->get('exam_fees')->row();
                $ef_id = (empty($examSett)) ? 0 : $examSett->ef_id;
                $data4 = array(
                    'exam_id'     => $exam_id,
                    'ef_id'       => $ef_id,
                    'invoice_id'  => $invoice_id,
                    'student_id'  => $student_id,
                    'class_id'    => $class_id,
                    'paid_amount' =>  $data3['amount'],
                    'year'        => $year,
                );
                $this->db->insert('exam_fee_collection', $data4);
            }
            /****************Create invoice session fee by Rasel*************/
            if (!empty($paid_session)) {
                $data2 = array();
                $discount                    = (int)$discount_session;
                $data2['root_id']            = $root_id;
                $data2['student_id']         = $student_id;
                $data2['title']              = "Session Fee";
                $data2['amount']             = $this->input->post('session_fee');
                $data2['amount_paid']        = $paid_session;
                $data2['due']                = (($data2['amount'] - ($paid_session + $discount_session))>0) ? ($data2['amount'] - ($paid_session + $discount_session)) : 0;
                $data2['discount']           = $discount;
                $data2['payment_type']       = 9;
                $data2['payment_date']       = date('Y-m-d', strtotime($date));
                $data2['creation_timestamp'] = strtotime($date);
                $data2['year']               = $year;
                if ($description != null) {
                    $data2['description']    = $description;
                }
                $this->db->insert('invoice', $data2);
                $invoice_id = $this->db->insert_id();
                $data3 = array();
                $data3['invoice_id']        =   $invoice_id;
                $data3['student_id']        =   $student_id;
                $data3['title']             =   "Session Fee";
                $data3['payment_type']      =  'income';
                $data3['method']            =   $method;
                $data3['amount']            =   $paid_session;
                $data3['timestamp']         =   strtotime($date);
                $data3['year']              =   $year;
                if ($description != null) {
                    $data3['description'] = $description;
                }
                $this->db->insert('payment' , $data3);
            }

            /****************Update invoice dress/batch fee by Rasel*************/
            if (!empty($paid_dress)) {
                $data2 = array();
                $discount                    = (int)$discount_dress;
                $data2['root_id']            = $root_id;
                $data2['student_id']         = $student_id;
                $data2['title']              = "Dress Fee";
                $data2['amount']             = $this->input->post('dress_fee');
                $data2['amount_paid']        = $paid_dress;
                $data2['due']                = (($data2['amount'] - ($paid_dress + $discount_dress))>0) ? ($data2['amount'] - ($paid_dress + $discount_dress)) : 0;
                $data2['discount']           = $discount;
                $data2['payment_type']       = 10;
                $data2['payment_date']       = date('Y-m-d', strtotime($date));
                $data2['creation_timestamp'] = strtotime($date);
                $data2['year']               = $year;
                if ($description != null) {
                    $data2['description']    = $description;
                }
                $this->db->insert('invoice', $data2);
                $invoice_id = $this->db->insert_id();
                $data3 = array();
                $data3['invoice_id']        =   $invoice_id;
                $data3['student_id']        =   $student_id;
                $data3['title']             =   "Dress Fee";
                $data3['payment_type']      =  'income';
                $data3['method']            =   $method;
                $data3['amount']            =   $paid_dress;
                $data3['timestamp']         =   strtotime($date);
                $data3['year']              =   $year;
                if ($description != null) {
                    $data3['description']    = $description;
                }
                $this->db->insert('payment' , $data3);
                $data4 = array();
                $data4['invoice_id']        =   $invoice_id;
                $data4['student_id']        =   $student_id;
                $data4['amount']            =   $paid_dress;
                $data4['payment_type']      =   $this->input->post('dress_id');
                $data4['discount']          =   $discount;
                $data4['year']              =   $year;
                $this->db->insert('dress_fee_collection' , $data4);
            }
            /****************Create invoice others fee by rasel*************/
            if (!empty($paid_others)) {
                $invoice_fee = $this->input->post('invoice_fee');
                $amount_paid = $paid_others;
                $discount    = (int)$discount_others;
                if (($invoice_fee >= $amount_paid) && ($amount_paid >= $discount)) {
                    $data2 = array();
                    $others_type = $this->input->post('others_name');
                    $others_title= '';
                    if($others_type == 4) {
                        $others_title ='Books Fee';
                    }
                    elseif($others_type == 5){
                        $others_title ='Copies Fee';
                    }
                    elseif($others_type == 6){
                        $others_title ='Stationery\'s Fee';
                    }
                    else {
                        $others_title ='Others/Remarks';
                    }
                    $data2['root_id']            = $root_id;
                    $data2['student_id']         = $student_id;
                    $data2['title']              = $others_title;
                    $data2['amount']             = $invoice_fee;
                    $data2['amount_paid']        = $paid_dress;
                    $data2['due']                = (($invoice_fee - ($paid_others + $discount_others))>0) ? ($invoice_fee - ($paid_others + $discount_others)) : 0;
                    $data2['discount']           = $discount;
                    $data2['payment_type']       = $others_type;
                    $data2['payment_date']       = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year']               = $year;
                    if ($description != null) {
                        $data2['description']    = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();

                    $data3 = array();
                    $data3['invoice_id']        =   $invoice_id;
                    $data3['student_id']        =   $student_id;
                    $data3['title']             =   "Others Fee";
                    $data3['payment_type']      =  'income';
                    $data3['method']            =   $method;
                    $data3['amount']            =   $paid_others;
                    $data3['timestamp']         =   strtotime($date);
                    $data3['year']              =   $year;
                    if ($description != null) {
                        $data3['description']    = $description;
                    }
                    $this->db->insert('payment' , $data3);

                }else {
                    $this->session->set_flashdata('error_message', get_phrase('please_correct_other_payment_amount'));
                }
            }

            $month = $this->input->post('tmonth');
            if (!empty($paid_transport) && $month != null)
            {
                $transport_id       = $this->input->post('transport_id');
                $settings           = $this->db->get_where('transport' , array('transport_id' => $transport_id))->row();
                $transport_fee      = ($settings == null) ? null : $settings->route_fare;
                $discount           = (int)$discount_transport;
                $ttm = count($month);
                $amount = ($ttm*$transport_fee);
//            var_dump($month); exit();
                if ($ttm==NULL){
                    $this->session->set_flashdata('error_message' , get_phrase('you_don\'t_select_any_month'));
                    redirect(site_url('accountant/student_payment'), 'refresh');
                }elseif($transport_fee==null)
                {
                    $this->session->set_flashdata('error_message' , get_phrase('please_set_transport_fee_for_the_class!'));
                    redirect(site_url('accountant/student_payment'), 'refresh');
                }
                $data2 = array();
                $data2['root_id']            = $root_id;
                $data2['student_id']         = $student_id;
                $data2['title']              = "Transport Fee";
                $data2['amount']             = $amount;
                $data2['amount_paid']        = $paid_transport;
                $data2['due']                = (($amount - ($paid_transport + $discount))>0) ? ($amount - ($paid_transport + $discount)) : 0;
                $data2['discount']           = $discount;
                $data2['payment_type']       = 3;
                $data2['payment_date']       = date('Y-m-d', strtotime($date));
                $data2['creation_timestamp'] = strtotime($date);
                $data2['year']               = $year;
                if ($description != null) {
                    $data2['description']    = $description;
                }
                $this->db->insert('invoice', $data2);
                $invoice_id = $this->db->insert_id();
                $data3 = array();
                $data3['invoice_id']        =   $invoice_id;
                $data3['student_id']        =   $student_id;
                $data3['title']             =   "Transport Fee";
                $data3['payment_type']      =  'income';
                $data3['method']            =   $method;
                $data3['amount']            =   $paid_transport;
                $data3['timestamp']         =   strtotime($date);
                $data3['year']              =   $year;
                if ($description != null) {
                    $data3['description']    = $description;
                }
                $this->db->insert('payment' , $data3);

                /****************@MonthWisePaymentDataStore@*************/
                $oneMonthPayment = $paid_transport/$ttm;
                $singleDiscount = ($discount>0) ? $discount/$ttm : 0;
                $fee = array (
                    'invoice_id' => $invoice_id,
                    'student_id' => $student_id,
                    'amount'     => $oneMonthPayment,
                    'discount'   => $singleDiscount,
                    'year'       => $year,
                );
                foreach ($month as $m)
                {
                    $fee['month'] = $m;
                    $this->db->insert('transport_fee_collection', $fee);
                }
            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->session->set_flashdata('error_message' , get_phrase('student_payment_failed'));
            }else {
                $this->session->set_flashdata('flash_message', get_phrase('student_payment_successful'));
            }
            redirect(site_url('accountant/student_payment/'.$invoiceNo), 'refresh');
        }


        /************************** UPDATE From HERE by rasel**************************/
        if($param1 == 'do_update'){
//            $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
//
//            $paid_tuition   = ($this->input->post('amount_paid_tuition')==null) ? 0 : $this->input->post('amount_paid_tuition');
//            $paid_exam      = ($this->input->post('amount_paid_exam')==null) ? 0 : $this->input->post('amount_paid_exam');
//            $paid_session   = ($this->input->post('amount_paid_session')==null) ? 0 : $this->input->post('amount_paid_session');
//            $paid_transport = ($this->input->post('amount_paid_transport')==null) ? 0 : $this->input->post('amount_paid_transport');
//            $paid_dress     = ($this->input->post('amount_paid_dress')==null) ? 0 : $this->input->post('amount_paid_dress');
//            $paid_others    = ($this->input->post('amount_paid_others')==null) ? 0 : $this->input->post('amount_paid_others');

            /****************************** Discount **************************/

//            $discount_tuition    = ($this->input->post('discount_tuition')==null) ? 0 : $this->input->post('discount_tuition');
//            $discount_exam       = ($this->input->post('discount_exam')==null) ? 0 : $this->input->post('discount_exam');
//            $discount_session    = ($this->input->post('discount_session')==null) ? 0 : $this->input->post('discount_session');
//            $discount_transport  = ($this->input->post('discount_transport')==null) ? 0 : $this->input->post('discount_transport');
//            $discount_dress      = ($this->input->post('discount_dress')==null) ? 0 : $this->input->post('discount_dress');
//            $discount_others     = ($this->input->post('discount_others')==null) ? 0 : $this->input->post('discount_others');


            $this->db->trans_start();
            $root_id        = $this->input->post('root_id');
            $student_id     = $this->input->post('student_id');
            $class_id       = $this->input->post('class_id');
            $title          = $this->input->post('title');
            $description    = $this->input->post('description');
            $method         = $this->input->post('method');
            $date           = $this->input->post('date');

            $data['student_id']     = $student_id;
            $data['class_id']       = $class_id;
            $data['grand_total']    = ($paid_tuition + $paid_exam + $paid_session + $paid_transport + $paid_dress + $paid_others);
            $data['title']          = $title;
            $data['description']    = $description;
            $data['payment_method'] = $method;
            $data['user_info']      = $this->session->userdata('login_type').','.$this->session->userdata('login_user_id');
            $data['invoice_date']   = date('Y-m-d', strtotime($date));
            $data['year']           = $year;
            $this->db->update('student_payment_invoices', $data, ['id' => $root_id]);

            if($paid_tuition>0 || isset($_POST['tui_id']))
            {
                $root_id = $this->input->post('root_id');
                $tuition_fee    = (int)$this->input->post('tuition_fee');
                $month          = $this->input->post('month');

                if (isset($_POST['tui_id'])){
                    $tui_id = $this->input->post('tui_id');
                    if ($month != ''){
                        if ($paid_tuition<1){
                            $this->db->where('invoice_id', $tui_id)->delete('invoice');
                            $this->db->where('invoice_id', $tui_id)->delete('payment');
                            $this->db->where('invoice_id', $tui_id)->delete('tuition_fee_collection');
                        }else {
                            $ttm = count($month);
                            $amount = ($ttm * $tuition_fee);
                            //update statement
                            $data = array();
                            $data['student_id']         = $this->input->post('student_id');
                            $data['amount']             = $amount;
                            $data['amount_paid']        = $paid_tuition;
                            $data['discount']           = $discount_tuition;
                            $data['due']                = ($amount - ($paid_tuition+$discount_tuition));
                            $data['creation_timestamp'] = strtotime($date);
                            $this->db->where('invoice_id', $tui_id);
                            $this->db->update('invoice', $data);

                            /*************************@MonthWisePaymentDataUpdate@***************************/
                            $oneMonthPayment = $paid_tuition/$ttm;
                            $singleDiscount = ($discount_tuition>0) ? $discount_tuition/$ttm : 0;
                            $fee = array(
                                'invoice_id' => $tui_id,
                                'student_id' => $data['student_id'],
                                'amount'     => $oneMonthPayment,
                                'discount'   => $singleDiscount,
                                'year'       => $year
                            );
                            $notDelIds = array();
                            foreach ($month as $m)
                            {
                                $chk_month = $this->db->get_where('tuition_fee_collection', array('invoice_id' => $tui_id, 'month' => $m, 'year' => $year));
                                $chkMonth = $chk_month->row();
                                if (empty($chkMonth)):
                                    $fee['month'] = $m;
                                    $this->db->insert('tuition_fee_collection', $fee);
                                    $notDelIds[] = $this->db->insert_id();
                                else:
                                    $this->db->where('id', $chkMonth->id);
                                    $this->db->update('tuition_fee_collection', $fee);
                                    $notDelIds[] = $chkMonth->id;
                                endif;

                            }
                            if (!empty($notDelIds)){
                                $this->db->where('invoice_id', $tui_id);
                                $this->db->where_not_in('id', $notDelIds);
                                $this->db->delete('tuition_fee_collection');
                            }


                            $pay_data['student_id']     = $data['student_id'];
                            $pay_data['amount']         = $paid_tuition;
                            $pay_data['timestamp']      = $data['creation_timestamp'];

                            $this->db->where('invoice_id', $tui_id);
                            $this->db->update('payment', $pay_data);
                            //end of update statement
                        }
                    }else{
                        $this->db->where('invoice_id', $tui_id)->delete('invoice');
                        $this->db->where('invoice_id', $tui_id)->delete('payment');
                        $this->db->where('invoice_id', $tui_id)->delete('tuition_fee_collection');
                    }
                }else{
                    if ($month != '' && $paid_tuition>0 && $tuition_fee!=null){
                        $ttm            = count($month);
                        $amount         = ($ttm*$tuition_fee);
                        $discount       = (int) $discount_tuition;
                        $data2 = array();
                        $data2['root_id']            = $root_id;
                        $data2['student_id']         = $student_id;
                        $data2['title']              = "Tuition Fee";
                        $data2['amount']             = $amount;
                        $data2['amount_paid']        = $paid_tuition;
                        $data2['due']                = ($amount - ($paid_tuition + $discount_tuition));
                        $data2['discount']           = $discount;
                        $data2['payment_type']       = 2;
                        $data2['payment_date']       = date('Y-m-d', strtotime($date));
                        $data2['creation_timestamp'] = strtotime($date);
                        $data2['year']               = $year;
                        if ($description != null) {
                            $data2['description']    = $description;
                        }
                        $this->db->insert('invoice', $data2);
                        $invoice_id = $this->db->insert_id();
                        $data3 = array();
                        $data3['invoice_id']        =   $invoice_id;
                        $data3['student_id']        =   $student_id;
                        $data3['title']             =   "Tuition Fee";
                        $data3['payment_type']      =  'income';
                        $data3['method']            =   $method;
                        $data3['amount']            =   $paid_tuition;
                        $data3['timestamp']         =   strtotime($date);
                        $data3['year']              =   $year;
                        if ($description != null) {
                            $data3['description']    = $description;
                        }
                        $this->db->insert('payment' , $data3);

                        /****************@MonthWisePaymentDataStore@*************/
                        $oneMonthPayment = $paid_tuition/$ttm;
                        $singleDiscount = ($discount>0) ? $discount/$ttm : 0;
                        $fee = array(
                            'invoice_id' => $invoice_id,
                            'student_id' => $student_id,
                            'amount'     => $oneMonthPayment,
                            'discount'   => $singleDiscount,
                            'year'       => $year,
                        );
                        foreach ($month as $m)
                        {
                            $fee['month'] = $m;
                            $this->db->insert('tuition_fee_collection', $fee);
                        }
                        //End of Insert tuition payment-in update

                    }

                }

            }//End of TUITION PAYMENT

            if($paid_exam>0 || isset($_POST['exam_id_hidden']))
            {

                $exam_fee       = $this->input->post('exam_fee');
                $exam_id        = $this->input->post('exam_id');

                if (isset($_POST['exam_id_hidden'])) {
                    $exam_hidden    = $this->input->post('exam_id_hidden');
                    if ($paid_exam < 1) {
                        $this->db->where('invoice_id', $exam_hidden)->delete('invoice');
                        $this->db->where('invoice_id', $exam_hidden)->delete('payment');
                        $this->db->where('invoice_id', $exam_hidden)->delete('exam_fee_collection');
                    } else {
                        $data = array();
                        if (empty($exam_fee)) {
                            $exam_fee = 0;
                        }
                        $due = ($exam_fee - ($paid_exam + $discount_exam));
                        $dut_total = ($exam_fee > 0 && $due >0 ? $due: 0);
                        $data['student_id'] = $student_id;
                        $data['amount'] = $exam_fee;
                        $data['amount_paid'] = $paid_exam;
                        $data['discount'] = (int)$discount_exam;
                        $data['due'] = $dut_total;
                        $data['creation_timestamp'] = strtotime($date);
                        $this->db->update('invoice', $data, ['invoice_id' => $exam_hidden]);

                        $pay_data = array();
                        $pay_data['student_id'] = $student_id;
                        $pay_data['amount'] = $paid_exam;
                        $pay_data['timestamp'] = strtotime($date);
                        $this->db->update('payment', $pay_data, ['invoice_id' => $exam_hidden]);

                        $examSett = $this->db->select('ef_id')->where('exam_id', $exam_id)->where('class_id', $class_id)->where('year', $year)->get('exam_fees')->row();
                        $ef_id = (empty($examSett)) ? 0 : $examSett->ef_id;

                        $colExam = [
                            'exam_id' => $exam_id,
                            'ef_id' => $ef_id,
                            'student_id' => $student_id,
                            'class_id' => $class_id,
                            'paid_amount' => $paid_exam,
                        ];
                        $this->db->update('exam_fee_collection', $colExam, ['invoice_id' => $exam_hidden]);
                    }
                } // end exam update
                elseif ($paid_exam>0 && $exam_fee !=null)
                {
                    $amount                      = $exam_fee;
                    $data2 = array();
                    $data2['root_id']            = $root_id;
                    $data2['student_id']         = $student_id;
                    $data2['title']              = "Exam Fee";
                    $data2['amount']             = $amount;
                    $data2['amount_paid']        = $paid_exam;
                    $data2['due']                = (($amount - ($paid_exam + $discount_exam)) > 0) ? ($amount - ($paid_exam + $discount_exam)) : 0;
                    $data2['discount']           = $discount_exam;
                    $data2['payment_type']       = 1;
                    $data2['payment_date']       = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year']               = $year;
                    if ($description != null) {
                        $data2['description']    = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();
                    $data3 = array();
                    $data3['invoice_id']        =   $invoice_id;
                    $data3['student_id']        =   $student_id;
                    $data3['title']             =   "Exam Fee";
                    $data3['payment_type']      =  'income';
                    $data3['method']            =   $method;
                    $data3['amount']            =   $paid_exam;
                    $data3['timestamp']         =   strtotime($date);
                    $data3['year']              =   $year;
                    if ($description != null) {
                        $data3['description']    = $description;
                    }
                    $this->db->insert('payment' , $data3);
                    $examSett = $this->db->select('ef_id')->where('exam_id', $exam_id)->where('class_id', $class_id)->where('year', $year)->get('exam_fees')->row();
                    $ef_id = (empty($examSett)) ? 0 : $examSett->ef_id;
                    $data4 = array(
                        'exam_id'     => $exam_id,
                        'ef_id'       => $ef_id,
                        'invoice_id'  => $invoice_id,
                        'student_id'  => $student_id,
                        'class_id'    => $class_id,
                        'paid_amount' =>  $data3['amount'],
                        'year'        => $year,
                    );
                    $this->db->insert('exam_fee_collection', $data4);

                }

            }//End of exam PAYMENT
            if($paid_session>0 || isset($_POST['sess_id']))
            {
                $session_fee    = $this->input->post('session_fee');
                if (isset($_POST['sess_id'])) {
                    $session_id    = $this->input->post('sess_id');
                    if ($session_id < 1) {
                        $this->db->where('invoice_id', $session_id)->delete('invoice');
                        $this->db->where('invoice_id', $session_id)->delete('payment');
                    }else {
                        $settings = $this->db->get_where('session_fee_settings', array('class_id' => $class_id, 'year' => $year))->row();
                        $check_fee = $this->db
                            ->select('SUM(amount_paid) AS amt_paid, SUM(discount) AS dis')
                            ->where('student_id', $student_id)
                            ->where('payment_type', 9)
                            ->where('year', $year)
                            ->where('invoice_id !=', $param2)
                            ->group_by('student_id')
                            ->get('invoice')->row();
                        if (!empty($check_fee)) {
                            $amt_paid = $check_fee->amt_paid;
                            $amt_dis = $check_fee->dis;
                        } else {
                            $amt_paid = 0;
                            $amt_dis = 0;
                        }
                        if (($amt_paid + $amt_dis + $paid_session + $discount_session) <= $settings->session_fee) {
                            $date = array();
                            $data['student_id']     = $student_id;
                            $data['amount']         = $this->input->post('session_fee');
                            $data['amount_paid']    = $paid_session;
                            $data['discount']       = (int)$discount_session;
                            $data['due']            = ($data['amount'] - ($paid_session + $discount_session));

                            $data['creation_timestamp'] = strtotime($date);

                            $this->db->update('invoice', $data, ['invoice_id'=>$session_id]);
                            $pay_data = array();
                            $pay_data['student_id'] = $student_id;
                            $pay_data['amount'] = $paid_session;
                            $pay_data['timestamp'] = $data['creation_timestamp'];

                            $this->db->update('payment', $pay_data,['invoice_id'=>$session_id]);
                        }
                    }

                } // end session update
                elseif ($paid_session>0 && $session_fee !=null)
                {
                    $data2 = array();
                    $data2['root_id']            = $root_id;
                    $data2['student_id']         = $student_id;
                    $data2['title']              = "Session Fee";
                    $data2['amount']             = $session_fee;
                    $data2['amount_paid']        = $paid_session;
                    $data2['due']                = ($session_fee - ($paid_session + $discount_session));
                    $data2['discount']           = $discount_session;
                    $data2['payment_type']       = 9;
                    $data2['payment_date']       = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year']               = $year;
                    if ($description != null) {
                        $data2['description']    = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();
                    $data3 = array();
                    $data3['invoice_id']        =   $invoice_id;
                    $data3['student_id']        =   $student_id;
                    $data3['title']             =   "Session Fee";
                    $data3['payment_type']      =  'income';
                    $data3['method']            =   $method;
                    $data3['amount']            =   $paid_session;
                    $data3['timestamp']         =   strtotime($date);
                    $data3['year']              =   $year;
                    if ($description != null) {
                        $data3['description'] = $description;
                    }
                    $this->db->insert('payment' , $data3);
                }
            }//End of session PAYMENT
            if ($paid_transport > 0 || isset($_POST['trans_id'])){
                $root_id = $this->input->post('root_id');
                $transport_fee    = (int)$this->input->post('route_fee');
                $tmonth          = $this->input->post('tmonth');

                if (isset($_POST['trans_id'])){
                    $trans_id = $this->input->post('trans_id');
                    if ($tmonth != ''){
                        if ($paid_tuition<1){
                            $this->db->where('invoice_id', $trans_id)->delete('invoice');
                            $this->db->where('invoice_id', $trans_id)->delete('payment');
                            $this->db->where('invoice_id', $trans_id)->delete('transport_fee_collection');
                        }else {
                            $ttmt = count($tmonth);
                            $tamount = ($ttmt * $transport_fee);
                            //update statement
                            $data = array();
                            $data['student_id']         = $student_id;
                            $data['amount']             = $tamount;
                            $data['amount_paid']        = $paid_transport;
                            $data['discount']           = $discount_transport;
                            $data['due']                = ($tamount - ($paid_transport+$discount_transport));
                            $data['creation_timestamp'] = strtotime($date);
                            $this->db->where('invoice_id', $trans_id);
                            $this->db->update('invoice', $data);

                            /*************************@MonthWisePaymentDataUpdate@***************************/
                            $oneMonthPayment = $paid_transport/$ttmt;
                            $singleDiscount = ($discount_transport>0) ? $discount_transport/$ttmt : 0;
                            $trans_fee = array(
                                'invoice_id' => $trans_id,
                                'student_id' => $student_id,
                                'amount'     => $oneMonthPayment,
                                'discount'   => $singleDiscount,
                                'year'       => $year
                            );
                            $notDelIds = array();
                            foreach ($tmonth as $mo)
                            {
                                $chk_month = $this->db->get_where('tuition_fee_collection', array('invoice_id' => $trans_id, 'month' => $mo, 'year' => $year));
                                $chkMonth = $chk_month->row();
                                if (empty($chkMonth)):
                                    $trans_fee['month'] = $mo;
                                    $this->db->insert('transport_fee_collection', $trans_fee);
                                    $notDelIds[] = $this->db->insert_id();
                                else:
                                    $this->db->where('id', $chkMonth->id);
                                    $this->db->update('transport_fee_collection', $trans_fee);
                                    $notDelIds[] = $chkMonth->id;
                                endif;

                            }
                            if (!empty($notDelIds)){
                                $this->db->where('invoice_id', $trans_id);
                                $this->db->where_not_in('id', $notDelIds);
                                $this->db->delete('transport_fee_collection');
                            }

                            $pay_data = array();
                            $pay_data['student_id']     = $student_id;
                            $pay_data['amount']         = $paid_tuition;
                            $pay_data['timestamp']      = $data['creation_timestamp'];

                            $this->db->where('invoice_id', $trans_id);
                            $this->db->update('payment', $pay_data);
                            //end of update statement
                        }
                    }else{
                        $this->db->where('invoice_id', $trans_id)->delete('invoice');
                        $this->db->where('invoice_id', $trans_id)->delete('payment');
                        $this->db->where('invoice_id', $trans_id)->delete('transport_fee_collection');
                    }
                }else{
                    if ($tmonth != '' && $paid_transport>0 && $transport_fee!=null){
                        $ttm            = count($tmonth);
                        $tamount         = ($ttm*$transport_fee);
                        $discount       = (int) $discount_transport;
                        $data2 = array();
                        $data2['root_id']            = $root_id;
                        $data2['student_id']         = $student_id;
                        $data2['title']              = "Transport Fee";
                        $data2['amount']             = $tamount;
                        $data2['amount_paid']        = $paid_transport;
                        $data2['due']                = ($tamount - ($paid_transport + $discount_transport));
                        $data2['discount']           = $discount;
                        $data2['payment_type']       = 3;
                        $data2['payment_date']       = date('Y-m-d', strtotime($date));
                        $data2['creation_timestamp'] = strtotime($date);
                        $data2['year']               = $year;
                        if ($description != null) {
                            $data2['description']    = $description;
                        }
                        $this->db->insert('invoice', $data2);
                        $invoice_id = $this->db->insert_id();
                        $data3 = array();
                        $data3['invoice_id']        =   $invoice_id;
                        $data3['student_id']        =   $student_id;
                        $data3['title']             =   "Transport Fee";
                        $data3['payment_type']      =  'income';
                        $data3['method']            =   $tamount;
                        $data3['amount']            =   $paid_transport;
                        $data3['timestamp']         =   strtotime($date);
                        $data3['year']              =   $year;
                        if ($description != null) {
                            $data3['description']    = $description;
                        }
                        $this->db->insert('payment' , $data3);

                        /****************@MonthWisePaymentDataStore@*************/
                        $oneMonthPayment = $paid_transport/$ttm;
                        $singleDiscount = ($discount>0) ? $discount/$ttm : 0;
                        $fee = array();
                        $fee = array(
                            'invoice_id' => $invoice_id,
                            'student_id' => $student_id,
                            'amount'     => $oneMonthPayment,
                            'discount'   => $singleDiscount,
                            'year'       => $year,
                        );
                        foreach ($tmonth as $m)
                        {
                            $fee['month'] = $m;
                            $this->db->insert('transport_fee_collection', $fee);
                        }
                        //End of Insert Transport payment-in update

                    }

                }

            }//End of transport PAYMENT
            if ($paid_dress > 0 || isset($_POST['dress_id_hidden'])){
                $dress_fee       = $this->input->post('dress_fee');
                $dress_id        = $this->input->post('dress_id');
                if (isset($_POST['dress_id_hidden'])) {
                    $dress_hidden    = $this->input->post('dress_id_hidden');
                    if ($paid_dress <1){
                        $this->db->where('invoice_id', $dress_hidden)->delete('invoice');
                        $this->db->where('invoice_id', $dress_hidden)->delete('payment');
                        $this->db->where('invoice_id', $dress_hidden)->delete('dress_fee_collection');
                    } else{
                        $data = array();
                        $data['student_id'] = $student_id;
                        $data['amount'] = $dress_fee;
                        $data['amount_paid'] = $paid_dress;
                        $data['discount'] = (int)$discount_dress;
                        $data['due'] = ($dress_fee - ($paid_dress + $discount_dress));
                        $data['creation_timestamp'] = strtotime($date);
                        $this->db->update('invoice', $data, ['invoice_id' => $dress_hidden]);

                        $pay_data = array();
                        $pay_data['student_id'] = $student_id;
                        $pay_data['amount']     = $paid_dress;
                        $pay_data['timestamp']  = strtotime($date);
                        $this->db->update('payment', $pay_data, ['invoice_id' => $dress_hidden]);

                        $colDress = [
                            'student_id' => $student_id,
                            'payment_type' => $dress_id,
                            'amount' => $class_id,
                            'discount' => $discount_dress,
                            'year' => $year,
                        ];
                        $this->db->update('dress_fee_collection', $colDress, ['invoice_id' => $dress_hidden]);
                    } //end dress/batch update
                }
                elseif ($paid_dress>0 && $dress_fee !=null)
                {
                    $data2 = array();
                    $data2['root_id']            = $root_id;
                    $data2['student_id']         = $student_id;
                    $data2['title']              = "Dress/Batch Fee";
                    $data2['amount']             = $dress_fee;
                    $data2['amount_paid']        = $paid_dress;
                    $data2['due']                = ($dress_fee - ($paid_dress + $discount_dress));
                    $data2['discount']           = $discount_dress;
                    $data2['payment_type']       = 10;
                    $data2['payment_date']       = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year']               = $year;
                    if ($description != null) {
                        $data2['description']    = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();
                    $data3 = array();
                    $data3['invoice_id']        =   $invoice_id;
                    $data3['student_id']        =   $student_id;
                    $data3['title']             =   "Dress/Batch Fee";
                    $data3['payment_type']      =  'income';
                    $data3['method']            =   $method;
                    $data3['amount']            =   $paid_dress;
                    $data3['timestamp']         =   strtotime($date);
                    $data3['year']              =   $year;
                    if ($description != null) {
                        $data3['description']    = $description;
                    }
                    $data4 = array();
                    $data4 = array(
                        'payment_type'=> $dress_id,
                        'invoice_id'  => $invoice_id,
                        'student_id'  => $student_id,
                        'amount'      => $paid_dress,
                        'discount'    => $discount_dress,
                        'year'        => $year,
                    );
                    $this->db->insert('dress_fee_collection', $data4);

                }
            }//End of dress/batch PAYMENT

            if ($paid_others > 0 || isset($_POST['other_id'])){
                $other_fee       = $this->input->post('invoice_fee');
                if (isset($_POST['other_id'])) {
                    $other_id    = $this->input->post('other_id');
                    if ($paid_dress <1){
                        $this->db->where('invoice_id', $other_id)->delete('invoice');
                        $this->db->where('invoice_id', $other_id)->delete('payment');
                    } else{
                        $data = array();
                        $data['student_id']     = $student_id;
                        $data['amount']         = $other_fee;
                        $data['amount_paid']    = $paid_others;
                        $data['discount']       = (int)$discount_others;
                        $data['due'] = ($other_fee - ($paid_others + $discount_others));
                        $data['creation_timestamp'] = strtotime($date);
                        $this->db->update('invoice', $data, ['invoice_id' => $other_id]);

                        $pay_data = array();
                        $pay_data['student_id'] = $student_id;
                        $pay_data['amount']     = $paid_others;
                        $pay_data['timestamp']  = strtotime($date);
                        $this->db->update('payment', $pay_data, ['invoice_id' => $other_id]);

                    } //end other update
                }
                elseif ($paid_others>0 && $other_fee !=null)
                {
                    $others_title= '';
                    $others_type = $this->input->post('others_name');
                    if($others_type == 4) {
                        $others_title ='Books Fee';
                    }
                    elseif($others_type == 5){
                        $others_title ='Copies Fee';
                    }
                    elseif($others_type == 6){
                        $others_title ='Stationery\'s Fee';
                    }
                    else {
                        $others_title ='Others/Remarks';
                    }
                    $data2 = array();
                    $data2['root_id']            = $root_id;
                    $data2['student_id']         = $student_id;
                    $data2['title']              = $others_title;
                    $data2['amount']             = $other_fee;
                    $data2['amount_paid']        = $paid_others;
                    $data2['due']                = ($other_fee - ($paid_others + $discount_others));
                    $data2['discount']           = $discount_others;
                    $data2['payment_type']       = $others_type;
                    $data2['payment_date']       = date('Y-m-d', strtotime($date));
                    $data2['creation_timestamp'] = strtotime($date);
                    $data2['year']               = $year;
                    if ($description != null) {
                        $data2['description']    = $description;
                    }
                    $this->db->insert('invoice', $data2);
                    $invoice_id = $this->db->insert_id();
                    $data3 = array();
                    $data3['invoice_id']        =   $invoice_id;
                    $data3['student_id']        =   $student_id;
                    $data3['title']             =   $others_title;
                    $data3['payment_type']      =  'income';
                    $data3['method']            =   $method;
                    $data3['amount']            =   $paid_others;
                    $data3['timestamp']         =   strtotime($date);
                    $data3['year']              =   $year;
                    if ($description != null) {
                        $data3['description']    = $description;
                    }
                }

            }//End of other PAYMENT
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $this->session->set_flashdata('error_message', get_phrase('no_data_updated'));
            }else{
                $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            }
            redirect(site_url('accountant/income/invoices_student_multiple_fee'), 'refresh');

        }//End of Update



        /*************************** transport fee update by rasel ************************/

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income'), 'refresh');
        }
        if ($param1 == 'delete_transport_fee') {
            $this->db->delete('transport_fee_collection' , ['invoice_id'=>$param2]);
            $this->db->delete('payment' , ['invoice_id'=>$param2]);
            $this->db->delete('invoice' , ['invoice_id'=>$param2]);
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income/student_transport_payment_history'), 'refresh');
        }
        if ($param1 == 'delete_student_multiple_fee') {
            $this->db->trans_start();
            $all_root_id = $this->db->get_where('invoice' , ['root_id'=>$param2])->result();
            foreach ($all_root_id as $root_id){
                $invoiceId = $root_id->invoice_id;
                $payment_type = $root_id->payment_type;
                if ($payment_type ==1){
                    $this->db->delete('exam_fee_collection' , ['invoice_id'=>$invoiceId]);
                } elseif ($payment_type ==2){
                    $this->db->delete('tuition_fee_collection' , ['invoice_id'=>$invoiceId]);
                } elseif ($payment_type ==3){
                    $this->db->delete('transport_fee_collection' , ['invoice_id'=>$invoiceId]);
                }elseif ($payment_type ==10){
                    $this->db->delete('dress_fee_collection' , ['invoice_id'=>$invoiceId]);
                }
                if (!empty($invoiceId)){
                    $this->db->delete('payment' , ['invoice_id'=>$invoiceId]);
                }
            }
            $this->db->delete('student_payment_invoices' , ['id'=>$param2]);
            $this->db->delete('invoice' , ['root_id'=>$param2]);

            $this->db->trans_complete();
            if ($this->db->trans_status() == false){
                $this->session->set_flashdata('error_message' , get_phrase('data_deleted_failed'));
            } else{
                $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            }

            redirect(site_url('accountant/income/invoices_student_multiple_fee'), 'refresh');
        }
        if ($param1 == 'delete_dress_fee') {
            $this->db->delete('transport_fee_collection' , ['invoice_id'=>$param2]);
            $this->db->delete('payment' , ['invoice_id'=>$param2]);
            $this->db->delete('invoice' , ['invoice_id'=>$param2]);
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income/invoices_dress_fee'), 'refresh');
        }

        if ($param1 == 'delete_others') {
            $this->db->delete('payment' , ['invoice_id'=>$param2]);
            $this->db->delete('invoice' , ['invoice_id'=>$param2]);
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income/student_transport_payment_history'), 'refresh');
        }

        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }



    function student_payment_edit($param1 = '' , $param2 = '' , $param3 = '') {
        $vtype = $this->session->userdata('vtype');

        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['student_info'] = $this->db->select('name,student_code, student_id')->order_by('name', 'asc')->get_where('student', ['vtype'=>$vtype])->result();
//            dd($page_data['student_info']);
        $page_data['root'] = $this->Barcode_model->get_rootInvoiceInfo($param1);

        if (empty($page_data['root'])){
            $this->session->set_flashdata('error_message' , get_phrase('no_record_found!'));
            redirect(site_url('admin/student_payment'), 'refresh');
        }

        $page_data['exam_pay'] = $this->Barcode_model->get_studentSingleInvoiceData($param1, 1);
        $page_data['student_class'] = $this->get_classOfSingleStudent($page_data['root']->student_id);
        //echo $page_data['class']; exit;
        $page_data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $page_data['session_pay'] = $this->Barcode_model->get_studentSingleInvoiceData($param1, 9);
        $invoice_id = (!empty($page_data['session_pay'])) ? $page_data['session_pay']->invoice_id : '';
        $page_data['session_data'] = $this->get_session_fee_data_forUpdate($page_data['root']->student_id, $invoice_id);

        $page_data['exam_pay'] = $this->Barcode_model->get_studentSingleInvoiceData($param1, 1);
        $invoice_id = (!empty($page_data['exam_pay'])) ? $page_data['exam_pay']->invoice_id : '';
        if ($invoice_id=='') {
            $collect = $this->Barcode_model->get_examInfo_byInvoiceId($invoice_id);
            $exam_id = (!empty($collect)) ? $collect->exam_id : '';
            $page_data['exam_data'] = $this->get_exam_fee_data_for_update($page_data['root']->student_id, $exam_id, $invoice_id);
        }else{
            $page_data['exam_data'] = '0|0';
        }

        $page_data['tuition_data'] = $this->search_student_payment_status_for_update($page_data['root']->student_id);
        $page_data['transport_data'] = $this->search_student_transport_pay_for_update($page_data['root']->student_id);



        $page_data['exams']        = $this->db->get_where('exam', array('year' => $page_data['year'], 'vtype'=>$vtype))->result_array();
        $page_data['page_name']  = 'student_payment_edit';
        $page_data['page_title'] = get_phrase('update_student_payment');
        $this->load->view('backend/index', $page_data);
    }


    function get_classOfSingleStudent($student_id)
    {
        $students = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => get_settings('running_year')) )->row();
        if ($students){
            $row = $this->db->get_where('class' , array('class_id' => $students->class_id))->row();
            return '<option value="'. $row->class_id .'">' . $row->name . '</option>';
        }
    }

    public function get_session_fee_data_forUpdate($student_id, $invoice_id='')
    {
        $data = '';
        $class = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => get_settings('running_year')))->row();
        $class_id = $class->class_id;
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $settings = $this->db->get_where('session_fee_settings', array('class_id' => $class_id, 'year' => $year))->row();
        $this->db->select('SUM(amount_paid) AS amt_paid, SUM(discount) AS dis');
        if ($invoice_id != ""){
            $this->db->where('invoice_id !=', $invoice_id);
        }
        $data = $this->db->where('student_id', $student_id)->where('payment_type', 9)->where('year', $year)->group_by('student_id')->get('invoice')->row();
//        echo $this->db->last_query(); exit();
        if (!empty($data))
        {
            $data = ($data->amt_paid+$data->dis).'|'.$settings->session_fee;
        }elseif($settings)
        {
            $data = '0|'.$settings->session_fee;
        }else{
            $data = '0|0';
        }
        return $data;
    }
    public function get_exam_fee_data_for_update($student_id, $exam_id, $invoice_id='')
    {
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $class = $this->db->get_where('enroll' , array( 'student_id' => $student_id , 'year' => get_settings('running_year')) )->row();
        $class_id = $class->class_id;

        $settings = $this->db->get_where('exam_fees' , array('class_id' => $class_id, 'exam_id' => $exam_id, 'year' => $year))->row();

        $this->db->select('SUM(amount_paid) AS amt_paid, SUM(discount) AS dis');
        $this->db->where('student_id', $student_id);
        if ($invoice_id != ""){
            $this->db->where('invoice_id !=', $invoice_id);
        }
        $data = $this->db->where('payment_type', 1)->where('year', $year)->group_by('student_id')->get('invoice')->row();
        if (!empty($data))
        {
            return ($data->amt_paid+$data->dis) . '|' . $settings->exam_fee;
        }elseif($settings)
        {
            return '0|'.$settings->exam_fee;
        }else{
            return 'w|w';
        }
    }
    public function search_student_payment_status_for_update($std_id)     //AJAX FUNCTION
    {
        $class = $this->db->get_where('enroll' , array( 'student_id' => $std_id , 'year' => get_settings('running_year')) )->row();
        $class_id = $class->class_id;
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $settings = $this->db->get_where('tuition_fee_settings' , array('class_id' => $class_id, 'year' => $year))->row();
        $tuition_fee = ($settings == null) ? null : $settings->tuition_fee;

        $pay = $this->db->get_where('tuition_fee_collection' , array('student_id' => $std_id, 'year' => $year))->result();

        $total_pay = 0;
        $total_discount = 0;
        $paid = 0;
        $data = "";
        if ($tuition_fee == null)
        {
            $data = "<h4 style='color: red; padding-left: 20px;'>Please set tuition fee for the class</h4>";
        }else{
            $use_month = (date('m')-1);
//            $payable_month = $use_month-$paid;

            $due = ($tuition_fee*$use_month) - ($total_discount+$total_pay);
            $data .= '<h4 style="padding-left: 20px;">Your Due: '.number_format($due, 2).'</h4>';
        }
        return $data;
    }
    public function search_student_transport_pay_for_update($std_id)
    {
        $data = "";
        $html = "";
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $std = $this->db->select('transport_id')->get_where('student' , array('student_id' => $std_id))->row();
        if ($std->transport_id == null)
        {
            $data .= "<h4 style='color: red; padding-left: 20px;'>Transport fare is not eligible for the student!</h4>";
        } else {
            $settings = $this->db->get_where('transport', array('transport_id' => $std->transport_id))->row();
            $transport_fee = ($settings == null) ? null : $settings->route_fare;
            $html .= '<p style=" margin-left: 18px; font-size: 14px; color: #000;">Route Name: '.$settings->route_name.', Fare: '.number_format($transport_fee, 0).'</p>';
            $pay = $this->db->get_where('transport_fee_collection', array('student_id' => $std_id, 'year' => $year))->result();

            $total_pay = 0;
            $total_discount = 0;
            if ($transport_fee == null) {
                $data = "<h4 style='color: red; padding-left: 20px;'>Please set Transport fee for the route</h4>";
            } else {
                $use_month = (date('m') - 1);
//            $payable_month = $use_month-$paid;

                $due = ($transport_fee * $use_month) - ($total_discount + $total_pay);
                $data .= '<h4 style="padding-left: 20px;">Your Due: ' . number_format($due, 2) . '</h4>';
            }
        }

        return $data.$html;

    }

    /**********ACCOUNTING********************/
    function income($param1 = 'invoices', $param2 = '', $param3 = '') {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['page_name'] = 'income';
        $page_data['inner'] = $param1;
        $page_data['page_title'] = get_phrase('student_payments');
        $this->load->view('backend/index', $page_data);
    }

    function get_invoices() {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $columns = array(
            0 => 'invoice_id',
            1 => 'student',
            2 => 'title',
            3 => 'total',
            4 => 'paid',
            5 => 'status',
            6 => 'date',
            7 => 'options',
            8 => 'invoice_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->ajaxload->all_invoices_count();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {            
            $invoices = $this->ajaxload->all_invoices($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $invoices =  $this->ajaxload->invoice_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ajaxload->invoice_search_count($search);
        }

        $data = array();
        if(!empty($invoices)) {
            foreach ($invoices as $row) {

                if ($row->due == 0) {
                    $status = '<button class="btn btn-success btn-xs">'.get_phrase('paid').'</button>';
                    $payment_option = '';
                } else {
                    $status = '<button class="btn btn-danger btn-xs">'.get_phrase('unpaid').'</button>';
                    $payment_option = '<li><a href="#" onclick="invoice_pay_modal('.$row->invoice_id.')"><i class="entypo-bookmarks"></i>&nbsp;'.get_phrase('take_payment').'</a></li><li class="divider"></li>';
                }
                    
                
                $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu">'.$payment_option.'<li><a href="#" onclick="invoice_view_modal('.$row->invoice_id.')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_edit_modal('.$row->invoice_id.')"><i class="entypo-pencil"></i>&nbsp;'.get_phrase('edit').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_delete_confirm('.$row->invoice_id.')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';

                $nestedData['invoice_id'] = $row->invoice_id;
                $nestedData['student'] = $this->crud_model->get_type_name_by_id('student',$row->student_id);
                $nestedData['title'] = $row->title;
                $nestedData['total'] = $row->amount;
                $nestedData['paid'] = $row->amount_paid;
                $nestedData['status'] = $status;
                $nestedData['date'] = date('d M,Y', $row->creation_timestamp);
                $nestedData['options'] = $options;
                
                $data[] = $nestedData;
                
            }
        }
          
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);
    }

    function get_payments() {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $columns = array(
            0 => 'payment_id',
            1 => 'title',
            2 => 'description',
            3 => 'method',
            4 => 'amount',
            5 => 'date',
            6 => 'options',
            7 => 'payment_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->ajaxload->all_payments_count();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {            
            $payments = $this->ajaxload->all_payments($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $payments =  $this->ajaxload->payment_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ajaxload->payment_search_count($search);
        }

        $data = array();
        if(!empty($payments)) {
            foreach ($payments as $row) {

                if ($row->method == 1)
                    $method = get_phrase('cash');
                else if ($row->method == 2)
                    $method = get_phrase('cheque');
                else if ($row->method == 3)
                    $method = get_phrase('card');
                else if ($row->method == 'Paypal')
                    $method = 'Paypal';
                else
                    $method = 'Stripe';
                    
                
                $options = '<a href="#" onclick="invoice_view_modal('.$row->invoice_id.')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a>';

                $nestedData['payment_id'] = $row->payment_id;
                $nestedData['title'] = $row->title;
                $nestedData['description'] = $row->description;
                $nestedData['method'] = $method;
                $nestedData['amount'] = $row->amount;
                $nestedData['date'] = date('d M,Y', $row->timestamp);
                $nestedData['options'] = $options;
                
                $data[] = $nestedData;
                
            }
        }
          
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);
    }

    function student_payment($param1 = 'invoices_student_multiple_fee' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');

        $vtype = $this->session->userdata('vtype');
        $page_data['student_info'] = $this->db->select('name,student_code, student_id')->order_by('name', 'asc')->get_where('student', ['vtype'=>$vtype])->result();
//            dd($page_data['student_info']);

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        if ($param1 != ''){
            $page_data['param1'] = $param1;
        }
        $page_data['exams']        = $this->db->get_where('exam', array('year' => $year, 'vtype'=>$vtype))->result_array();

        $page_data['page_name']  = 'student_payment';
        $page_data['page_title'] = get_phrase('create_student_payment');
        $this->load->view('backend/index', $page_data); 
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            if ($this->input->post('description') != null) {
               $data['description']         =   $this->input->post('description');
            }
            
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('accountant/expense'), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            if ($this->input->post('description') != null) {
               $data['description']         =   $this->input->post('description');
            }
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('accountant/expense'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/expense'), 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data); 
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('accountant/expense_category'), 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('accountant/expense_category'), 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/expense_category'), 'refresh');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = get_phrase('expense_category');
        $this->load->view('backend/index', $page_data);
    }

    /*******************************Income/ by rasel***************************************/
    function income_other($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['income_category_id']  =   $this->input->post('income_category_id');
            $data['payment_type']        =   'income';
            $data['income_id']           =   1;
            $data['income_expense_date'] =   date('Y-m-d');
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('accountant/income_other'), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['income_category_id']  =   $this->input->post('income_category_id');
            $data['payment_type']        =   'income';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['income_id']           =   1;
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            else{
                $data['description']     =   null;
            }
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('accountant/income_other'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income_other'), 'refresh');
        }

        $page_data['page_name']  = 'income_other';
        $page_data['page_title'] = get_phrase('income');
        $this->load->view('backend/index', $page_data);
    }

    /*******************************Income Category / by rasel***************************************/
    function income_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('income_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('accountant/income_category'), 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('income_category_id' , $param2);
            $this->db->update('income_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('accountant/income_category'), 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('income_category_id' , $param2);
            $this->db->delete('income_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('accountant/income_category'), 'refresh');
        }
        $page_data['page_name']  = 'income_category';
        $page_data['page_title'] = get_phrase('income_category');
        $this->load->view('backend/index', $page_data);
    }
    
    // MANAGE OWN PROFILE AND CHANGE PASSWORD
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $validation = email_validation_for_edit($data['email'], $this->session->userdata('accountant_id'), 'accountant');
            if ($validation == 1) {
                $this->db->where('accountant_id', $this->session->userdata('accountant_id'));
                $this->db->update('accountant', $data);
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('accountant/manage_profile'), 'refresh');
        }

        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            
            $current_password = $this->db->get_where('accountant', array(
                'accountant_id' => $this->session->userdata('accountant_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('accountant_id', $this->session->userdata('accountant_id'));
                $this->db->update('accountant', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(site_url('accountant/manage_profile'), 'refresh');
        }
        
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('accountant', array(
            'accountant_id' => $this->session->userdata('accountant_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function get_expenses() {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(site_url('login'), 'refresh');

        $columns = array(
            0 => 'payment_id',
            1 => 'title',
            2 => 'category',
            3 => 'method',
            4 => 'amount',
            5 => 'date',
            6 => 'options',
            7 => 'payment_id'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->ajaxload->all_expenses_count();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {            
            $expenses = $this->ajaxload->all_expenses($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $expenses =  $this->ajaxload->expense_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ajaxload->expense_search_count($search);
        }

        $data = array();
        if(!empty($expenses)) {
            foreach ($expenses as $row) {
                $category = $this->db->get_where('expense_category', array('expense_category_id' => $row->expense_category_id))->row()->name;
                if ($row->method == 1)
                    $method = get_phrase('cash');
                else if ($row->method == 2)
                    $method = get_phrase('cheque');
                else 
                    $method = get_phrase('card');
                $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu"><li><a href="#" onclick="expense_edit_modal('.$row->payment_id.')"><i class="entypo-pencil"></i>&nbsp;'.get_phrase('edit').'</a></li><li class="divider"></li><li><a href="#" onclick="expense_delete_confirm('.$row->payment_id.')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';

                $nestedData['payment_id'] = $row->payment_id;
                $nestedData['title'] = $row->title;
                $nestedData['category'] = $category;
                $nestedData['method'] = $method;
                $nestedData['amount'] = $row->amount;
                $nestedData['date'] = date('d M,Y', $row->timestamp);
                $nestedData['options'] = $options;
                
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);
    }

    function get_sections_for_ssph($class_id) {
        $sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
        $options = '';
        foreach ($sections as $row) {
            $options .= '<option value="'.$row['section_id'].'">'.$row['name'].'</option>';
        }
        echo '<select class="" name="section_id" id="section_id">'.$options.'</select>';
    }

    function get_students_for_ssph($class_id, $section_id) {
        $enrolls = $this->db->get_where('enroll', array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
        $options = '';
        foreach ($enrolls as $row) {
            $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
            $options .= '<option value="'.$row['student_id'].'">'.$name.'</option>';
        }
        echo '<select class="" name="student_id" id="student_id">'.$options.'</select>';
    }

    function get_payment_history_for_ssph($student_id) {
        $page_data['student_id'] = $student_id;
        $this->load->view('backend/admin/student_specific_payment_history_table', $page_data);
    }
}
















