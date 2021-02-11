<?php
$class_id = isset($class_id) ? $class_id : '';
$section_id = isset($section_id) ? $section_id : '';
$student_id = isset($student_id) ? $student_id : '';
?>
<style>
    .input_file{
        background: #fff ;
        box-shadow: none;
        background-clip: border-box;
        border-radius: 3px;
        height: 42px;
        line-height: 41px;
        outline: 0;
        padding-left: 15px;
        border: 1px solid #ebebeb;
        display: block;
        width: 100%;
    }
</style>
<hr />
<?php echo form_open(site_url('admin/extra_curriculum_grade_manage'));?>

<div class="row">

    <div class="col-md-3">
        <label><?php echo get_phrase('class');?></label>
        <select class="" name="class_id" id="class_id">
            <option value=""><?php echo get_phrase('select_a_class');?></option>
            <?php
            $vtype = $this->session->userdata('vtype');
            $classes = $this->db->get_where('class', ['vtype'=>$vtype])->result_array();
            foreach ($classes as $row):
                ?>
                <option value="<?php echo $row['class_id'];?>">
                    <?php echo $row['name'];?>
                </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-3">
        <label><?php echo get_phrase('section');?></label>
        <div id="section_holder">
            <select class="sec_field" name="section_id" id="section_id" disabled="">
                <option value=""><?php echo get_phrase('select_a_section_first');?></option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <label><?php echo get_phrase('student');?></label>
        <div id="student_holder">
            <select class="" name="student_id" required id="student_id" disabled>
                <option value=""><?php echo get_phrase('select_a_student');?></option>
            </select>
        </div>
    </div>
    <div class="col-md-2" style="margin-top: 20px;">
        <center>
            <button type="submit" class="btn btn-info"><?php echo get_phrase('manage_grade');?></button>
        </center>
    </div>

</div>
<?php echo form_close();?>

<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-chart-bar"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('Student_for');?> <?php echo $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;?></h3>
            <!--			<h4 style="color: #696969;">-->
            <?php echo get_phrase('class_: ');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?><br>
            <?php echo get_phrase('section_: ');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?>
            <!--			</h4>-->
            <h4 style="color: #696969;">
                <!--				--><?php //echo get_phrase('subject');?><!-- : --><?php //echo $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;?>
            </h4>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
<style>
    table tr td {
        text-align: center;
    }
    .c_header{
        text-align: center; background-color: #d9ecd8 !important; color: #666!important; ; font-size: 14px; font-weight: bold
    }
</style>
<div class="row">
    <div class="col-md-2"></div>
    <?php if (!isset($result)): ?>
        <div class="col-md-8">
            <?php echo form_open(site_url('admin/store_extra_curriculum_marks'));?>
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 45%"><?php echo get_phrase('name');?></th>
                    <th style="text-align: center"><?php echo get_phrase('A+');?></th>
                    <th style="text-align: center"><?php echo get_phrase('A');?></th>
                    <th style="text-align: center"><?php echo get_phrase('B');?></th>
                    <th style="text-align: center"><?php echo get_phrase('C');?></th>
                </tr>
                <tr>
                    <th class="c_header">General</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $generals_all       = $this->db->get_where('extra_curriculum_settings',['group_id'=>1])->result();
                $written_all        = $this->db->get_where('extra_curriculum_settings',['group_id'=>2])->result();
                $team_works_all     = $this->db->get_where('extra_curriculum_settings',['group_id'=>3])->result();
                $music_all          = $this->db->get_where('extra_curriculum_settings',['group_id'=>4])->result();

                foreach ($generals_all as $general) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$general->name?></td>
                        <td><input type="radio" value="1" name="<?=$general->id?>"></td>
                        <td><input type="radio" value="2" name="<?=$general->id?>"></td>
                        <td><input type="radio" value="3" name="<?=$general->id?>"></td>
                        <td><input type="radio" value="4" name="<?=$general->id?>"></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Written</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($written_all as $written) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$written->name?></td>
                        <td><input type="radio" value="1" name="<?=$written->id?>"></td>
                        <td><input type="radio" value="2" name="<?=$written->id ?>"></td>
                        <td><input type="radio" value="3" name="<?=$written->id?>"></td>
                        <td><input type="radio" value="4" name="<?=$written->id?>"></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Team Works</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($team_works_all as $team_work) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$team_work->name?></td>
                        <td><input type="radio" value="1" name="<?=$team_work->id?>"></td>
                        <td><input type="radio" value="2" name="<?=$team_work->id?>"></td>
                        <td><input type="radio" value="3" name="<?=$team_work->id?>"></td>
                        <td><input type="radio" value="4" name="<?=$team_work->id?>"></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Music</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($music_all as $music) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$music->name?></td>
                        <td><input type="radio" value="1" name="<?=$music->id?>"></td>
                        <td><input type="radio" value="2" name="<?=$music->id?>"></td>
                        <td><input type="radio" value="3" name="<?=$music->id?>"></td>
                        <td><input type="radio" value="4" name="<?=$music->id?>"></td>
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
    <?php else: ?>
        <div class="col-md-8">
            <?php echo form_open(site_url('admin/update_extra_curriculum_marks'));?>
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 45%"><?php echo get_phrase('name');?></th>
                    <th style="text-align: center"><?php echo get_phrase('A+');?></th>
                    <th style="text-align: center"><?php echo get_phrase('A');?></th>
                    <th style="text-align: center"><?php echo get_phrase('B');?></th>
                    <th style="text-align: center"><?php echo get_phrase('C');?></th>
                </tr>
                <tr>
                    <th class="c_header">General</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($generals_all as $general) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$general->name?><input type="hidden" name="gid<?=$general->id?>" value="<?=$general->gid?>"> </td>
                        <td><input type="radio" value="1" name="<?=$general->id?>" <?= ($general->grade == 1) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="2" name="<?=$general->id?>" <?= ($general->grade == 2) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="3" name="<?=$general->id?>" <?= ($general->grade == 3) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="4" name="<?=$general->id?>" <?= ($general->grade == 4) ? 'checked' : '' ?>></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Written</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($written_all as $written) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$written->name?><input type="hidden" name="gid<?=$written->id?>" value="<?=$written->gid?>"></td>
                        <td><input type="radio" value="1" name="<?=$written->id?>" <?= ($written->grade == 1) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="2" name="<?=$written->id?>" <?= ($written->grade == 2) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="3" name="<?=$written->id?>" <?= ($written->grade == 3) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="4" name="<?=$written->id?>" <?= ($written->grade == 4) ? 'checked' : '' ?>></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Team Works</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($team_works_all as $team_work) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$team_work->name?><input type="hidden" name="gid<?=$team_work->id?>" value="<?=$team_work->gid?>"></td>
                        <td><input type="radio" value="1" name="<?=$team_work->id?>" <?= ($team_work->grade == 1) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="2" name="<?=$team_work->id?>" <?= ($team_work->grade == 2) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="3" name="<?=$team_work->id?>" <?= ($team_work->grade == 3) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="4" name="<?=$team_work->id?>" <?= ($team_work->grade == 4) ? 'checked' : '' ?>></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <thead>
                <tr>
                    <th class="c_header">Music</th>
                    <th colspan="4" class="c_header"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($music_all as $music) :
                    ?>
                    <tr>
                        <td style="text-align: left"><?=$music->name?><input type="hidden" name="gid<?=$music->id?>" value="<?=$music->gid?>"> </td>
                        <td><input type="radio" value="1" name="<?=$music->id?>" <?= ($music->grade == 1) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="2" name="<?=$music->id?>" <?= ($music->grade == 2) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="3" name="<?=$music->id?>" <?= ($music->grade == 3) ? 'checked' : '' ?>></td>
                        <td><input type="radio" value="4" name="<?=$music->id?>" <?= ($music->grade == 4) ? 'checked' : '' ?>></td>
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
    <?php endif; ?>
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





<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').select2();
        $('#section_id').select2();
        $('#student_id').select2();
        $('#exam').select2();
        $('#class_id').on('change', function() {
            var class_id = $(this).val();
            $.ajax({
                url: '<?php echo site_url('Report/get_sections_for_ssph/');?>' + class_id
            }).done(function(response) {
                // $('#section_holder').html(response);
                $('.sec_field').html();
                $('.sec_field').html(response);
                $('#section_id').attr('disabled', false);
                $('#section_id').select2();
                // var section_id = $('#section_id').val();
            });
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#class_id').select2();
        $('#student_id').select2();
        $('.sec_field').on('change', function() {
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            $.ajax({
                url: '<?php echo site_url('Report/get_student_for_ssph/');?>' + class_id + '/' + section_id
            }).done(function(response) {
                $('#student_holder').html(response);
                $('#student_id').select2();
                //var section_id = $('#student_id').val();
            });
        });

    });

</script>