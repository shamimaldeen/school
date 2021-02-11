<style>
    div#select2-drop {
        bottom: 1112px !important;
    }
</style>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('admission_form');?>
            	</div>
            </div>
			<div class="panel-body">

                    <?php echo form_open(site_url('admin/student/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nick_name');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="nick_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('class_roll');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="class_roll" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label for="field-2" class="col-sm-3 control-label">--><?php //echo get_phrase('version_type');?><!--</label>-->
<!---->
<!--                        <div class="col-sm-5">-->
<!--                            <select name="version_id" class="form-control" data-validate="required"-->
<!--                                    data-message-required="--><?php //echo get_phrase('value_required');?><!--">-->
<!--                                <option value="">--><?php //echo get_phrase('select');?><!--</option>-->
<!--                                --><?php
//                                $version_all = $this->db->get('version_type')->result_array();
//                                foreach($version_all as $row2):
//                                    ?>
<!--                                    <option value="--><?php //echo $row2['id'];?><!--">-->
<!--                                        --><?php //echo $row2['name'];?>
<!--                                    </option>-->
<!--                                --><?php
//                                endforeach;
//                                ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('guardian');?></label>

						<div class="col-sm-5">
							<select name="parent_id" class="form-control select2" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
								$parents = $this->db->get('parent')->result_array();
								foreach($parents as $row):
									?>
                            		<option value="<?php echo $row['parent_id'];?>">
										<?php echo $row['name'].' - '. $row['mother_name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" id="class_id"
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
                              $vtype = $this->session->userdata('vtype');
								$classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
								foreach($classes as $row):
                                ?>
                            		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
					</div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admit_section');?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="section" id="section_selector_holder2" data-validate="required"
                                data-message-required="<?php echo get_phrase('value_required');?>" required>
                            <option value=""><?php echo get_phrase('select_section');?></option>
                        </select>
                    </div>
                </div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('batch');?></label>
		                    <div class="col-sm-5">
		                        <select name="section_id[]" class="form-control" id="section_selector_holder" data-validate="required"
                                    data-message-required="<?php echo get_phrase('value_required');?>" multiple required>
		                            <option value=""><?php echo get_phrase('select_class_first');?></option>
			                    </select>
			                </div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('id_no');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="student_code" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>" data-validate="required" id="class_id"
								data-message-required="<?php echo get_phrase('value_required');?>">
						</div>
					</div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Group');?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="group">
                            <option value="">Select Group</option>
                            <option value="Humanities">Humanities</option>
                            <option value="Business Studies">Business Studies</option>
                            <option value="Science">Science</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('optional_subject_(if any)');?></label>
                    <div class="col-sm-5">
                        <select name="opt_sub_id" class="form-control" id="optional_subject_selector_holder">
                            <option value=""><?php echo get_phrase('select_class_first');?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label">Shift</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="shift">
                            <option value="">Select Shift</option>
                            <option value="Day">Day</option>
                            <option value="Morning">Morning</option>
                        </select>
                    </div>
                </div>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="birthday" id="std-birthday" value="" data-start-view="2" autocomplete="off">
						</div>
					</div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admission_date');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="popupDatepicker2" name="admission_date" value="" data-start-view="2" autocomplete="off">
                        </div>
                    </div>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>

						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
						</div>
					</div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admission_fee');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="admission_fee" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required >
                        </div>
                    </div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email').'/'.get_phrase('username');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>

						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('dormitory');?></label>

						<div class="col-sm-5">
							<select name="dormitory_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$dormitories = $this->db->get('dormitory')->result_array();
	                              	foreach($dormitories as $row):
	                              ?>
                              		<option value="<?php echo $row['dormitory_id'];?>"><?php echo $row['name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('transport_route');?></label>

						<div class="col-sm-5">
							<select name="transport_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$transports = $this->db->get('transport')->result_array();
	                              	foreach($transports as $row):
	                              ?>
                              		<option value="<?php echo $row['transport_id'];?>"><?php echo $row['route_name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div>
					</div>

                    <div class="form-group">
                        <label for="agent_banking_no" class="col-sm-3 control-label"><?php echo get_phrase('agent_banking_no.');?></label>

                        <div class="col-sm-5">
                            <input type="text" id="agent_banking_no" class="form-control" name="agent_banking_no" value="" placeholder="<?php echo get_phrase('agent_banking_no.');?> (if any)">
                        </div>
                    </div>



					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>

						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<blockquote class="blockquote-blue">
			<p>
				<strong>Student Admission Notes</strong>
			</p>
			<p>
				Admitting new students will automatically create an enrollment to the selected class in the running session.
				Please check and recheck the informations you have inserted because once you admit new student, you won't be able
				to edit his/her class,roll,section without promoting to the next session.
			</p>
		</blockquote>
	</div>

</div>

<script type="text/javascript">

	function get_class_sections(class_id) {
    	$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
                jQuery('#section_selector_holder2').html(response);
            }
        });
    	$.ajax({
            url: '<?php echo site_url('admin/get_4th_subject_listByClass/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#optional_subject_selector_holder').html(response);
            }
        });

    }
</script>