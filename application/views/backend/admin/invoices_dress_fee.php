<div class="row">    <div class="col-md-12">        <table class="table table-bordered datatable">            <thead >            <tr>                <th width="40"><div><?php echo get_phrase('id');?></div></th>                <th><div><?php echo get_phrase('student');?></div></th><!--                <th><div>--><?php //echo get_phrase('class');?><!--</div></th>-->                <th><div><?php echo get_phrase('class');?></div></th>                <th><div><?php echo get_phrase('total');?></div></th>                <th><div><?php echo get_phrase('paid');?></div></th>                <th><div><?php echo get_phrase('status');?></div></th>                <th><div><?php echo get_phrase('date');?></div></th>                <th><div><?php echo get_phrase('options');?></div></th>            </tr>            </thead>            <tbody>            <?php//            $this->db->select('invoice.*,student.name, class.name as class_name ');////            $this->db->join('student' , 'invoice.student_id = student.student_id','left');//            $this->db->join('enroll' , 'enroll.student_id = student.student_id', 'left');//            $this->db->join('class' , 'enroll.class_id = class.class_id', 'left');//            $this->db->where('invoice.payment_type' , 10);//            $this->db->order_by('creation_timestamp' , 'desc');//            $payments = $this->db->get('invoice')->result_array();            $this->db->select('invoice.*, class.name as class_name, class.class_id');//            $this->db->from('invoice');            $this->db->join('enroll','enroll.student_id= invoice.student_id');            $this->db->join('class','enroll.class_id= class.class_id');            $this->db->join('dress_fee_settings','class.class_id= dress_fee_settings.class_id');            $this->db->where('invoice.payment_type' , 10);            $this->db->order_by('creation_timestamp' , 'desc');            $payments = $this->db->get('invoice')->result_array();            foreach ($payments as $row):                if ( $row['due'] == 0) {                    $status = '<button class="btn btn-success btn-xs">'.get_phrase('paid').'</button>';                    $payment_option = '';                } else {                    $status = '<button class="btn btn-danger btn-xs">'.get_phrase('unpaid').'</button>';                    $payment_option = '';                }                ?>                <tr>                    <td><?php echo $row['invoice_id'];?></td>                    <?php $student_name = $this->db->get_where('student',['student_id'=>$row['student_id']])->row()?>                    <td><?php echo $student_name->name;?></td>                    <td><?php echo $row['class_name'];?></td>                    <?php                    $dress_fee = $this->db->get_where('dress_fee_settings', ['class_id'=>$row['class_id']])->row();//                        if($dress_fee->num_rows() > 0){//                         return $dress_fee->row();//                        }else {////                            return [];//                    }                    ?>                    <td><?php $dress_fee->dress_fee; if($row['payment_type'] == 1){echo $dress_fee->dress_fee;} else{ echo $dress_fee->batch_fee;}?></td>                    <td><?php echo $row['amount'];?></td>                    <td><?php echo $status;?></td>                    <td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>                    <?php                    $options = '<div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">                                        Action <span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right" role="menu">'.$payment_option.'<li><a href="#" onclick="invoice_view_modal('.$row['invoice_id'].')"><i class="entypo-credit-card"></i>&nbsp;'.get_phrase('view_invoice').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_edit_modal('.$row['invoice_id'].')"><i class="entypo-pencil"></i>&nbsp;'.get_phrase('edit').'</a></li><li class="divider"></li><li><a href="#" onclick="invoice_delete_confirm('.$row['invoice_id'].')"><i class="entypo-trash"></i>&nbsp;'.get_phrase('delete').'</a></li></ul></div>';                    ?>                    <td align="center">                        <?=$options?>                    </td>                </tr>            <?php endforeach; ?>            </tbody>        </table>    </div></div><script type="text/javascript">    jQuery(document).ready(function($) {        $('.datatable').DataTable();    });    function invoice_view_modal(invoice_id) {        showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/');?>' + invoice_id);    }    function invoice_edit_modal(invoice_id) {        showAjaxModal('<?php echo site_url('modal/popup/modal_edit_dress_fee_invoice/');?>' + invoice_id);    }    function invoice_delete_confirm(invoice_id) {        confirm_modal('<?php echo site_url('admin/invoice/delete_dress_fee/');?>' + invoice_id);    }</script>