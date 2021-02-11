<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_exam_shedule');?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-print"></i>
                    <?php echo get_phrase('print_exam_shedule');?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>

        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <hr />
                <form  action="<?= base_url()?>index.php/Report/exam_schedule" method="post">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
                                <select name="exam_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                    $vtype = $this->session->userdata('vtype');
                                    $year    = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                                    $exams = $this->db->get_where('exam', array('year' => $year, 'vtype'=>$vtype))->result_array();
                                    $class = $this->db->get_where('class', ['vtype'=>$vtype])->result_array();
                                    foreach($exams as $row):
                                    ?>
                                        <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
                                <select name="class_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                    foreach($class as $row2):
                                        ?>
                                        <option value="<?php echo $row2['class_id'];?>">
                                            <?php echo $row2['name'];?>
                                        </option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div id="subject_holder">

                            <div class="col-md-2" style="margin-top: 20px;">
                                <center>
                                    <button type="submit" class="btn btn-info"><?php echo get_phrase('search_schedule');?></button>
                                </center>
                            </div>
                        </div>

                    </div>
                </form>
                <?php echo form_close();?>
                <p id="from_time_error" style="color: red; text-align: center; font-size: 14px"></p>
                <?php if (!empty($all_subject)): ?>
                    <form method="post" id="exam_shedul_form" action="<?php echo base_url()?>index.php/Report/save_examSchedule" onsubmit="return validate_schedule_table();">

                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                        <div class="row" style="text-align: center;">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <div class="tile-stats tile-gray">
                                    <div class="icon"><i class="entypo-chart-bar"></i></div>
                                    <h3 style="color: #696969;"><?php echo get_phrase('exam schedule_for_'.$examname->name); ?></h3>
                                    <h3 style="color: #696969;"><?php echo get_phrase('class name_'.$classname->name); ?></h3>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th  style="width: 5%">#</th>
                                        <th><?php echo get_phrase('subject_name');?></th>
                                        <th width="15%"><?php echo get_phrase('exam_date');?></th>
                                        <th  style="width: 18%"><?php echo get_phrase('time_from');?></th>
                                        <th  style="width: 18%"><?php echo get_phrase('time_to');?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sl =0;
                                    foreach($all_subject as $subject):

                                        ?>
                                        <tr>
                                            <td><?= ++$sl; ?></td>
                                            <td><?= $subject->name;?></td>
                                            <td>
                                                <input type="text" placeholder="click here.." id="exam_date" class="datepicker form-control" name="exam_date[<?php echo $sl; ?>]" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                            </td>
                                            <td>
                                                <div class="col-sm-5" style="padding: 0; margin: 0;">
                                                    <input type="text" class="form-control" id="from_time" name="from_time[<?php echo $sl; ?>]" placeholder="8:00" data-validate="required"/>

                                                </div>
                                                <div class="col-sm-7" style="padding: 0; margin: 0;">
                                                    <select id="from_am_pm" name="from_am_pm[<?php echo $sl; ?>]" class="form-control" >
                                                        <option value=""><?php echo get_phrase('select');?></option>
                                                        <option value="am">am</option>
                                                        <option value="pm">pm</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-5" style="padding: 0; margin: 0;">
                                                    <input type="text" class="form-control" id="to_time" name="to_time[<?php echo $sl; ?>]" placeholder="8:00" data-validate="required"/>
                                                </div>
                                                <div class="col-sm-7" style="padding: 0; margin: 0;">
                                                    <select id="to_am_pm" name="to_am_pm[<?php echo $sl; ?>]" class="form-control"   >
                                                        <option value=""><?php echo get_phrase('select');?></option>
                                                        <option value="am">am</option>
                                                        <option value="pm">pm</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="subject_id[<?php echo $sl; ?>]" value="<?php echo $subject->subject_id; ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                                <center>
                                    <button type="submit" class="btn btn-success" id="submit_button">
                                        <i class="entypo-plus-circled"></i> add exam schedule
                                    </button>
                                </center>
                                <?php echo form_close();?>

                            </div>
                            <div class="col-md-2"></div>
                        </div>

                    </form>
                <?php endif; ?>
                <!------EDITED SCHEDULE DATA ----------------------------->
                <?php if (isset($exam_schedule)): ?>
                    <form method="post" id="exam_shedul_form" action="<?php echo base_url()?>index.php/Report/update_examSchedule_data" onsubmit="return validate_schedule_table();">

                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                        <div class="row" style="text-align: center;">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <div class="tile-stats tile-gray">
                                    <div class="icon"><i class="entypo-chart-bar"></i></div>
                                    <h3 style="color: #696969;"><?php echo get_phrase('exam schedule_for_'.$examname->name); ?></h3>
                                    <h3 style="color: #696969;"><?php if (!empty($classname)){ echo get_phrase('class name_'.$classname->name); }?></h3>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th  style="width: 5%">#</th>
                                        <th><?php echo get_phrase('subject_name');?></th>
                                        <th width="15%"><?php echo get_phrase('exam_date');?></th>
                                        <th  style="width: 18%"><?php echo get_phrase('time_from');?></th>
                                        <th  style="width: 18%"><?php echo get_phrase('time_to');?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sl = 0;

                                    foreach($exam_schedule as $schedule):
                                        ?>
                                        <tr>
                                            <td><?= ++$sl; ?></td>
                                            <td><?= $schedule->subject_name;?></td>
                                            <td>
                                                <input type="text" placeholder="click here.." id="exam_date" value="<?php echo date_format(date_create($schedule->exam_date), 'm/d/Y'); ?>" class="datepicker form-control" name="exam_date[<?php echo $schedule->id; ?>]" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                            </td>
                                            <td>
                                                <div class="col-sm-5" style="padding: 0; margin: 0">
                                                    <input type="text" class="form-control" id="from_time" name="from_time[<?php echo $sl; ?>]" value="<?php echo $schedule->from_time; ?>" placeholder="8:00" data-validate="required"/>

                                                </div>
                                                <div class="col-sm-7" style="padding: 0; margin: 0">
                                                    <select id="from_am_pm" name="from_am_pm[<?php echo $schedule->id; ?>]" class="form-control" required>
                                                        <option value=""><?php echo get_phrase('select');?></option>
                                                        <option value="am" <?php echo ($schedule->from_am_pm == 'am') ? 'selected' : ''; ?>>am</option>
                                                        <option value="pm" <?php echo ($schedule->from_am_pm == 'pm') ? 'selected' : ''; ?>>pm</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-5" style="padding: 0; margin: 0">
                                                    <input type="text" class="form-control" id="to_time" name="to_time[<?php echo $schedule->id; ?>]" value="<?php echo $schedule->to_time; ?>" placeholder="8:00" data-validate="required"/>
                                                </div>
                                                <div class="col-sm-7" style="padding: 0; margin: 0">
                                                    <select id="to_am_pm" name="to_am_pm[<?php echo $sl; ?>]" class="form-control" required>
                                                        <option value=""><?php echo get_phrase('select');?></option>
                                                        <option value="am" <?php echo ($schedule->to_am_pm == 'am') ? 'selected' : ''; ?>>am</option>
                                                        <option value="pm" <?php echo ($schedule->to_am_pm == 'pm') ? 'selected' : ''; ?>>pm</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="subject_id[<?php echo $schedule->id; ?>]" value="<?php echo $schedule->subject_id; ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                                <center>
                                    <button type="submit" class="btn btn-success" id="submit_button">
                                        <i class="entypo-plus-circled"></i> <?php echo get_phrase('update_exam_schedule'); ?>
                                    </button>
                                </center>
                                <?php echo form_close();?>

                            </div>
                            <div class="col-md-2"></div>
                        </div>

                    </form>
                <?php endif; ?>

            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <hr>
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <form id="print_schedule" action="<?= base_url()?>index.php/Report/sheet_exam_schedule" method="post" target="_blank">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
                                    <select name="exam_id" class="form-control select2" id="exam_id2" required>
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php

                                        foreach($exams as $row3):
                                            ?>
                                            <option value="<?php echo $row3['exam_id'];?>">
                                                <?php echo $row3['name'];?>
                                            </option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
                                    <select name="class_id" class="form-control select2" id="class_id2" required>
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php
                                        foreach($class as $row4):
                                            ?>
                                            <option value="<?php echo $row4['class_id'];?>">
                                                <?php echo $row4['name'];?>
                                            </option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div id="subject_holder">

                                <div class="col-md-2" style="margin-top: 20px;">
                                    <center>
                                        <button type="submit" class="btn btn-info"><?php echo get_phrase('Print_Exam_schedule');?></button>
                                    </center>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            <!----CREATION FORM ENDS-->
        </div>
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {


        var datatable = $("#table_export").dataTable();

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>

<script type="text/javascript">
    function validate_schedule_table() {
        var flag = true;
        $('#from_time_error').empty();
        $("input#exam_date").each(function() {
            if($(this).val() == "" && $(this).val().length < 1) {
                $('#from_time_error').append('Exam date field is required<br />');
                flag = false;
            }
        });
        $("input#from_time").each(function() {
            if($(this).val() == "" && $(this).val().length < 1) {
                $('#from_time_error').append('From time field is required<br />');
                flag = false;
            }
        });
        $("select#from_am_pm").each(function() {
            if($(this).val() == "" && $(this).val().length < 1) {
                $('#from_time_error').append('Select the from time am/pm field is required<br />');
                flag = false;
            }
        });
        $("input#to_time").each(function() {
            if($(this).val() == "" && $(this).val().length < 1) {
                $('#from_time_error').append('To time field is required<br />');
                flag = false;
            }
        });
        $("select#to_am_pm").each(function() {
            if($(this).val() == "" && $(this).val().length < 1) {
                $('#from_time_error').append('Select the to time am/pm field is required<br />');
                flag = false;
            }
        });
        return flag;
    }
</script>
<script>
    $('.datepicker').datepicker({
        autoclose: true,
    });
</script>
<script>
    //$(document).ready(function () {
    //    $("#print_schedule").submit(function () {
    //        alert('success');
    //        var class_id = $("#class_id2").val();
    //        var exam_id  = $("#exam_id2").val();
    //
    //        $.ajax({
    //            url: '<?php //echo site_url('Report/check_exam_schedule/');?>//' + class_id + '/' + exam_id ,
    //            success: function(result)
    //            {
    //                if (result == 0)
    //                {
    //                    toastr.error('Please insert exam schedule for the class/exam & try again.');
    //                    return false;
    //                }
    //            }
    //        });
    //
    //    });
    //});
</script>
<script>
    //function check_exam_scheduleData() {
    //    event.preventDefault();
    //    var ret = false;
    //    $(document).ready(function () {
    //        var class_id = $("#class_id2").val();
    //        var exam_id  = $("#exam_id2").val();
    //
    //        $.ajax({
    //            url: '<?php //echo site_url('Report/check_exam_schedule/');?>//' + class_id + '/' + exam_id,
    //            success: function(result)
    //            {
    //                if (result == 0)
    //                {
    //                    toastr.error('Please insert exam schedule for the class/exam & try again.');
    //                    ret = false;
    //                }else{
    //                    return true;
    //                    $( "#print_schedule" ).submit();
    //                }
    //            }
    //        });
    //    });
        // return ret;
    // }

    //$('#print_schedule').submit(function (evt) {
    //    evt.preventDefault();
    //        var class_id = $("#class_id2").val();
    //        var exam_id  = $("#exam_id2").val();
    //        $.ajax({
    //            url: '<?php //echo site_url('Report/check_exam_schedule/');?>//' + class_id + '/' + exam_id,
    //            success: function(result)
    //            {
    //                if (result == 0)
    //                {
    //                    toastr.error('Please insert exam schedule for the class/exam & try again.');
    //                    // window.history.back();
    //                }else{
    //                    //return true;
    //                    $( "#print_schedule" ).submit();
    //                }
    //            }
    //        });
    //
    //});
</script>