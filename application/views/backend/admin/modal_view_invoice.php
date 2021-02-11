<?php
$edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
$singleData = $this->db->get_where('tuition_fee_collection', array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
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
        'student_id' => $row['student_id'],
        'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
    ))->row()->class_id;
    $class_roll = $this->db->get_where('enroll' , array(
        'student_id' => $row['student_id'],
        'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
    ))->row()->roll;?>
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
            <p style="float: right; display: inline-block">Receipt No : <?=get_invoice_no($row['invoice_id'], 6)?></p><br><br>
            <div class="clr"></div>
            <p style="float: right; display: inline-block; margin-right: 0">Date :  <span style="border: 1px solid #000; padding: 5px; "> <?php echo date('d / M / Y', $row['creation_timestamp']);?></span></p><br>
            <table width="100%">
                <tr>
                    <td><p>Name : <?= $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;?></p> </td>
                    <td colspan="2"><p>Roll : <?= $class_roll?></p> </td>
                </tr>

                <tr>
                    <td><p>Class : <?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name?></p></td>
                    <td><p>Section : <?= $this->db->get_where('section', array('class_id' => $class_id))->row()->name?></p></td>
                    <td><p style="text-align: right">School ID No : <?= $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->student_code;?></p></td>
                </tr>
            </table>
            <table width="100%"  style="border-collapse:collapse;"class="table_body table table-bordered" border="1">
                <tr>
                    <th width="8%" style="padding: 5px;">Sl</th>
                    <th width="70%">Particulars</th>
                    <th width="17%">Amount</th>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px">1</td>
                    <td style="padding: 5px"><?php echo $row['title'];?></td>
                    <td style="text-align: right; padding: 5px"><?php echo number_format($row['amount_paid'],2); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold"> Grand Total</td>
                    <td style="text-align: right"><?php echo number_format($row['amount_paid'],2); ?></td>
                </tr>
                <br>
            </table>
            <b style="text-transform: capitalize; margin-top: 30px"> <?php echo convertNumber($row['amount'].'.00') ?> taka Only </b>
        </div>

        <!-- payment history -->
        <table width="100%" style="margin-top: 15px">
            <tr>
                <?php
                $all_signature = $this->db->get_where('designation',['id'=>2])->result();
                $count= 0;
                $i = 0;
                $right = count($all_signature);
                foreach ($all_signature as $signature):
                    $count++;
                    ?>
                    <td class="text_align" style="font-size: 10px; text-align: right!important;
                            "> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$signature->name.'</span> <br style="border-top: 0 !important; text-align: center">'.$signature->designation?> <br><p> </p></td>
                <?php endforeach;?>
            </tr>
        </table>

    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
        // Popup($('#invoice_print').html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 250);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }

</script>
