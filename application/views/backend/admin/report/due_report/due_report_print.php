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
    table tbody tr td, table thead tr th {
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
            <h2>Student Due Report</h2>
            <table>
                <tr>
                    <th><h4>Class Name : <?= $class_name->name?></h4></th>
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
                        <th>Student Name</th>
                        <th>Student Parent Name</th>
                        <th>Student Roll</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sl = 0;
                $total_allStudent_due = 0;
                foreach ( $all_student_dueReport as $student_due_report) :
                $sl ++;
                    ?>
                    <tr>
                        <td> <?= $sl ?></td>
                        <td><?=$student_due_report->student_name?></td>
                        <td><?=$student_due_report->parent_name?></td>
                        <td><?=$student_due_report->roll?></td>
                        <?php
                        $student_due_tk= 0;
                        $all_student_due = get_studentDue_tk($student_due_report->student_id);
                        foreach ($all_student_due as $student_due){
                            $student_due_tk += ($student_due->amount + $student_due->discount);
                        }

                        $date = (int)date('m');
                        $payable_month = $date-1;
                        $total_due= $payable_month * $tuitionFeeByClass->tuition_fee - $student_due_tk;
                        $total_allStudent_due += $total_due;
                        ?>
                        <td><?=number_format($total_due,2)?></td>
                    </tr>
                <?php endforeach;?>
                    <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold">Total Due = </td>
                        <td><?= number_format($total_allStudent_due, 2)?></td>
                    </tr>
                </tbody>
            </table><br>
        </div>
        <br>
    </body>
</html>

