<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Pathsala Institute System" />
    <meta name="author" content="Jobayer Hossaion" />
    <title>Student Admin Card PDF/Print</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <!--    <link rel="stylesheet" href="--><?php //echo base_url('assets/css/bootstrap.css');?><!--">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">

    <script src="<?php echo base_url('assets/js/jquery-1.11.0.min.js');?>"></script>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons/font-awesome/css/font-awesome.min.css');?>">
    <!--Amcharts-->

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
        margin-top: 20px;
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
        margin: -35px 15px 15px 15px;
        /*margin-top: -35px;*/
    }
    .table_body{
        color: #000;
        margin-top: -110px;
    }

    .table_body h2{
        text-align: center;
        display: block;
        font-weight: bold;
        font-size: 18px;
        color: #000;
        margin-top: -25px;
    }
    .table_body p{
        text-align: center;
        display: block;
        color: #000;
        margin-top: -15px;
        font-size: 16px;
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
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        border-radius: 20px;
        line-height: 180px;
        /*margin: 15px;*/
        /*margin-top: -20px;*/
        border: 1px solid #000;
    }

</style>
<?php
$count= 0;
$border= [" ",'admit_border', 'admit_border'];
$page_brack= ['','','page-break-after:always'];
foreach ($student_admit as $studentinfo ):
$count++;
?>
<div class="container">
    <div class="c_header">
        <div class="header_igm col-md-12">
            <table>
                <tr>
                    <td>
                        <img width="100" src="<?php echo base_url('uploads/logo.png') ?>" alt="">
                    </td>
                    <td>
                        <h2><?php echo get_settings('system_name'); ?></h2>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clar"></div>
    </div>
    <div class="clar"></div>
    <div class="student_photo" style="display: inline-block; background: url('<?php echo $this->crud_model->get_image_url('student', $studentinfo->student_id); ?>');">
        <!--            <img src="--><?php //echo $this->crud_model->get_image_url('student', $student_id) ;?><!--" alt=""/>-->
    </div>
    <div class="clar"></div>
    <div class="table_body">
        <?php
        $exam_year = $this->db->get_where('exam', array('exam_id' => $exam_id))->row();
        $exam_date= date_format(date_create($exam_year->date), 'Y');
        ?>
        <p><?=$exam_name->name. ' ' .$exam_date?></p>
        <h2>Admit Card</h2>
        <table width="100%">
            <tr>
                <td colspan="4">Student's name : <b><?=$studentinfo->student_name?></b></td>
            </tr>
            <tr>
                <td colspan="">Father's name : <b><?=$studentinfo->parent_name?></b></td>
                <td colspan="3">Class : <?=$className->name?></td>
            </tr>
            <tr>
                <td>Section : <?=$studentinfo->section_name?></td>
                <td>Roll : <?=$studentinfo->roll_number?></td>
                <td>ID : <?=$studentinfo->student_code?></td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 20px">
            <tr>
                <?php
                $signature = $this->db->get_where('designation',['id'=>4])->row();
                ?>
                <td style="text-align: right"><span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$signature->name?></span><br style="text-align: center!important; border-top: 0!important;"><?=$signature->designation?></td>
            </tr>
        </table>
    </div>
    <div class="clar"></div>
    <br>
    <div class="<?=$border[$count %count($border)]?>"></div>
    <?php
    if ($count/3==0):
        ?>
        <div style="<?=$page_brack[0]?>"></div>
    <?php endif; endforeach; ?>
    <!--Admit Card 2nd Pard-->

</body>

</html>