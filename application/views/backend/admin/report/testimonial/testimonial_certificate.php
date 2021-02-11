<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>

    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">

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
    .roll_setion{
        text-align: right;
        line-height: 10px;
    }
    .c_body h2{
        font-size: 25px;
       font-weight: bold;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 a4size">
            <div class="c_header">
                <div class="header_igm col-md-6">
                    <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt=""> <?php echo get_settings('system_name'); ?>
                </div>
                <div class="header_text col-md-6">

                </div>
            </div>
            <div class="c_body">
                <div class="roll_setion">
                    <p>Roll No: <?=$sudentdata->roll?></p>
                    <p>Reg. No: <?=$registration?></p>
                    <p>Session: <?=$sudentdata->year?></p>
                </div>
                <br><br><p>SL.NO: <?=$sl?></p>
                <h2>Testimonial</h2><br>
                <p class="ctext">Certify that Wasima
                    <?=$sudentdata->student_name?>, Father :  <?=$sudentdata->fathers_name?> and Mother : <?=$sudentdata->mother_name?>,
                    Passed the <?=$sudentdata->class_name?> <?=$passing_year. ' '. $group?> group of the Board of Intermediate and Secondary Education, Sylhet from this college with
                    <?=$class_name?> as  <?=($sudentdata->sex == 'male') ? 'his' : 'her';?>
                    subjects of study and that she scored G.P.A <?=$result?> in the scale of 5.00 .
                </p><br><br>
                <p>While <?=($sudentdata->sex == 'male') ? 'he' : 'ahe';?> was a student of this college, <?=($sudentdata->sex == 'male') ? 'his' : 'her';?> conduct and character were good. <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> did not take part in any activity subversive of state or of college discipline.
                </p><br>
                <p>I wish <?=($sudentdata->sex == 'male') ? 'his' : 'her';?> every success in life.</p>
                <div class="c_date">
                    <br>
                    <p>Date: <?= date('d-m-Y')?><p>Written by:</p><p style="text-align: right">Head Master;s Signature</p>
                </div>
                <div class="c_footer">

                </div>
            </div>

        </div>
    </div>
</div>
