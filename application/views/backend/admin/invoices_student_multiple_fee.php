<div class="row">    <div class="col-md-12">        <table class="table table-bordered datatable">            <thead >            <tr>                <th width="40"><div><?php echo get_phrase('id');?></div></th>                <th><div><?php echo get_phrase('invoice_no');?></div></th>                <th><div><?php echo get_phrase('student');?></div></th>                <th><div><?php echo get_phrase('class');?></div></th>                <th><div><?php echo get_phrase('title');?></div></th>                <th><div><?php echo get_phrase('total');?></div></th><!--                <th><div>--><?php //echo get_phrase('paid');?><!--</div></th>--><!--                <th><div>--><?php //echo get_phrase('status');?><!--</div></th>-->                <th><div><?php echo get_phrase('date');?></div></th>                <th><div><?php echo get_phrase('options');?></div></th>            </tr>            </thead>            <tbody>                <?php                $vtype = $this->session->userdata('vtype');                $this->db->select('student_payment_invoices.*,student.name, class.name as class_name');                $this->db->join('student' , 'student_payment_invoices.student_id = student.student_id','left');                $this->db->join('class' , 'student_payment_invoices.class_id = class.class_id', 'left');                $this->db->where('student.vtype', $vtype);                $this->db->group_by('student_payment_invoices.id');                $this->db->order_by('created_at' , 'desc');                $payments = $this->db->get('student_payment_invoices')->result_array();                $sl= 1;                foreach ($payments as $row):                    ?>                    <tr>                        <td><?php echo $sl++;?></td>                        <td><?php echo $row['invoice_no'];?></td>                        <td><?php echo $row['name'];?></td>                        <td><?php echo $row['class_name'];?></td>                        <td><?php echo $row['title'];?></td>                        <td><?php echo $row['grand_total'];?></td><!--                        <td>--><?php //echo $row['amount_paid'];?><!--</td>--><!--                        <td>--><?php //echo $status;?><!--</td>-->                        <td><?php echo date('d M,Y', strtotime($row['created_at']));?></td>                        <?php                        $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">                                        Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu"><li><a href="#" onclick="invoice_view_modal('.$row['id'].')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a></li><li class="divider"></li><li><a href="'.site_url('admin/student_payment_edit/'). $row['id'].'"><i class="entypo-pencil"></i>&nbsp;'.get_phrase('edit').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_delete_confirm('.$row['id'].')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';                        ?>                        <td align="center">                            <?=$options?>                        </td>                    </tr>                <?php endforeach; ?>            </tbody>        </table>    </div></div><script type="text/javascript">    jQuery(document).ready(function($) {        $('.datatable').DataTable();    });    function invoice_view_modal(invoice_id) {        showAjaxModal('<?php echo site_url('modal/popup/modal_view_multiple_invoice/');?>' + invoice_id);    }    function invoice_edit_modal(invoice_id) {        showAjaxModal('<?php echo site_url('modal/popup/modal_edit_session_fee_invoice/');?>' + invoice_id);    }    function invoice_delete_confirm(invoice_id) {        confirm_modal('<?php echo site_url('admin/invoice/delete_student_multiple_fee/');?>' + invoice_id);    }</script>