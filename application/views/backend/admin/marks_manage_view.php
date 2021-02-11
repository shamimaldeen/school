<style>

</style>
<hr />
<?php echo form_open(site_url('admin/marks_selector'));?>
<div class="row">

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
            <select name="exam_id" class="form-control selectboxit" required>
                <?php
                $vtype = $this->session->userdata('vtype');
                $exams = $this->db->get_where('exam' , array('year' => $running_year, 'vtype'=>$vtype))->result_array();
                foreach($exams as $row):
                    ?>
                    <option value="<?php echo $row['exam_id'];?>"
                        <?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
            <select name="class_id" class="form-control selectboxit" onchange="get_class_subject(this.value)">
                <option value=""><?php echo get_phrase('select_class');?></option>
                <?php
                $classes = $this->db->get_where('class' , [ 'vtype'=>$vtype])->result_array();
                foreach($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id'];?>"
                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>

    <div id="subject_holder">
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
                <select name="section_id" id="section_id" class="form-control selectboxit">
                    <?php
                    $sections = $this->db->get_where('section' , array(
                        'class_id' => $class_id,  'vtype'=>$vtype
                    ))->result_array();
                    foreach($sections as $row):
                        ?>
                        <option value="<?php echo $row['section_id'];?>"
                            <?php if($section_id == $row['section_id']) echo 'selected';?>>
                            <?php echo $row['name'];?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
                <select name="subject_id" id="subject_id" class="form-control selectboxit">
                    <?php
                    $subjects = $this->db->get_where('subject' , array(
                        'class_id' => $class_id ,  'vtype'=>$vtype, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                    ))->result_array();
                    foreach($subjects as $row):
                        ?>
                        <option value="<?php echo $row['subject_id'];?>"
                            <?php if($subject_id == $row['subject_id']) echo 'selected';?>>
                            <?php echo $row['name'];?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-md-2" style="margin-top: 20px;">
            <center>
                <button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
            </center>
        </div>
    </div>

</div>
<?php echo form_close();?>

<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-chart-bar"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('marks_for');?> <?php echo $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;?></h3>
            <h4 style="color: #696969;">
                <?php echo get_phrase('class');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> :
                <?php echo get_phrase('section');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?>
            </h4>
            <h4 style="color: #696969;">
                <?php
                $subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row();
                echo get_phrase('subject');?> : <?php if (!empty($subject_name)){ echo $subject_name->name;}?>
            </h4>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
<div class="row">
    <div class="col-md-12">

        <?php echo form_open(site_url('admin/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id));?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo get_phrase('roll');?></th>
                    <th><?php echo get_phrase('id');?></th>
                    <th style="width: 25%"><?php echo get_phrase('name');?></th>
                    <th><?php echo get_phrase('marks_obtained_(CQ)');?></th>
                    <th><?php echo get_phrase('MCQ');?></th>
                    <th><?php echo get_phrase('practical');?></th>
                    <th><?php echo get_phrase('comment');?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            $year = get_settings('running_year');
            $vtype = $this->session->userdata('vtype');
//            $all_students = $this->db
//                ->select('student.name, student.student_code')
//                ->from('student')
//                ->join('enroll','enroll.student_id=student.student_id', 'left')
//                ->where(['student.vtype'=>$vtype, 'enroll.class_id'=>$class_id])
//                ->result_array();;
            $marks_of_students = $this->db->get_where('mark' , array(
                'class_id' => $class_id,
                'section_id' => $section_id ,
                'year' => $running_year,
                'subject_id' => $subject_id,
                'exam_id' => $exam_id
            ))->result_array();
            //dd($marks_of_students);
            foreach($marks_of_students as $row):
                $stdInfo = $this->db->select('student.name,student.student_code, enroll.roll')
                    ->from('student')
                    ->join('enroll', 'enroll.student_id = student.student_id')
                    ->where(array('student.student_id'=>$row['student_id'], 'student.vtype'=>$this->session->userdata('vtype'), 'enroll.year'=>$running_year))->get()->row();
                ?>
                <tr>
                    <td><?php echo str_pad($count++, '2', '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo $stdInfo->roll; ?></td>
                    <td><?php echo $stdInfo->student_code; ?></td>
                    <td><?php echo $stdInfo->name; ?></td>
                    <td><input type="text" class="form-control" name="marks_obtained_<?php echo $row['mark_id'];?>"
                               value="<?php echo $row['mark_obtained'];?>"></td>
                    <td><input type="text" class="form-control" name="cw_<?php echo $row['mark_id'];?>"
                               value="<?php echo $row['cw_marks'];?>"></td>
                    <td><input type="text" class="form-control" name="hw_<?php echo $row['mark_id'];?>"
                               value="<?php echo $row['hw_marks'];?>"></td>
                    <td>
                        <input type="text" class="form-control" name="comment_<?php echo $row['mark_id'];?>"
                               value="<?php echo $row['comment'];?>">
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        <center>
            <button type="submit" class="btn btn-success" id="submit_button">
                <i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
            </button>
        </center>
        <?php echo form_close();?>

    </div>
    <div class="col-md-2"></div>
</div>





<script type="text/javascript">
    function get_class_subject(class_id) {
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/marks_get_subject/');?>' + class_id ,
                success: function(response)
                {
                    jQuery('#subject_holder').html(response);
                }
            });
        }
    }
</script>