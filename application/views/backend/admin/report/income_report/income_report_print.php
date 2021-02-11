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
    <div class="container body_all">
        <div class="c_header">
            <div class="header_igm col-md-12">
                <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
            </div>
        </div>
        <div class="clar"></div>
        <div class="table_body">
            <h2>Income Report</h2>
            <table>
                <tr>
                    <th><h4>Class Name :  <?php if (!empty($class_name)){
                                echo $class_name->name;
                            }else { echo 'All Class';}?>
                            </h4></th>
                    <th style="text-align: right">
                        <h4>Section Name : <?php if (!empty($section_name)){
                                echo $section_name->name;
                            }else { echo 'All Section';}?></h4>
                    </th>
                </tr>
            </table>
            <br>
            <table border="1" class="total_GPA">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Payment Type</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <?php
                $CI = get_instance();
                $CI->load->model('report_model');
                $sl =0;
                $begin = new DateTime($from_date);
                $end = new DateTime(date("Y-m-d",strtotime($to_date) + 60*60*24));
                $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                //var_dump($daterange); exit();

                $tbl ='';
                $total_taka = 0;
                foreach($daterange as $date):
                    $c_date = $date->format("Y-m-d");
                    $exam_data = $CI->report_model->get_income_report(8,$c_date, $class_id, $section_id);
                    $tuition_data = $CI->report_model->get_income_report(2,$c_date, $class_id, $section_id);



                    if (empty($exam_data) && empty($tuition_data)){
                        continue;
                    }
//                    var_dump($exam_data);
//                    var_dump($tuition_data);
//                    echo ((!empty($exam_data)) && (!empty($tuition_data))) ? 'rowspan="2"' : 'else'; exit();

                    $sl++;
                    $tuition_fees_tk=0;
                    $exam_fees_tk=0;
                    foreach ($tuition_data as $tuitionFees){
                        $tuition_fees_tk += $tuitionFees->amount_paid;
                    }
                    foreach ($exam_data as $examFees){
                        $exam_fees_tk += $examFees->amount_paid;
                    }
                    $total_taka += ($tuition_fees_tk + $exam_fees_tk);
                ?>
                    <tr>
                        <td <?php echo ((!empty($exam_data)) && (!empty($tuition_data))) ? 'rowspan="2"' : ''; ?>><?= $sl?></td>
                        <td <?php echo ((!empty($exam_data)) && (!empty($tuition_data))) ? 'rowspan="2"' : ''; ?>><?= date('d/m/Y', strtotime($c_date))?></td>
                        <?php if (!empty($exam_data)):?>
                            <td>Admission Fee</td>
                            <td style="text-align: right"><?php echo number_format($exam_fees_tk, 2); ?></td>
                        <?php else: ?>
                                <td>Tuition Fee</td>
                                <td style="text-align: right"><?php echo number_format($tuition_fees_tk, 2); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php if (!empty($exam_data) && !empty($tuition_data)): ?>
                        <tr>
                            <td>Tuition Fee</td>
                            <td style="text-align: right"><?php echo number_format($tuition_fees_tk, 2); ?></td>
                        </tr>

                     <?php endif;?>
                <?php endforeach;?>
                <tr>
                    <th style="text-align: center;" colspan="3">Total </th>
                    <th style="text-align: right"><?= number_format($total_taka, 2)?></th>
                </tr>
            </table>
        </div>
        <br>
    </body>
</html>

