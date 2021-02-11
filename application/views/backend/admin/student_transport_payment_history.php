<table class="table table-bordered datatable">
	<thead >
        <tr>
            <th width="40"><div><?php echo get_phrase('id');?></div></th>
            <th><div><?php echo get_phrase('student');?></div></th>
            <th><div><?php echo get_phrase('title');?></div></th>
            <th><div><?php echo get_phrase('total');?></div></th>
            <th><div><?php echo get_phrase('status');?></div></th>
            <th><div><?php echo get_phrase('date');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php
    		$this->db->select('payment.*,student.name, invoice.*');
    		$this->db->where('payment.payment_type' , 'income');
    		$this->db->join('invoice' , 'payment.invoice_id = invoice.invoice_id','left');
    		$this->db->join('student' , 'payment.student_id = student.student_id','left');
            $this->db->where('invoice.payment_type' , 3);
    		$this->db->order_by('timestamp' , 'desc');
    		$payments = $this->db->get('payment')->result_array();
    		foreach ($payments as $row):
                if ( $row['due'] == 0) {
                    $status = '<button class="btn btn-success btn-xs">'.get_phrase('paid').'</button>';
                    $payment_option = '';
                } else {
                    $status = '<button class="btn btn-danger btn-xs">'.get_phrase('unpaid').'</button>';
                    $payment_option = '';
                }
                ?>

	        <tr>
	            <td><?php echo $row['payment_id'];?></td>
	            <td><?php echo $row['name'];?></td>
	            <td><?php echo $row['title'];?></td>
	            <td><?php echo $row['amount'];?></td>
	            <td><?php echo $status;?></td>
	            <td><?php echo date('d M,Y', $row['timestamp']);?></td>
                <?php
                $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu">'.$payment_option.'<li><a href="#" onclick="invoice_view_modal('.$row['invoice_id'].')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_edit_modal('.$row['invoice_id'].')"><i class="entypo-pencil"></i>&nbsp;'.get_phrase('edit').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_delete_confirm('.$row['invoice_id'].')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';
                ?>
	            <td align="center">
	            	<?=$options?>
	            </td>
	        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $('.datatable').DataTable();
    });

    function invoice_view_modal(invoice_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/');?>' + invoice_id);
    }

    function invoice_edit_modal(invoice_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_edit_transportFee_invoice/');?>' + invoice_id);
    }

    function invoice_delete_confirm(invoice_id) {
        confirm_modal('<?php echo site_url('admin/invoice/delete_transport_fee/');?>' + invoice_id);
    }

</script>
