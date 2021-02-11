<?php$vtype = $this->session->userdata('vtype');$row = $this->db->get_where('tuition_fee_settings' , array('id' => $param2) )->row_array();?><div class="tab-pane box active" id="edit" style="padding: 5px">    <div class="box-content">            <?php echo form_open(site_url('admin/payment_settings_action/update_tuition_fee/'.$row['id']), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>            <div class="form-group">                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>                <div class="col-sm-6">                    <select name="class_id" class="form-control selectboxit class_id" disabled="">                        <option value=""><?php echo get_phrase('select_class');?></option>                        <?php                        $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();                        foreach ($classes as $cls):                            $selc = ($cls['class_id'] == $row['class_id']) ? 'selected' : '';                            ?>                            <option value="<?php echo $cls['class_id'];?>" <?php echo $selc;?>><?php echo $cls['name'];?></option>                        <?php endforeach;?>                    </select>                </div>            </div>            <input type="hidden" name="class_id" value="<?php echo $row['class_id'];?>" hidden>            <div class="form-group">                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>                <div class="col-sm-5">                    <select class="form-control" name="section_id" id="section_selector_holder" data-validate="required"                            data-message-required="<?php echo get_phrase('value_required');?>" required>                        <option value=""><?php echo get_phrase('select_section');?></option>                        <?php                        $sections = $this->db->get_where('section' , array('class_id' => $row['class_id'], 'vtype'=>$vtype))->result_array();                        foreach($sections as $row2):                        ?>                            <option value="<?php echo $row2['section_id'];?>"                                <?php if($row['section_id'] == $row2['section_id']) echo 'selected';?>><?php echo $row2['name'];?></option>                        <?php endforeach;?>                    </select>                </div>            </div>            <div class="form-group">                <label class="col-sm-3 control-label"><?php echo get_phrase('tuition_fee');?></label>                <div class="col-sm-6">                    <input type="text" class="form-control" name="tuition_fee" value="<?php echo $row['tuition_fee'];?>" placeholder="Monthly tuition fee"                           data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>                </div>            </div>            <div class="form-group">                <label class="col-sm-3 control-label"><?php echo get_phrase('course_fee');?></label>                <div class="col-sm-6">                    <input type="text" class="form-control" name="course_fee" value="<?php echo $row['course_fee'];?>" placeholder="Total course fee"                           data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>                </div>            </div>            <div class="form-group">                <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>                <div class="col-sm-6">                    <input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>"/>                </div>            </div>            <div class="form-group">                <div class="col-sm-offset-3 col-sm-5">                    <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_tuition_fee');?></button>                </div>            </div>        </form>    </div></div>