<style>
    .student_images img{
        width: 150px;
        height: 150px;
        border-radius: 50%;
        text-align: center;
        display: block;
        border: 1px solid #666;
        margin: 10px auto;
        padding: 10px;
    }

    th{
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        background-color: #ccc;
    }
    table {
        width: 100%;
        border: 1px solid #999;
        margin-bottom: 40px;
    }
    th, td {
        padding: 5px;
    }
    .bg_head{
         background-color: #eee;
         color: #444;
         font-weight: bold;
         font-size: 13px;
         text-align: center;
     }
</style>
<div class="col-md-12 student_images">
    <img src="<?php echo $this->crud_model->get_image_url('student', $student_information->student_id) ;?>" alt="">
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="student_info">
                <table border="1">
                    <tr>
                        <th colspan="2">Student Information</th>
                    </tr>
                    <tr>
                        <td>Student Name</td>
                        <td><?=$student_information->std_name?></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><?=$student_information->student_phone?></td>
                    </tr>
                    <tr>
                        <td>Class Roll</td>
                        <td><?=$student_information->roll?></td>
                    </tr>
                    <tr>
                        <td>Class Name</td>
                        <td><?=$student_information->class_name?></td>
                    </tr>
                    <tr>
                        <td>Section name</td>
                        <?php
                            $slice = explode(',', $student_information->sections);
                            $sec_name = '';
                            foreach ($slice as $val)
                            {
                                $sec_name .= get_sectionName($val) . ', ';
                            }
                        ?>
                        <td><?=trim($sec_name, ', ')?></td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td><?=$student_information->group?></td>
                    </tr>
                    <tr>
                        <td>Shift</td>
                        <td><?=$student_information->shift?></td>
                    </tr>
                    <tr>
                        <td>Birthday</td>
                        <td><?=$student_information->birthday?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?=$student_information->address?></td>
                    </tr>
                </table>

                <table border="1">
                    <tr>
                        <th colspan="4">Student Guardian Information</th>
                    </tr>
                    <tr>
                        <td class="bg_head">Guardian</td>
                        <td class="bg_head">Name</td>
                        <td class="bg_head">Contact</td>
                        <td class="bg_head">Picture</td>
                    </tr>
                    <tr>
                        <td>Father</td>
                        <td><?=$student_information->parent_name?></td>
                        <td><?=$student_information->father_contact?></td>
                        <td>
                            <div class="fileinput-new thumbnail" style="width: 50px; height: 50px; display: inherit;  text-align: center" data-trigger="fileinput">
                                <img style="text-align: center; margin: 0 auto;" src="<?php echo $this->crud_model->get_image_url('parent' , 'father_'.$student_information->parent_id);?>" alt="...">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Mother</td>
                        <td><?=$student_information->mother_name?></td>
                        <td><?=$student_information->mother_contact?></td>
                        <td>
                            <div class="fileinput-new thumbnail" style="width: 50px; height: 50px; display: inherit;  text-align: center" data-trigger="fileinput">
                                <img style="text-align: center; margin: 0 auto;" src="<?php echo $this->crud_model->get_image_url('parent' , 'mother_'.$student_information->parent_id);?>" alt="...">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Local Guardian</td>
                        <td><?=$student_information->local_guardian_name?></td>
                        <td><?=$student_information->local_guardian_contact?></td>
                        <td>
                            <div class="fileinput-new thumbnail" style="width: 50px; height: 50px; display: inherit;  text-align: center" data-trigger="fileinput">
                                <img style="text-align: center; margin: 0 auto;" src="<?php echo $this->crud_model->get_image_url('parent' , 'local_guardian_'.$student_information->parent_id);?>" alt="...">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="payment_info">
                <table border="1">
                    <tr>
                        <th colspan="2">Student Payment Information</th>
                    </tr>
                    <?php foreach ($section_name as $key => $sec): ?>
                        <tr>
                            <td colspan="2" class="text-center bold"><?=$sec?></td>
                        </tr>
                        <tr>
                            <td>Due Payment</td>
                            <td style="text-align: right; font-weight: bold">
                                <?php
                                if($payment[$key]===false){ echo '<b style=\'color: red; padding-left: 20px;\'>Please set tuition fee for the batch</b>';
                                }elseif($payment[$key]===null){
                                    echo '<b style=\'color: red; padding-left: 20px;\'>Invalid/No admission date</b>';
                                } else{ echo number_format($payment[$key], 2);} ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Payable Exam Fees</td>
                        <td style="text-align: right; font-weight: bold">
                            <?php
                            $exam =0;
                            foreach ($exam_fees as $student_exam){
                                $exam += $student_exam->amount_paid + $student_exam->discount;
                            }
                            echo number_format($exam, 2 );
                            ?>
                        </td>
                    </tr>
                </table>
                <table border="1">
                    <tr>
                        <th colspan="2">Student Attendance Information</th>
                    </tr>
                    <?php foreach ($section_name as $key => $sec): ?>
                    <tr>
                        <td colspan="2" class="text-center bold"><?=$sec?></td>
                    </tr>
                    <tr>
                        <td>Schooling days</td>
                        <td><?=$all_schoolingDay[$key]?></td>
                    </tr>
                    <tr>
                        <td>Present days</td>
                        <td><?=$student_day[$key]?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>