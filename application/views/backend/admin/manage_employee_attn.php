<hr /><?php echo form_open(site_url('admin/manage_employee_attendance/'));?><div class="row">    <div class="col-md-3">        <div class="form-group">            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date');?></label>            <input type="text" class="form-control datepicker" name="sel_date" data-format="dd-mm-yyyy"                   value="<?php echo date("d-m-Y");?>"/>        </div>    </div>    <input type="hidden" name="year" value="<?php echo $running_year;?>">    <div class="col-md-3" style="margin-top: 20px;">        <button type="submit" id = "submit" class="btn btn-info"><?php echo get_phrase('manage_attendance');?></button>    </div></div><?php echo form_close();?><script type="text/javascript">    var class_selection = "";    jQuery(document).ready(function($) {        $('#submit').attr('disabled', false);    });    function check_validation(){        if(class_selection !== ''){            $('#submit').removeAttr('disabled')        }        else{            $('#submit').attr('disabled', 'disabled');        }    }</script>