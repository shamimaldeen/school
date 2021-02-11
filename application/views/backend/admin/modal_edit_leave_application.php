<?php$row      = $this->db->get_where('leave_apply_form' , array('id' => $param2) )->row_array();$teachers = $this->db->select('teacher_id, name')->get('teacher')->result();$leaves   = $this->db->get('leaves')->result();?><div class="row">    <div class="col-md-12">        <div class="panel panel-primary" data-collapsed="0">            <div class="panel-heading">                <div class="panel-title" >                    <i class="entypo-plus-circled"></i>                    <?php echo get_phrase('edit_leave_application');?>                </div>            </div>            <div class="panel-body">                <?php echo form_open(site_url('leave/update_leave_application/'.$row['id'] ), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>                <div class="padded">                    <div class="form-group">                        <label class="col-sm-3 control-label"><?php echo get_phrase('leave_type');?></label>                        <div class="col-sm-5">                            <select name="leave_id" id="leave_id" class="form-control" title="Leave Type" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required>                                <option value=""> Select a Leave Type</option>                                <?php                                foreach ($leaves as $le) {                                     echo '<option value="'.$le->id.'"  '.(($le->id==$row['leave_id']) ? "selected" : "").'>'.$le->leave_name.'</option>';                                }                                ?>                            </select>                            <span class="form-error"><?php echo form_error('leave_id'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label" for="employee_id"><?php echo get_phrase('employee_name');?></label>                        <div class="col-sm-5">                            <select name="employee_id" id="employee_id" class="form-control" title="<?php echo get_phrase('employee_name');?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required>                                <option value=""> Select an Employee </option>                                <?php                                foreach ($teachers as $emp) {                                    echo '<option value="'.$emp->teacher_id.'" '.(($emp->teacher_id==$row['employee_id']) ? "selected" : "").'>'.$emp->name.'</option>';                                }                                ?>                            </select>                            <span class="form-error"><?php echo form_error('employee_id'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label" for="from_date"><?php echo get_phrase('from_date');?></label>                        <div class="col-sm-5">                            <input type="text" class="datepicker form-control From_Date" name="from_date" id="from_date" value="<?php echo date('m/d/Y', strtotime($row['from_date'])); ?>" placeholder="<?php echo get_phrase('from_date');?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" readonly required>                            <span class="form-error"><?php echo form_error('from_date'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label" for="to_date"><?php echo get_phrase('to_date');?></label>                        <div class="col-sm-5">                            <input type="text" class="datepicker form-control To_Date" name="to_date" id="to_date" value="<?php echo date('m/d/Y', strtotime($row['to_date'])); ?>" placeholder="<?php echo get_phrase('to_date');?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" readonly required/>                            <span class="form-error"><?php echo form_error('to_date'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label" for="reason_type">Reason of Leave</label>                        <div class="col-sm-5">                            <input type="text" class="form-control" name="reason_type" id="reason_type" value="<?php echo $row['reason_type']; ?>" placeholder="Reason of Leave" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>                            <span class="form-error"><?php echo form_error('reason_type'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label" for="leavecount"><?php echo get_phrase('total_leave');?></label>                        <div class="col-sm-5">                            <input type="number" class="form-control" name="leavecount" id="leavecount" value="<?php echo $row['leavecount']; ?>" placeholder="Total Leave" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" required>                            <span class="form-error"><?php echo form_error('leavecount'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <div class="col-sm-offset-3 col-sm-5">                            <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>                        </div>                    </div>                    </form>                </div>            </div>        </div>    </div>    <script>        function date_diff(FD, TD) {            var date1 = new Date(FD);            var date2 = new Date(TD);            var timeDiff = Math.abs(date2.getTime() - date1.getTime());            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));            return diffDays + 1;        }        jQuery(function ($) {            $('#leavecount').on('focus', function () {                var FD = $('.From_Date').datepicker({ dateFormat: 'dd-mm-yy' }).val();                var TD = $('.To_Date').datepicker({ dateFormat: 'dd-mm-yy' }).val();                $(this).val(date_diff(FD, TD));            });        });    </script>