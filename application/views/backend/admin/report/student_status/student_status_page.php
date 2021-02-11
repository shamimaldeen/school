
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
    <form action="<?= base_url()?>index.php/Report/student_status_print" method="post" target="_blank">
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
        <div class="col-md-3">
            <label><?php echo get_phrase('student');?></label>
            <div id="student_holder">
                <select class="" name="student_id" required id="student_id" disabled>
                    <option value=""><?php echo get_phrase('select_a_student');?></option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label></label>
            <button class="btn btn-info btn-block" id="submit">
                Student Present Status Print
            </button>
        </div>
    </form>
</div>
<hr>


<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').select2();
        $('#section_id').select2();
        $('#student_id').select2();
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
            var sectionId= document.getElementById('section_id').value ==''
            var studentId= document.getElementById('student_id').value ==''
            if(classId){
                alert('Please Select The Class')
                return false;
            } else if (sectionId){
                alert('Please Select The Section')
                return false;
            } else if (studentId){
                alert('Please Select The Student')
                return false;
            }
            else {
                $("form").attr('target', '_blank');
                return true;
            }
        })
    })
</script>