<?php 
$edit_data		=	$this->db->get_where('extra_curriculum_settings' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_curriculum');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/extra_curriculum/edit/do_update/'.$row['id'] ), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('type_of_curriculum');?></label>
                    <div class="col-sm-5">
                        <select name="curriculum_group" class="form-control selectboxit visible" style="width: 100%; display: none;">
                            <option <?= $row['group_id'] ==1 ? "selected" :  "" ?>  value="1">General</option>
                            <option <?= $row['group_id'] ==2 ? "selected" :  "" ?> value="2">Written</option>
                            <option <?= $row['group_id'] ==3 ? "selected" :  "" ?> value="3">Team Works</option>
                            <option <?= $row['group_id'] ==4 ? "selected" :  "" ?> value="4">Music</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_extra_curriculum');?></button>
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





