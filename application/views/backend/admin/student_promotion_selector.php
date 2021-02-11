<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-users"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('students_of_class');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id_from))->row()->name;?></h3>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead align="center">
            <tr>
                <td align="center"><?php echo get_phrase('name');?></td >
                <td align="center"><?php echo get_phrase('section');?></td >
                <td align="center"><?php echo get_phrase('roll_number');?></td >
                <td align="center"><?php echo get_phrase('info');?></td >
                <td align="center"><?php echo get_phrase('id_no');?></td >
                <td align="center"><?php echo get_phrase('options');?></td >
            </tr>
            </thead>
            <tbody>
            <?php
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $class_id_from , 'year' => $running_year
            ))->result_array();

            foreach($students as $row):
                $query = $this->db->get_where('enroll' , array(
                    'student_id' => $row['student_id'],
                    'year' => $promotion_year
                ));
                ?>
                <tr>
                    <td align="center">
                        <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
                    </td>
                    <td align="center">
                        <?php
                        $year = get_settings('running_year');
                        $section_all = $this->db
                            ->where('section.class_id',$class_id_to)->get('section')->result();
                        $selected_section = $this->db->where('year',$promotion_year)->get_where('enroll' , array('student_id' => $row['student_id']));
                        if ($selected_section->num_rows() >0){
                            $selected_section = $selected_section->row()->section_id;
                        }
                        ?>
                        <select class="form-control selectboxit" name="promotion_section_<?php echo $row['student_id'];?>" style="width: 40px;" id="promotion_status">
                        <?php
                            foreach ($section_all as $section):
                        ?>
                            <option <?= $selected_section == $section->section_id ? "selected" :  "" ?> value="<?php echo $section->section_id;?>"><?php echo $section->name;?></option>
                        <?php
                        endforeach;
                        ?>
                        </select>
                    </td>
                    <!-- Student Roll Number -->
                    <?php $roll_number = $this->db->get_where('enroll' , ['student_id' => $row['student_id']])
                        ->row()->roll;?>
                    <td align="center" style="text-align: center; width: 12%">
                        <input type="text" style="text-align: center;"class="form-control" name="roll_number[<?php echo $row['student_id']; ?>]" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$roll_number?>" autofocus required>
                    </td>
                    <td align="center" width="15%">
                        <button type="button" class="btn btn-default"
                                onclick="showAjaxModal('<?php echo site_url('modal/popup/student_promotion_performance/'.$row['student_id'].'/'.$class_id_from);?>');">
                            <i class="entypo-eye"></i> <?php echo get_phrase('view_academic_performance');?>
                        </button>
                    </td>
                    <td align="center"><?php echo $this->db->get_where('student' , array(
                            'student_id' => $row['student_id']
                        ))->row()->student_code;?></td>
                    <td width="15%">
                        <?php if($query->num_rows() < 1):?>
                            <select class="form-control selectboxit" name="promotion_status_<?php echo $row['student_id'];?>" style="width: 40px;" id="promotion_status">
                                <option value="<?php echo $class_id_to;?>">
                                    <?php echo get_phrase('enroll_to_class') ." - ". $this->crud_model->get_class_name($class_id_to);?>
                                </option>
                                <option value="<?php echo $class_id_from;?>">
                                    <?php echo get_phrase('enroll_to_class') ." - ". $this->crud_model->get_class_name($class_id_from);?>
                            </select>
                        <?php endif;?>
                        <?php if($query->num_rows() > 0):?>
                            <button class="btn btn-success">
                                <i class="entypo-check"></i> <?php echo get_phrase('student_already_enrolled');?>
                            </button>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="row">
    <center>
        <button type="submit" class="btn btn-success">
            <i class="entypo-check"></i> <?php echo get_phrase('promote_slelected_students');?>
        </button>
    </center>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function(i, el)
            {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }
    });
</script>