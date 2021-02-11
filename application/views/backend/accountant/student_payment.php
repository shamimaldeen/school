<style>
    .clar{
        clear: both;
    }
</style>
<hr />
<?php echo form_open(site_url('admin/invoice/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_self'));?>
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
                                    <option value="<?=$student->student_id?>"><?php echo $student->name.' - '.$student->student_code?></option>
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
                                <option value=""><?php echo get_phrase('select_student_first');?></option>
                            </select>
                        </div>
                        <div class="clar"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="datepicker form-control" name="date"
                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                        <div class="clar"></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title"
                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                        <div class="clar"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-9">
                            <select name="method" class="form-control selectboxit">
                                <option value="1"><?php echo get_phrase('cash');?></option>
                                <option value="4"><?php echo get_phrase('agent_banking');?></option>
                                <option value="2"><?php echo get_phrase('check');?></option>
                                <option value="3"><?php echo get_phrase('card');?></option>
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
            <!-- creation of single invoice -->
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
                            </style>

                            <div class="form-group" id="section-data"></div>
                            <div class="form-group" id="monthly-data"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_tuition" id="paid_tuition" onkeyup="return isNumber(event, this.value)"
                                           placeholder="<?php echo get_phrase('enter_payment_amount');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="0" name="discount_tuition" onkeyup="return isNumber(event, this.value)"
                                           placeholder="<?php echo get_phrase('enter_discount');?>" />
                                </div>
                            </div>
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
                                            <option value="<?php echo $exam['exam_id'];?>"><?php echo $exam['name'];?></option>
                                        <?php endforeach;?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('exam_fee');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="exam_fee" id="exam_fee" placeholder="<?php echo get_phrase('exam_fee');?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_exam" id="paid_exam" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" vocab="0" name="discount_exam" value="0" placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)" />
                                </div>
                            </div>

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
                            <div class="form-group" id="session-fee-data"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('session_fee');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="session_fee" id="session_fee" placeholder="<?php echo get_phrase('session_fee');?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_session" id="paid_session" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="discount_session"  value="0" placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>

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
                            <style>
                                input[type="radio"], input[type="checkbox"]{
                                    width: 13px;
                                    float: left;
                                    margin-right: 5px;
                                }
                            </style>

                            <div class="form-group" id="transport_fare_info"></div>
                            <div class="form-group" id="transport_monthly_data"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_transport" id="paid_transport"
                                           placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="0" name="discount_transport"
                                           placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
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
                                        <option value="1">Dress</option>
                                        <option value="2">Batch</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group" id="dress-fee-data"></div>
                                <label class="col-sm-3 control-label"><?php echo get_phrase('dress/Batch_fee');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="dress_fee" id="batch_fee" placeholder="<?php echo get_phrase('dress/Batch_fee');?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_dress" id="paid_dress" placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="discount_dress"  value="0" placeholder="<?php echo get_phrase('enter_discount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
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
                                        <option value=""><?php echo get_phrase('select_invoice_type');?></option>
                                        <option value="4">Books</option>
                                        <option value="5">Copies</option>
                                        <option value="6">Stationeries</option>
                                        <option value="7">Others/Remarks</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Invoice Fee</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="invoice_fee"
                                           placeholder="<?php echo get_phrase('invoice_fee');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount_paid_others" id="paid_others"
                                           placeholder="<?php echo get_phrase('enter_payment_amount');?>" onkeyup="return isNumber(event, this.value)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="0" name="discount_others" onkeyup="return isNumber(event, this.value)"
                                           placeholder="<?php echo get_phrase('enter_discount');?>" />
                                </div>
                            </div>
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
        <button type="submit" class="btn btn-info all_submit" id="save"><?php echo get_phrase('save_student_payment');?></button>
    </div>
</div>
<?php echo form_close();?>
</div>


<script type="text/javascript">
    function get_payment_status(std_id) {
        if (std_id !== '') {
            //var cls_id = $("#class_id").val();
            $.ajax({
                url: '<?php echo site_url('admin/get_student_enrolled_section/');?>' + std_id,
                success: function(response)
                {
                    jQuery('#section-data').empty();
                    jQuery('#section-data').html(response);
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
            jQuery('#monthly-data').empty();
            jQuery('#transport_monthly_data').empty();
            jQuery("#exam-fee-data").empty();
            jQuery("#dress-fee-data").empty();
            jQuery('#batch_fee').val('');
            jQuery('#session_fee').val('');
            jQuery("#session-fee-data").empty();
        }
    }
    function getTuitionFeeViewData(sec_id) {
        $.ajax({
            url: '<?php echo site_url('admin/search_student_payment_status/');?>' + sec_id + '/'+ std_id,
            success: function(response)
            {
                jQuery('#monthly-data').empty();
                jQuery('#monthly-data').html(response);
        });
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
                    if (response==0) {
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
    $('#student_id').on('change', function () {
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


<script type="text/javascript">
    var class_id = '';
    jQuery(document).ready(function($) {
        $('.all_submit').attr('disabled', 'disabled');
    });

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
<!-- invoice Print Page -->
<?php
if (isset($param1)):
    $invoice = $this->db->get_where('student_payment_invoices', array('invoice_no' => $param1))->row();
    if(!empty($invoice)):
        $root_id = $invoice->id;
        $student_id = $invoice->student_id;
        $rows = $this->db->get_where('invoice', array('root_id' => $root_id))->result();
        ?>
        <style>
            .table_body tr td, .table_body th {
                padding: 5px;
            }
            .table_body th {
                background-color: #dbdbdd;
            }
            .clr{
                clear: both;
            }
        </style>
        <style type="text/css" media="print">
            @page { size: portrait; }
        </style>
        <?php
        $class_id = $this->db->get_where('enroll' , array(
            'student_id' => $student_id,
            'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
        ))->row()->class_id;?>
        <div id="print-layout" style="display: none;">
            <div id="invoice_print">
                <div class="header_igm col-md-12">
                    <table width="100%" border="0" style="text-align: center">
                        <tr>
                            <td>
                                <img style="text-align: center!important; display: inline-block !important;; margin: 0 auto" width="300" src="<?php echo base_url('uploads/large_logo.png') ?>" alt="">
                                <br>
                                <br>
                            </td>
                        </tr>
                    </table>
                    <p style="float: right; display: inline-block">Receipt No : <?=$invoice->invoice_no?></p><br><br>
                    <div class="clr"></div>
                    <p style="float: right; display: inline-block; margin-right: 0">Date :  <span style="border: 1px solid #000; padding: 5px; "> <?php echo date('d / M / Y', strtotime($invoice->created_at));?></span></p><br>
                    <table width="100%">
                        <tr>
                            <td colspan="3"><p>Name : <?= $this->db->get_where('student', array('student_id' => $student_id))->row()->name;?></p> </td>
                        </tr>

                        <tr>
                            <td><p>Class : <?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name?></p></td>
                            <td><p>Section : <?= $this->db->get_where('section', array('class_id' => $class_id))->row()->name?></p></td>
                            <td><p style="text-align: right">School ID No : <?= $this->db->get_where('student', array('student_id' => $student_id))->row()->student_code;?></p></td>
                        </tr>
                    </table>
                    <table width="100%"  style="border-collapse:collapse;"class="table_body table table-bordered" border="1">
                        <tr>
                            <th width="8%" style="padding: 5px;">Sl</th>
                            <th width="70%">Particulars</th>
                            <th width="17%">Amount</th>
                        </tr>
                        <?php
                        $total_amount= 0;
                        $sl =1;
                        foreach ($rows as $row):
                            ?>
                            <tr>
                                <td style="text-align: center; padding: 5px"><?= $sl++?></td>
                                <td style="padding: 5px"><?php echo $row->title;?></td>
                                <td style="text-align: right; padding: 5px"><?php echo number_format($row->amount_paid,2);
                                    $total_amount += $row->amount_paid;
                                    ?></td>
                            </tr>
                        <?php endforeach;?>
                        <tr>
                            <td colspan="2" style="text-align: center; font-weight: bold"> Total</td>
                            <td style="text-align: right"><?php echo number_format($total_amount,2); ?></td>
                        </tr>

                        <br>
                    </table>
                    <b style="text-transform: capitalize; margin-top: 30px"> Taka In Words : <?php echo convertNumber($total_amount.'.00') ?> tk Only </b>
                </div>

                <!-- payment history -->
                <table width="100%" style="margin-top: 50px">
                    <tr>
                        <?php
                        $all_signature = $this->db->get('designation')->result();
                        $count= 0;
                        $i = 0;
                        $right = count($all_signature);
                        foreach ($all_signature as $signature):
                            $count++;
                            ?>
                            <td class="text_align" style="font-size: 10px; text-align: <?php if ($count == 1){echo 'left';} elseif ($i == $right -1){'right!important;';} else{ echo 'center';}
                            ?>"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$signature->name.'</span> <br style="border-top: 0 !important; text-align: center">'.$signature->designation?> <br><p> </p></td>
                        <?php endforeach;?>
                    </tr>
                </table>

            </div>
        </div>

        <script>

            // function myFunction(id='invoice_print') {
            //     var printContents = document.getElementById(id).innerHTML;
            //     var originalContents = document.body.innerHTML;
            //     document.body.innerHTML = printContents;
            //     window.print();
            //     document.body.innerHTML = originalContents;
            //     return window.location.reload(true);
            // }()

            var data=document.getElementById('invoice_print').innerHTML;

            var myWindow = window.open('', 'Print', 'height=400,width=500');
            //myWindow.document.write('<html><head><title>CFC Daily Sell Print</title>');
            /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
            myWindow.document.write('</head><body >');
            myWindow.document.write(data);
            myWindow.document.write('</body></html>');
            myWindow.document.close();
            myWindow.onload = init;
            function init() {
                var objBrowse = window.navigator;
                if (objBrowse.appName == 'Chrome') {
                    setTimeout('myWindow.print()', 1000);
                    myWindow.focus();

                    if (myWindow.print()) {
                        return false;
                    } else {
                        location.reload();
                    }
                    //myWindow.print();
                    myWindow.close();
                }
                else {
                    myWindow.focus();
                    myWindow.print();
                    myWindow.close();
                }
            }

        </script>
    <?php endif;
endif; ?>