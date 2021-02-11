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
            <h2>Expense Report</h2>
            <br>
            <table border="1" class="total_GPA">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $CI = get_instance();
                $CI->load->model('report_model');
                $begin = new DateTime($from_date);
                $end = new DateTime(date("Y-m-d",strtotime($to_date) + 60*60*24));
                $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                $sl =1;
                $total_expense_tk = 0;
                foreach ($daterange as $date) :
                    $c_date = $date->format("Y-m-d");
                    $expense_data = $CI->report_model->get_expense_report_by_date($c_date);
                    if (empty($expense_data)){
                        continue;
                    }

                    $expense_taka = 0;
                    foreach ($expense_data as $expense_date):?>
                        <tr>
                            <td><?= $sl++;?></td>
                            <td><?= date('d/m/Y', strtotime($c_date))?></td>
                            <td style="text-align: right"><?=number_format($expense_date->amount, 2)?></td>
                        </tr>
                    <?php
                        $total_expense_tk += $expense_date->amount;
                    endforeach;
                    ?>
<!--                    <tr>-->
<!--                        <td>--><?//= $sl++;?><!--</td>-->
<!--                        <td>--><?//= date('d/m/Y', strtotime($c_date))?><!--</td>-->
<!--                        <td></td>-->
<!--                        <td style="text-align: right">--><?//=number_format($expense_taka, 2)?><!--</td>-->
<!--                    </tr>-->
                <?php endforeach;?>
                </tbody>
                <tr>
                    <th style="text-align: center;" colspan="2">Total Taka = </th>
                    <th style="text-align: right"><?=number_format($total_expense_tk, 2)?></th>
                </tr>
            </table>
        </div>
        <br>
    </body>
</html>

