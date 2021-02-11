<hr />
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo site_url('admin/manage_payment_settings/exam_fee');?>" class="btn btn-<?php echo $inner == 'exam_fee' ? 'primary' : 'default'; ?>">
			<?php echo get_phrase('exam_fee');?>
		</a>
		<a href="<?php echo site_url('admin/manage_payment_settings/tuition_fee');?>" class="btn btn-<?php echo $inner == 'tuition_fee' ? 'primary' : 'default'; ?>">
			<?php echo get_phrase('monthly_tuition_fee');?>
		</a>
        <a href="<?php echo site_url('admin/manage_payment_settings/session_fee');?>" class="btn btn-<?php echo $inner == 'session_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('session_fee');?>
        </a>
        <a href="<?php echo site_url('admin/manage_payment_settings/dress_fee');?>" class="btn btn-<?php echo $inner == 'dress_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('dress/Batch_fee');?>
        </a>
	</div>
</div>
<hr>
<?php include $inner.'.php'; ?>
