<!-- Footer -->
<footer class="main">
	&copy; 2018 <strong> <?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?> | Version 6.4</strong>
    Developed by
	<a href="www.mensadigiworld.com"
    	target="_blank">Mensa Digiworld</a>
</footer>

