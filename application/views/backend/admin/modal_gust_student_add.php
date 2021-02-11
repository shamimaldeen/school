<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('guest_student');?>
            	</div>
            </div>
			<div class="panel-body">
                <form class="form-horizontal form-groups-bordered" onsubmit="return save_guest_student();">
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" id="gs_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" id="phone" value="">
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default" id="btn_savee"><?php echo get_phrase('add_student');?></button>
						</div>
					</div>
                </form>

            </div>
        </div>
    </div>
</div>
