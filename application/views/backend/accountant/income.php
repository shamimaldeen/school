<hr />
<div class="row">
	<div class="col-md-12">
<!--		<a href="--><?php //echo site_url('accountant/income/invoices');?><!--" class="btn btn---><?php //echo $inner == 'invoices' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('invoices');?>
<!--		</a>-->
<!--		<a href="--><?php //echo site_url('accountant/income/payment_history');?><!--" class="btn btn---><?php //echo $inner == 'payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('payment_history');?>
<!--		</a>-->
<!--		<a href="--><?php //echo site_url('accountant/income/student_specific_payment_history');?><!--" class="btn btn---><?php //echo $inner == 'student_specific_payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('student_specific_payment_history');?>
<!--		</a>-->

        <a href="<?php echo site_url('accountant/income/invoices_student_multiple_fee');?>" class="btn payment btn-<?php echo $inner == 'invoices_student_multiple_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('student_payment');?>
        </a>
        <a href="<?php echo site_url('accountant/income/invoices_admission_fee');?>" class="btn payment btn-<?php echo $inner == 'invoices_admission_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('admission_fee_invoice');?>
        </a>
	</div>
</div>
<hr>
<?php include $inner.'.php'; ?>
