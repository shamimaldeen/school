<?php
$row = $this->db->get_where('working_days' , array('id' => $param2) )->row_array();
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_working_days');?>
            	</div>
            </div>
			<div class="panel-body">
				
            <?php echo form_open(site_url('leave/working_action/do_update/'.$row['id'] ), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('month_name');?></label>
                    <div class="col-sm-5">
                        <select class="width-30 form-control" name="month" data-validate="required">
                            <option value="">Select Month</option>
                            <option value="01" <?php
                            if ($row['month'] == '01') {
                                echo "selected";
                            }
                            ?> >January</option>
                            <option value="02" <?php
                            if ($row['month'] == '02') {
                                echo "selected";
                            }
                            ?> >February</option>
                            <option value="03" <?php
                            if ($row['month'] == '03') {
                                echo "selected";
                            }
                            ?> >March</option>
                            <option value="04" <?php
                            if ($row['month'] == '04') {
                                echo "selected";
                            }
                            ?> >April</option>
                            <option value="05" <?php
                            if ($row['month'] == '05') {
                                echo "selected";
                            }
                            ?> >May</option>
                            <option value="06" <?php
                            if ($row['month'] == '06') {
                                echo "selected";
                            }
                            ?> >June</option>
                            <option value="07" <?php
                            if ($row['month'] == '07') {
                                echo "selected";
                            }
                            ?> >July</option>
                            <option value="08" <?php
                            if ($row['month'] == '08') {
                                echo "selected";
                            }
                            ?> >August</option>
                            <option value="09" <?php
                            if ($row['month'] == '09') {
                                echo "selected";
                            }
                            ?> >September</option>
                            <option value="10" <?php
                            if ($row['month'] == '10') {
                                echo "selected";
                            }
                            ?> >October</option>
                            <option value="11" <?php
                            if ($row['month'] == '11') {
                                echo "selected";
                            }
                            ?> >November</option>
                            <option value="12" <?php
                            if ($row['month'] == '12') {
                                echo "selected";
                            }
                            ?> >December</option>
                        </select>
                        <span class="red"><?php echo form_error('month'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>
                    <div class="col-sm-5">
                        <select class="width-30 form-control" name="year" data-validate="required">
                            <option value="">Select Year</option>
                            <?php
                            for ($year = date("Y"); $year >= 2014; $year--) {
                                ?>
                                <option value="<?php echo $year ?>" <?php
                                if ($row['year'] == $year) {
                                    echo "selected";
                                }
                                ?> ><?php echo $year ?></option>
                            <?php } ?>
                        </select>
                        <span class="red"><?php echo form_error('year'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('working_day');?></label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="working_day" value="<?= $row['working_day'] ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_working_day');?></button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>





