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
            <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>uploads/logo.png"  style="max-height:60px;"/>
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
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('accountant/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <!-- ACCOUNTING -->
        <li class="<?php
        if ($page_name == 'income' ||
                $page_name == 'expense' ||
                 $page_name == 'income_other' ||
                    $page_name == 'expense_category' ||
                    $page_name == 'income_category' ||
                        $page_name == 'student_payment')
                            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('accounting'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/student_payment'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/income/invoices_student_multiple_fee'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payments'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/expense'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/expense_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income_other') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/income_other'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('income'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('accountant/income_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('income_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('accountant/manage_profile'); ?>">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>