<div class="mail-header">
    <!-- title -->
    <h3 class="mail-title">

    </h3>
</div>
<div class="mail-wrapper" style="height: 0px; overflow-y: auto;">
</div>

<?php echo form_open(site_url('admin/batch_time_alert_message/send_message/'), array('enctype' => 'multipart/form-data')); ?>
<div class="mail-reply" id="recipient">
    <div class="form-group">
        <label for="message-to">Sent To:</label>
        <div id="">
            <select class="message_to" name="message_to" id="message-to">
                <option value="1">Student</option>
                <option value="2">Parents</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label><?php echo get_phrase('class'); ?></label>
        <select class="" name="class_id" id="class_id">
            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
            <?php
            $vtype = $this->session->userdata('vtype');
            $classes = $this->db->get_where('class', ['vtype' => $vtype])->result_array();
            foreach ($classes as $row):
            ?>
                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label><?php echo get_phrase('root_section'); ?></label>
        <div id="section_holder">
            <select class="sec_field" name="section_id" id="section_id" disabled="">
                <option value=""><?php echo get_phrase('select_a_section_first'); ?></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            <div class="form-group">
                <label><?php echo get_phrase('student'); ?></label>
                <div id="student_holder">
                    <select multiple class="" name="student_ids[]" id="student_id" disabled>
                        <option value="" disabled><?php echo get_phrase('select_a_student'); ?></option>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-1">
            <div class="form-group" id="select-checkbox">
                <label for="all-select"><input class="checked" type="checkbox" id="all-select" onclick="select_all_student()"> Select All</label>
            </div>
        </div>
    </div>

    <!-- end -->
    <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-send"></i> <?php echo get_phrase('send'); ?>
    </button>
    <br><br>
</div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#class_id').select2();
        $('#section_id').select2();
        $('#student_id').select2();
        $('#class_id').on('change', function () {
            var class_id = $(this).val();
            if (class_id){
                $.ajax({
                    url: '<?php echo site_url('Report/get_sections_for_ssph/');?>' + class_id
                }).done(function (response) {
                    // $('#section_holder').html(response);
                    $('.sec_field').html();
                    $('.sec_field').html(response);
                    $('#section_id').attr('disabled', false);
                    $('#section_id').select2();
                    $('#message-option').attr('disabled', false);
                    // var section_id = $('#section_id').val();
                });
            }else{
                $('#section_id').attr('disabled', true);
                $('#message-option').attr('disabled', true);
            }

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#message-to').select2();
        $('#class_id').select2();
        $('#student_id').select2();
        $('.sec_field').on('change', function () {
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            $.ajax({
                url: '<?php echo site_url('Report/get_student_for_time_message/');?>' + class_id + '/' + section_id
            }).done(function (response) {
                $('#student_holder').html(response);
                // $('#student_id').attr('multiple', 'multiple');
                $('#student_id').select2();

                //var section_id = $('#student_id').val();
            });
        });
    });

    function select_all_student() {
        if ($("#all-select").is(':checked')) {
            $("#student_id > option").prop("selected", "selected");
            $("#student_id").trigger("change");
        } else {
            $("#student_id > option").removeAttr("selected");
            $("#student_id").trigger("change");
        }
    }
</script>
<style>
    #select-checkbox {
        padding-top: 32px;
    }
</style>