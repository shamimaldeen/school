<link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons/entypo/css/entypo.css');?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/datepikar/css/jquery.datepick.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/neon-core.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/neon-theme.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/neon-forms.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
<?php
$skin_colour = $this->db->get_where('settings' , array(
    'type' => 'skin_colour'
))->row()->description;
if ($skin_colour != ''):?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/' . $skin_colour . '.css');?>">

<?php endif;?>

<?php if ($text_align == 'right-to-left') : ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/neon-rtl.css');?>">
<?php endif; ?>
<script src="<?php echo base_url('assets/js/jquery-1.11.0.min.js');?>"></script>
<!--<script type="text/javascript" src="--><?php //echo  base_url('assets/autocomplete/scripts/jquery-1.8.2.min.js') ?><!--"></script>-->
<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]-->

<script src="<?php echo base_url('assets/js/html5shiv.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/respond.min.js');?>" type="text/javascript"></script>
<!--[endif]-->
<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons/font-awesome/css/font-awesome.min.css');?>">

<link rel="stylesheet" href="<?php echo base_url('assets/js/vertical-timeline/css/component.css');?>">

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/dataTables/css/dataTables.bootstrap.css');?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/buttons/css/buttons.bootstrap.css');?>"/>

<link rel="stylesheet" href="<?php echo base_url('assets/js/wysihtml5/bootstrap-wysihtml5.css');?>">

<!--Amcharts-->
<script src="<?php echo base_url('assets/js/amcharts/amcharts.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/pie.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/serial.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/gauge.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/funnel.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/radar.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/amexport.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/rgbcolor.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/canvg.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/jspdf.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/filesaver.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/amcharts/exporting/jspdf.plugin.addimage.js');?>" type="text/javascript"></script>
<style>
.datepick-popup{
	z-index: 90000000000000000000000;
}
</style>
<script>
    function checkDelete()
    {
        var chk=confirm("Are You Sure To Delete This !");
        if(chk)
        {
            return true;
        }
        else{
            return false;
        }
    }
</script>
