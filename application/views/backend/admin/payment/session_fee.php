<div class="row">
	<div class="col-md-12">

        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
            <thead>
            <tr>
                <th width="40"><div><?php echo get_phrase('id');?></div></th>
                <th><div><?php echo get_phrase('class_name');?></div></th>
                <th><div><?php echo get_phrase('session_fee');?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            foreach ($session_payment_data as $row):
                ?>
                <tr>
                    <td><?php echo ($count++); ?></td>
                    <td><?php echo $row->class_name; ?></td>
                    <td><?php echo number_format($row->session_fee, 2); ?></td>
                    <td>
                        <div class="btn-group"><button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                <li><a href="#" onclick="payment_settings_edit_modal(<?php echo $row->id; ?>)"><i class="entypo-pencil"></i>&nbsp;<?php echo get_phrase('edit'); ?></a></li>
                                <li class="divider"></li><li><a href="#" onclick="payment_settings_delete_confirm(<?php echo $row->id; ?>)"><i class="entypo-trash"></i>&nbsp;<?php echo get_phrase('delete'); ?></a></li>
                        </ul></div>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

	</div>
</div>

<script type="text/javascript">
	function payment_settings_edit_modal(tid) {
        showAjaxModal('<?php echo site_url('modal/popup_payment/popup_edit_session_fee_settings/');?>' + tid);
    }

    function payment_settings_delete_confirm(tid) {
        confirm_modal('<?php echo site_url('admin/payment_settings_action/delete_session_fee/');?>' + tid);
    }
</script>