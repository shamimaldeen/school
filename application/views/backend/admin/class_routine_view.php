<hr />
<a href="<?php echo site_url('admin/class_routine_add');?>"
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_class_routine');?>
    </a> 
<br><br><br>

<?php
    $vtype = $this->session->userdata('vtype');
	$query = $this->db->get_where('section' , array('class_id' => $class_id, 'vtype'=>$vtype));
	if($query->num_rows() > 0):
		$sections = $query->result_array();
	foreach($sections as $row):
?>
<div class="row">
	
    <div class="col-md-12">

        <div class="panel panel-default" data-collapsed="0">
            <div class="panel-heading" >
                <div class="panel-title" style="font-size: 16px; color: white; text-align: center;">
                    <?php echo get_phrase('class');?> - <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> :
                    <?php echo get_phrase('section');?> - <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id'], 'vtype'=>$vtype))->row()->name;?>
                    <a href="<?php echo site_url('admin/class_routine_print_view/'.$class_id.'/'.$row['section_id']);?>"
                        class="btn btn-primary btn-xs pull-right" target="_blank">
                            <i class="entypo-print"></i> <?php echo get_phrase('print');?>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                    <tbody>
                        <?php 
                        for($d=1;$d<=7;$d++):
                        
                        if($d==1)$day='sunday';
                        else if($d==2)$day='monday';
                        else if($d==3)$day='tuesday';
                        else if($d==4)$day='wednesday';
                        else if($d==5)$day='thursday';
                        else if($d==6)$day='friday';
                        else if($d==7)$day='saturday';
                        ?>
                        <tr class="gradeA">
                            <td width="100"><?php echo strtoupper($day);?></td>
                            <td>
                                <?php
                                $this->db->order_by("time_start", "asc");
                                $this->db->where('day' , $day);
                                $this->db->where('class_id' , $class_id);
                                $this->db->where('section_id' , $row['section_id']);
                                $this->db->where('year' , $running_year);
//                                $this->db->where('vtype' , $this->session->userdata('vtype'));
                                $routines   =   $this->db->get_where('class_routine', ['vtype'=>$vtype])->result_array();
                                foreach($routines as $row2):
                                    $subject_info = $this->crud_model->get_subject_name_by_id($row2['subject_id']);
                                    if ($subject_info):
                                ?>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                            echo $subject_info;
                                                if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0)
                                                    echo '('.$row2['time_start'].'-'.$row2['time_end'].')';
                                                if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                    echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';
                                        ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_class_routine/'.$row2['class_routine_id']);?>');">
                                            <i class="entypo-pencil"></i><?php echo get_phrase('edit');?></a></li>
                                         <li>
                                            <a href="#" onclick="confirm_modal('<?php echo site_url('admin/class_routine/delete/'.$row2['class_routine_id']);?>');">
                                            <i class="entypo-trash"></i><?php echo get_phrase('delete');?></a>
                                        </li>
                                    </ul>
                                </div>
                                <?php endif; endforeach;?>

                            </td>
                        </tr>
                        <?php endfor;?>
                        
                    </tbody>
                </table>
                
            </div>
        </div>

    </div>

</div>
<?php endforeach;?>
<?php endif;?>