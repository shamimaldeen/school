<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Ekattor School Manager Pro - Creativeitem" />
    <meta name="author" content="Creativeitem" />

    <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<!--    <link rel="stylesheet" href="--><?php //echo base_url('assets/css/bootstrap.css');?><!--">-->
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
</head>
    <body>
<style>
    .header_igm img{
        width: 150px;
    }
    .header_igm{
        text-align: center;
        font-size: 21px;
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
        border-radius: 20px;
        border: 1px solid #000;
        display:block;
        float: right;
        text-align: center;
        line-height: 180px;
        margin: 15px;
        margin-top: -35px;
        ;
    }
    .table_body{
        color: #000;
        margin-top: -85px;
    }
    .table_body h2{
        text-align: center;
        display: block;
        font-weight: bold;
        font-size: 18px;
        color: #000;
        margin-top: 25px;
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
    .student_photo img{
        /*width: 100%;*/
        /*height: 50px !important;*/
        border-radius: 20px;
        padding: 5px;
    }
    .clar{
        clear: both;
    }
    .admit_border{
        width: 100%;
        border-bottom: 1px dotted #000;
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
        margin-top: -20px;
        border: 1px solid #000;
    }

</style>
    <?php
    $count= 0;
    $border= [" ",'admit_border'];
    $page_brack= ["page-break-after:always",''];
    foreach ($student_admit as $studentinfo ):
    $count++;
    ?>
    <div class="container">
        <div class="c_header">
            <div class="header_igm col-md-12">
                <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
            </div>
            <div class="clar"></div>
        </div>
        <div class="clar"></div>
        <div class="student_photo" style="display: inline-block">
            <!--            <img src="--><?php //echo $this->crud_model->get_image_url('student', $student_id) ;?><!--" alt=""/>-->
        </div>
        <div class="clar"></div>
        <div class="table_body">
            <?php
            $exam_year = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
            $exam_date= date_format(date_create($exam_year->date), 'Y');
            ?>
            <h2>Model Test : <?=$exam_date?></h2>
            <p style="text-align: center">Admit Card</p>
            <h3>Card No: <?=$studentinfo->student_code?></h3>
            <table>
                <tr>
                    <td>Student's name </td>
                    <td> : <?=$studentinfo->student_name?></td>
                    <td>Class : <?=$className->name?></td>
                </tr>
                <tr>
                    <td>Father's name or Mother's Name </td>
                    <td> : <?=$studentinfo->parent_name?> </td>
                    <td>Role : <?=$studentinfo->roll?> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td>  </td>
                    <td>Group : Science </td>
                </tr>
                <tr class="subject">
                <tr>
                    <td>Compulsory Sub </td>
                    <td colspan="2"> : <?php
                        $compulsor = "";
                        foreach ($all_compulsor_subject as $compulsor_subject){
                            echo $compulsor = $compulsor_subject->name.' ['.$compulsor_subject->subject_code.'] '.', ';
                        }
                        echo trim($compulsor, ', ')
                        ?> </td>
                </tr>
                <tr>
                    <td>Elective Sub </td>
                    <td colspan="2"> : <?php
                        $compulsor = "";
                        foreach ($all_elective_subject as $elective__subject){
                            echo $compulsor = $elective__subject->name.' ['.$elective__subject->subject_code.'] '.', ';
                        }
                        echo trim($compulsor, ', ')
                        ?> </td>
                </tr>
                <tr>
                    <td>Forth Sub </td>
                    <td colspan="2"> : <?php
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
            <p style="margin-top: 50px">Convener</p>
            <table>
                <tr>
                    <td style="text-align: left; float: left" width="78%">Exam Committee</td>
                    <td style="text-align: right; float: right">Head of the Institute</td>
                </tr>
            </table>
        </div>
        <br>
        <div class="<?=$border[$count %count($border)]?>"></div>
        <div style="<?=$page_brack[$count %count($page_brack)]?>"></div>
        <?php endforeach; ?>
        <!--Admit Card 2nd Pard-->

    </body>

</html>