<?php
$class_id = isset($class_id) ? $class_id : '';
$section_id = isset($section_id) ? $section_id : '';
?>
<div class="row">
    <form action="<?= site_url('report/get_guest_student')?>" method="post">
        <div class="col-md-3">
            <label><?php echo get_phrase('class');?></label>
            <select class="" name="class_id" id="class_id">
                <option value=""><?php echo get_phrase('select_a_class');?></option>
                <?php
                $vtype = $this->session->userdata('vtype');
                $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                foreach ($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id'];?>">
                        <?php echo $row['name'];?>
                    </option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <label><?php echo get_phrase('section');?></label>
            <div id="section_holder">
                <select class="sec_field" name="section_id" id="section_id" disabled="">
                    <option value=""><?php echo get_phrase('select_a_section_first');?></option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <label>From Date</label>
            <div id="section_holder">
                <input type="text" class="form-control datepicker" name="from_date" id="from_date">
            </div>
        </div>
        <div class="col-md-2">
            <label>To Date</label>
            <div id="section_holder">
                <input type="text" class="form-control datepicker" name="to_date" id="to_date">
            </div>
        </div>
        <div class="col-md-2">
            <label></label>
            <button class="btn btn-info btn-block" id="submit">
                <?php echo get_phrase('get_guest_student');?>
            </button>
        </div>
    </form>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div id="data">
            <?php //include 'student_specific_payment_history_table.php'; ?>
        </div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $("form").submit(function() {
            var classId = document.getElementById('class_id').value == '';
            var sectionId = document.getElementById('section_id').value == '';
            var fromDate = document.getElementById('from_date').value == '';
            var toDate = document.getElementById('to_date').value == '';
            if(classId){
                alert('Please Select The Class!');
                return false;
            } else if (sectionId){
                alert('Please Select The Section!');
                return false;
            } else if (fromDate){
                alert('Please Select From Date!');
                return false;
            } else if (toDate){
                alert('Please Select To Date!');
                return false;
            } else {
                $("form").attr('target', '_blank');
                return true;
            }
        })
    })
</script>