<hr /><?php echo form_open(site_url('admin/manage_employee_advance_salary')); ?><div class="row">    <div class="col-md-2">        <div class="form-group">            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('month'); ?></label>            <select name="month" class="form-control selectboxit" title="Month">                <?php                for ($i = 1; $i <= 12; $i++):                    if ($i == 1)                        $m = 'january';                    else if ($i == 2)                        $m = 'february';                    else if ($i == 3)                        $m = 'march';                    else if ($i == 4)                        $m = 'april';                    else if ($i == 5)                        $m = 'may';                    else if ($i == 6)                        $m = 'june';                    else if ($i == 7)                        $m = 'july';                    else if ($i == 8)                        $m = 'august';                    else if ($i == 9)                        $m = 'september';                    else if ($i == 10)                        $m = 'october';                    else if ($i == 11)                        $m = 'november';                    else if ($i == 12)                        $m = 'december';                    ?>                    <option value="<?php echo $i; ?>"                        <?php if($month == $i) echo 'selected'; ?>  >                        <?php echo get_phrase($m); ?>                    </option>                <?php                endfor;                ?>            </select>        </div>    </div>    <div class="col-md-2">        <div class="form-group">            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('year'); ?></label>            <select class="form-control selectboxit" name="year1">                <?php                $sessional_year = explode('-', $running_year);                ?>                <option value="<?php echo $sessional_year[0]; ?>"><?php echo $sessional_year[0]; ?></option>                <option value="<?php echo $sessional_year[1]; ?>"><?php echo $sessional_year[1]; ?></option>            </select>        </div>    </div>    <input type="hidden" name="year" value="<?php echo $running_year;?>">    <div class="col-md-2" style="margin-top: 20px;">        <button type="submit" class="btn btn-info"><?php echo get_phrase('show_report');?></button>    </div></div><?php echo form_close(); ?><hr /><div class="row" style="text-align: center;">    <div class="col-sm-4"></div>    <div class="col-sm-4">        <div class="tile-stats tile-gray">            <div class="icon"><i class="entypo-chart-area"></i></div>            <h3 style="color: #696969;"><?php echo get_phrase('daily_employee_attendance'); ?></h3>            <h4 style="color: #696969;">                <?php echo get_monthName($month) . ', '.$year1; ?>            </h4>        </div>    </div>    <div class="col-sm-4"></div></div><br><div class="row">    <div class="col-md-1"></div>    <div class="col-md-10">        <?php if (!isset($data)):            ?>            <?php echo form_open(site_url('admin/storeEmployeeAdvanceSalaryData')); ?>            <input type="hidden" name="month" value="<?php echo $month; ?>">            <input type="hidden" name="year1" value="<?php echo $year1; ?>">            <div id="attendance_update">                <table class="table table-bordered">                    <thead>                    <tr>                        <th>#</th>                        <th><?php echo get_phrase('name'); ?></th>                        <th><?php echo get_phrase('designation'); ?></th>                        <th><?php echo get_phrase('advance'); ?></th>                    </thead>                    <tbody>                    <?php                    $count = 1;                    $select_id = 0;                    $teachers = $this->db->select('teacher_id, name, designation')->get('teacher')->result_array();                    $total = count($teachers);                    foreach ($teachers as $row):                        ?>                        <tr>                            <td><?php echo $count++; ?></td>                            <td>                                <?php echo $row['name']; ?>                            </td>                            <td>                                <?php echo $row['designation']; ?>                            </td>                            <td><input type="text" class="form-control" name="advance_<?php echo $row['teacher_id']; ?>" value="0" onkeypress="return isNumber(event)" required="required"></td>                        </tr>                        <?php                        $select_id++;                    endforeach; ?>                    </tbody>                </table>            </div>            <center>                <button type="submit" class="btn btn-success" id="submit_button">                    <i class="entypo-thumbs-up"></i> <?php echo get_phrase('save_changes'); ?>                </button>            </center>            <?php echo form_close(); ?>        <?php else:            $total = count($data);            ?>            <?php echo form_open(site_url('admin/updateEmployeeAdvanceSalary')); ?>            <input type="hidden" name="month" value="<?php echo $month; ?>">            <input type="hidden" name="year1" value="<?php echo $year1; ?>">            <div id="attendance_update">                <table class="table table-bordered">                    <thead>                    <tr>                        <th>#</th>                        <th><?php echo get_phrase('name'); ?></th>                        <th><?php echo get_phrase('designation'); ?></th>                        <th><?php echo get_phrase('advance'); ?></th>                    </tr>                    </thead>                    <tbody>                    <?php                    $count = 1;                    $select_id = 0;                    foreach ($data as $row):                        ?>                        <tr>                            <td><?php echo $count++; ?></td>                            <td>                                <?php echo $row['name']; ?><input type="hidden" name="asid_<?php echo $row['teacher_id']; ?>" value="<?php echo $row['asid']; ?>">                            </td>                            <td>                                <?php echo $row['designation']; ?>                            </td>                            <td><input type="text" class="form-control" name="advance_<?php echo $row['teacher_id']; ?>" value="<?php echo $row['advance']; ?>" onkeypress="return isNumber(event)" required="required"></td>                        </tr>                        <?php                        $select_id++;                    endforeach; ?>                    </tbody>                </table>            </div>            <center>                <button type="submit" class="btn btn-success" id="submit_button">                    <i class="entypo-thumbs-up"></i> <?php echo get_phrase('save_changes'); ?>                </button>            </center>            <?php echo form_close(); ?>        <?php endif; ?>    </div>    <div class="col-md-1"></div></div><script>    function isNumber(evt) {        evt = (evt) ? evt : window.event;        var charCode = (evt.which) ? evt.which : evt.keyCode;        if ((charCode > 31 && (charCode < 45 || charCode > 57)) || charCode == 47) {            return false;        }        return true;    }</script>