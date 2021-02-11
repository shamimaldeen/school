<?php 
	$edit_data	=	$this->db->get_where('payment' , array(
		'invoice_id' => $param2
	))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_income');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/income_other/edit/'.$row['invoice_id']) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
							value="<?php echo $row['title'];?>" >
						</div>
					</div>

					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('category');?></label>
                        <div class="col-sm-6">
                            <select name="income_category_id" class="form-control" required>
                                <option value=""><?php echo get_phrase('select_income_category');?></option>
                                <?php 
                                	$categories = $this->db->get('income_category')->result_array();
                                	foreach ($categories as $row2):
                                ?>
                                <option value="<?php echo $row2['income_category_id'];?>"
                                	<?php if ($row['income_category_id'] == $row2['income_category_id'])
                                		echo 'selected';?>>
                                			<?php echo $row2['name'];?>
                                				</option>
                            <?php endforeach;?>
                            </select>
                        </div>
                    </div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="amount" value="<?php echo $row['amount'];?>" 
                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
						</div> 
					</div>

					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-6">
                            <select name="method" class="form-control selectboxit">
                                <option value="1" <?php if ($row['method'] == 1) echo 'selected';?>><?php echo get_phrase('cash');?></option>
                                <option value="2" <?php if ($row['method'] == 2) echo 'selected';?>><?php echo get_phrase('check');?></option>
                                <option value="3" <?php if ($row['method'] == 3) echo 'selected';?>><?php echo get_phrase('card');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" name="timestamp"
                            value="<?php echo date('d M,Y', $row['timestamp']);?>"
                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('update');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>