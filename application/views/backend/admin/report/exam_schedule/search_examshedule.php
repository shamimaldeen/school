<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_exam_shedule');?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-print"></i>
                    <?php echo get_phrase('add_schedule');?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>

        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <hr />

                <form action="<?= base_url()?>index.php/Report/sheet_exam_schedule" method="post">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
                                <select name="exam_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                    $vtype = $this->session->userdata('vtype');
                                    $year    = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
                                    $exams = $this->db->get_where('exam', array('year' => $year, 'vtype'=>$vtype))->result_array();
                                    $class = $this->db->get_where('class', ['vtype'=>$vtype])->result_array();

                                    foreach($exams as $row):
                                        ?>
                                        <option value="<?php echo $row['exam_id'];?>">
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
                                <select name="class_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php
                                    foreach($class as $row):
                                        ?>
                                        <option value="<?php echo $row['class_id'];?>">
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div id="subject_holder">

                            <div class="col-md-2" style="margin-top: 20px;">
                                <center>
                                    <button type="submit" class="btn btn-info"><?php echo get_phrase('add_schedule');?></button>
                                </center>
                            </div>
                        </div>

                    </div>
                </form>


            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">


                </div>
            </div>
            <!----CREATION FORM ENDS-->
        </div>
    </div>
</div>
<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {


        var datatable = $("#table_export").dataTable();

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>
