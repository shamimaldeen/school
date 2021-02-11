<div class="mail-header" style="padding-bottom: 27px ;">
    <!-- title -->
    <h3 class="mail-title">
        <?php echo get_phrase('write_new_message'); ?>
    </h3>
</div>

<div class="mail-compose" id="recipient">

    <?php echo form_open(site_url('admin/message/send_new/'), array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>


    <div class="form-group">
        <label for="subject"><?php echo get_phrase('recipient'); ?>:</label>
        <br><br>
        <select class="form-control select2" name="receiver" required>

            <option value=""><?php echo get_phrase('select_a_user'); ?></option>
            <optgroup label="<?php echo get_phrase('student'); ?>">
                <?php
                $students = $this->db->get('student')->result_array();
                foreach ($students as $row):
                ?>
                    <option value="student-<?php echo $row['student_id']; ?>">
                        - <?php echo $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
            <optgroup label="<?php echo get_phrase('teacher'); ?>">
                <?php
                $teachers = $this->db->get('teacher')->result_array();
                foreach ($teachers as $row):
                    ?>

                    <option value="teacher-<?php echo $row['teacher_id']; ?>">
                        - <?php echo $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
            <optgroup label="<?php echo get_phrase('parent'); ?>">
                <?php
                $parents = $this->db->get('parent')->result_array();
                foreach ($parents as $row):
                    ?>

                    <option value="parent-<?php echo $row['parent_id']; ?>">
                        - <?php echo $row['name']; ?></option>

                <?php endforeach; ?>
            </optgroup>
        </select>
    </div>


    <div class="compose-message-editor">
        <textarea row="2" class="form-control count_me" name="message" placeholder="<?php echo get_phrase('write_your_message'); ?>" required></textarea>
    </div>
    <div class="col-md-12">
        <div style="float: right"> <span class="charleft contacts-count">&nbsp;</span><span class="parts-count-limit">&nbsp;</span></div>
    </div>

    <hr>

    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-send"></i>
        <?php echo get_phrase('send'); ?>
    </button>
</form>
</div>

<script src="<?php echo base_url("assets/js/jquery.textareaCounter.plugin.js");  ?>"></script>
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
        'counterCssClass':'#recipient .charleft',

    }, function (data) {
        var parts = 1;
        var isUnicode = isDoubleByte($('#recipient .count_me').val());
        var typeRadio = $('input:radio[name=recipientsmsRadios]:checked').val();
        var charPerSMS = 160;
        $('#recipient .count_me').val(  $('#recipient .count_me').val().substring(0, isUnicode ? 670 : 1530)  );
        if(isUnicode) {
            $('#recipient .charleft.contacts-count').text($('#recipient .count_me').val().length + ' Characters | ' + (670-$('#recipient .count_me').val().length) + ' Characters Left');
            charPerSMS = 70;
            if (data.input > 70) {
                parts = Math.ceil(data.input / 67);
                charPerSMS = 67;
            }
            if(typeRadio=="text")
            {
                $("#recipientsmsRadiosUnicode").prop('checked', true);
            }else if(typeRadio=="flash")
            {
                $("#recipientsmsRadiosUnicodeFlash").prop('checked', true);
            }
        }
        else
        {
            var isUnicodeNormal = isDoubleByteNormal($('#recipient .count_me').val());
            if(isUnicodeNormal)
            {   charPerSMS = 140;
                if (data.input > 140) {
                    parts = Math.ceil(data.input / 134);
                    charPerSMS = 134;
                }
            }else{
                charPerSMS = 160;
                if (data.input > 160) {
                    parts = Math.ceil(data.input / 153);
                    charPerSMS = 153;
                }
            }

            if(typeRadio=="unicode")
            {
                $("#recipientsmsRadiosText").prop('checked', true);
            }else if(typeRadio=="flashunicode")
            {
                $("#recipientsmsRadiosFlash").prop('checked', true);
            }
        }
        $('.parts-count-limit').text('| ' + parts + ' SMS ('+charPerSMS+' Char./SMS)');
    });
    function isDoubleByte(str) {
        for (var i = 0, n = str.length; i < n; i++) {
            //if (str.charCodeAt( i ) > 255 && str.charCodeAt( i )!== 8364 )
            if (str.charCodeAt( i ) > 255)
            { return true; }
        }
        return false;
    }

    function isDoubleByteNormal(str) {
        for (var i = 0, n = str.length; i < n; i++) {
            if (str.charCodeAt( i ) ==91
                || str.charCodeAt( i ) ==92
                || str.charCodeAt( i ) ==93
                || str.charCodeAt( i ) ==94
                || str.charCodeAt( i ) ==123
                || str.charCodeAt( i ) ==124
                || str.charCodeAt( i ) ==125
                || str.charCodeAt( i ) ==126
            ) { return true; }
        }
        return false;
    }
</script>