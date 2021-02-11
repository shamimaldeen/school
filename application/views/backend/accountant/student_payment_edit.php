<style>
    .clar{
        clear: both;
    }
</style>
<hr />
<?php echo form_open(site_url('accountant/invoice/do_update') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_self'));?>
<input type="hidden" name="root_id" value="<?php echo $root->id; ?>" hidden>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title text-center"><?php echo get_phrase('student_information');?></div>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Student');?></label>
                        <div class="col-sm-9">
                            <select name="student_id" id="student_id" class="form-control select2" onchange="get_payment_status(this.value);" required>
                                <option value=""><?php echo get_phrase('select');?></option>
                                <?php
                                foreach ($student_info as $student):
                                ?>
                                <option value="<?=$student->student_id?>" <?php echo ($student->student_id==$root->student_id) ? 'selected' : ''; ?>><?php echo $student->name.' - '.$student->student_code?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="clar"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Class');?></label>
                        <div class="col-sm-9">
                            <select name="class_id" class="form-control" style="width:100%;" id="class_id" required readonly="">
                                <?php echo $student_class; ?>
                            </select>
                        </div>
                        <div class="clar"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="datepicker form-control" name="date" value="<?=date('m/d/Y',strtotime($root->invoice_date))?>"
                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                        <div class="clar"></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?=$root->title?>" name="title"
                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                        <div class="clar"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description"  value="<?=$root->description?>" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-9">
                            <select name="method" class="form-control selectboxit">
                                <option value="1" <?= ($root->payment_method == 1) ? 'selected' : ''?> ><?php echo get_phrase('cash');?></option>
                                <option value="4" <?= ($root->payment_method == 4) ? 'selected' : ''?> ><?php echo get_phrase('agent_banking');?></option>
                                <option value="2" <?= ($root->payment_method == 2) ? 'selected' : ''?> ><?php echo get_phrase('check');?></option>
                                <option value="3" <?= ($root->payment_method == 3) ? 'selected' : ''?> ><?php echo get_phrase('card');?></option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<!--    <div class="col-md-6 top_student_info">-->
    </div>
    <br>
	<div class="col-md-12">
			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('tuition_fee_invoice');?></span>
					</a>
				</li>
				<li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('exam_fee_invoice');?></span>
					</a>
				</li>
                <li>
                    <a href="#session" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('session_fee_invoice');?></span>
                    </a>
                </li>
                <li>
                    <a href="#transport" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('transport_fee_invoice');?></span>
                    </a>
                </li>
                <li>
                    <a href="#dress" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('dress/Batch_fee_invoice');?></span>
                    </a>
                </li>
                <li>
                    <a href="#others" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('others_fee_invoice');?></span>
                    </a>
                </li>
			</ul>

			<div class="tab-content">
            <br>
				<div class="tab-pane active" id="unpaid">
                    <!-- creation of single invoice TUITION PAYMENT -->
                    <?php

                        function get_monthNameEdit($monthNum)
                        {
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            return $dateObj->format('F'); // March
                        }
                        $CI = get_instance();
                        $CI->load->model('Barcode_model');
                        $exam_pay           = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 1);
                        $tui_pay            = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 2);
                        $session_pay        = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 9);
                        $dress_pay          = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 10);
                        $books_pay          = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 4);
                        $copies_pay         = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 5);
                        $stationeries_pay   = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 6);
                        $other_pay          = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 7);
                        $trans_pay          = $CI->Barcode_model->get_studentSingleInvoiceData($root->id, 3);
//                        var_dump($other_pay); exit();
//                        dd($tuition);
                        //$tuition_id = $tuition->invoice_id;

                        $qu = $this->db->select('tuition_fee_settings.tuition_fee')
                            ->from('tuition_fee_settings')
                            ->join('enroll', 'enroll.class_id=tuition_fee_settings.class_id')
                            ->where('enroll.student_id', $root->student_id)
                            ->where('tuition_fee_settings.year', $year)
                            ->where('enroll.year', $year)
                            ->get();
                        $tuition  = $qu->row();
                        $tuitionFee = $tuition->tuition_fee;

                        $query = $this->db->select('month, invoice_id')
                            ->from('tuition_fee_collection')
                            ->where('student_id', $root->student_id)
                            ->where('year', $year)
                            ->get();
                        $month_arr = $query->result();


                    /*****************************Transport Fee Edit*****************************/
                    $trans = $this->db->select('transport.route_fare')
                        ->join('student', 'student.transport_id=transport.transport_id')
                        ->where('student.student_id', $root->student_id)
                        ->get('transport');
                    $transport = $trans->row();

                    $transport_coll= $this->db->select('month, invoice_id')
                        ->from('transport_fee_collection')
                        ->where('student_id', $root->student_id)
                        ->where('year', $year)
                        ->get();
                    $transport_arr = $transport_coll->result();

                    ?>
				<!-- creation of single invoice TUITION PAYMENT -->
				<div class="row">
	                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('tuition_payment');?></div>
                            </div>
                            <div class="panel-body">
                                <style>
                                    input[type="radio"], input[type="checkbox"]{
                                        width: 13px;
                                        float: left;
                                        margin-right: 5px;
                                    }
                                    .form-horizontal .form-group{
                                        margin-left:-4px
                                    }
                                </style>
                                <div id="monthly-tuition-data2">
                                    <?php echo $tuition_data; ?>
                                </div>

                                <div class="form-group" id="monthly-data">
                                        <?php
                                        $paid = 0;
                                        $html = "";
                                        for ($i=1; $i<=12; $i++)
                                        {
                                            $done = 0;
                                            foreach ($month_arr as $value)
                                            {
                                                if ($i == $value->month)
                                                {
                                                    if (empty($tui_pay)):
                                                        $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='month[]' id='".$value->month."' value='".$value->month."' class='form-control chk_month' checked><label class='control-label' for='".$value->month."' >".get_monthNameEdit($value->month)."</label></div>";
                                                    else:
                                                        $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='month[]' id='".$value->month."' value='".$value->month."' class='form-control chk_month' " . (($value->invoice_id == $tui_pay->invoice_id )? '' : 'disabled')." checked><label class='control-label' for='".$value->month."' >".get_monthNameEdit($value->month)."</label></div>";
                                                    endif;
                                                    $done = 1;
                                                    $paid++;
                                                }
                                            }
                                            if ($done == 0)
                                            {
                                                $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='month[]' id='".$i."' value='".$i."' class='form-control chk_month'><label class='control-label' for='".$i."'>".get_monthNameEdit($i)."</label></div>";
                                            }
                                        }
                                        echo $html;
                                        ?>
                                        <input type="hidden" id="tuitionFee" name="tuition_fee" value="<?php echo $tuitionFee; ?>">
                                        <!--                    <input type="hidden" id="invoice_id" name="invoice_id" value="--><?php //echo  $param2; ?><!--">-->
                                    <style>
                                        input[type="radio"], input[type="checkbox"]{
                                            width: 13px;
                                            float: left;
                                            margin-right: 5px;
                                        }
                                    </style>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="amount_paid_tuition" id="paid_tuition" onkeyup="return isNumber(event, this.value)"
                                            value="<?php echo (empty($tui_pay)) ? '' : $tui_pay->amount_paid; ?>" placeholder="<?php echo get_phrase('enter_payment_amount');?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?php echo (empty($tui_pay)) ? '0' : $tui_pay->discount; ?>" name="discount_tuition" onkeyup="return isNumber(event, this.value)" placeholder="<?php echo get_phrase('enter_discount');?>" />
                                    </div>
                                </div>
                                <?php echo (empty($tui_pay)) ? '' : '<input type="hidden" name="tui_id" value="'.$tui_pay->invoice_id.'">'; ?>
                            </div>
                        </div>
                    </div>

	                </div>

				<!-- creation of single invoice -->

				</div>
				<div class="tab-pane" id="paid">


				<!-- creation of mass invoice -->
                <div class="row">

                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('exam_payment');?></div>
                            </div>
                            <div class="form-group" id="exam-fee-data"></div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Exam Name</label>
                                    <div class="col-sm-9">
                                        <select name="exam_id" class="form-control selectboxit class_id_ex" onchange="get_exam_fees(this.value);" title="Select Exam">
                                            <option value=""><?php echo get_phrase('select_exam');?></option>
                                            <?php
                                            foreach ($exams as $exam):
                                                ?>
                                                <option value="<?php echo $exam['exam_id'];?>" <?php if (!empty($exam_pay)){
                                                    $collection = $CI->Barcode_model->get_examInfo_byInvoiceId($exam_pay->invoice_id);
                                                    echo ($collection->exam_id == $exam['exam_id']) ? '' : 'selected';
                                                }
                                                ?>><?php echo $exam['name'];?></option>
                                            <?php endforeach;?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('exam_fee');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="exam_fee" id="exam_fee" value="<?php if (!empty($exam_pay)){echo $exam_pay->amount;}?>" placeholder="<?php echo get_phrase('exam_fee');?>" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="amount_paid_exam" id="paid_exam" value="<?php if (!empty($exam_pay)){echo $exam_pay->amount_paid;}?>" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?php echo (empty($exam_pay)) ? '0' : $exam_pay->discount; ?>"  name="discount_exam" value="0" placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)" />
                                    </div>
                                </div>
                                <?php echo (empty($exam_pay)) ? '' : '<input type="hidden" name="exam_id_hidden" value="'.$exam_pay->invoice_id.'">'; ?>
                            </div>
                        </div>
                    </div>


                </div>
				<!-- creation of mass invoice -->

				</div>

                <!-- creation of session fee invoice -->
                <div class="tab-pane" id="session">


                    <!-- creation of mass invoice -->
                    <div class="row">

                        <div class="col-md-6">
                            <div class="panel panel-default panel-shadow" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo get_phrase('session_payment');?></div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group" id="session-fee-data">

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('session_fee');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="session_fee" id="session_fee" value="<?php if (!empty($session_pay)){ echo $session_pay->amount;}?>" placeholder="<?php echo get_phrase('session_fee');?>" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="amount_paid_session" id="paid_session" value="<?php if (!empty($session_pay)){ echo $session_pay->amount_paid;}?>" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="discount_session"  value="<?php if (!empty($session_pay)){ echo $session_pay->discount;} else{echo '0';}?>"  placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <?php echo (empty($session_pay)) ? '' : '<input type="hidden" name="sess_id" value="'.$session_pay->invoice_id.'">'; ?>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- creation of mass invoice -->

                </div>
                <!-- end of session fee -->
                <div class="tab-pane" id="transport">


                    <!-- creation of transport mass invoice -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default panel-shadow" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo get_phrase('transport_payment');?></div>
                                </div>
                                <div class="panel-body">

                                    <div id="monthly-transport-data2">
                                        <?php echo $transport_data; ?>
                                    </div>
                                    <div class="" id="transport_fare_info"></div>
                                    <div class="form-group" id="transport_monthly_data">

                                        <?php
                                        $paid = 0;
                                        $html = "";
                                        if (!empty($transport)):
                                            for ($i=1; $i<=12; $i++)
                                            {
                                                $done = 0;
                                                foreach ($transport_arr as $value)
                                                {
                                                    if ($i == $value->month)
                                                    {
                                                        if (empty($trans_pay)):
                                                            $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='tmonth[]' id='".$value->month."' value='".$value->month."' class='form-control chk_month' checked><label class='control-label' for='".$value->month."' >".get_monthName($value->month)."</label></div>";
                                                        else:
                                                            $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='tmonth[]' id='".$value->month."' value='".$value->month."' class='form-control chk_month' ".(($value->invoice_id == $trans_pay->invoice_id) ? '' : 'disabled')." checked><label class='control-label' for='".$value->month."' >".get_monthName($value->month)."</label></div>";
                                                        endif;
                                                        $done = 1;
                                                        $paid++;
                                                    }
                                                }
                                                if ($done == 0)
                                                {
                                                    $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='tmonth[]' id='".$i."' value='".$i."' class='form-control chk_month'><label class='control-label' for='".$i."'>".get_monthName($i)."</label></div>";
                                                }
                                            }
                                            echo $html;
                                            echo (empty($trans_pay)) ? '' : '<input type="hidden" name="trans_id" value="'.$trans_pay->invoice_id.'">';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="amount_paid_transport" value="<?php if (!empty($trans_pay)){ echo $trans_pay->amount_paid;}?>" id="paid_transport"
                                                   placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?php if (!empty($trans_pay)){ echo $trans_pay->discount;} else{ echo '0';}?>" name="discount_transport"
                                                   placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <?php echo (empty($transport)) ? '' : '<input type="hidden" name="route_fee" value="'.$transport->route_fare.'">'; ?>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- creation of transport invoice end -->

                </div>

                <div class="tab-pane" id="dress">


                    <!-- creation of dress/batch invoice -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default panel-shadow" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo get_phrase('dress/batch_payment');?></div>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Dress/Batch</label>
                                        <div class="col-sm-9">
                                            <select name="dress_id" class="form-control selectboxit class_id_db" onchange="get_batch_fees(this.value);" title="Select Dress/Batch">
                                                <option value=""><?php echo get_phrase('select_dress/batch');?></option>
                                                <option value="1"
                                                    <?php if ($dress_pay){
                                                        echo ($dress_pay->payment_type == 1) ? '' : 'selected';
                                                    }
                                                    ?>
                                                >Dress</option>
                                                <option value="2"
                                                    <?php if ($dress_pay){
                                                        echo ($dress_pay->payment_type == 2) ? '' : 'selected';
                                                    }
                                                    ?>
                                                >Batch</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group" id="dress-fee-data"></div>
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('dress/Batch_fee');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="dress_fee" id="batch_fee" value="<?php if (!empty($dress_pay)) { echo $dress_pay->amount;}?>" placeholder="<?php echo get_phrase('dress/Batch_fee');?>" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="amount_paid_dress" id="paid_dress" value="<?php if (!empty($dress_pay)) { echo $dress_pay->amount_paid;}?>" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="discount_dress"  value="<?php if (!empty($dress_pay)) { echo $dress_pay->discount;} else{echo '0';}?>" placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <?php echo (empty($dress_pay)) ? '' : '<input type="hidden" name="dress_id_hidden" value="'.$dress_pay->invoice_id.'">'; ?>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                <!-- end of dress/batch fee -->

                <div class="tab-pane" id="others">


                    <!-- others fee invoice start -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default panel-shadow" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo get_phrase('others_payment');?></div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Invoice Type</label>
                                        <div class="col-sm-9">
                                            <select name="others_name" class="form-control selectboxit others_name" id="others_id_dg" required data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                                                <option value=""> <?php echo get_phrase('select_invoice_type');?></option>
                                                <option value="4" <?php if(!empty($books_pay)){ echo($books_pay->payment_type == 4) ? 'selected' : ''; }?>>Books</option>
                                                <option value="5" <?php if(!empty($copies_pay)){ echo($copies_pay->payment_type == 5) ? 'selected' : ''; }?>>Copies</option>
                                                <option value="6" <?php if(!empty($stationeries_pay)){ echo($stationeries_pay->payment_type == 6) ? 'selected' : ''; }?>>Stationeries</option>
                                                <option value="7" <?php if(!empty($other_pay)){ echo($other_pay->payment_type == 7) ? 'selected' : ''; }?>>Others/Remarks</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Invoice Fee</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="invoice_fee"
                                                   value="<?php
                                                   if (!empty($books_pay)){
                                                       echo $books_pay->amount;
                                                   } elseif (!empty($copies_pay)){
                                                       echo $copies_pay->amount;
                                                   }elseif (!empty($stationeries_pay)){
                                                       echo $stationeries_pay->	amount;
                                                   }elseif (!empty($other_pay)){
                                                       echo $other_pay->amount;
                                                   }
                                                   ?>"
                                                   placeholder="<?php echo get_phrase('invoice_fee');?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="amount_paid_others" id="paid_others"
                                                   value="<?php
                                                   if (!empty($books_pay)){
                                                       echo $books_pay->amount_paid;
                                                   } elseif (!empty($copies_pay)){
                                                       echo $copies_pay->amount_paid;
                                                   }elseif (!empty($stationeries_pay)){
                                                       echo $stationeries_pay->amount_paid;
                                                   }elseif (!empty($other_pay)){
                                                       echo $other_pay->amount_paid;
                                                   }
                                                   ?>"
                                                   placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="<?php
                                                   if (!empty($books_pay)){
                                                       echo $books_pay->discount;
                                                   } elseif (!empty($copies_pay)){
                                                       echo $copies_pay->discount;
                                                   }elseif (!empty($stationeries_pay)){
                                                       echo $stationeries_pay->discount;
                                                   }elseif (!empty($other_pay)){
                                                       echo $other_pay->discount;
                                                   }else{
                                                       echo '0';
                                                   }
                                                   ?>"
                                                   name="discount_others" onkeyup="return isNumber(event, this.value)"
                                                   placeholder="<?php echo get_phrase('enter_discount');?>" />
                                        </div>
                                    </div>
                                    <?php
                                        if (!empty($books_pay)){
                                            echo '<input type="hidden" name="other_id" value="'.$books_pay->invoice_id.'">';
                                        } elseif (!empty($copies_pay)){
                                            echo '<input type="hidden" name="other_id" value="'.$copies_pay->invoice_id.'">';
                                        }elseif (!empty($stationeries_pay)){
                                            echo '<input type="hidden" name="other_id" value="'.$stationeries_pay->invoice_id.'">';
                                        }elseif (!empty($other_pay)){
                                            echo '<input type="hidden" name="other_id" value="'.$other_pay->invoice_id.'">';
                                        }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- creation of mass invoice -->
                </div>
			</div>
	</div>
    <div class="form-group">
        <div class="col-sm-5">
            <button type="submit" class="btn btn-info all_submit" id="save"><?php echo get_phrase('update_student_payment');?></button>
        </div>
    </div>
<?php echo form_close();?>
</div>

<script type="text/javascript">
    function get_payment_status(std_id) {
        if (std_id !== '') {
            //var cls_id = $("#class_id").val();
            $.ajax({
                url: '<?php echo site_url('admin/search_student_payment_status/');?>' + std_id,
                success: function(response)
                {
                    jQuery('#monthly-data').empty();
                    jQuery('#monthly-data').html(response);
                }
            });
            $.ajax({
                url: '<?php echo site_url('admin/search_student_transport_pay/');?>' + std_id,
                success: function(response)
                {
                    jQuery('#transport_monthly_data').html(response);
                }
            });
            var exam_id = $('.class_id_ex').val();
            if (exam_id != "") {
                $.ajax({
                    url: '<?php echo site_url('admin/get_exam_fee_data/');?>' + std_id + '/' + exam_id,
                    success: function (response) {
                        var data = response.split("|");
                        var fee = parseInt(data[1]);
                        var paid = parseInt(data[0]);
                        if (paid == 0 && fee == 0) {
                            jQuery('#exam_fee').val('');
                            jQuery("#exam-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set exam fee for the class!</h4>");
                        } else if (paid > 0 && fee > 0) {
                            var due = (fee - paid);
                            if (due > 0 && due < fee) {
                                jQuery("#exam-fee-data").html('');
                                jQuery("#exam-fee-data").html("<h4 style='color: green;padding-left: 20px;'>Paid: " + paid + "</h4>");
                                jQuery("#exam-fee-data").append("<h4 style='color: red;padding-left: 20px;'>Due: " + due + "</h4>");
                                jQuery('#exam_fee').val(due);
                            } else {
                                jQuery('#exam_fee').val('');
                                jQuery("#exam-fee-data").html('');
                                jQuery("#exam-fee-data").html("<h4 style='color: #24AA7A;padding-left: 20px;'>Already paid exam fee</h4>");
                            }

                        } else if (paid == 0 && fee > 0) {
                            jQuery("#exam-fee-data").html('');
                            jQuery('#exam_fee').val(fee);
                        }

                    }
                });
            }else{
                jQuery("#exam-fee-data").empty();
                jQuery('#exam_fee').val('');
            }


        }else{
            jQuery('#monthly-tuition-data2').empty();
            jQuery('#monthly-transport-data2').empty();
            jQuery('#monthly-data').empty();
            jQuery('#transport_monthly_data').empty();
            jQuery("#exam-fee-data").empty();
            jQuery("#dress-fee-data").empty();
            jQuery('#batch_fee').val('');
            jQuery('#session_fee').val('');
            jQuery("#session-fee-data").empty();
        }
    }
</script>
<script type="text/javascript">
    function search_student_transport_pay(std_id) {
        if (std_id !== '') {
            var transport_id = $(".transport_id").val();
            $.ajax({
                url: '<?php echo site_url('admin/search_student_transport_pay/');?>' + std_id,
                success: function(response)
                {
                    jQuery('#transport_monthly_data').html(response);
                }
            });
        }else {
            jQuery('#transport_monthly_data').empty();
        }
    }
</script>
<script type="text/javascript">
    function get_batch_fees(batch_id) {
        if (batch_id != '') {
            var cls_id = $("#class_id").val();
            $.ajax({
                url: '<?php echo site_url('admin/get_dress_fee_data/');?>' + cls_id + '/' + batch_id,
                success: function(response)
                {
                    //alert(response);
                    if (response==0){
                        jQuery("#dress-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set dress/batch fee for the class!</h4>");
                    } else {
                        jQuery("#dress-fee-data").html('');
                        jQuery('#batch_fee').val(response);
                    }
                }
            });
        }else {
            jQuery("#dress-fee-data").empty();
            jQuery('#batch_fee').val('');
        }
    }
</script>
<script type="text/javascript">
    $('#student_id').on('change', function() {
        // e.preventDefault();
        var student_id = $('#student_id'). val();
        $.ajax({
            url: '<?= site_url('admin/get_studentBy_class/')?>' + student_id,
            success: function(response)
            {
                $('#class_id').html(response);
            }
        });
    });
</script>
<?php
$session_data = explode('|', $session_data);
?>
<script>
    var fee = parseInt("<?php echo $session_data[1]; ?>");
    var paid = parseInt("<?php echo $session_data[0]; ?>");
    if (paid==0 && fee==0){
        jQuery('#session_fee').val('');
        jQuery("#session-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set session fee for the session/class!</h4>");
    }else if(paid>0 && fee>0)
    {
        var due = (fee - paid);
        if (due>0 && due < fee){
            jQuery("#session-fee-data").empty();
            jQuery("#session-fee-data").html("<h4 style='color: green;padding-left: 20px;'>Paid: " + paid +"</h4>");
            jQuery("#session-fee-data").append("<h4 style='color: red;padding-left: 20px;'>Due: " + due +"</h4>");
            jQuery('#session_fee').val(due);
        }else
        {
            jQuery('#session_fee').val('');
            jQuery("#session-fee-data").empty();
            jQuery("#session-fee-data").html("<h4 style='color: #24AA7A;padding-left: 20px;'>Already paid session fee</h4>");
        }

        //jQuery("#save-session").attr('disabled', false);

    }else if(paid==0 && fee>0)
    {
        jQuery("#session-fee-data").empty();
        jQuery('#session_fee').val(fee);
    }
</script>
<script type="text/javascript">
    $('#student_id').on('change', function() {
        //var class_id = $("#class_id").val();
        var student_id = $('#student_id').val();
        $.ajax({
            url: '<?php echo site_url('admin/get_session_fee_data/');?>' + student_id,
            success: function(response)
            {
                var data = response.split("|");
                var fee = parseInt(data[1]);
                var paid = parseInt(data[0]);
                if (paid==0 && fee==0){
                    jQuery('#session_fee').val('');
                    jQuery("#session-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set session fee for the session/class!</h4>");
                }else if(paid>0 && fee>0)
                {
                    var due = (fee - paid);
                    if (due>0 && due < fee){
                        jQuery("#session-fee-data").empty();
                        jQuery("#session-fee-data").html("<h4 style='color: green;padding-left: 20px;'>Paid: " + paid +"</h4>");
                        jQuery("#session-fee-data").append("<h4 style='color: red;padding-left: 20px;'>Due: " + due +"</h4>");
                        jQuery('#session_fee').val(due);
                    }else
                    {
                        jQuery('#session_fee').val('');
                        jQuery("#session-fee-data").empty();
                        jQuery("#session-fee-data").html("<h4 style='color: #24AA7A;padding-left: 20px;'>Already paid session fee</h4>");
                    }

                    //jQuery("#save-session").attr('disabled', false);

                }else if(paid==0 && fee>0)
                {
                    jQuery("#session-fee-data").empty();
                    jQuery('#session_fee').val(fee);
                }
            }
        });

        // Exam fee



    });
</script>
<?php
$exam_data = explode('|', $exam_data);
?>
<script>
    var fee = parseInt("<?php echo $exam_data[1]; ?>");
    var paid = parseInt("<?php echo $exam_data[0]; ?>");
    if (paid == 0 && fee == 0) {
        jQuery('#exam_fee').val('');
        jQuery("#exam-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set exam fee for the class!</h4>");
    } else if (paid > 0 && fee > 0) {
        var due = (fee - paid);
        if (due > 0 && due < fee) {
            jQuery("#exam-fee-data").empty();
            jQuery("#exam-fee-data").html("<h4 style='color: green;padding-left: 20px;'>Paid: " + paid + "</h4>");
            jQuery("#exam-fee-data").append("<h4 style='color: red;padding-left: 20px;'>Due: " + due + "</h4>");
            jQuery('#exam_fee').val(due);
        } else {
            jQuery('#exam_fee').val('');
            jQuery("#exam-fee-data").empty();
            jQuery("#exam-fee-data").html("<h4 style='color: #24AA7A;padding-left: 20px;'>Already paid exam fee</h4>");
        }

    } else if (paid == 0 && fee > 0) {
        jQuery("#exam-fee-data").empty();
        jQuery('#exam_fee').val(fee);
    }else{
        jQuery("#exam-fee-data").empty();
        jQuery('#exam_fee').val('');
    }

</script>
<script type="text/javascript">
    function get_exam_fees(exam_id) {
        var student_id = $('#student_id').val();
        // var exam_id = $('.class_id_ex').val();
        $.ajax({
            url: '<?php echo site_url('admin/get_exam_fee_data/');?>' + student_id + '/' + exam_id,
            success: function (response) {
                var data = response.split("|");
                var fee = parseInt(data[1]);
                var paid = parseInt(data[0]);
                if (paid == 0 && fee == 0) {
                    jQuery('#exam_fee').val('');
                    jQuery("#exam-fee-data").html("<h4 style='color: red;padding-left: 20px;'>Please set exam fee for the class!</h4>");
                } else if (paid > 0 && fee > 0) {
                    var due = (fee - paid);
                    if (due > 0 && due < fee) {
                        jQuery("#exam-fee-data").html('');
                        jQuery("#exam-fee-data").html("<h4 style='color: green;padding-left: 20px;'>Paid: " + paid + "</h4>");
                        jQuery("#exam-fee-data").append("<h4 style='color: red;padding-left: 20px;'>Due: " + due + "</h4>");
                        jQuery('#exam_fee').val(due);
                    } else {
                        jQuery('#exam_fee').val('');
                        jQuery("#exam-fee-data").html('');
                        jQuery("#exam-fee-data").html("<h4 style='color: #24AA7A;padding-left: 20px;'>Already paid exam fee</h4>");
                    }

                } else if (paid == 0 && fee > 0) {
                    jQuery("#exam-fee-data").html('');
                    jQuery('#exam_fee').val(fee);
                }

            }
        });
    }
</script>
<script>
    function isNumber(evt, value) {
        var ID = $(evt.target).attr("id");
        if (ID === 'paid_tuition' || ID === 'paid_exam' || ID === 'paid_session' || ID==='paid_transport' || ID==='paid_dress' || ID==='paid_others') {
            if (value>0) {
                $('.all_submit').removeAttr('disabled');
            }else{
                $('.all_submit').attr('disabled', 'disabled');
            }
        }
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 45 || charCode > 57)) || charCode == 47) {
            return false;
        }
        return true;
    }
</script>
