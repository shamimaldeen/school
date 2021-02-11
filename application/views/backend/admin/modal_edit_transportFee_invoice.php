<?php
$edit_data = $this->db->get_where('invoice' , array('invoice_id' => $param2) )->result_array();
$year = get_settings('running_year');
?>

<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):
            $qu = $this->db->select('tuition_fee_settings.tuition_fee')
                ->from('tuition_fee_settings')
                ->join('enroll', 'enroll.class_id=tuition_fee_settings.class_id')
                ->where('enroll.student_id', $row['student_id'])
                ->where('tuition_fee_settings.year', $year)
                ->get();
            $tuition    = $qu->row();
            $tuitionFee = $tuition->tuition_fee;

            $query = $this->db->select('month, invoice_id')
                ->from('tuition_fee_collection')
                ->where('student_id', $row['student_id'])
                ->where('year', $year)
                ->get();
            $month_arr = $query->result();
//            var_dump($month_arr); exit();

            ?>

            <?php echo form_open(site_url('admin/invoice/do_update_transport_fee/'.$row['invoice_id']), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

            <div class="form-group">
                <?php
                function get_monthName($monthNum)
                {
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    return $dateObj->format('F'); // March
                }

                $paid = 0;
                $html = "";
                for ($i=1; $i<=12; $i++)
                {
                    $done = 0;
                    foreach ($month_arr as $value)
                    {
                        if ($i == $value->month)
                        {
                            $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='month[]' id='".$value->month."' value='".$value->month."' class='form-control chk_month'".(($value->invoice_id == $param2) ? '' : 'disabled')." checked><label class='control-label' for='".$value->month."' >".get_monthName($value->month)."</label></div>";
                            $done = 1;
                            $paid++;
                        }
                    }
                    if ($done == 0)
                    {
                        $html .= "<div class='col-md-3 month_status'><input type='checkbox' name='month[]' id='".$i."' value='".$i."' class='form-control chk_month'><label class='control-label' for='".$i."'>".get_monthName($i)."</label></div>";
                    }
                }
                echo $html;
                ?>
                <input type="hidden" id="tuitionFee" name="transport_fee" value="<?php echo  $tuitionFee; ?>">
                <!--                    <input type="hidden" id="invoice_id" name="invoice_id" value="--><?php //echo  $param2; ?><!--">-->
            </div>
            <style>
                input[type="radio"], input[type="checkbox"]{
                    width: 13px;
                    float: left;
                    margin-right: 5px;
                }
            </style>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('student');?></label>
                <div class="col-sm-6">
                    <select name="student_id" class="form-control select2" required>
                        <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php
                        //$this->db->order_by('class_id','asc');
                        $students = $this->db->get('student')->result_array();
                        foreach($students as $row2):
                            ?>
                            <option value="<?php echo $row2['student_id'];?>"
                                <?php if($row['student_id']==$row2['student_id'])echo 'selected';?>>
                                <?php
                                echo $this->crud_model->get_type_name_by_id('student' , $row2['student_id']);
                                $class_id = $this->db->get_where('enroll' , array(
                                    'student_id' => $row2['student_id'],
                                    'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                                ))->row()->class_id;
                                ?> -
                                <?php echo $this->crud_model->get_class_name($class_id);?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="title" value="<?php echo $row['title'];?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('total_amount');?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="amount" id="ttAmount" value="<?php echo $row['amount'];?>" readonly/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="amount_paid" value="<?php echo $row['amount_paid'];?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('discount');?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="discount" value="<?php echo $row['discount'];?>"
                           placeholder="<?php echo get_phrase('enter_discount');?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                <div class="col-sm-9">
                    <select name="method" class="form-control selectboxit">
                        <option value="1" <?php echo ($row['payment_method'] == 1)?'selected':''; ?>><?php echo get_phrase('cash');?></option>
                        <option value="2" <?php echo ($row['payment_method'] == 2)?'selected':''; ?>><?php echo get_phrase('check');?></option>
                        <option value="3" <?php echo ($row['payment_method'] == 3)?'selected':''; ?>><?php echo get_phrase('card');?></option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                <div class="col-sm-5">
                    <input type="text" class="datepicker form-control" name="date"
                           value="<?php echo date('m/d/Y', $row['creation_timestamp']);?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_transport_fee');?></button>
                </div>
            </div>
            </form>
        <?php endforeach;?>
    </div>
</div>

<script>
    $( ".chk_month" ).click(function() {
        var tuitionFee  = $("#tuitionFee").val();
        tuitionFee      = parseFloat(tuitionFee);
        var ttAmount    = $("#ttAmount").val();
        ttAmount        = parseFloat(ttAmount);
        if ($(this).is(':checked'))
        {
            $("#ttAmount").val((ttAmount+tuitionFee));
        }else{
            $("#ttAmount").val((ttAmount-tuitionFee));
        }
    });
</script>
