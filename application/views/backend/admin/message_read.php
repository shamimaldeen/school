<?php
$messages = $this->db->get_where('message', array('message_thread_code' => $current_message_thread_code))->result_array();
foreach ($messages as $row):

    $sender = explode('-', $row['sender']);
    $sender_account_type = $sender[0];
    $sender_id = $sender[1];
    ?>
    <div class="mail-info">

        <div class="mail-sender " style="padding:7px;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $this->crud_model->get_image_url($sender_account_type, $sender_id); ?>" class="img-circle" width="30">
                <span><?php echo $this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->name; ?></span>
            </a>
        </div>

        <div class="mail-date" style="padding:7px;">
            <?php echo date("d M, Y", $row['timestamp']); ?>
        </div>

    </div>

    <div class="mail-text">
        <p> <?php echo $row['message']; ?></p>
        <?php if ($row['attached_file_name'] != ''):?>
          <p style="text-align: right;">
            <a href="<?php echo base_url('uploads/private_messaging_attached_file/'.$row['attached_file_name']);?>" target="_blank" style="color: #2196F3;">
            <i class="entypo-download" style="color: #757575"></i> <?php echo $row['attached_file_name']; ?>
          </a>
          </p>
        <?php endif; ?>
    </div>

<?php endforeach; ?>

<?php echo form_open(site_url('admin/message/send_reply/'.$current_message_thread_code)  , array('enctype' => 'multipart/form-data')); ?>
<div class="mail-reply" id="recipient">
    <div class="compose-message-editor">
        <textarea row="5" class="form-control count_me" name="message"
                  placeholder="<?php echo get_phrase('reply_message'); ?>" style="height: 120px;" required></textarea>
    </div>
    <div class="col-md-12">
        <div style="float: right"> <span class="charleft contacts-count">&nbsp;</span><span class="parts-count-limit">&nbsp;</span></div>
    </div>
    <br>
    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-send"></i>
        <?php echo get_phrase('send'); ?>
    </button>
    <br><br>
</div>
</form>
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