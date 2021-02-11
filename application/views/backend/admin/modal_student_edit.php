<?php
$vtype = $this->session->userdata('vtype');
$row = $this->db->get_where('enroll' , array(
	'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
))->row_array();
//dd($row);
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="fa fa-edit"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/student/do_update/'.$row['student_id'].'/'.$row['class_id'])  , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" alt="...">
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
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id'], 'vtype'=>$vtype))->row()->name; ?>">
						</div>
					</div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nick_name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="nick_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"
                                   value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id'], 'vtype'=>$vtype))->row()->nick_name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('class_roll');?></label>
                        <?php $roll_number = $this->db->get_where('enroll' , ['student_id' => $row['student_id']])
                            ->row()->roll;?>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="class_roll" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"
                                   value="<?= $roll_number?>" autofocus required>
                        </div>
                    </div>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="class" disabled value="<?php echo $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admit_section');?></label>
						<div class="col-sm-5">
							<select class="form-control" name="section" id="section_selector_holder2" data-validate="required"
                                    data-message-required="<?php echo get_phrase('value_required');?>" required>
                              <option value=""><?php echo get_phrase('select_section');?></option>
                              <?php
                              	$sections = $this->db->get_where('section' , array('class_id' => $row['class_id'], 'vtype'=>$vtype))->result_array();
                              	foreach($sections as $row2):
                                    ?>
                                <option value="<?php echo $row2['section_id'];?>"
                              	<?php if($row['section_id'] == $row2['section_id']) echo 'selected';; ?>><?php echo $row2['name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('batch');?></label>
						<div class="col-sm-5">
							<select class="form-control" name="section_id[]" id="section_selector_holder" data-validate="required"
                                    data-message-required="<?php echo get_phrase('value_required');?>" multiple required>
                              <option value=""><?php echo get_phrase('select_multiple_batch');?></option>
                              <?php
//                              	$sections = $this->db->get_where('section' , array('class_id' => $row['class_id'], 'vtype'=>$vtype))->result_array();
                              	$taken_sections = explode(',', $row['sections']);
                              	foreach($sections as $row2):
                                    ?>
                              <option value="<?php echo $row2['section_id'];?>"
                              	<?php foreach ($taken_sections as $sec_id):
                                    if($sec_id == $row2['section_id']) echo 'selected'; endforeach; ?>><?php echo $row2['name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('id');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="student_code"
								value="<?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>">
						</div>
					</div>

<!--                <div class="form-group">-->
<!--                    <label for="field-2" class="col-sm-3 control-label">--><?php //echo get_phrase('version_type');?><!--</label>-->
<!---->
<!--                    <div class="col-sm-5">-->
<!--                        --><?php
//                        $vtype = $this->db->get_where('student' , array(
//                            'student_id' => $row['student_id']
//                        ))->row()->vtype;?>
<!--                        <select name="version_id" class="form-control" data-validate="required"-->
<!--                                data-message-required="--><?php //echo get_phrase('value_required');?><!--">-->
<!--                            <option value="">--><?php //echo get_phrase('select');?><!--</option>-->
<!--                            --><?php
//                            $version_all = $this->db->get('version_type')->result_array();
//                            foreach($version_all as $row4):
//                                ?>
<!--                                <option --><?//= $row4['id'] ==  $vtype? "selected" : "" ?><!-- value="--><?php //echo $row4['id'];?><!--">-->
<!--                                    --><?php //echo $row4['name'];?>
<!--                                </option>-->
<!--                            --><?php
//                            endforeach;
//                            ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Group');?></label>
                    <?php $studentdta = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row();
//                    var_dump($studentdta); exit();
                    ?>
                    <div class="col-sm-5">
                        <select class="form-control" name="group">
                            <option value="">Select Group</option>
                            <option value="Humanities"  <?= $studentdta->group == "Humanities" ? "selected" : "" ?>>Humanities</option>
                            <option value="Business Studies"  <?= $studentdta->group == "Business Studies" ? "selected" : "" ?>>Business Studies</option>
                            <option value="Science"  <?= $studentdta->group == "Science" ? "selected" : "" ?>>Science</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('optional_subject_(if any)');?></label>

                    <div class="col-sm-5">
                        <select name="opt_sub_id" class="form-control selectboxit">
                            <option value=""><?php echo get_phrase('select_optional_subject');?></option>
                            <?php
                            $session = get_settings('running_year');
                            $subjects = $this->db->get_where('subject' , array(
                                'class_id' => $row['class_id'], 'vtype'=>$vtype, 'year' => $session
                            ))->result_array();
                            foreach ($subjects as $sub) {
                                echo '<option value="' . $sub['subject_id'] . '" '.(($row['opt_sub_id'] == $sub['subject_id']) ? 'selected' :'').' >' . $sub['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label">Shift</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="shift">
                            <option value="">Select Shift</option>
                            <option value="Day"  <?= $studentdta->shift == "Day" ? "selected" : "" ?>>Day</option>
                            <option value="Morning" <?= $studentdta->shift == "Morning" ? "selected" : "" ?>>Morning</option>
                        </select>
                    </div>
                </div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('guardian');?></label>
                        
						<div class="col-sm-5">
							<select name="parent_id" class="form-control select2" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$parents = $this->db->get('parent')->result_array();
									$parent_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['parent_id'];?>"
                                        	<?php if($row3['parent_id'] == $parent_id)echo 'selected';?>>
													<?php echo $row3['name'].' - ' .$row3['mother_name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div>

					
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="birthday" id="student-birthday"
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->birthday; ?>" data-start-view="2">
						</div> 
					</div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admission_date');?></label>
                        <div class="col-sm-5">
                            <?php $admissiondate = date( 'd-m-Y', strtotime($studentdta->admission_date))?>
                            <input type="text" class="form-control" id="date-pop" name="admission_date" value="<?=$admissiondate?>" data-start-view="2">
                        </div>
                    </div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
							<?php
								$gender = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->sex;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male" <?php if($gender == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female"<?php if($gender == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->address; ?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone; ?>" >
						</div> 
					</div>
                <?php
                    $admission_fee = $this->db->get_where('invoice' , array('payment_type' => 8, 'student_id' => $row['student_id']))->row();
                    if ($admission_fee) {
                        $ad_fee = $admission_fee->amount_paid;
                    } else {
                        $ad_fee = "";
                    }
                ?>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('admission_fee');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="admission_fee"
                                   value="<?php echo $ad_fee; ?>" >
                        </div>
                    </div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email').'/'.get_phrase('username');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('dormitory');?></label>
                        
						<div class="col-sm-5">
							<select name="dormitory_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$dorm_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->dormitory_id;
	                              	$dormitories = $this->db->get('dormitory')->result_array();
	                              	foreach($dormitories as $row2):
	                              ?>
                              		<option value="<?php echo $row2['dormitory_id'];?>"
                              			<?php if($dorm_id == $row2['dormitory_id']) echo 'selected';?>><?php echo $row2['name'];?></option>
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
	                              	$trans_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->transport_id; 
	                              	$transports = $this->db->get('transport')->result_array();
	                              	foreach($transports as $row2):
	                              ?>
                              		<option value="<?php echo $row2['transport_id'];?>"
                              			<?php if($trans_id == $row2['transport_id']) echo 'selected';?>><?php echo $row2['route_name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div> 
					</div>

                <div class="form-group">
                    <label for="agent_banking_no" class="col-sm-3 control-label"><?php echo get_phrase('agent_banking_no.');?></label>

                    <div class="col-sm-5">
                        <input type="text" id="agent_banking_no" class="form-control" name="agent_banking_no" value="<?=$studentdta->agent_banking_no?>" placeholder="<?php echo get_phrase('agent_banking_no.');?> (if any)">
                    </div>
                </div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> <?php echo get_phrase('edit_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $( "#date-pop" ).datepick({ dateFormat: 'dd-mm-yyyy' });
        $( "#student-birthday" ).datepick({ dateFormat: 'dd/mm/yyyy' });
    });

</script>