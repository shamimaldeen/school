<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered datatable">
            <thead >
            <tr>
                <th width="40"><div><?php echo get_phrase('id');?></div></th>
                <th width="40"><div><?php echo get_phrase('invoice_id');?></div></th>
                <th><div><?php echo get_phrase('student');?></div></th>
<!--                <th><div>--><?php //echo get_phrase('class');?><!--</div></th>-->
                <th><div><?php echo get_phrase('class');?></div></th>
                <th><div><?php echo get_phrase('title');?></div></th>
                <th><div><?php echo get_phrase('amount');?></div></th>
                <th><div><?php echo get_phrase('date');?></div></th>
                <th><div><?php echo get_phrase('options');?></div></th>
            </tr>
            </thead>
            <tbody>
            <?php
//            $this->db->select('invoice.*,student.name, class.name as class_name ');
//
//            $this->db->join('student' , 'invoice.student_id = student.student_id','left');
//            $this->db->join('enroll' , 'enroll.student_id = student.student_id', 'left');
//            $this->db->join('class' , 'enroll.class_id = class.class_id', 'left');
//            $this->db->where('invoice.payment_type' , 10);
//            $this->db->order_by('creation_timestamp' , 'desc');
//            $payments = $this->db->get('invoice')->result_array();
            $vtype = $this->session->userdata('vtype');
            $payment_option = 0;
            $this->db->select('invoice.*, class.name as class_name, student.name as student_name');
//            $this->db->from('invoice');
            $this->db->join('enroll','invoice.student_id= enroll.student_id ');
            $this->db->join('class','enroll.class_id= class.class_id');
            $this->db->join('student','invoice.student_id= student.student_id');
            $this->db->group_by('student_id');
            $this->db->where('student.vtype' , $vtype);
            $this->db->where('invoice.payment_type' , 8);
            $this->db->order_by('creation_timestamp' , 'desc');
            $payments = $this->db->get('invoice')->result_array();
            $sl = 1;
            foreach ($payments as $row):
                ?>

                <tr>
                    <td><?php echo $sl++;?></td>
                    <td><?php echo $row['invoice_id'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['class_name'];?></td>
                    <td><?php echo 'Admission Fee';?></td>
                    <td><?php echo $row['amount_paid'];?></td>
                    <td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
                    <?php
                    $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu"><li><a href="#" onclick="invoice_view_modal('.$row['invoice_id'].')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_edit_modal('.$row['invoice_id'].')"><li><a href="#" onclick="invoice_delete_confirm('.$row['invoice_id'].')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';
                    ?>
                    <td align="center">
                        <?=$options?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $('.datatable').DataTable();
    });
    function invoice_view_modal(invoice_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/');?>' + invoice_id);
    }
    function invoice_edit_modal(invoice_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_edit_dress_fee_invoice/');?>' + invoice_id);
    }

    function invoice_delete_confirm(invoice_id) {
        confirm_modal('<?php echo site_url('admin/invoice/delete_dress_fee/');?>' + invoice_id);
    }

</script>