<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
</head>
<body>
<style>
    @page { sheet-size: A4-L; }
    .header_igm img{
        width: 150px;
    }
    .header_igm{
        text-align: center;
        font-size: 30px;
        margin-left: -24px;
        margin-top: 42px;
        font-weight: bold;
    }
    body{
        font-size: 13px;
    }

    .c_header{
        display: block;
    }
    .clar{
        clear: both;
    }
    /* color */
    body, table, tr, td, a, p, h1, h2, h3, h4, h5, h6 {
        color: #000;
    }
    table{
        width: 100%;
    }
    td, th {
        padding: 8px;
    }
    .table_body h2{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding: 0 !important;
    }
    .table_body p {
        text-align: center;
    }
</style>
<?php
$xam = array();
$xam_name = array();
foreach ($exams as $xm)
{
    $xam[] = $xm->exam_id;
    $xam_name[] = $xm->name;
}
$cnt = count($xam);
if ($cnt == 2){
    $xmid1 = $xam[1];
    $st_exam_name = $xam_name[1];
    $nd_exam_name = $xam_name[0];
    $xmid2 = $xam[0];
}elseif ($cnt == 1){
    $xmid1=$xam[0];
    $xmid2=null;
}else{
    $xmid1=null;
    $xmid2=null;
}
?>
<div class="container body_all">
    <div class="c_header">
        <div class="header_igm col-md-12">
            <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
        </div>
    </div>
    <div class="clar"></div>
    <div class="table_body">
        <h2>Tuition Fee Sheet - <?= date('Y')?></h2>
        <p>Class : <?=$class_name->name?></p>
        <p>Section : <?php if(!empty($section_name->name)){echo $section_name->name;}?><span style="margin-left: 40px">Shift : <?php if (!empty($shift_name)) {echo $shift_name;}?></span></p>
        <table border="1" class="total_GPA">
            <thead>
            <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Nick Name</th>
                <th>Ad. Fee</th>
                <th>Sess. Char</th>
                <th>Books</th>
                <th>Copies</th>
                <th>Sta.</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th><?php
                    if ($xmid1 != null) {
                        echo $st_exam_name;
                    }
                    ?></th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
                <th><?php
                    if ($xmid2 != null) {
                        echo $nd_exam_name;
                    }
                    ?></th>
            </tr>
            </thead>
            <tbody>
        <?php
        $sl =1;
        //echo count($xam).'  --- '. $xmid1.'   ===    '.$xmid2;
        //$xmid1=1; $xmid2=2;

        foreach ($all_student_info as $student_info):

                $ci = get_instance();
                $ci->load->model('report_model');
                $student_id             = $student_info->student_id;
                $admission_all_fee      = $ci->report_model->get_payment_fee($student_id,8);
                $session_all_fee        = $ci->report_model->get_payment_fee($student_id,9);
                $copies_all_fee         = $ci->report_model->get_payment_fee($student_id,5);
                $stationeries_all_fee   = $ci->report_model->get_payment_fee($student_id,6);
                $books_all_fee          = $ci->report_model->get_payment_fee($student_id,4);
                $tuition_fee_array      = $ci->report_model->get_tuition_fee($student_id);
                ?>

            <tr>
                <td><?= $sl++?></td>
                <td><?= $student_info->name ?></td>
                <td><?= $student_info->nick_name ?></td>
                <td>
                    <?php
                    $admission_fee      = 0;
                    foreach ($admission_all_fee as $admission){
                        $admission_fee += $admission->amount_paid;
                    }
                    if (!empty($admission_fee)) {echo number_format($admission_fee,0); };
                    ?>
                </td>
                <td>
                    <?php
                    $session_fee      = 0;
                    foreach ($session_all_fee as $session){
                        $session_fee += $session->amount_paid;
                    }
                    if (!empty($session_fee)) {echo number_format($session_fee,0); };
                    ?>
                </td>
           <?php
//                var_dump($tuition_fee_array); exit;
                $books_fee      = 0;
                foreach ($books_all_fee as $books){
                    $books_fee += $books->amount_paid;
                }
            ?>
                <td><?php if (!empty($books_fee)) {echo number_format($books_fee,0); }?></td>
                <td>
                    <?php
                    $copies_fee =0;
                    foreach ($copies_all_fee as $copies){
                        $copies_fee += $copies->amount_paid;
                    }
                    if (!empty($copies_fee)){echo number_format($copies_fee,0);};
                    ?>
                </td>
                <td>
                    <?php
                    $stationeries_fee = 0;
                    foreach ($stationeries_all_fee as $stationeries){
                        $stationeries_fee += $stationeries->amount_paid;
                    }
                    if (!empty($stationeries_fee)) {echo number_format($stationeries_fee,0);}
                    ?>
                </td>
                <?php
                for ($i = 1; $i <= 6; $i++):
                    $key = array_search($i, array_column($tuition_fee_array, 'month'));
                    if ($key != "" || $key===0) {
                ?>
                    <td><?= number_format($tuition_fee_array[$key]['amount'],0); ?></td>


                <?php
                    }else{
                        echo '<td></td>';
                    }
                endfor;
                if ($xmid1 != null) {
                    $exam_fee1 = $ci->report_model->get_exam_fee($student_id, $xmid1);
                    //var_dump($exam_fee1);exit();
                    if ($exam_fee1){
                        echo '<td>'.number_format($exam_fee1->paid_amount,0).'</td>';
                    }else{
                        echo '<td></td>';
                    }
                }else{
                    echo '<td></td>';
                }
                for ($s = 7; $s <= 12; $s++):
                    $key = array_search($s, array_column($tuition_fee_array, 'month'));
                    if ($key != "" || $key===0) {
                        ?>
                        <td><?= number_format($tuition_fee_array[$key]['amount'],0); ?></td>


                        <?php
                    }else{
                        echo '<td></td>';
                    }
                endfor;
                if ($xmid2 != null) {
                    $exam_fee2 = $ci->report_model->get_exam_fee($student_id, $xmid2);
                    if ($exam_fee2){
                        echo '<td>'.number_format($exam_fee2->paid_amount,0).'</td>';
                    }else{
                        echo '<td></td>';
                    }
                }else{
                    echo '<td></td>';
                }
                ?>
            </tr>
        <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <br>
</body>
</html>

