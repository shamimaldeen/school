<link rel="stylesheet" href="<?php echo base_url('assets/js/select2/select2-bootstrap.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/js/select2/select2.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/js/selectboxit/jquery.selectBoxIt.css');?>">

	<!-- Bottom Scripts -->
<script src="<?php echo base_url('assets/js/gsap/main-gsap.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.js');?>"></script>
<script src="<?php echo base_url('assets/js/joinable.js');?>"></script>
<script src="<?php echo base_url('assets/js/resizeable.js');?>"></script>
<script src="<?php echo base_url('assets/js/neon-api.js');?>"></script>
<script src="<?php echo base_url('assets/js/toastr.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-timepicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/fileinput.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/datatable/dataTables/js/jquery.dataTables.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/datatable/dataTables/js/dataTables.bootstrap.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/datatable/buttons/js/dataTables.buttons.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/datatable/buttons/js/buttons.bootstrap.js');?>"></script>

<script src="<?php echo base_url('assets/js/select2/select2.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/selectboxit/jquery.selectBoxIt.min.js');?>"></script>


<script src="<?php echo base_url('assets/js/neon-calendar.js');?>"></script>
<script src="<?php echo base_url('assets/js/neon-chat.js');?>"></script>
<script src="<?php echo base_url('assets/js/neon-custom.js');?>"></script>
<script src="<?php echo base_url('assets/js/neon-demo.js');?>"></script>

<script src="<?php echo base_url('assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/wysihtml5/bootstrap-wysihtml5.js');?>"></script>


<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""): ?>

<script type="text/javascript">
	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>

<?php endif; ?>

<!---  DATA TABLE EXPORT CONFIGURATIONS -->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var datatable = $("#table_export").dataTable();
	});

</script>
<!---  Datepikar Stard -->
<script type="text/javascript" src="<?php echo  base_url('assets/datepikar/js/jquery.plugin.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo  base_url('assets/datepikar/js/jquery.datepick.js') ?>"></script>
<script type="text/javascript" src="<?php echo  base_url('assets/datepikar/js/custom.js') ?>"></script>
<!---  Datepikar End -->

<script type="text/javascript" src="<?php echo  base_url('assets/autocomplete//bootstrap3-typeahead.min.js') ?>"></script>

<script>
    $(document).ready(function(){

        $('#autocomplete-dynamic').typeahead({
            source: function(query, result)
            {
                $.ajax({
                    url:"<?php echo base_url('index.php/admin/search_student_autocomplete'); ?>",
                    method:"POST",
                    data:{query:query},
                    dataType:"json",
                    success:function(data)
                    {
                        result($.map(data, function(item){
                            return item;
                        }));
                    }
                })
            }
        });

    });
</script>

<style>
    /*body { font-family: sans-serif; font-size: 14px; line-height: 1.6em; margin: 0; padding: 0; }*/
    /*.typeahead { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); z-index: 99999; position: absolute; top: 0; left: 0;}*/

    /*.atypeahead  { padding: 2px 5px; white-space: nowrap; overflow: hidden; }*/
    /*.typeahead  { padding: 2px 5px;}*/
    /*.typeahead .active { background: #F0F0F0; }*/
    /*.typeahead  strong { font-weight: bold; color: #000; }*/
    /*.autocomplete-group { padding: 2px 5px; font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }*/
    /*.autocomplete-suggestion { cursor: pointer; }*/
    ul.typeahead.dropdown-menu{
        z-index: 999999999999999!important;
        top: 0;
        left: 0;
        position: absolute !important;
        width: 100% !important;
        background-color: white !important;
    }
    #main-menu #search ul.typeahead.dropdown-menu li a {
        background-color: #fff !important;
        color: #000 !important;
    }
    /*ul.typeahead.dropdown-menu li a:hover {*/
        /*background-color: red !important;*/
        /*color: #000 !important;*/
    /*}*/
    #main-menu #search form ul.typeahead.dropdown-menu li a:hover, #main-menu #search ul.typeahead.dropdown-menu li.active a {
            background-color: #000 !important;
            color: #fff !important;
        }
</style>