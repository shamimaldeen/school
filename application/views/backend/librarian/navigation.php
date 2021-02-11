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
            <a href="<?php echo site_url('librarian/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
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
                    <a href="<?php echo site_url('librarian/book'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('book_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'book_request') echo 'active'; ?> ">
                    <a href="<?php echo site_url('librarian/book_request'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('book_requests'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('librarian/manage_profile'); ?>">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>