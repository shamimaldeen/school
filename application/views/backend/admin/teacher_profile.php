<script>
    function myFunction(id) {
        var printContents = document.getElementById(id).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        return window.location.reload(true);
    }
</script>
<style>
  .images_teacher img{
      /*width       : 30% !important;*/
  }
  img.img-circle{

  }
</style>

<?php
  $student_info = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->result_array();
  foreach ($student_info as $row):
//    $enroll_info = $this->db->get_where('enroll', array(
//      'student_id' => $row['student_id'], 'year' => $running_year
//    ));
//    $class_id = $enroll_info->row()->class_id;
//    $exams = $this->crud_model->get_exams();
?>
<div class="profile-env">
	<header class="row" id="teacher_print">
		<div class="col-md-3">
			<center>
        <a href="#" class="images_teacher">
  				<img src="<?php echo $this->crud_model->get_image_url('teacher', $teacher_id) ;?>" height="150px" class="img-circle"
           />
  			</a>
        <br>
        <h3>
          <?php echo $row['name']; ?>
        </h3>
                <p>Designation -
                    <?php echo $row['designation']; ?>
                </p>
      </center>
		</div>
    <div class="col-md-9">
		<ul class="nav nav-tabs">
<!--			<li class="">-->
<!--                <a href="#tab1" data-toggle="tab" class="btn btn-default">-->
<!--					--><?php //echo get_phrase('teacher_info'); ?>
<!--				</a>-->
<!--			</li>-->
            <a onClick="myFunction('teacher_print'); return false" class="btn btn-default icon-left hidden-print">
                <i class="entypo-print"></i>
                    Print Teacher Profile
                </a>

<!--			<li class="">-->
<!--				<a href="#tab2" data-toggle="tab" class="btn btn-default">-->
<!--					<span class="visible-xs"><i class="entypo-user"></i></span>-->
<!--					<span class="hidden-xs">--><?php //echo get_phrase('parent_info'); ?><!--</span>-->
<!--				</a>-->
<!--			</li>-->
<!--			<li class="">-->
<!--				<a href="#tab3" data-toggle="tab" class="btn btn-default">-->
<!--					<span class="visible-xs"><i class="entypo-mail"></i></span>-->
<!--					<span class="hidden-xs">--><?php //echo get_phrase('exam_marks'); ?><!--</span>-->
<!--				</a>-->
<!--			</li>-->
			<!-- <li class="">
				<a href="#tab4" data-toggle="tab" class="btn btn-default">
					<span class="visible-xs"><i class="entypo-cog"></i></span>
					<span class="hidden-xs"><?php //echo get_phrase('attendance'); ?></span>
				</a>
			</li> -->
<!--      <li class="">-->
<!--				<a href="#tab5" data-toggle="tab" class="btn btn-default">-->
<!--					<span class="visible-xs"><i class="entypo-cog"></i></span>-->
<!--					<span class="hidden-xs">--><?php //echo get_phrase('payments'); ?><!--</span>-->
<!--				</a>-->
<!--			</li>-->
<!--		</ul>-->

		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
        <?php
          $basic_info_titles = ['name','designation', 'phone', 'email', 'birth_date', 'gender', 'address', 'blood_group', 'religion', 'gross_salary'];
          $basic_info_values = [$row['name'], $row['designation'], $row['phone'], $row['email'], $row['birthday'], ucfirst($row['sex']), $row['address'], $row['blood_group'], $row['religion'], number_format($row['total_salary'], 2) ];
        ?>
        <table class="table table-bordered" style="margin-top: 20px;">
          <tbody>
          <?php for ($i=0; $i < count($basic_info_titles) ; $i++) { ?>
            <tr>
              <td width="30%">
                <strong><?php echo get_phrase($basic_info_titles[$i]); ?></strong>
              </td>
              <td><?php echo $basic_info_values[$i]; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
		</div>

		<br>

	</div>
	</header>
</div>
<?php endforeach; ?>
