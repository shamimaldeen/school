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
    table tr td {
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
    .subject_body tr td {
        text-align: center;
    }
    .subject_body tr td:first-child{
        text-align: left;
    }
    .total_GPA tr td {
        text-align: center;
        font-weight: bold;
    }
    .table_signature {
        margin-top: 100px;
    }
    .table_signature tr td p {


    }
</style>
    <div class="container body_all">
        <div class="c_header">
            <div class="header_igm col-md-12">
                <img src="<?php echo base_url('uploads/large_logo.png') ?>" alt=""> <?php //echo get_settings('system_name'); ?>
            </div>
        </div>
        <div class="clar"></div>
        <div class="table_body">
            <h2>Academic Transcript</h2>
            <?php
            $database_date = strtotime($exam_name->date);
            $year = date('Y', $database_date);
            ?>
            <p><?=$exam_name->name?> : <?=$year?></p>
            <table border="1" style="text-align: center">
                <tr>
                    <td>Student's Name</td>
                    <td colspan="2"><h2> <?=$student_transcript_info->name;?></h2></td>
                    <td>Shift - <?=$student_transcript_info->shift;?></td>
                    <td> Section - <?=$section->name?> </td>
                </tr>
                <tr>
                    <td>Roll No</td>
                    <td> <?=$student_roll->roll?></td>
                    <td>Class - <?=$className->name?></td>
                    <td colspan="2"> Group - <?=$student_transcript_info->group;?></td>
                </tr>
            </table> <br>
            <table border="1" class="subject_body">
                <thead>
                    <tr style="font-weight: bold">
                        <td>Subject List</td>
                        <td>Creative</td>
                        <td>MCQ</td>
                        <td>Practical</td>
                        <td>Sub Total</td>
                        <td>80%</td>
                        <td>CA</td>
                        <td>TM</td>
                        <td>GD</td>
                        <td>GP</td>
                    </tr>
                </thead>
                <tbody>
                <?php
//                var_dump($student_gpa); exit;
                $total_grade_point = 0;
                $total_point = 0;
                $total_mark = 0;
                $point_count= 0;
                $fail_status = 0;
//                dd($student_gpa);
                foreach ($student_gpa as $gpa):
                    $grade = get_grade_by_mark($gpa['total_mark']);
//                    var_dump($grade->grade_point); exit();
                    if ($grade != null){
                        $grade_point = $grade->grade_point;
                        $grade_name = $grade->name;
                        $total_mark += $gpa['total_mark'];
                        $total_grade_point += $grade_point;
                    }else{
                        $grade_point = 0;
                        $grade_name = null;
                    }
                    if ($grade_name == 'F' || $grade_point == 0)
                    {
                        $fail_status = 1;
                    }
                    $point_count++;
                ?>
                    <tr>
                        <td><?php echo $gpa['subject_name']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $gpa['total_mark']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $grade_name; ?></td>
                        <td><?php echo round($grade_point, 2); ?></td>
                    </tr>
                <?php
                endforeach;
                ?>
                </tbody>
                <?php if (!empty($optinal_sub)): ?>
                <tr>
                    <td colspan="10" style="text-align: left"><b>Optional Subject</b></td>
                </tr>
                <?php
                endif;
                $total_mark_opt=0;
                $total_point_opt = 0;
                $total_mark_opt = 0;
                $opt_count= 0;
                $total_point_optional = 0;

                foreach ($optinal_sub as $opt):
                    $grade_opt = get_grade_by_mark($opt['total_mark']);
                    if ($grade_opt != null){
                        $grade_point = $grade_opt->grade_point;
                        $grade_name = $grade_opt->name;
                        $total_point_opt += $grade_point;
                        if ($grade_point > 2){
                            $total_point_optional +=$grade_opt->grade_point -=2;
                        }
                        $total_mark_opt += $opt['total_mark'];
                    }else{
                        $grade_point = 0;
                        $grade_name = null;
                    }

                    if ($grade_name == 'F' || $grade_point == 0)
                    {
                        $fail_status = 1;
                    }
                    $opt_count++;
                    ?>
                    <tr>
                        <td><?php echo $opt['subject_name']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $opt['total_mark']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $grade_name; ?></td>
                        <td><?php echo round($grade_point, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table> <br>
            <table border="1" class="total_GPA">
                <tr>
                    <td><p>Examination</p></td>
                    <td>Total Marks</td>
                    <td>GPA</td>
                    <td>Average Marks</td>
                    <td>CGPA</td>
                    <td>Grade</td>
                </tr>
                <tr>
                    <td style="font-weight: normal; text-align: left"><?=$exam_name->name?></td>
                    <td><?= $total_mark+$total_mark_opt ?></td>
                    <td>
                        <?php
                        if (($total_point_opt>0) || ($opt_count>0)):
                            $opt_avg_pnt = $total_point_opt/$opt_count;
                        else:
                            $opt_avg_pnt = 0;
                        endif;
                            //var_dump($total_point_opt); exit();
                            $avg_point = $total_grade_point/$point_count;
                        if (($total_grade_point>0) || ($point_count>0)):
                            $avg_point = $total_grade_point/$point_count;
                        else:
                            $avg_point = 0;
                        endif;
                        if ($fail_status == 0):
                            $totalcount = $total_grade_point+$total_point_optional;
                            $avg = $totalcount/$point_count;
                        else:
                            $avg = 0;
                        endif;
                        echo round($avg = ($avg>5) ? 5 : $avg, 2);
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        $qg =$this->db->select('name')
                            ->from('grade')
                            ->where('grade.grade_point <=', $avg)
                            ->order_by('grade_point','desc')
                            ->get();
                        //        $this->db->last_query();
                        $grade = $qg->row();
                        echo ($grade) ? $grade->name : null;
                        ?>
                    </td>
                </tr>
            </table><br>
            <table border="1">
                <tr>
                    <td class="col-md-4">Behaviour</td>
                    <td style="text-align: center"> Good</td>
                    <td class="col-md-4">Merit Position (Section)</td>
                    <td style="text-align: center">1</td>
                </tr>
                <tr>
                    <td class="col-md-4">Co-curricular Activities</td>
                    <td style="text-align: center"> </td>
                    <td class="col-md-4">Merit Position (Shift)</td>
                    <td style="text-align: center">2</td>
                </tr>
                <tr>
                    <td>Remarks</td>
                    <td colspan="3"></td>
                </tr>
            </table>
            <table class="table_signature">
                <tr>
                    <td><span style="border-top: 1px solid #000;">Class Teacher's Signature</span></td>
                    <td style="text-align: center"><span style="border-top: 1px solid #000;">Guardian's Signature</span></td>
                    <td style="text-align: right"><span style="border-top: 1px solid #000;">Head Master's Signature</span></td>
                </tr>
            </table>
        </div>
        <br>
    </body>
</html>