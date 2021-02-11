<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
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
    @page { sheet-size: A4-L; }
    .c_header{
        text-align: center;
        height: 150px;
    }
    .header_igm{

    }
    .header_igm img{
        width: 150px;
    }
    .header_text{

    }
    .header_igm{
        text-align: center;
        font-size: 30px;
        margin-left: -24px;
        margin-top: 42px;
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
    'TD' => array(
    'PADDING-LEFT' => '0.1em',
    'PADDING-RIGHT' => '0.1em',
    'PADDING-TOP' => '0.2em',
    'PADDING-BOTTOM' => '0.2em',
    ),
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 a4size">
            <div class="c_header">
                <div class="header_igm col-md-6">
                    <img width="100" src="https://brandmark.io/logo-rank/random/bp.png" alt="">GOVT AGRAGAMI IRLS HIGH SCHOOL & COLLEGE
                </div>
                <div class="header_text col-md-6">

                </div>
            </div>
            <div class="c_body" style="background-image: url('https://brandmark.io/logo-rank/random/bp.png');
        background-size: auto 100%;
        background-position: 50% 50%;
background-repeat: no-repeat;
background-image-opacity: 0.5;">
                <?php
                function gender($mail, $femail){
                    if ($sudentdata->sex = 'male'){
                        echo $mail;
                    }
                    else{
                        echo $femail;
                    }
                }
                ?>
                      <?php
                function hisHer($sex){
                    return ($sex == 'male') ? 'his' : 'her';
                }
                function heShe($sex){
                    return ($sex == 'male') ? 'he' : 'she';
                }
                ?>
                <br><br><p>SL.NO: <?=$sl?></p>
                <h2>Transfer Certificate</h2><br>
                <p class="ctext">This is to consenting that
                    <?=$sudentdata->student_name?>, Father or Mother:
                    <?=$sudentdata->fathers_name?> Address:
                    <?=$sudentdata->address?>.
                    <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> has been studying in this institution.
                    <?=gender('His','Her')?> date of birth is
                    <span><?=$sudentdata->birthday?> </span>(as per description of admission book). <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> has been reading in
                    <span><?=$sudentdata->class_name?></span> of this institution and <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> was passed / was not passed the annual examination of
                    <span><?=$sudentdata->class_name?></span>. <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> is offered
                    <?=$class_name?> as <?=($sudentdata->sex == 'male') ? 'his' : 'her';?> subjects of study. All the dues from <?=($sudentdata->sex == 'male') ? 'his' : 'her';?> was received with understanding up to the dated month of
                    <?= date("F Y")?> A.D
                </p><br><br>
                <p>Cause of leaving the institution:</p>
                <ol>
                    <li>
                        Willing of the guardian
                    </li>
                </ol>
                <div class="c_date">
                    <br><br><br>

                    <p>Date: <?= date('d-m-Y')?><p style="text-align: right">Head Master;s Signature</p>
                </div>
                <div class="c_footer">

                </div>
            </div>

        </div>
    </div>
</div>
<?php include 'backend/includes_bottom.php';?>