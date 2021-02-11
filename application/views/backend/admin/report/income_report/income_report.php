<div class="row">
	<div class="col-md-12">
        <form action="<?= base_url()?>index.php/Report/income_report_print" method="post" target="_blank">
            <div class="col-md-3">
                <label><?php echo get_phrase('class');?></label>
                <select class="" name="class_id" id="class_id">
                    <option value=""><?php echo get_phrase('select_a_class');?></option>
                    <?php
                    $classes = $this->db->get('class')->result_array();
                    foreach ($classes as $row):
                        ?>
                        <option value="<?php echo $row['class_id'];?>">
                            <?php echo $row['name'];?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-3">
                <label><?php echo get_phrase('section');?></label>
                <div id="section_holder">
                    <select class="sec_field" name="section_id" id="section_id" disabled="">
                        <option value=""><?php echo get_phrase('select_a_section_first');?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <label><?php echo get_phrase('from_date');?></label>
                <div id="section_holder">
                    <input type="text" class="form-control datepicker" name="from_date" required>
                </div>
            </div>
            <div class="col-md-2">
                <label><?php echo get_phrase('to_date');?></label>
                <div id="section_holder">
                    <input type="text" class="form-control datepicker" name="to_date" required>
                </div>
            </div>
            <div class="col-md-2">
                <label></label>
                <button class="btn btn-info btn-block" id="submit">
                    Income Report
                </button>
            </div>
        </form>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').select2();
        $('#section_id').select2();
        $('#class_id').on('change', function() {
            var class_id = $(this).val();
            $.ajax({
                url: '<?php echo site_url('Report/get_sections_for_ssph/');?>' + class_id
            }).done(function(response) {
                // $('#section_holder').html(response);
                $('.sec_field').html();
                $('.sec_field').html(response);
                $('#section_id').attr('disabled', false);
                $('#section_id').select2();
                // var section_id = $('#section_id').val();
            });
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#class_id').select2();
        $('#student_id').select2();
        $('.sec_field').on('change', function() {
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            $.ajax({
                url: '<?php echo site_url('Report/get_student_for_ssph/');?>' + class_id + '/' + section_id
            }).done(function(response) {
                $('#student_holder').html(response);
                $('#student_id').select2();
                //var section_id = $('#student_id').val();
            });
        });

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