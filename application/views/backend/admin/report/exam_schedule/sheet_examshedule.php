<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Ekattor School Manager Pro - Creativeitem" />
    <meta name="author" content="Creativeitem" />

    <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">

    <script src="<?php echo base_url('assets/js/jquery-1.11.0.min.js');?>"></script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons/font-awesome/css/font-awesome.min.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/js/vertical-timeline/css/component.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/dataTables/css/dataTables.bootstrap.css');?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/buttons/css/buttons.bootstrap.css');?>"/>

    <link rel="stylesheet" href="<?php echo base_url('assets/js/wysihtml5/bootstrap-wysihtml5.css');?>">

    <!--Amcharts-->
    <script src="<?php echo base_url('assets/js/amcharts/amcharts.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/pie.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/serial.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/gauge.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/funnel.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/radar.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/amexport.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/rgbcolor.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/canvg.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/jspdf.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/filesaver.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/amcharts/exporting/jspdf.plugin.addimage.js');?>" type="text/javascript"></script>

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
<style>
    /*@page { sheet-size: A4-L; }*/
    /*.c_header{*/
        /*text-align: center;*/
        /*height: 150px;*/
    /*}*/
    .header_igm{

    }
    .header_igm img{
        width: 150px;
    }
    .header_igm{
        text-align: center;
        font-size: 35px;
        margin-left: -24px;
        margin-top: 42px;
        font-weight: bold;
        color: #000;
    }
    .c_body h2{
        color: #000;
        text-align: center;
        font-size: 20px
        font-weight: bold;
    }
    body{
        font-size: 16px;
        color: #000;
    }

    .subject_table{

        margin: 0 auto;
    }
    .subject_table tr td{
        text-align: center;
        padding: 8px;
    }
    .table_body h2{
        font-weight: bold;
        color: #000;
        text-align: center;
    }
    .notice_table{
        text-align: center;
    }
    .instite{
        margin-top: 40px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 a4size">
            <div class="c_header">
                <div class="header_igm col-md-12">
                    <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
                </div>
            </div>
            <div class="table_body">
                <?php

                $vtype = $this->session->userdata('vtype');
//                $year    = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
//                $exams = $this->db->get_where('exam', array('year' => $year, 'vtype'=>$vtype))->result_array();
//                $class = $this->db->get_where('class', ['vtype'=>$vtype])->result_array();

                $exam_year = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
                $exam_date= date_format(date_create($exam_year->date), 'Y');
                ?>
                <br><br><h2>Model Test : <?=$exam_date?></h2>
                <table>
                    <tr>
                        <td width="79%"><p>Class : <?=$class_name->name?></p></td>
                        <td><p style="text-align: right !important;">Class : <?=$session?></p></td>
                    </tr>
                </table>
                <br>
                <table border="1" class="subject_table">
                    <thead>
                    <tr>
                        <td style="padding: 10px">SI.</td>
                        <td style="padding: 10px">Date & Day</td>
                        <td style="padding: 10px">Time</td>
                        <td style="padding: 10px">Sub.ect</td>

                        <td style="padding: 10px">Sub. Code</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $conut = 1;
                    foreach ($exam_shedule as $shedule) :
                        $conut ++;
                        $database_date= date_format(date_create($shedule->exam_date), 'd-m-Y');
                        $daye_date= date_format(date_create($shedule->exam_date), 'D').'day';

                        ?>
                        <tr>
                            <td><?=$conut?>.</td>
                            <td><?=$database_date.'<br>'.$daye_date ?></td>
                            <td>From : <?=$shedule->from_time.$shedule->from_am_pm ."<br> To :".$shedule->to_time.$shedule->to_am_pm?></td>
                            <td><?=$shedule->subject_name?></td>

                            <td><?=$shedule->subject_code?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <h2>Exam Schedule</h2>
                <p class="notice_table">Note: The authority has full right to change or chancel the exam schedule any time.</p>
            </div>
            <p class="instite">Head of the Institute</p>
        </div>
    </div>
</div>