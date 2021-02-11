<hr /><?php echo form_open(site_url('admin/employee_attendance_report_selector')); ?><div class="row">    <div class="col-md-2">        <div class="form-group">            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('month'); ?></label>            <select name="month" class="form-control selectboxit" id="month">                <?php                for ($i = 1; $i <= 12; $i++):                    if ($i == 1)                        $m = 'january';                    else if ($i == 2)                        $m = 'february';                    else if ($i == 3)                        $m = 'march';                    else if ($i == 4)                        $m = 'april';                    else if ($i == 5)                        $m = 'may';                    else if ($i == 6)                        $m = 'june';                    else if ($i == 7)                        $m = 'july';                    else if ($i == 8)                        $m = 'august';                    else if ($i == 9)                        $m = 'september';                    else if ($i == 10)                        $m = 'october';                    else if ($i == 11)                        $m = 'november';                    else if ($i == 12)                        $m = 'december';                    ?>                    <option value="<?php echo $i; ?>"                        <?php if ($month == $i) echo 'selected'; ?>  >                        <?php echo get_phrase($m); ?>                    </option>                <?php                endfor;                ?>            </select>        </div>    </div>    <div class="col-md-2">        <div class="form-group">            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('sessional_year'); ?></label>            <select class="form-control selectboxit" name="sessional_year">                <?php                $sessional_year_options = explode('-', $running_year); ?>                <option value="<?php echo $sessional_year_options[0]; ?>" <?php if($sessional_year == $sessional_year_options[0]) echo 'selected'; ?>>                    <?php echo $sessional_year_options[0]; ?></option>                <option value="<?php echo $sessional_year_options[1]; ?>" <?php if($sessional_year == $sessional_year_options[1]) echo 'selected'; ?>>                    <?php echo $sessional_year_options[1]; ?></option>            </select>        </div>    </div>    <input type="hidden" name="year" value="<?php echo $running_year; ?>">    <div class="col-md-2" style="margin-top: 20px;">        <button type="submit" class="btn btn-info"><?php echo get_phrase('show_report'); ?></button>    </div></div><?php echo form_close(); ?><?php if ($month != '' && $sessional_year != ''): ?>    <br>    <div class="row">        <div class="col-md-4"></div>        <div class="col-md-4" style="text-align: center;">            <div class="tile-stats tile-gray">                <div class="icon"><i class="entypo-docs"></i></div>                <h3 style="color: #696969;">                    <?php                    if ($month == 1)                        $m = 'January';                    else if ($month == 2)                        $m = 'February';                    else if ($month == 3)                        $m = 'March';                    else if ($month == 4)                        $m = 'April';                    else if ($month == 5)                        $m = 'May';                    else if ($month == 6)                        $m = 'June';                    else if ($month == 7)                        $m = 'July';                    else if ($month == 8)                        $m = 'August';                    else if ($month == 9)                        $m = 'Sepetember';                    else if ($month == 10)                        $m = 'October';                    else if ($month == 11)                        $m = 'November';                    else if ($month == 12)                        $m = 'December';                    echo get_phrase('employee_attendance_sheet');                    ?>                </h3>                <h4 style="color: #696969;">                    <?php echo $m . ', ' . $sessional_year; ?>                </h4>            </div>        </div>        <div class="col-md-4"></div>    </div>    <hr />    <div class="row">        <div class="col-md-12">            <table class="table table-bordered" id="my_table">                <thead>                <tr>                    <td style="text-align: center;">                        <?php echo get_phrase('teacher'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>                    </td>                    <?php                    $year = explode('-', $running_year);                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $sessional_year);                    for ($i = 1; $i <= $days; $i++) {                        ?>                        <td style="text-align: center;"><?php echo $i; ?></td>                    <?php } ?>                </tr>                </thead>                <tbody>                <?php                $data = array();                $teachers = $this->db->get('teacher')->result_array();                foreach ($teachers as $row):                ?>                <tr>                    <td style="text-align: left;">                        <?php echo $row['name']; ?>                    </td>                    <?php                    $status = 0;                    for ($i = 1; $i <= $days; $i++) {                        $working_date = $sessional_year . '-' .  str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);                        $attendance = $this->db->get_where('employee_attendance', array('year' => $running_year, 'working_date' => $working_date, 'emp_id' => $row['teacher_id']))->result_array();                        foreach ($attendance as $row1):                            $month_dummy = date('d', strtotime($row1['working_date']));                            if ($i == $month_dummy)                                $status = $row1['status'];                        endforeach;                        ?>                        <td style="text-align: center;">                            <?php if ($status == 1) { ?>                                <i class="entypo-record" style="color: #00a651;"></i>                            <?php  } if($status == 2)  { ?>                                <i class="entypo-record" style="color: #ee4749;"></i>                            <?php  } $status =0;?>                        </td>                    <?php } ?>                    <?php endforeach; ?>                </tr>                <?php ?>                </tbody>            </table>            <center>                <a href="<?php echo site_url('admin/employee_attendance_report_print_view/' .  $month . '/' . $sessional_year); ?>"                   class="btn btn-primary" target="_blank">                    <?php echo get_phrase('print_attendance_sheet'); ?>                </a>            </center>        </div>    </div><?php endif; ?><script type="text/javascript">    // ajax form plugin calls at each modal loading,    $(document).ready(function() {        // SelectBoxIt Dropdown replacement        if($.isFunction($.fn.selectBoxIt))        {            $("select.selectboxit").each(function(i, el)            {                var $this = $(el),                    opts = {                        showFirstOption: attrDefault($this, 'first-option', true),                        'native': attrDefault($this, 'native', false),                        defaultText: attrDefault($this, 'text', ''),                    };                $this.addClass('visible');                $this.selectBoxIt(opts);            });        }    });</script>