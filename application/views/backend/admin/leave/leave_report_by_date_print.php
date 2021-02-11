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
    .table_body h6{
        text-align: center;
        font-size: 13px;
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
        <div class="clear"></div>
        <div class="table_body">
            <h2>Employee Leave Report</h2>
            <h6>Date From <?= date('d/m/Y', strtotime($from_date)) ?> - Date To <?= date('d/m/Y', strtotime($to_date)) ?></h6>
            <table border="1" class="total_GPA">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th>Leave Type</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Leave Count</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                $sl =1;
                foreach($leave_list as $row):?>
                    <tr>
                        <td><?= $sl++;?></td>
                        <td><?php echo $row->emp_name;?></td>
                        <td><?php echo $row->designation;?></td>
                        <td><?php echo get_leaveNameById($row->leave_id);?></td>
                        <td><?php echo date('d/m/Y', strtotime($row->from_date));?></td>
                        <td><?php echo date('d/m/Y', strtotime($row->to_date));?></td>
                        <td><?php echo $row->leavecount;?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <br>
    </body>
</html>

