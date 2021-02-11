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
        font-size: 40px;
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
        font-size: 14px;
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
        margin-top: 50px;
    }
    .clar{
        clear: both;
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
            <div class="clar"></div>
            <div class="table_body">
                <h2>Signature Sheet</h2>
                <?php
                $exam_year = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
                $exam_date= date_format(date_create($exam_year->date), 'Y');
                ?>
                <p style="text-align: center">Model Test : <?=$exam_date?></p>
                <p style="text-align: center">Class : <?=$className->name?></p><br>
                <table>
                    <tr>
                        <td>Name of Examinee </td>
                        <td colspan="2"> : <?=$studentinfo->student_name?></td>

                    </tr>
                    <tr>
                        <td style="padding:20px 0px 0px!important;">Role  <?=$classRoll->roll?></td>
                        <td style="padding:20px 0px 0px!important;">:</td>
                        <td style="padding:20px 0px 0px!important;">Shift : <?=$studentinfo->shift?></td>
                    </tr>
                    <tr>
                        <?php
                        $sections = $this->db->get_where('section', array('section_id' => $section_id))->row();
                        ?>
                        <td> Group <?=$studentinfo->group?></td>
                        <td>:  </td>
                        <td>Session : <?=$sections->name?> </td>
                    </tr>
                    <tr class="subject" >
                    <tr>
                        <td style="padding:20px 0px 0px!important;">Compulsory Sub </td>
                        <td colspan="2" style="padding:20px 0px 0px!important;"> : <?php
                            $compulsor = "";
                            foreach ($all_compulsor_subject as $compulsor_subject){
                                echo $compulsor = $compulsor_subject->name.' ['.$compulsor_subject->subject_code.'] '.', ';
                            }
                            echo trim($compulsor, ', ')
                            ?> </td>
                    </tr>
                    <tr>
                        <td>Elective Sub </td>
                        <td colspan="2" > : <?php
                            $forth = "";
                            foreach ($all_elective_subject as $elective_subject){
                                $forth .= $elective_subject->name.' ['.$elective_subject->subject_code.'] '.' , ';
                            }
                            echo trim($forth, ', ')
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Forth Sub </td>
                        <td colspan="2" > : <?php
                            $forth = "";
                            foreach ($all_4th_subject as $fourth_subject){
                                $forth .= $fourth_subject->name.' ['.$fourth_subject->subject_code.'] '.' , ';
                            }
                            echo trim($forth, ', ')
                            ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <div class="clar"></div>
                <table border="1" class="subject_table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <td>SI.</td>
                            <td>Date & Day</td>
                            <td>Time</td>
                            <td>Sub.ect</td>

                            <td>Sub. Code</td>
                            <td>Student's Signature</td>
                            <td>Invigilator's Signature</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $conut = 1;
                    foreach ($exam_shedule as $shedule) :
                        $conut ++;
                        $database_date= date_format(date_create($shedule->exam_date), 'd-m-Y');
                        $daye_date= date_format(date_create($shedule->exam_date), 'D');

                        ?>
                        <tr>
                            <td><?=$conut?>.</td>
                            <td><?=$database_date.'<br>'.$daye_date ?></td>
                            <td>From : <?=$shedule->from_time.$shedule->from_am_pm ."<br> To :".$shedule->to_time.$shedule->to_am_pm?></td>
                            <td><?=$shedule->subject_name?></td>

                            <td><?=$shedule->subject_code?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

            </div>
            <p class="instite"><span style="border-top: 1px solid #000">Convener of Exam</span></p>
        </div>
    </div>
</div>