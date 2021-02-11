<?php echo form_open(site_url('admin/change_version') , array('id' => 'versionstatic'));?>
<li>

	<div class="form-group">
		<select name="version_type" class="form-control" <?php if ($this->session->userdata('login_type') != 'student'):?>onchange="submitVersion();" <?php endif; ?>>
		  	<?php
            $vtype = $this->session->userdata('vtype');
            $version_type = $this->db->get_where('version_type', array('status' => 1))->result();?>
		  	<?php foreach($version_type as $varsion): ?>
		      	<option value="<?php echo $varsion->id;?>"
		        <?php if($varsion->id == $vtype) echo 'selected';?>>
		          	<?php echo $varsion->name;?>
		      	</option>
		  <?php endforeach;?>
		</select>
	</div>


</li>
<?php echo form_close();?>



<script type="text/javascript">

    function submitVersion()
    {
    	$('#versionstatic').submit();
    }

</script>