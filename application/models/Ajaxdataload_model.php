<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxdataload_model extends CI_Model
{
	function __construct() {
        parent::__construct(); 
    }

	/*----------------------------- BOOKS -------------------------------*/

	function all_books_count()
	{
        $vtype = $this->session->userdata('vtype');
		$query = $this->db->get_where('book', ['vtype'=>$vtype]);
		return $query->num_rows();
	}

	function all_books($limit, $start, $col, $dir)
    {
        $vtype = $this->session->userdata('vtype');
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get_where('book', ['vtype'=>$vtype]);
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function book_search($limit, $start, $search, $col, $dir)
    {
        $vtype = $this->session->userdata('vtype');
        $query = $this
                ->db
                ->like('name', $search)
                ->or_like('author', $search)
                ->or_like('book_id', $search)
                ->or_like('price', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get_where('book', ['vtype'=>$vtype]);
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function book_search_count($search)
    {
        $vtype = $this->session->userdata('vtype');
        $query = $this
                ->db
                ->like('name', $search)
                ->or_like('book_id', $search)
                ->or_like('author', $search)
                ->or_like('price', $search)
                ->get_where('book', ['vtype'=>$vtype]);
    
        return $query->num_rows();
    }

	/*----------------------------- BOOKS -------------------------------*/


    /*----------------------------- TEACHERS -------------------------------*/

    function all_teachers_count()
    {
        $query = $this->db->get('teacher');
        return $query->num_rows();
    }

    function all_teachers($limit, $start, $col, $dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('teacher');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function teacher_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
                ->db
                ->like('teacher_id', $search)
                ->or_like('name', $search)
                ->or_like('email', $search)
                ->or_like('total_salary', $search)
                ->or_like('phone', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('teacher');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function teacher_search_count($search)
    {
        $query = $this
                ->db
                ->like('teacher_id', $search)
                ->or_like('name', $search)
                ->or_like('email', $search)
                ->or_like('phone', $search)
                ->get('teacher');
    
        return $query->num_rows();
    }

    /*----------------------------- TEACHERS -------------------------------*/


    /*----------------------------- PARENTS -------------------------------*/

    function all_parents_count()
    {
        $query = $this->db->get('parent');
        return $query->num_rows();
    }

    function all_parents($limit, $start, $col, $dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('parent');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function parent_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
                ->db
                ->like('parent_id', $search)
                ->or_like('name', $search)
                ->or_like('email', $search)
                ->or_like('phone', $search)
                ->or_like('mother_name', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('parent');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function parent_search_count($search)
    {
        $query = $this
                ->db
                ->like('parent_id', $search)
                ->or_like('name', $search)
                ->or_like('email', $search)
                ->or_like('phone', $search)
                ->or_like('mother_name', $search)
                ->get('parent');
    
        return $query->num_rows();
    }

    /*----------------------------- PARENTS -------------------------------*/

    /*----------------------------- EXPENSES -------------------------------*/

    function all_expenses_count()
    {
        $array = array('expense_category_id != '=>99999, 'payment_type' => 'expense', 'year' => get_settings('running_year'));
        $query = $this->db
                ->where($array)
                ->get('payment');
        return $query->num_rows();
    }

    function all_expenses($limit, $start, $col, $dir)
    {
        $array = array('expense_category_id != '=>99999, 'payment_type' => 'expense', 'year' => get_settings('running_year'));
        $query = $this
                ->db
                ->where($array)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('payment');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function expense_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
                ->db
                ->like('payment_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->where('expense_category_id !=', 99999)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('payment');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function expense_search_count($search)
    {
        $query = $this->db
                ->like('payment_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->where('expense_category_id !=', 99999)
                ->get('payment');
    
        return $query->num_rows();
    }

    /*----------------------------- EXPENSES -------------------------------*/


    /*----------------------------- INVOICES FOR TUITION -------------------------------*/

    function all_invoices_count2()
    {
        $array = array('year' => get_settings('running_year'), 'payment_type' => 2);
        $query = $this->db->where($array)->get('invoice');
        return $query->num_rows();
    }

    function all_invoices2($limit, $start, $col, $dir)
    {
        $array = array('year' => get_settings('running_year'), 'payment_type' => 2);
        $query = $this
                ->db
                ->where($array)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('invoice');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function invoice_search2($limit, $start, $search, $col, $dir)
    {
        $query = $this->db
                ->where('payment_type', '2')
                ->like('invoice_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->or_like('status', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('invoice');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function invoice_search_count2($search)
    {
        $query = $this->db
                ->where('payment_type', '2')
                ->like('invoice_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->or_like('status', $search)
                ->get('invoice');
    
        return $query->num_rows();
    }

    /*----------------------------- INVOICES FOR TUITION -------------------------------*/

    /*--------------------------- INVOICES for EXAM FEE -----------------------------*/

    function all_invoices_count1()
    {
        $array = array('year' => get_settings('running_year'), 'payment_type' => 1);
        $query = $this->db->where($array)->get('invoice');
        return $query->num_rows();
    }

    function all_invoices1($limit, $start, $col, $dir)
    {
        $array = array('year' => get_settings('running_year'), 'payment_type' => 1);
        $query = $this->db
            ->where($array)
            ->limit($limit,$start)
            ->order_by($col,$dir)
            ->get('invoice');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;

    }

    function invoice_search1($limit, $start, $search, $col, $dir)
    {
        $query = $this->db
            ->where('payment_type', 1)
            ->like('invoice_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->or_like('status', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('invoice');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function invoice_search_count1($search)
    {
        $query = $this->db
            ->where('payment_type', 1)
            ->like('invoice_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->or_like('status', $search)
            ->get('invoice');

        return $query->num_rows();
    }

    /*----------------------------- //INVOICES for EXAM FEE-----------------------------*/

    /*----------------------------- PAYMENTS -------------------------------*/

    function all_payments_count()
    {
        $array = array('payment_type' => 'income', 'year' => get_settings('running_year'));
        $query = $this
                ->db
                ->where($array)
                ->get('payment');
        return $query->num_rows();
    }

    function all_payments($limit, $start, $col, $dir)
    {
        $array = array('payment_type' => 'income', 'year' => get_settings('running_year'));
        $query = $this
                ->db
                ->where($array)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('payment');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
        
    }

    function payment_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
                ->db
                ->like('payment_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('payment');
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function payment_search_count($search)
    {
        $query = $this
                ->db
                ->like('payment_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->get('payment');
    
        return $query->num_rows();
    }

    /*----------------------------- PAYMENTS //08/09/2018-------------------------------*/

    function get_exam_payment_data()
    {
        $vtype = $this->session->userdata('vtype');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $query = $this->db
            ->select('exam_fees.ef_id, exam_fees.exam_fee, exam.name exam_name, class.name class_name')
            ->join('exam', 'exam.exam_id=exam_fees.exam_id')
            ->join('class', 'class.class_id=exam_fees.class_id')
            ->where('exam_fees.year', $running_year)
            ->where('exam.vtype', $vtype)
            ->where('class.vtype', $vtype)
            ->get('exam_fees');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }
    function get_tuition_payment_data()
    {
        $vtype = $this->session->userdata('vtype');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $query = $this->db
            ->select('tuition_fee_settings.id, tuition_fee_settings.tuition_fee, tuition_fee_settings.course_fee, class.name class_name, section.name section_name')
            ->join('class', 'class.class_id=tuition_fee_settings.class_id')
            ->join('section', 'section.section_id=tuition_fee_settings.section_id')
            ->where('tuition_fee_settings.year', $running_year)
            ->where('class.vtype', $vtype)
            ->get('tuition_fee_settings');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }
    function get_session_payment_data()
    {
        $vtype = $this->session->userdata('vtype');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $query = $this->db
            ->select('session_fee_settings.id, session_fee_settings.session_fee, class.name class_name')
            ->join('class', 'class.class_id=session_fee_settings.class_id')
            ->where('session_fee_settings.year', $running_year)
            ->where('class.vtype', $vtype)
            ->get('session_fee_settings');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }
    function get_dress_payment_data()
    {
        $vtype = $this->session->userdata('vtype');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $query = $this->db
            ->select('dress_fee_settings.id, dress_fee_settings.dress_fee, dress_fee_settings.batch_fee, class.name class_name')
            ->join('class', 'class.class_id=dress_fee_settings.class_id')
            ->where('dress_fee_settings.year', $running_year)
            ->where('class.vtype', $vtype)
            ->get('dress_fee_settings');

        if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }

}