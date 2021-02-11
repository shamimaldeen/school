
<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/income_other_add/');?>');"
class="btn btn-primary pull-right">
<i class="entypo-plus-circled"></i>
<?php echo get_phrase('add_new_income');?>
</a>
<br><br>
<table class="table table-bordered datatable" id="expenses">
    <thead>
        <tr>
            <th width="40"><div><?php echo get_phrase('payment_id');?></div></th>
            <th><div><?php echo get_phrase('title');?></div></th>
            <th><div><?php echo get_phrase('category');?></div></th>
            <th><div><?php echo get_phrase('method');?></div></th>
            <th><div><?php echo get_phrase('amount');?></div></th>
            <th><div><?php echo get_phrase('date');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $expenses = $this->db->select('payment.*, income_category.name')
            ->join('income_category','payment.income_category_id = income_category.income_category_id','left')
            ->get_where('payment',['income_id'=>1])->result_array();
    foreach ($expenses as $row):
        ?>
        <tr>
            <td><?php echo $row['payment_id'];?></td>
            <td><?php echo $row['title'];?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php
                if ($row['method'] == 1){
                    echo 'Cash';
                } elseif ($row['method'] == 2){
                    echo 'Cheque';
                } else{
                    echo 'Card';
                }
                ?></td>
            <td><?php echo $row['amount'];?></td>
            <td><?php echo date('d M,Y', $row['timestamp']);?></td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                        <!-- teacher EDITING LINK -->
                        <li>
                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/income_other_edit/'.$row['payment_id']);?>');">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit');?>
                            </a>
                        </li>
                        <li class="divider"></li>

                        <!-- teacher DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo site_url('accountant/income_other/delete/'.$row['payment_id']);?>');">
                                <i class="entypo-trash"></i>
                                <?php echo get_phrase('delete');?>
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.datatable').DataTable();
    });

</script>
