<div class="mail-header">
    <!-- title -->
    <h3 class="mail-title">

    </h3>
</div>
<div class="mail-wrapper" style="height: 0px; overflow-y: auto;">

</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>`-->
<?php echo form_open(site_url('admin/group_message/send_message/'), array('enctype' => 'multipart/form-data')); ?>
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
                <option value="<?php echo $row['class_id']; ?>">
                    <?php echo $row['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label><?php echo get_phrase('section'); ?></label>
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
    <div class="form-group">
        <label for="message-option">Message Options</label>
        <div id="">
            <select class="message_option" name="message_option" id="message-option" disabled>
                <option value="1">Custom Message</option>
                <option value="2">Unpaid Notification</option>
                <option value="3">Exam Result</option>
            </select>
        </div>
    </div>
    <div id="exam-result-area">

    </div>

    <div class="compose-message-editor" id="your-message">
        <textarea row="2" class="form-control count_me" name="message"
                  placeholder="<?php echo get_phrase('write_your_message'); ?>"></textarea>
    </div>
    <div class="col-md-12" id="custom-text-extra">
        <div style="float: right"><span class="charleft contacts-count">&nbsp;</span><span class="parts-count-limit">&nbsp;</span>
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
        $('#message-option').select2();
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
                url: '<?php echo site_url('Report/get_student_for_ssph/');?>' + class_id + '/' + section_id
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
<script>
    $(document).ready(function () {
        $('.message_option').on('change', function () {
            var option = $(this).val();
            if (option==2) {
                $("#your-message").hide();
                $("#exam-result-area").hide();
            }
            else if (option==3)
            {
                $("#your-message").hide();
                $("#exam-result-area").show();
                var class_id = $('#class_id').val();
                $.ajax({
                    url: '<?php echo site_url('Report/get_examAndSubjectField/');?>' + class_id
                }).done(function (response) {
                    $('#exam-result-area').html(response);
                    $('#exam_id').select2();
                    $('#subject_id').select2();
                });
            }
            else if (option == 1)
            {
                $("#your-message").show();
                $("#exam-result-area").hide();
            }

        });
    });
</script>
<style>
    textarea.form-control.count_me {
        height: 120px;
    }
    #select-checkbox {
        padding-top: 32px;
    }
</style>

<script src="<?php echo base_url("assets/js/jquery.textareaCounter.plugin.js"); ?>"></script>
<script>
    $('#recipient .count_me').textareaCount({
        'maxCharacterSize': 1530,
        'textAlign': 'right',
        'warningColor': '#CC3300',
        'warningNumber': 160,
        'isCharacterCount': true,
        'isWordCount': false,
        'displayFormat': '#input Characters | #left Characters Left',
        'originalStyle': 'contacts-count',
        'counterCssClass': '#recipient .charleft',

    }, function (data) {
        var parts = 1;
        var isUnicode = isDoubleByte($('#recipient .count_me').val());
        var typeRadio = $('input:radio[name=recipientsmsRadios]:checked').val();
        var charPerSMS = 160;
        $('#recipient .count_me').val($('#recipient .count_me').val().substring(0, isUnicode ? 670 : 1530));
        if (isUnicode) {
            $('#recipient .charleft.contacts-count').text($('#recipient .count_me').val().length + ' Characters | ' + (670 - $('#recipient .count_me').val().length) + ' Characters Left');
            charPerSMS = 70;
            if (data.input > 70) {
                parts = Math.ceil(data.input / 67);
                charPerSMS = 67;
            }
            if (typeRadio == "text") {
                $("#recipientsmsRadiosUnicode").prop('checked', true);
            } else if (typeRadio == "flash") {
                $("#recipientsmsRadiosUnicodeFlash").prop('checked', true);
            }
        } else {
            var isUnicodeNormal = isDoubleByteNormal($('#recipient .count_me').val());
            if (isUnicodeNormal) {
                charPerSMS = 140;
                if (data.input > 140) {
                    parts = Math.ceil(data.input / 134);
                    charPerSMS = 134;
                }
            } else {
                charPerSMS = 160;
                if (data.input > 160) {
                    parts = Math.ceil(data.input / 153);
                    charPerSMS = 153;
                }
            }

            if (typeRadio == "unicode") {
                $("#recipientsmsRadiosText").prop('checked', true);
            } else if (typeRadio == "flashunicode") {
                $("#recipientsmsRadiosFlash").prop('checked', true);
            }
        }
        $('.parts-count-limit').text('| ' + parts + ' SMS (' + charPerSMS + ' Char./SMS)');
    });

    function isDoubleByte(str) {
        for (var i = 0, n = str.length; i < n; i++) {
            //if (str.charCodeAt( i ) > 255 && str.charCodeAt( i )!== 8364 )
            if (str.charCodeAt(i) > 255) {
                return true;
            }
        }
        return false;
    }

    function isDoubleByteNormal(str) {
        for (var i = 0, n = str.length; i < n; i++) {
            if (str.charCodeAt(i) == 91
                || str.charCodeAt(i) == 92
                || str.charCodeAt(i) == 93
                || str.charCodeAt(i) == 94
                || str.charCodeAt(i) == 123
                || str.charCodeAt(i) == 124
                || str.charCodeAt(i) == 125
                || str.charCodeAt(i) == 126
            ) {
                return true;
            }
        }
        return false;
    }
</script>
