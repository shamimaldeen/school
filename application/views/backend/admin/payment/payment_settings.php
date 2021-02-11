<hr />
<div class="row">
	<div class="col-md-12">
			
			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('exam_fee_settings');?></span>
					</a>
				</li>
				<li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('tuition_fees_settings');?></span>
					</a>
				</li>
                <li>
                    <a href="#session" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('session_fee_settings');?></span>
                    </a>
                </li>
                <li>
                    <a href="#dress" data-toggle="tab">
                        <span class="hidden-xs"><?php echo get_phrase('dress/Batch_fee_settings');?></span>
                    </a>
                </li>
			</ul>
			
			<div class="tab-content">
            <br>
            <div class="tab-pane active" id="unpaid">

				<!-- creation of single invoice -->
				<div class="row">
                    <?php echo form_open(site_url('admin/payment_settings_action/store_exam_fee') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','method'=>'POST'));?>
					<div class="col-md-6">
	                        <div class="panel panel-default panel-shadow" data-collapsed="0">
	                            <div class="panel-heading">
	                                <div class="panel-title"><?php echo get_phrase('class_wise_exam_fee');?></div>
	                            </div>
	                            <div class="panel-body">
	                                
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
	                                    <div class="col-sm-9">
                                            <select name="class_id" class="form-control selectboxit class_id"
                                                    onchange="return get_class_students(this.value)">
                                                <option value=""><?php echo get_phrase('select_class');?></option>
                                                <?php
                                                $vtype = $this->session->userdata('vtype');
                                                $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                                                foreach ($classes as $row):
                                                    ?>
                                                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
	                                    </div>
	                                </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label">Exam Name</label>
	                                    <div class="col-sm-9">
                                            <select name="exam_id" class="form-control selectboxit class_id">
                                                <option value=""><?php echo get_phrase('select_exam');?></option>
                                                <?php
                                                foreach ($exams as $exam):
                                                    ?>
                                                    <option value="<?php echo $exam['exam_id'];?>"><?php echo $exam['name'];?></option>
                                                <?php endforeach;?>

                                            </select>
	                                    </div>
	                                </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('exam_fee');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="exam_fee"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
	                                    </div>
	                                </div>
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="description"/>
	                                    </div>
	                                </div>
	                                
	                            </div>
	                        </div>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info submit"><?php echo get_phrase('save');?></button>
                            </div>
                        </div>
	                    </div><!----col-md-6----->
                    <?php echo form_close();?>

                </div>


				<!-- creation of single invoice -->
					
				</div>
				<div class="tab-pane" id="paid">

				<!-- creation of mass invoice -->
				<?php echo form_open(site_url('admin/payment_settings_action/storeMonthlyFeeSettings') , array('class' => 'form-horizontal form-groups-bordered validate', 'id'=> 'mass' ,'target'=>'_top'));?>
				<br>
				<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                        <div class="col-sm-9">
                            <select name="class_id" class="form-control class_id2" data-validate="required" id="class_id"
                                    data-message-required="<?php echo get_phrase('value_required');?>"
                                    onchange="return get_sections_by_class(this.value)">
                                <option value=""><?php echo get_phrase('select_class');?></option>
                                <?php
                                $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                                foreach ($classes as $row):
                                    ?>
                                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                <?php endforeach;?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
                        <div class="col-sm-9">
                            <select name="section_id" class="form-control class_id2" id="section_selector_holder" data-validate="required"
                                    data-message-required="<?php echo get_phrase('value_required');?>" onchange="getTuitionPaymentType(this.value)" required>
                                <option value=""><?php echo get_phrase('select_class_first');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group month_section">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('tuition_fee');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tuition_fee" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group course_section">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('course_fee');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="course_fee" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-3">
                            <button type="submit" class="btn btn-info submit2"><?php echo get_phrase('save');?></button>
                        </div>
                    </div>
                    


				</div>
				<div class="col-md-6">
					<div id="student_selection_holder_mass"></div>
				</div>
				</div>
				<?php echo form_close();?>

				<!-- creation of mass invoice -->

				</div>

                <!-- session fee settings-->
                <div class="tab-pane" id="session">

                    <!-- creation of mass invoice -->
                    <?php echo form_open(site_url('admin/payment_settings_action/session_fee_settings') , array('class' => 'form-horizontal form-groups-bordered validate', 'id'=> 'mass' ,'target'=>'_top'));?>
                    <br>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-9">
                                    <select name="class_id" class="form-control class_id2" required="">
                                        <option value=""><?php echo get_phrase('select_class');?></option>
                                        <?php
                                        $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                                        foreach ($classes as $row):
                                            ?>
                                            <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php endforeach;?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('session_fee');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="session_fee" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="description"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-3">
                                    <button type="submit" class="btn btn-info submit2"><?php echo get_phrase('save');?></button>
                                </div>
                            </div>



                        </div>
                        <div class="col-md-6">
                            <div id="student_selection_holder_mass"></div>
                        </div>
                    </div>
                    <?php echo form_close();?>

                    <!-- creation of mass invoice -->

                </div>


                <!-- dress fee settings-->
                <div class="tab-pane" id="dress">

                    <!-- creation of single invoice -->
                    <div class="row">
                        <?php echo form_open(site_url('admin/payment_settings_action/dress_fee_settings') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','method'=>'POST'));?>
                        <div class="col-md-6">
                            <div class="panel panel-default panel-shadow" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><?php echo get_phrase('class_wise_dress_fee');?></div>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                                        <div class="col-sm-9">
                                            <select name="class_id" class="form-control selectboxit class_id3"
                                                    onchange="return get_class_students(this.value)">
                                                <option value=""><?php echo get_phrase('select_class');?></option>
                                                <?php
                                                $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                                                foreach ($classes as $row):
                                                    ?>
                                                    <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('dress');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="dress_fee"
                                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('batch');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="batch_fee"
                                                   data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="description"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-info submit"><?php echo get_phrase('save');?></button>
                                </div>
                            </div>
                        </div><!----col-md-6----->
                        <?php echo form_close();?>

                    </div>


                    <!-- creation of single invoice -->

                </div>
				
			</div><!----tab-content----->
			
			
	</div><!----col-md-12----->
</div><!----row----->

<script type="text/javascript">

	function select() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = true ;
			}

		//alert('asasas');
	}
	function unselect() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = false ;
			}
	}
</script>

<script type="text/javascript">
    function get_class_students(class_id) {
        if (class_id !== '') {
        $.ajax({
            url: '<?php echo site_url('admin/get_class_students/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder').html(response);
            }
        });
    }
}
</script>

<script type="text/javascript">
var class_id = '';
jQuery(document).ready(function($) {
    // $('.submit').attr('disabled', 'disabled');
});
    function get_class_students_mass(class_id) {
    	if (class_id !== '') {
        $.ajax({
            url: '<?php echo site_url('admin/get_class_students_mass/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder_mass').html(response);
            }
        });
      }
    }
    function check_validation(){
        if (class_id !== '') {
            $('.submit').removeAttr('disabled');
        }
        else{
            $('.submit').attr('disabled', 'disabled');
        }
    }
    $('.class_id').change(function(){
        class_id = $('.class_id').val();
        check_validation();
    });
</script>
<script type="text/javascript">
    function get_sections_by_class(class_id) {
        $.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }
</script>
<script type="text/javascript">
    jQuery('.month_section').hide();
    jQuery('.course_section').hide();
    function getTuitionPaymentType(section_id) {
        if (section_id) {
            $.ajax({
                url: '<?php echo site_url('admin/get_payment_type_by_section/');?>' + section_id,
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        jQuery('.month_section').show();
                        jQuery('.course_section').hide();
                    } else if (response == 2) {
                        jQuery('.course_section').show();
                        jQuery('.month_section').hide();
                    }
                }
            });
        }
    }
</script>