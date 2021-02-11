<div class="row">
	<div class="col-md-12">
        <form action="<?= base_url()?>index.php/Report/expense_reportBy_date_print" method="post" target="_blank">
            <div class="col-md-3">
                <label><?php echo get_phrase('from_date');?></label>
                <div id="section_holder">
                    <input type="text" class="form-control datepicker" name="from_date">
                </div>
            </div>
            <div class="col-md-3">
                <label><?php echo get_phrase('to_date');?></label>
                <div id="section_holder">
                    <input type="text" class="form-control datepicker" name="to_date">
                </div>
            </div>
            <div class="col-md-2">
                <label></label>
                <button class="btn btn-info btn-block" id="submit">
                    Expense Report
                </button>
            </div>
        </form>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').select2();
        $('#section_id').select2();

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("form").submit(function() {
            var fromDate= document.getElementById('from_date').value ==''
            var to_date= document.getElementById('to_date').value ==''
            if(fromDate) {
                alert('Please Select From Date')
                return false;
            }else if(to_date){
                alert('Please Select The To Date')
                return false;
            }
            else {
                $("form").attr('target', '_blank');
                return true;
            }
        })
    })
</script>