<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title>Student Status Print</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">

    <script src="<?php echo base_url('assets/js/jquery-1.11.0.min.js');?>"></script>

    <!--[endif]-->

    <script>
        function checkDelete()
        {
            var chk=confirm("Are You Sure To Delete This !");
            if(chk)
            {
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</head>
    <body>
<style>
    .header_igm img{
        width: 150px;
    }
    .header_igm{
        text-align: center;
        font-size: 30px;
        margin-left: -24px;
        margin-top: 42px;
        font-weight: bold;
        color: #000;
    }
    .c_body h2{
        color: #000;
        text-align: center;
        font-size: 18px
        font-weight: bold;
    }
    body{
        font-size: 13px;
        color: #000;
    }
    .student_photo{
        width: 100px;
        height: 115px;
        display:block;
        float: right;
        background-size: cover;
        text-align: right;
        background: url("<?php echo $this->crud_model->get_image_url('student', $student_id) ;?>");
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        border-radius: 20px;
        line-height: 180px;
        margin: 15px;
        margin-top: 10px;
        border: 1px solid #000;
        ;
    }
    .table_body{
        color: #000;
        margin-top: -155px;
    }
    .table_body h2{
        text-align: center;
        display: block;
        font-weight: bold;
        font-size: 18px;
        color: #000;
    }
    .table_body h3{
        display: block;
        font-weight: bold;
        text-align: right;
        font-size: 16px;
        color: #000;
        margin-right: 80px;
    }
    .c_header{
        display: block;
    }
    .subject{
        display: block;
        margin-top: 40px;
    }
    table tr td {
        padding: 5px;
    }

    table tr th {
        padding: 5px;
        text-align: center;
    }
    .student_photo img{
        width: 100%;
        height: 100%;
        border-radius: 20px;
        padding: 5px;
        border: 1px solid #000;
    }
    .clar{
        clear: both;
    }
    .admit_border{
        width: 100%;
        border-bottom: 1px dotted #000;
    }
    .student_info tr td{
        text-align: center;
    }
</style>
    <div class="container body_all">
        <div class="c_header">
            <div class="header_igm col-md-12">
                <img src="<?php echo base_url('uploads/large_logo.png') ?>" alt=""> <?php //echo get_settings('system_name'); ?>
            </div>
        </div><br>
        <div class="student_photo" style="display: inline-block">
<!--            <img src="--><?php //echo $this->crud_model->get_image_url('student', $student_id) ;?><!--" alt=""/>-->
        </div>
        <div class="clar"></div>
        <div class="table_body">
            <h2>Student Present Status</h2>
            <b>Present information</b>

                <table style="border-bottom: 3px solid #000; width: 100%;">
                    <tr>
                        <td><h2 style="font-size: 20px; color: #000">Student Name</h2></td>
                        <td><h2 style="font-size: 20px; color: #000">: <?=$studentinfo->student_name?></h2></td>
                    </tr>
                    <tr>
                        <td>Father's name</td>
                        <td>: <?=$studentinfo->parent_name?></td>
                    </tr>
                    <tr>
                        <td>Mother's Name</td>
                        <td>: <?=$studentinfo->mother_name?></td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td>: <?=$studentinfo->phone?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: <?=$studentinfo->address?></td>
                    </tr>
                </table>
                <table style="border-bottom: 3px solid #000; width: 100%" border="1"  class="student_info">
                    <tr>
                        <td colspan="8" style="text-align: center"><b>Academic Information</b></td>
<!--                        <td></td>-->
<!--                        <td></td>-->
<!--                        <td></td>-->
<!--                        <td></td>-->
<!--                        <td></td>-->
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Shift</th>
                        <th>Roll Number</th>
                        <th>Admission Date</th>
                        <th>Schooling days</th>
                        <th>Present days</th>
                    </tr>
                    <tr>
                        <td><?=$studentinfo->student_code?></td>
                        <td><?=$className->name?></td>
                        <td><?=$section->name?></td>
                        <td><?=$studentinfo->shift?></td>
                        <td><?=$student_roll->roll?></td>
                        <td><?=$studentinfo->admission_date?></td>
                        <td><?=$schoolingDay ?></td>
                        <td><?=$studentAttand?></td>
                    </tr>

                </table> <br>
                <?php
//                $discount =0;
//                $tuition_pay_amount = 0;
//                foreach ($student_account_info as $account){
//                    $tuition_pay_amount += $account->amount;
//                    $discount += $account->discount;
//                }
//                $date = (int)date('m');
//                $payable_month = $date-1;
//                $tuition_dues = $manthly_t_fees->tuition_fee * $payable_month-$tuition_pay_amount-$discount;
//

                // Tuition Fee
                $tuition_discount =0;
                $paid_tuition = 0;
                $due_tuition = 0;
                foreach ($all_tuition_fee as $tuition_fee){
                    $paid_tuition       = $tuition_fee->paid_amount;
                    $tuition_discount   = $tuition_fee->total_discount;
                    $due_transport      = $tuition_fee->total_due;
                }
                $date_tuition = (int)date('m');
                $payable_month_tuition = $date_tuition-1;
                $tuition_all_fee = $payable_month_tuition * $manthly_t_fees->tuition_fee;
                $tuition_dues = $tuition_all_fee - $paid_tuition - $tuition_discount;

                // Transport Fee
                $transport_discount =0;
                $transport_pay_amount = 0;
                $due_transport = 0;
                foreach ($all_transport_fee as $transport){
                    $transport_pay_amount   = $transport->paid_amount;
                    $transport_discount     = $transport->total_discount;
                    $due_transport          = $transport->total_due;

                }
                $date_transport = (int)date('m');
                $payable_month_trans = $date_transport-1;
                if (!empty($transport_fees_s)){
                    $transport_all_fee = $payable_month_trans * $transport_fees_s->route_fare;
                    $tuition_dues = $transport_fees_s->route_fare * $payable_month_trans - $transport_pay_amount - $transport_discount;
                }else{
                    $transport_all_fee= '';
                    $tuition_dues= '';
                }

//                Session Fee;
                $paid_session = 0;
                $total_session = 0;
                $total_due = 0;
                foreach ($all_session_fee as $session_fee){
                    $paid_session = $session_fee->paid_amount;
                    $total_session = $session_fee->total_amount;
                    $total_due = $session_fee->total_due;
                }

          //  Addmission Fee;
                $total_Addmission = 0;
                $paid_Addmission = 0;
                $Addmission_due = 0;
            foreach ($all_admission_fee as $admission_fee){
                $total_Addmission = $admission_fee->total_amount;
                $paid_Addmission = $admission_fee->paid_amount;
                $Addmission_due = $admission_fee->total_due;
            }
                //  exam Fee;
                $total_exam = 0;
                $paid_exam = 0;
                $due_exam = 0;
                foreach ($all_exam_fee as $exam_fee){
                    $total_exam = $exam_fee->total_amount;
                    $paid_exam = $exam_fee->paid_amount;
                    $due_exam = $exam_fee->total_due;
                }
                //  dress Fee;
                $total_dress = 0;
                $paid_dress = 0;
                $due_dress = 0;
                foreach ($all_dress_fee as $dress_fee){
                    $total_dress = $dress_fee->total_amount;
                    $paid_dress = $dress_fee->paid_amount;
                    $due_dress = $dress_fee->total_due;
                }
                //  Books Fee;
                $total_book = 0;
                $paid_book = 0;
                $due_book = 0;
                foreach ($all_books_fee as $book_fee){
                    $total_book = $book_fee->total_amount;
                    $paid_book = $book_fee->paid_amount;
                    $due_book = $book_fee->total_due;
                }
                //  Books Fee;
                $total_copies = 0;
                $paid_copies = 0;
                $due_copies = 0;
                foreach ($all_copies_fee as $copies_fee){
                    $total_copies = $copies_fee->total_amount;
                    $paid_copies = $copies_fee->paid_amount;
                    $due_copies = $copies_fee->total_due;
                }
                //  Books Fee;
                $total_stationeries = 0;
                $paid_stationeries = 0;
                $due_stationeries = 0;
                foreach ($all_stationeries_fee as $stationeries_fee){
                    $total_stationeries = $stationeries_fee->total_amount;
                    $paid_stationeries = $stationeries_fee->paid_amount;
                    $due_stationeries = $stationeries_fee->total_due;
                }
                //  Others & remarks Fee;
                $total_remark = 0;
                $paid_remark = 0;
                $due_remark = 0;
                foreach ($others_remarks_fee as $remark_fee){
                    $total_remark = $remark_fee->total_amount;
                    $paid_remark = $remark_fee->paid_amount;
                    $due_remark = $remark_fee->total_due;
                }

            ?>
                <table style="border-bottom: 3px solid #000; width: 100%" border="1">
                    <tr>
                        <th colspan="4" class="text-center">Student Payment Information</th>
                    </tr>
                    <tr>
                        <th>Type of Payment</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Dues</th>
                    </tr>
                    <tr>
                        <td>Tuition Fee</td>
                        <td class="text-center"><?Php echo (!empty($tuition_all_fee)? number_format($tuition_all_fee,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_tuition && 0 < $paid_tuition)? number_format($paid_tuition, 2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($tuition_dues && 0 < $tuition_dues)? number_format($tuition_dues, 2) : '')?></td>
                    </tr>
                    <tr>
                        <td>Exam Fee</td>
                        <td class="text-center"><?Php echo (!empty($total_exam && 0 <$total_exam)? $total_exam : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_exam && 0 < $paid_exam)? $paid_exam : '')?></td>
                        <td class="text-center"><?Php echo (!empty($due_exam) && 0 < $due_exam ? $due_exam : '')?></td>
                    </tr>
                    <tr>
                        <td>Session Fee</td>
                        <td class="text-center"><?Php echo (!empty($total_session && 0 <$total_session)? $total_session : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_session && 0 < $paid_session)? $paid_session : '')?></td>
                        <td class="text-center"><?Php echo (!empty($total_due) && 0 < $total_due ? $total_due : '')?></td>
                    </tr>
                    <tr>
                        <td>Admission Fee</td>
                        <td class="text-center"><?Php echo (!empty($total_Addmission && 0 <$total_Addmission)? $total_Addmission : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_Addmission && 0 < $paid_Addmission)? $paid_Addmission : '')?></td>
                        <td class="text-center"><?Php echo (!empty($Addmission_due) && 0 < $Addmission_due ? $Addmission_due : '')?></td>
                    </tr>
                    <tr>
                        <td>Transport Fee</td>
                        <td class="text-center"><?Php echo (!empty($transport_all_fee)? number_format($transport_all_fee,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($transport_pay_amount && 0 < $transport_pay_amount)? number_format($transport_pay_amount, 2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($tuition_dues) && 0 < $tuition_dues ? number_format($tuition_dues, 0) : '')?></td>
                    </tr>
                    <tr>
                        <td>Dress/Batch Fee</td>
                        <td class="text-center"><?Php echo (!empty($total_dress && 0 <$total_dress)? number_format($total_dress,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_dress && 0 < $paid_dress)? number_format($paid_dress,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($due_dress) && 0 < $due_dress ? number_format($due_dress, 2) : '')?></td>
                    </tr>
                    <?php if (!empty($all_books_fee)):?>
                    <tr>
                        <td>Books Fee</td>
                        <td class="text-center"><?Php echo (!empty($total_book && 0 <$total_book)? number_format($total_book,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($paid_book && 0 < $paid_book)? number_format($paid_book,2) : '')?></td>
                        <td class="text-center"><?Php echo (!empty($due_book) && 0 < $due_book ? number_format($due_book, 2) : '')?></td>
                    </tr>
                    <?php endif;?>
                    <?php if (!empty($all_copies_fee)):?>
                        <tr>
                            <td>Copies Fee</td>
                            <td class="text-center"><?Php echo (!empty($total_copies && 0 <$total_copies)? number_format($total_copies, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($paid_copies && 0 < $paid_copies)? number_format($paid_copies, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($due_copies) && 0 < $due_copies ? number_format($due_copies, 2) : '')?></td>
                        </tr>
                    <?php endif;?>
                    <?php if (!empty($all_stationeries_fee)):?>
                        <tr>
                            <td>Stationery's Fee</td>
                            <td class="text-center"><?Php echo (!empty($total_stationeries && 0 <$total_stationeries)? number_format($total_stationeries, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($paid_stationeries && 0 < $paid_stationeries)? number_format($paid_stationeries, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($due_stationeries) && 0 < $due_stationeries ? number_format($due_stationeries, 2) : '')?></td>
                        </tr>
                    <?php endif;?>
                    <?php if (!empty($others_remarks_fee)):?>
                        <tr>
                            <td>Others/Remarks Fee</td>
                            <td class="text-center"><?Php echo (!empty($total_remark && 0 <$total_remark)? number_format($total_remark, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($paid_remark && 0 < $paid_remark)? number_format($paid_remark, 2) : '')?></td>
                            <td class="text-center"><?Php echo (!empty($due_remark) && 0 < $due_remark ? number_format($due_remark, 2) : '')?></td>
                        </tr>
                    <?php endif;?>
                </table>


            <p style="text-align: right; font-size: 10px;"><i>Report generated on <?php echo date('d M Y, H:i a')?></i></p>
            <table style="width: 100%; margin-top: 80px">
                <tr>
                    <td style="text-align: left"> Accountant</td>
                    <td style="text-align: right"> Head of institute</td>
                </tr>
            </table>
        </div>
        <br>
    </body>
</html>