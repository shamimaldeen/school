<style>
    .text_align{
        text-align: center;
    }
    .text_align:first-child{
        text-align: left!important;
    }
    .text_align:last-child{
        text-align: right!important;
    }
</style>
<?php

date_default_timezone_set("Asia/Dhaka");


$edit_data	=	$this->db
    ->select('payment.*,expense_category.name')
    ->join('expense_category', 'payment.expense_category_id = expense_category.expense_category_id','left')
    ->get_where('payment' , array(
    'payment_id' => $param2
))->result_array();
foreach ($edit_data as $row):
    ?>
    <center>
        <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
            Print Invoice
            <i class="entypo-print"></i>
        </a>
    </center>

    <br><br>

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

        </div>

        <h4 style="text-align: center; font-weight: bold"> EXPENSE VOUCHER</h4>
        <p style="text-align: right;"> PV No. <span style="border-bottom: 1px solid #000 "> <?=get_invoice_no($row['payment_id'], 6)?></span></p>
<!--        <h4 style="text-align: center"> --><?php //echo $row['title'];?><!--</h4>-->
        <table width="80%" border="0" style="margin: 0 auto">
            <tr>
                <td width="40%">Expense Category</td>
                <td width="60%"> : <?=$row['name']?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td> : <?=$row['description']?></td>
            </tr>
            <tr>
                <td>Payment Amount</td>
                <td> : <?=number_format($row['amount'], 2)?></td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td> : <?php  if ($row['method'] == 1)
                        echo get_phrase('cash');
                    if ($row['method'] == 2)
                        echo get_phrase('check');
                    if ($row['method'] == 3)
                        echo get_phrase('card');
                    if ($row['method'] == 'paypal')
                        echo 'Paypal'; ?>
                </td>
            </tr>
            <?php if ($row['payment_to'] != ''): ?>
            <tr>
                <td>Payment To</td>
                <td> : <?=$row['payment_to']?></td>
            </tr>
            <?php endif;
            if ($row['address'] != ''): ?>
            <tr>
                <td>Address</td>
                <td> : <?=$row['address']?></td>
            </tr>
            <?php endif;
            if ($row['contact'] != ''): ?>
            <tr>
                <td>Contact</td>
                <td> : <?=$row['contact']?></td>
            </tr>
            <?php endif; ?>

            <tr>
                <td>Payment Date</td>
                <td> : <?= date('d/m/Y - h:m:s a', $row['timestamp'])?></td>
            </tr>
        </table>
        <hr>
        <b style="text-transform: capitalize; margin-top: 30px"> (amount in words: <span style="border-bottom: 1px solid #000"> <?php echo convertNumber($row['amount'].'.00') ?> tk Only )</span></b>

        <table width="100%" style="margin-top: 50px">
            <tr>
                <?php
                    $receive_by = get_singleSignature('receive_by');
                    $headAcc = get_singleSignature('head_of_accounts');
                    $finance = get_singleSignature('finance_hr');
                    $principal = get_singleSignature('head_master');
                ?>
                <td class="text_align" style="font-size: 10px; text-align: left;"><span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$receive_by->name?> </span><br><p> </p></td>
                <td class="text_align" style="font-size: 10px; text-align: right! important"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$headAcc->name?> </span><br><p> </p></td>
                <td class="text_align" style="font-size: 10px; text-align: right! important"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$finance->name?> </span><br><p> </p></td>
                <td class="text_align" style="font-size: 10px; text-align: right! important"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$principal->name?> </span><br><p> </p></td>
                <?php
                if ($row['amount']>4999):
                    $founder = get_singleSignature('founder');
                ?>
                <td class="text_align" style="font-size: 10px; text-align: right! important"> <span style="border-top: 1px dotted #000; text-transform: uppercase"><?=$founder->name?> </span><br><p> </p></td>
                <?php endif; ?>
            </tr>
        </table>
        <p style="margin-top: 50px"> Print Date : <?= date('d/m/Y  h:m:s a')?></p>
    </div>
<?php endforeach;?>
<script type="text/javascript">
    // print invoice function
    function PrintElem(elem)
    {
        // Popup($(elem).html());
        Popup($('#invoice_print').html());
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