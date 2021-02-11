<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/section_add/');?>');" 
	class="btn btn-primary pull-right">
    	<i class="entypo-plus-circled"></i>
			<?php echo get_phrase('add_new_section');?>
</a> 
<br><br><br>

<div class="row">
	<div class="col-md-12">
	
		<div class="tabs-vertical-env">
		
			<ul class="nav tabs-vertical">
			<?php
                $vtype = $this->session->userdata('vtype');
				$classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
				foreach ($classes as $row):
			?>
				<li class="<?php if ($row['class_id'] == $class_id) echo 'active';?>">
					<a href="<?php echo site_url('admin/section/'.$row['class_id']);?>">
						<i class="entypo-dot"></i>
						<?php echo get_phrase('class');?> <?php echo $row['name'];?>
					</a>
				</li>
			<?php endforeach;?>
			</ul>
			
			<div class="tab-content">

				<div class="tab-pane active">
					<table class="table table-bordered responsive">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo get_phrase('section_name');?></th>
								<th><?php echo get_phrase('nick_name');?></th>
								<th><?php echo get_phrase('subject');?></th>
								<th><?php echo get_phrase('teacher');?></th>
								<th><?php echo get_phrase('type');?></th>
								<th><?php echo get_phrase('options');?></th>
							</tr>
						</thead>
						<tbody>

						<?php
							$count    = 1;
							$sections = $this->db->get_where('section' , array(
								'class_id' => $class_id, 'vtype'=>$vtype
							))->result_array();
							$sections = $this->db->select('section.*, teacher.name as teacher_name, subject.name as subject_name')->from('section')
                                ->join('teacher', 'section.teacher_id=teacher.teacher_id')
                                ->join('subject', 'section.subject_id=subject.subject_id', 'left')
                                ->where(array(
								'section.class_id' => $class_id, 'section.vtype' => $vtype
							))->get()->result_array();

							foreach ($sections as $row):
						?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['nick_name'];?></td>
								<td><?php echo $row['subject_name'];?></td>
								<td>
                                    <?php echo $row['teacher_name'];?>
								</td>
                                <td><?php echo ($row['course_type']==2)?'Course':'Monthly';?></td>
								<td>
									<div class="btn-group">
		                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		                                    Action <span class="caret"></span>
		                                </button>
		                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
		                                    
		                                    <!-- EDITING LINK -->
		                                    <li>
		                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/section_edit/'.$row['section_id']);?>');">
		                                            <i class="entypo-pencil"></i>
		                                                <?php echo get_phrase('edit');?>
		                                            </a>
		                                                    </li>
		                                    <li class="divider"></li>
		                                    
		                                    <!-- DELETION LINK -->
		                                    <li>
		                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/sections/delete/'.$row['section_id']);?>');">
		                                            <i class="entypo-trash"></i>
		                                                <?php echo get_phrase('delete');?>
		                                            </a>
		                                    </li>
		                                </ul>
		                            </div>
								</td>
							</tr>
						<?php endforeach;?>
							
						</tbody>
					</table>
				</div>

			</div>
			
		</div>	
	
	</div>
</div>
<script type="text/javascript">
    function get_subject_by_class(class_id) {
        $.ajax({
            url: '<?php echo site_url('admin/get_subject/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#section_subject_holder').html(response);
            }
        });
    }
</script>