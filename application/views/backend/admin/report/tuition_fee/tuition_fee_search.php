<?php
$class_id = isset($class_id) ? $class_id : '';
$section_id = isset($section_id) ? $section_id : '';
$student_id = isset($student_id) ? $student_id : '';
?>
<style>
    .input_file{
        background: #fff ;
        box-shadow: none;
        background-clip: border-box;
        border-radius: 3px;
        height: 42px;
        line-height: 41px;
        outline: 0;
        padding-left: 15px;
        border: 1px solid #ebebeb;
        display: block;
        width: 100%;
    }
</style>
<div class="row">
    <form action="<?= base_url()?>index.php/Report/tuition_fee_sheet_print" method="post" target="_blank">
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
        <div class="col-md-3">
            <label><?php echo get_phrase('Shift');?></label>
            <select class="" name="shift" id="shift">
                <option value=""><?php echo get_phrase('select_a_shift');?></option>
                    <option value="Morning">Morning</option>
                    <option value="Day">Day</option>
            </select>
        </div>
        <div class="col-md-2">
            <label></label>
            <button class="btn btn-info btn-block" id="submit">
                Tuition Fee Sheet Print
            </button>
        </div>
    </form>
</div>
<hr>


<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').select2();
        $('#section_id').select2();
        $('#shift').select2();
        $('#exam').select2();
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
            var classId= document.getElementById('class_id').value ==''
            if(classId){
                alert('Please Select The Class')
                return false;
            }
            else {
                $("form").attr('target', '_blank');
                return true;
            }
        })
    })
</script>