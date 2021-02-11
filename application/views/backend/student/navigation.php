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
            <a href="<?php echo site_url($account_type.'/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>



        <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/teacher_list'); ?>">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>



        <!-- SUBJECT -->
        <li class="<?php if ($page_name == 'subject') echo ' active'; ?> ">
            <a href="<?php echo site_url($account_type.'/subject'); ?>">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('subject'); ?></span>
            </a>
        </li>

        <!-- CLASS ROUTINE -->
        <li class="<?php if ($page_name == 'class_routine') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/class_routine'); ?>">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
        </li>

        <!-- Attendance -->
        <li class="<?php if ($page_name == 'manage_attendace') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/manage_attendace'); ?>">
                <i class="fa fa-line-chart"></i>
                <span><?php echo get_phrase('attendance'); ?></span>
            </a>
        </li>

		<!-- STUDY MATERIAL -->
        <li class="<?php if ($page_name == 'study_material') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/study_material'); ?>">
                <i class="entypo-book-open"></i>
                <span><?php echo get_phrase('study_material'); ?></span>
            </a>
        </li>

        <!-- ACADEMIC SYLLABUS -->
        <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/academic_syllabus/'.$this->session->userdata('login_user_id')); ?>">
                <i class="entypo-doc"></i>
                <span><?php echo get_phrase('academic_syllabus'); ?></span>
            </a>
        </li>

        <!-- Exam marks -->
        <li class="<?php if ($page_name == 'student_marksheet') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/student_marksheet/'.$this->session->userdata('login_user_id')); ?>">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam_marks'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'online_exam' || $page_name == 'online_exam_take') echo 'active'; ?> ">
            <a href="<?php echo site_url('student/online_exam');?>">
                <i class="fa fa-feed"></i>
                <span><?php echo get_phrase('online_exam'); ?></span>
            </a>
        </li>

        <!-- PAYMENT -->
        <li class="<?php if ($page_name == 'invoice' || $page_name == 'pay_with_payumoney') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/invoice'); ?>">
                <i class="entypo-credit-card"></i>
                <span><?php echo get_phrase('payment'); ?></span>
            </a>
        </li>

        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'book' || $page_name == 'book_request') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('library'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'book') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/book'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('book_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'book_request') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/book_request'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('my_book_requests'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- TRANSPORT -->
        <li class="<?php if ($page_name == 'transport') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/transport'); ?>">
                <i class="entypo-location"></i>
                <span><?php echo get_phrase('transport'); ?></span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/noticeboard'); ?>">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class="<?php if ($page_name == 'message' || $page_name == 'group_message') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/message'); ?>">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/manage_profile'); ?>">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>
