<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>

    <meta charset="utf-8">


    <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>">
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
        font-size: 40px;
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
            </div>
            <div class="c_body">
                <br><br><p>SL.NO: <?=$sl?></p>
                <h2>Transfer Certificate</h2><br>
                <p class="ctext">This is to consenting that
                    <?=$sudentdata->student_name?>, Father :  <?=$sudentdata->fathers_name?> and Mother : <?=$sudentdata->mother_name?>
                    <?=$sudentdata->fathers_name?>, Address :
                    <?=$sudentdata->address?>.
                    <?=($sudentdata->sex == 'male') ? 'He' : 'She';?> has been studying in this institution.
                    <?=($sudentdata->sex == 'male') ? 'His' : 'Her';?> date of birth is
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

                    <p>Date: <?= date('d-m-Y')?><p style="text-align: right">Head Master's Signature</p>
                </div>
                <div class="c_footer">

                </div>
            </div>

        </div>
    </div>
</div>
