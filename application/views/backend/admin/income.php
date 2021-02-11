<hr />
<style>
    .payment{
        margin-top: 6px;
    }
</style>
<div class="row">
	<div class="col-md-12">
        <a href="<?php echo site_url('admin/income/invoices_student_multiple_fee');?>" class="btn payment btn-<?php echo $inner == 'invoices_student_multiple_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('student_payment');?>
        </a>
        <a href="<?php echo site_url('admin/income/invoices_admission_fee');?>" class="btn payment btn-<?php echo $inner == 'invoices_admission_fee' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('admission_fee_invoice');?>
        </a>
<!--		<a href="--><?php //echo site_url('admin/income/invoices');?><!--" class="btn payment btn---><?php //echo $inner == 'invoices' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('tuition_fee_invoices');?>
<!--		</a>-->
<!--        <a href="--><?php //echo site_url('admin/income/invoices_exam_fee');?><!--" class="btn payment btn---><?php //echo $inner == 'invoices_exam_fee' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('exam_fee_invoices');?>
<!--		</a>-->
<!--        <a href="--><?php //echo site_url('admin/income/invoices_session_fee');?><!--" class="btn payment btn---><?php //echo $inner == 'invoices_session_fee' ? 'primary' : 'default'; ?><!--">-->
<!--            --><?php //echo get_phrase('session_fee_invoices');?>
<!--        </a>-->
<!--        <a href="--><?php //echo site_url('admin/income/student_transport_payment_history');?><!--" class="btn payment btn---><?php //echo $inner == 'student_transport_payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--            --><?php //echo get_phrase('transport_fee_invoice');?>
<!--        </a>-->
<!--        <a href="--><?php //echo site_url('admin/income/invoices_dress_fee');?><!--" class="btn payment btn---><?php //echo $inner == 'invoices_dress_fee' ? 'primary' : 'default'; ?><!--">-->
<!--            --><?php //echo get_phrase('dress/Batch_fee_invoice');?>
<!--        </a>-->
<!--        <a href="--><?php //echo site_url('admin/income/student_others_payment_history');?><!--" class="btn payment btn---><?php //echo $inner == 'student_others_payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--            --><?php //echo get_phrase('Others_fee_invoice');?>
<!--        </a>-->
<!--        <a href="--><?php //echo site_url('admin/income/payment_history');?><!--" class="btn payment btn---><?php //echo $inner == 'payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('payment_history');?>
<!--        </a>-->
<!--        <a href="--><?php //echo site_url('admin/income/student_specific_payment_history');?><!--" class="btn payment btn---><?php //echo $inner == 'student_specific_payment_history' ? 'primary' : 'default'; ?><!--">-->
<!--			--><?php //echo get_phrase('student_specific_payment_history');?>
<!--        </a>-->
	</div>
</div>
<hr>
<?php include $inner.'.php'; ?>
