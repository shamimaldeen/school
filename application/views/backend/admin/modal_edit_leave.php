<?php 
$edit_data		=	$this->db->get_where('leaves' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_employee_leave');?>
            	</div>
            </div>
			<div class="panel-body">
				
            <?php echo form_open(site_url('leave/leave_action/do_update/'.$row['id'] ), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('leave_name');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="leave_name" value="<?php echo $row['leave_name'];?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('short_name');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="short_name" value="<?php echo $row['short_name'];?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('leave_days');?></label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="leave_days" value="<?php echo $row['leave_days'];?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_leave');?></button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>





