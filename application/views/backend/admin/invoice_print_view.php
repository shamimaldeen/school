<?php
if (isset($param1)):
$invoice = $this->db->get_where('student_payment_invoices', array('invoice_no' => $param1))->row();
if(!empty($invoice)):
$root_id = $invoice->id;
$student_id = $invoice->student_id;
$rows = $this->db->get_where('invoice', array('root_id' => $root_id))->result();
?>
    <script>
        function myFunction(id) {
            var printContents = document.getElementById(id).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            return window.location.reload(true);
        }
    </script>
<style>
    .table_body tr td, .table_body th {
        padding: 5px;
    }
    .table_body th {
        background-color: #dbdbdd;
    }
    .clr{
        clear: both;
    }
</style>
    <style type="text/css" media="print">
        @page { size: portrait; }
    </style>
<center>
    <a onClick="myFunction('invoice_print'); return false" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print Invoice
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>
    <?php
    $class_id = $this->db->get_where('enroll' , array(
        'student_id' => $student_id,
        'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
    ))->row()->class_id;?>
    <div id="invoice_print">
        <div class="header_igm col-md-12">
            <table width="100%" border="0" style="text-align: center">
                <tr>
                    <td>
                        <img style="text-align: center!important; display: inline-block !important;; margin: 0 auto" width="300" src="<?php echo base_url('uploads/large_logo.png') ?>" alt="">
                        <br>
                        <br>
                    </td>
                </tr>
            </table>
            <p style="float: right; display: inline-block">Receipt No : <?=$invoice->invoice_no?></p><br><br>
            <div class="clr"></div>
            <p style="float: right; display: inline-block; margin-right: 0">Date :  <span style="border: 1px solid #000; padding: 5px; "> <?php echo date('d / M / Y', $invoice->created_at);?></span></p><br>
            <table width="100%">
                <tr>
                    <td colspan="3"><p>Name : <?= $this->db->get_where('student', array('student_id' => $student_id))->row()->name;?></p> </td>
                </tr>

                <tr>
                    <td><p>Class : <?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name?></p></td>
                    <td><p>Section : <?= $this->db->get_where('section', array('class_id' => $class_id))->row()->name?></p></td>
                    <td><p style="text-align: right">School ID No : <?= $this->db->get_where('student', array('student_id' => $student_id))->row()->student_code;?></p></td>
                </tr>
            </table>
            <table width="100%"  style="border-collapse:collapse;"class="table_body table table-bordered" border="1">
                <tr>
                    <th width="8%" style="padding: 5px;">Sl</th>
                    <th width="70%">Particulars</th>
                    <th width="17%">Amount</th>
                </tr>
                <?php
                $total_amount= 0;
                $sl =1;
                foreach ($rows as $row):
                ?>
                <tr>
                    <td style="text-align: center; padding: 5px"><?= $sl++?></td>
                    <td style="padding: 5px"><?php echo $row->title;?></td>
                    <td style="text-align: right; padding: 5px"><?php echo number_format($row->amount_paid,2);
                        $total_amount += $row->amount_paid;
                    ?></td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold"> Total</td>
                    <td style="text-align: right"><?php echo number_format($total_amount,2); ?></td>
                </tr>

                <br>
            </table>
            <b style="text-transform: capitalize; margin-top: 30px"> <?php echo convertNumber($total_amount) ?> tk Only </b>
        </div>

        <!-- payment history -->
        <table width="100%" style="margin-top: 50px">
            <tr>
                <?php
                $all_signature = $this->db->get('designation')->result();
                $count= 0;
                $i = 0;
                $right = count($all_signature);
                foreach ($all_signature as $signature):
                    $count++;
                    ?>
                    <td class="text_align" style="font-size: 10px; text-align: <?php if ($count == 1){echo 'left';} elseif ($i == $right -1){'right!important;';} else{ echo 'center';}
                    ?>"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$signature->name.'</span> <br style="border-top: 0 !important; text-align: center">'.$signature->designation?> <br><p> </p></td>
                <?php endforeach;?>
            </tr>
        </table>

    </div>


<?php endif;
 endif; ?>