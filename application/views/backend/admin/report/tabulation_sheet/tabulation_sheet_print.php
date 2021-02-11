<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
</head>
<style>
    @page { sheet-size: A4-L; }
    .header_igm img{
        width: 740px;
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
    .clar{
        clear: both;
    }
    /* color */
    body, table, tr, td, a, p, h1, h2, h3, h4, h5, h6 {
        color: #000;
    }
    table{
        width: 100%;
        text-align: center;
    }
    table tr td{
        padding: 3px;
    }
</style>
<body>
    <div class="container body_all">
        <div class="c_header">
            <div class="header_igm col-md-12">
                <img src="<?php echo base_url('uploads/large_logo.png') ?>" alt=""> <?php //echo get_settings('system_name'); ?>
            </div>
        </div>
        <div class="clar"></div>
        <div class="table_body"><br><br>
            <?php
            $CI = get_instance();
            $CI->load->model('report_model');
            $database_date = strtotime($exam_name->date);
            $year = date('Y', $database_date);
            ?>
            <b>Tabulation Sheet :</b>
                Exam:
                <?=$exam_name->name?>, Class: <?=$class_name->name?>, Half Yearly : <?=$year?><br>
            <br>
            <table border="1">
                <tr>
                    <td rowspan="2">Roll</td>
                    <td rowspan="2">Student Name</td>
                    <?php foreach ($tabulation_all_sub as $tabulation):?>
                    <td colspan="3"><?=$tabulation->name?></td>
                    <?php endforeach;?>
                    <td rowspan="2">Total Mark</td>
                    <td rowspan="2">GPA</td>
                    <td rowspan="2">Grade</td>
                    <td rowspan="2">Merit (Sec)</td>
                    <td rowspan="2">Merit (C)</td>
                    <td rowspan="2">Fail Subs.</td>
                </tr>
                <tr>
                    <?php foreach ($tabulation_all_sub as $tabulation):?>
                    <td>T</td>
                    <td>G.P</td>
                    <td>LG</td>
                    <?php endforeach;?>
                </tr>
                <!-- Student Information Loop Start-->
            <?php
            foreach ($tabulation_all_student as $k => $student):
                // if ($k==5) break;
            ?>
                <tr class="">
                    <td><?=$student->roll?></td>
                    <td style="text-align: left"><?=$student->student_name?></td>
                    <!-- Compulsor Subject Loop Stard -->
                    <?php
                    $total_mark= 0;
                    $conunt_sub = 0;
                    $total_point= 0;
                    $fail_subjects = 0;
                    foreach ($tabulation_all_sub as $tabulation):
                        $mark = get_tabulation_mark($exam_id, $student->student_id, $tabulation->subject_id);
                        if (!empty($mark)):
                        $each_mark = ($mark->mark_obtained+$mark->cw_marks+$mark->hw_marks);
                        $each_mark = ($each_mark>99) ? 100 : $each_mark;
                        $each_mark = ($each_mark<0) ? 0 : $each_mark;
                        $total_mark += $each_mark;
                        if ($tabulation->full_marks==50)
                        {
                            $grade = get_grade_point_Mark(($each_mark*2));
                        }else{
                            $grade = get_grade_point_Mark($each_mark);
                        }
                        ?>
                        <td><?=$each_mark?></td>
                        <td><?=$grade->grade_point?></td>
                        <?php
                        if ($tabulation->subject_id == $student->opt_sub_id){
                            if ($grade->grade_point>2) {
                                $total_point += ($grade->grade_point - 2);
                            }
                        }else{
                            $conunt_sub++;
                            if ($grade->grade_point==0) {
                                $fail_subjects++;
                            }else{
                                $total_point += $grade->grade_point;
                            }
                        }

                        ?>
                        <td><?=$grade->name?></td>
                       <?php
                        elseif($tabulation->subject_id != $student->opt_sub_id):
                            $fail_subjects++;
                        ?>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <?php else:; ?>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        <?php endif; ?>

                    <?php endforeach;?>
                    <!-- Compulsory Subject Loop End -->
                    <td><?= $total_mark ?></td>
                    <?Php
                        if (($total_point>0) && ($conunt_sub>0) && ($fail_subjects==0)) {
                            echo '<td>'.round(($total_point/$conunt_sub), 2).'</td>';
//                            $qg =$this->db->select('name')->from('grade')
//                                ->where('grade.grade_point <=', ($total_point/$conunt_sub))
//                                ->order_by('grade_point','desc')->get();
//                            $grade = $qg->row();
                            echo '<td>'.($CI->report_model->get_gradeName_byPoint( ($total_point/$conunt_sub))).'</td>';
                        } else {
                            echo '<td>0.00</td><td>F</td>';
                        }
                    ?>


                    <?php
                        $merit_cls = $CI->report_model->getMeritPosition($exam_id, $class_id, $student->student_id);
                        $merit_sec = $CI->report_model->getMeritPosition($exam_id, $class_id, $student->student_id, $student->section_id);
                    ?>
                    <td><?php echo $merit_sec; ?></td>
                    <td><?php echo $merit_cls; ?></td>
                    <td><?php echo $fail_subjects; ?></td>
                </tr>
            <?php endforeach;?>
            <!-- Student Information Loop End -->
            </table>
        </div>
        <br>
    </body>
</html>