<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-chart-area"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('daily_attendance_report_of_class'); ?> <?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name; ?></h3>
            <h4 style="color: #696969;">
                <?php echo get_phrase('section/Batch'); ?> - <?php echo $section_name; ?>
            </h4>
            <h4 style="color: #696969;">
                <?php echo date("d/m/Y", $timestamp); ?>
            </h4>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>

<br>

<div class="row">

    <div class="col-md-4">
        <center><h4 style="color: darkgreen"><u>Paid Student</u></h4></center>
        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="color: darkgreen;"><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('remarks'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $unpaid = array();
                $count = 1;
                foreach ($attendance as $row):
                    $payment_status = $report_model->check_payment_status($row->student_id, $section_id, $course_type);
//                    dd($payment_status);
                    if ($payment_status===true){
                        ?>
                        <tr>
                            <td><?php echo str_pad($count++, '2', '0', STR_PAD_LEFT); ?></td>
                            <td style="color: darkgreen;"><?php echo $row->name. " (" . $row->roll . ")"; ?></td>
                            <td style="text-align: center;">Thanks</td>
                        </tr>
                        <?php
                    }else {
                        $row->due = number_format($payment_status, 2);
                        $unpaid[] = $row;
                    }
                endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="col-md-4">
        <center><h4 style="color: darkred;"><u>Unpaid Student</u></h4></center>
        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="color: darkred;"><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('due_amount'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                foreach ($unpaid as $row):
                ?>
                    <tr>
                        <td><?php echo str_pad($count++, '2', '0', STR_PAD_LEFT); ?></td>
                        <td style="color: darkred;"><?php echo $row->name . " (" . $row->roll . ")"; ?></td>
                        <td style="text-align: center; font-weight: bold; color: darkred;">
                            <?php echo $row->due; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="col-md-4">
        <center><h4 style="color: darkblue"><u>Guest Student</u></h4></center>
        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="color: darkblue;"><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('remarks'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                foreach ($guest_attendances as $row):
                ?>
                        <tr>
                            <td><?php echo str_pad($count++, '2', '0', STR_PAD_LEFT); ?></td>
                            <td style="color: darkblue;"><?php echo $row->name; ?></td>
                            <td style="text-align: center;">Welcome</td>
                        </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
