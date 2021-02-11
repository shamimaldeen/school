<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
    <head>
        <title>Guest Student</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
    <style>
        @page { sheet-size: A4; }
        .c_header{
            text-align: center;
            height: 100px;
        }
        .header_igm{

        }
        .header_igm img{
            width: 150px;
        }
        .header_igm{
            text-align: center;
            font-size: 28px;
            margin-left: -30px;
            margin-top: 35px;
            font-weight: bold;
            color: #000;
        }
        .c_body{
            color: #000;
            text-align: justify;
            position: relative;
            z-index: 1;
        }
        .c_body p{
            opacity: 1;
        }
        .c_body h2{
            color: #000;
            text-align: center;
            font-size: 25px
            font-weight: bold;
        }
        .ctext span{
            text-decoration: underline;
        }
        .c_body ol li, .c_date, .c_body p {
            font-size: 16px;
        }
        .c_date{
            color: #000;
        }
        .c_date span{
            text-align: right;
            display: block;
        }
        .c_body h2{
            font-size: 25px;
            font-weight: bold;
        }
        table#temp-student-tbl tr th, td {
            padding: 5px;
            color: #000000;
            text-align: center;
        }
        .header-addressing{
            font-weight: bold;
        }
        .report-title {
            text-align: center;
            text-decoration: underline;
            font-size: 20px;
        }
    </style>
    </head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-md-12 a4size">
                <div class="c_header">
                    <div class="header_igm col-md-6">
                        <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
                    </div>
                </div>
                <div class="c_body">
                    <h4 class="header-addressing report-title">Guest Student Information</h4>
                    <h4 class="header-addressing">Class: <?= $className?> Batch: <?= $sectionName?> </h4>
                    <?php
                    if ($from_date && $to_date){ ?>
                        <h4 class="header-addressing">Date From <?= date('d/m/Y', strtotime($from_date))?> to <?= date('d/m/Y', strtotime($to_date))?> </h4>
                    <?php }  ?>
                    <table class="table table-striped" border="1" id="temp-student-tbl">
                        <tr>
                            <th>Serial</th>
                            <th>Student Name</th>
                            <th>Phone Number</th>
                            <th>Attendance Date</th>
                        </tr>
                        <tbody>
                            <?php
                            $sl = 0;
                            foreach ($temp_students as $student): ?>
                            <tr>
                                <td><?= str_pad(++$sl, 2, 0, STR_PAD_LEFT)?></td>
                                <td><?=$student->name?></td>
                                <td><?=$student->phone?></td>
                                <td><?=date('d/m/Y', strtotime($student->attn_date))?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                    <div class="c_footer">

                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
</html>