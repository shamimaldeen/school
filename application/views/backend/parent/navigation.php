<style>
    body .page-container .sidebar-menu, .page-container .sidebar-menu #main-menu li.has-sub ul, .page-container .sidebar-menu #main-menu li.has-sub ul a{
        /*background-color: #053b69 !important;*/
        background-color: #252424 !important;
        /*background-color: #354a5e !important;*/
    }
    .page-container .sidebar-menu #main-menu li a i{
        color: #fff !important;
    }
    .page-container .sidebar-menu #main-menu li a{
        color: #fff !important;
    }
    .page-container .sidebar-menu #main-menu li.has-sub ul li.active a, .page-container .sidebar-menu #main-menu li.has-sub ul a:hover{
        background-color: #eb9a20 !important;
    }
    .page-container .sidebar-menu #main-menu li a:hover, .page-container .sidebar-menu #main-menu li.active a{
        background-color: #eb9a20 !important;
    }
    .page-container .sidebar-menu #main-menu li#search .search-input{
        background-color: #51555a !important;
    }
    .form-control{
        border: 1px solid #949494 !important;
    }
    .page-body .select2-container .select2-choice .select2-arrow b{
        /*background: #eb9a2070!important;*/
    }
</style>
<div class="sidebar-menu">
    <header class="logo-env" >
        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo site_url('login'); ?>">
                <img src="<?php echo base_url('uploads/logo.png');?>"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <style>
        .search_header::placeholder {
            color: #fff !important;
            position: relative;
        }
    </style>
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>



        <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/teacher_list'); ?>">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>

        <!-- ACADEMIC SYLLABUS -->
        <li class="<?php if ($page_name == 'academic_syllabus') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-doc"></i>
                <span><?php echo get_phrase('academic_syllabus'); ?></span>
            </a>
            <ul>
                <?php
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
                    ?>
                    <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
                        <a href="<?php echo site_url('parents/academic_syllabus/'.$row['student_id']); ?>">
                            <span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </li>


        <!-- CLASS ROUTINE -->
        <li class="<?php if ($page_name == 'class_routine') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
            <ul>
            <?php
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'class_routine') echo 'active'; ?> ">
                    <a href="<?php echo site_url('parents/class_routine/'.$row['student_id']); ?>">
                        <span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>

        <!-- ATTENDANCE VIEW FOR CHILDREN -->
        <li class="<?php if ($page_name == 'attendance_report' || $page_name == 'attendance_report_view') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('student_attendance'); ?></span>
            </a>
            <ul>
            <?php
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('parents/attendance_report/'.$row['student_id']); ?>">
                        <span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>

        <!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'marks') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam_marks'); ?></span>
            </a>
            <ul>
            <?php
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'marks' && $student_id == $row['student_id']) echo 'active'; ?> ">
                    <a href="<?php echo site_url('parents/marks/'.$row['student_id']); ?>">
                        <span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>

        <!-- PAYMENT -->
        <li class="<?php if ($page_name == 'invoice' || $page_name == 'pay_with_payumoney') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-credit-card"></i>
                <span><?php echo get_phrase('payment'); ?></span>
            </a>
            <ul>
            <?php
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
                    <a href="<?php echo site_url('parents/invoice/'.$row['student_id']); ?>">
                        <span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>


        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'book') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/book'); ?>">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('library'); ?></span>
            </a>
        </li>

        <!-- TRANSPORT -->
        <li class="<?php if ($page_name == 'transport') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/transport'); ?>">
                <i class="entypo-location"></i>
                <span><?php echo get_phrase('transport'); ?></span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/noticeboard'); ?>">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- MESSAGE -->
<!--        <li class="--><?php //if ($page_name == 'message' || $page_name == 'group_message') echo 'active'; ?><!-- ">-->
<!--            <a href="--><?php //echo site_url('parents/message'); ?><!--">-->
<!--                <i class="entypo-mail"></i>-->
<!--                <span>--><?php //echo get_phrase('message'); ?><!--</span>-->
<!--            </a>-->
<!--        </li>-->

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/manage_profile'); ?>">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>
