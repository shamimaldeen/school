<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_new_section');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/sections/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" placeholder="Name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('nick_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nick_name" value="" >
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                        
						<div class="col-sm-5">
							<select name="class_id" class="form-control" onchange="return get_subject_by_class(this.value)" data-message-required="<?php echo get_phrase('value_required');?>" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
                              $vtype = $this->session->userdata('vtype');
									$classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
									foreach($classes as $row):
                                ?>
                                		<option value="<?php echo $row['class_id'];?>">
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php
									endforeach;
								?>
                          </select>
						</div>
					</div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
                        <div class="col-sm-5">
                            <select class="form-control" name="subject_id" id="section_subject_holder" data-message-required="<?php echo get_phrase('value_required');?>" required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('shift');?></label>
                        <div class="col-sm-5">
                            <select class="form-control" name="shift">
                                <option value="">Select Shift</option>
                                <option value="Day">Day</option>
                                <option value="Morning">Morning</option>
                            </select>
                        </div>
                    </div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
						<div class="col-sm-5">
							<select name="teacher_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$teachers = $this->db->get('teacher')->result_array();
									foreach($teachers as $row):
										?>
                                		<option value="<?php echo $row['teacher_id'];?>"><?php echo $row['name'];?></option><?php
									endforeach;
								?>
                          </select>
						</div> 
					</div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Course Type</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="course_type">
                                <option value="">Select Course Type</option>
                                <option value="1">Monthly</option>
                                <option value="2">Course (Contractual)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_section');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

