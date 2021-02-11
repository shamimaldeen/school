<style>
    .student_text h2{

    }
    .student_details{

    }
    input.search-input {
        border: 1px solid #ccc;
        font-size: 14px;
        padding: 6px;
        color: #666;
        background-color: #fff !important;
    }
    .student_btn{
        background-color: #fff;
        border: 1px solid #ddd;
        margin-left: -7px;
        padding: 6px;
        font-size: 14px;
        padding-bottom: 7px;
        padding-top: 5px;
    }
    ul.select2-results{
        background-color:#fff !important;
    }
    .clsDatePicker {
        z-index: 9999999999999999999999999999999999999999999999999999999999999999999999999999999999;
    }
</style>
<div class="row">
	<div class="col-md-12 col-sm-12 clearfix student_text" style="text-align:center;">
		<h2 style="font-weight:200; margin:0px;"><?php echo $system_name;?>
        <form class="student_details pull-right" action="<?php echo site_url($account_type . '/student_details'); ?>" method="post">
            <input type="text" class="search-input" name="student_identifier" placeholder="<?php echo get_phrase('student_name').' / '.get_phrase('code').'...'; ?>" value="" required style="font-family: 'Poppins', sans-serif !important;">
            <button class="student_btn" type="submit">
                <i class="entypo-search"></i>
            </button>
        </form>
        </h2>
    </div>
	<!-- Raw Links -->
	<div class="col-md-12 col-sm-12 clearfix ">

        <ul class="list-inline links-list pull-left">
        <!-- Language Selector -->
        	<div id="session_static" class="pull-left">
	           <li style="float: left">
	           		<h4>
	           			<a href="#" style="color: #696969;"
	           				<?php if($account_type == 'admin'):?>
	           				onclick="get_session_changer()"
	           			<?php endif;?>>
	           				<?php echo get_phrase('running_session');?> : <?php echo $running_year.' ';?><i class="entypo-down-dir"></i>
	           			</a>
	           		</h4>
	           </li>
           </div>
            <style>
                #version_static select.form-control, #version_static li{
                    margin-top: -14px;
                    margin-left: 59px;
                }
                #version_static select.form-control{
                    margin-left: 30px;
                    width: 165px;
                }
            </style>

            <?php
            $vtype = $this->session->userdata('vtype');
            $type = $this->db->get_where('version_type', array('id' => $vtype))->row();
            $vname = (empty($type)) ? '' : $type->name;
            ?>
            <ul class="list-inline links-list pull-left">
                <div id="version_static" class="pull-left">
                    <li style="float: left">
                        <h4>
                            <a href="#" style="color: #696969;"
                                <?php if($account_type == 'admin' || $account_type == 'teacher' || $account_type == 'librarian'|| $account_type == 'accountant'):?>
                            onclick="get_version_changer()"
                            <?php endif;?>>
                            <?php echo get_phrase('version_type');?> : <?php echo $vname.' ';?><i class="entypo-down-dir"></i>
                            </a>
                        </h4>
                    </li>
                </div>
            </ul>
        </ul>


		<ul class="list-inline links-list pull-right">

		<li class="dropdown language-selector">
			<a href="<?php echo site_url('home');?>" target="_blank">
				<i class="entypo-globe"></i> Website
			</a>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        	<i class="entypo-user"></i>
                                    <?php
                                        $name = $this->db->get_where($this->session->userdata('login_type'), array($this->session->userdata('login_type').'_id' => $this->session->userdata('login_user_id')))->row()->name;
                                        echo $name;
                                    ?>
                    </a>

				<?php if ($account_type != 'parent'):?>
				<ul class="dropdown-menu <?php if ($text_align == 'right-to-left') echo 'pull-right'; else echo 'pull-left';?>">
					<li>
						<a href="<?php echo site_url($account_type . '/manage_profile');?>">
                        	<i class="entypo-info"></i>
							<span><?php echo get_phrase('edit_profile');?></span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url($account_type . '/manage_profile');?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('change_password');?></span>
						</a>
					</li>
				</ul>
				<?php endif;?>
				<?php if ($account_type == 'parent'):?>
				<ul class="dropdown-menu <?php if ($text_align == 'right-to-left') echo 'pull-right'; else echo 'pull-left';?>">
					<li>
						<a href="<?php echo site_url('parents/manage_profile');?>">
                        	<i class="entypo-info"></i>
							<span><?php echo get_phrase('edit_profile');?></span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url('parents/manage_profile');?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('change_password');?></span>
						</a>
					</li>
				</ul>
				<?php endif;?>
			</li>

			<li>
				<a href="<?php echo site_url('login/logout');?>">
					<?php echo get_phrase('log_out'); ?><i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
	</div>

</div>

<hr style="margin-top:0px;" />

<script type="text/javascript">
	function get_session_changer()
	{
		$.ajax({
            url: '<?php echo site_url('admin/get_session_changer');?>',
            success: function(response)
            {
                jQuery('#session_static').html(response);
            }
        });
	}
</script>
<script type="text/javascript">
    function get_version_changer()
    {
        $.ajax({
            url: '<?php echo site_url('admin/get_version_changer');?>',
            success: function(response)
            {
                jQuery('#version_static').html(response);
            }
        });
    }
</script>
