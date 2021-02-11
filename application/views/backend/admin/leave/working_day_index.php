<hr /><div class="row">    <div class="col-md-12">        <!------CONTROL TABS START------>        <ul class="nav nav-tabs bordered">            <li class="active">                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>                    <?php echo get_phrase('working_day');?>                </a></li>            <li>                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>                    <?php echo get_phrase('add_working_day');?>                </a>            </li>        </ul>        <!------CONTROL TABS END------>        <div class="tab-content">            <br>            <!----TABLE LISTING STARTS-->            <div class="tab-pane box active" id="list">                <table  class="table table-bordered datatable" id="table_export">                    <thead>                    <tr>                        <th><div><?php echo get_phrase('month');?></div></th>                        <th><div><?php echo get_phrase('year');?></div></th>                        <th><div><?php echo get_phrase('working_day');?></div></th>                        <th><div><?php echo get_phrase('options');?></div></th>                    </tr>                    </thead>                    <tbody>                    <?php foreach($days as $row):?>                        <tr>                            <td><?php echo get_month_name($row->month); ?></td>                            <td><?php echo $row->year;?></td>                            <td><?php echo $row->working_day;?></td>                            <td>                                <div class="btn-group">                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">                                        Action <span class="caret"></span>                                    </button>                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">                                        <!-- EDITING LINK -->                                        <li>                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_working_day/'.$row->id);?>');">                                                <i class="entypo-pencil"></i>                                                <?php echo get_phrase('edit');?>                                            </a>                                        </li>                                        <li class="divider"></li>                                        <!-- DELETION LINK -->                                        <li>                                            <a href="#" onclick="confirm_modal('<?php echo site_url('leave/working_action/delete_row/'.$row->id);?>');">                                                <i class="entypo-trash"></i>                                                <?php echo get_phrase('delete');?>                                            </a>                                        </li>                                    </ul>                                </div>                            </td>                        </tr>                    <?php endforeach;?>                    </tbody>                </table>            </div>            <!----TABLE LISTING ENDS--->            <!----CREATION FORM STARTS---->            <div class="tab-pane box" id="add" style="padding: 5px">                <div class="box-content">                    <?php echo form_open(site_url('leave/working_action/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>                    <div class="form-group">                        <label class="col-sm-3 control-label"><?php echo get_phrase('month_name');?></label>                        <div class="col-sm-5">                            <select class="width-30 form-control" name="month" data-validate="required">                                <option value="">Select Month</option>                                <option value="01" <?php                                if (date('m') == '01') {                                    echo "selected";                                }                                ?> >January</option>                                <option value="02" <?php                                if (date('m') == '02') {                                    echo "selected";                                }                                ?> >February</option>                                <option value="03" <?php                                if (date('m') == '03') {                                    echo "selected";                                }                                ?> >March</option>                                <option value="04" <?php                                if (date('m') == '04') {                                    echo "selected";                                }                                ?> >April</option>                                <option value="05" <?php                                if (date('m') == '05') {                                    echo "selected";                                }                                ?> >May</option>                                <option value="06" <?php                                if (date('m') == '06') {                                    echo "selected";                                }                                ?> >June</option>                                <option value="07" <?php                                if (date('m') == '07') {                                    echo "selected";                                }                                ?> >July</option>                                <option value="08" <?php                                if (date('m') == '08') {                                    echo "selected";                                }                                ?> >August</option>                                <option value="09" <?php                                if (date('m') == '09') {                                    echo "selected";                                }                                ?> >September</option>                                <option value="10" <?php                                if (date('m') == '10') {                                    echo "selected";                                }                                ?> >October</option>                                <option value="11" <?php                                if (date('m') == '11') {                                    echo "selected";                                }                                ?> >November</option>                                <option value="12" <?php                                if (date('m') == '12') {                                    echo "selected";                                }                                ?> >December</option>                            </select>                            <span class="red"><?php echo form_error('month'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>                        <div class="col-sm-5">                            <select class="width-30 form-control" name="year" data-validate="required">                                <option value="">Select Year</option>                                <?php                                for ($year = date("Y"); $year >= 2014; $year--) {                                    ?>                                    <option value="<?php echo $year ?>" <?php                                    if (date("Y") == $year) {                                        echo "selected";                                    }                                    ?> ><?php echo $year ?></option>                                <?php } ?>                            </select>                            <span class="red"><?php echo form_error('year'); ?></span>                        </div>                    </div>                    <div class="form-group">                        <label class="col-sm-3 control-label"><?php echo get_phrase('working_day');?></label>                        <div class="col-sm-5">                            <input type="number" class="form-control" name="working_day" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>                        </div>                    </div>                    <div class="form-group">                        <div class="col-sm-offset-3 col-sm-5">                            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_working_day');?></button>                        </div>                    </div>                    </form>                </div>            </div>            <!----CREATION FORM ENDS-->        </div>    </div></div><!-----  DATA TABLE EXPORT CONFIGURATIONS ----><script type="text/javascript">    jQuery(document).ready(function($)    {        $('#table_export').dataTable();    });</script>