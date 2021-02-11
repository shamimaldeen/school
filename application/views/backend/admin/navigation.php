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
        <li id="search" class="auto-search">
            <form class="" action="<?php echo site_url($account_type . '/search_student'); ?>" method="post">
                <input type="text" class="search-input search_header" name="student_identifier" id="autocomplete-dynamic" placeholder="<?php echo get_phrase('student_name').' / '.get_phrase('code').'...'; ?>" value="" required style="font-family: 'Poppins', sans-serif !important; background-color: #94949466 !important; color: #fff!important; border-bottom: 1px solid #3F3E5F;">
                <button type="submit">
                    <i class="entypo-search"></i>
                </button>
            </form>
        </li>

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- ADMINS -->
        <li class="<?php if ($page_name == 'admin') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/admin'); ?>">
                <i class="fa fa-user-secret"></i>
                <span><?php echo get_phrase('admin'); ?></span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class="<?php if ($page_name == 'student_add' ||
                            $page_name == 'student_bulk_add' ||
                            $page_name == 'student_information' ||
                            $page_name == 'student_marksheet' ||
                            $page_name == 'student_promotion' ||
                            $page_name == 'student_profile' ||
                            $page_name == "report/student_status/student_status_page")
                echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT BULK ADMISSION -->
                <li class="<?php if ($page_name == 'student_bulk_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_bulk_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_bulk_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $vtype = $this->session->userdata('vtype');
                        $classes = $this->db->get_where('class',['vtype'=>$vtype])->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id'] || $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'student_information' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo site_url('admin/student_information/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- STUDENT PROMOTION -->
                <li class="<?php if ($page_name == 'student_promotion') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_promotion'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_promotion'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/student_status/student_status_page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/student_status'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_status'); ?></span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- TEACHER -->

        <li class="<?php if ($page_name == 'teacher' || $page_name == 'teacher_bulk_add') echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'teacher') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/teacher'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('teacher'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'teacher_bulk_add') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/teacher_bulk_add'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('admit_bulk_teacher'); ?></span>
                    </a>
                </li>
            </ul>
        </li>



        <!-- PARENTS -->
        <li class="<?php if ($page_name == 'parent') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/parent'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('parents'); ?></span>
            </a>
        </li>

        <!-- CLASS -->
        <li class="<?php
        if ($page_name == 'class' ||
                $page_name == 'section' ||
                    $page_name == 'academic_syllabus')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('class'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'class') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/classes'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'section') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/section'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_sections'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/academic_syllabus'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('academic_syllabus'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SUBJECT -->
        <li class="<?php if ($page_name == 'subject') echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('subject'); ?></span>
            </a>
            <ul>
                <?php
                foreach ($classes as $row):
                    ?>
                    <li class="<?php if ($page_name == 'subject' && $class_id == $row['class_id']) echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/subject/' . $row['class_id']); ?>">
                            <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <!-- DAILY ATTENDANCE -->
        <li class="<?php if ($page_name == 'manage_attendance' ||  $page_name == 'manage_attendance_view' || $page_name == 'attendance_report' || $page_name == 'attendance_report_view'
        || $page_name == 'manage_employee_attn' || $page_name == 'manage_employee_attendance_view' ||
        $page_name == 'employee_manage_attendance_view' || $page_name == 'employee_attendance_report' || $page_name == 'employee_attendance_report_view' || $page_name == 'daily-attendance-report-form'
        || $page_name == 'daily-attendance-report' || $page_name == 'report/guest_student/form')
        echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('daily_attendance'); ?></span>
            </a>
            <ul>
                <li class="<?php if (($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view')) echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/manage_attendance'); ?>">
                        <span><i class="entypo-dot"></i><?php echo get_phrase('daily_attendance'); ?></span>
                    </a>
                </li>
            </ul>
            <ul>

                <li class="<?php if (($page_name == 'daily-attendance-report-form') || ($page_name == 'daily-attendance-report')) echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/daily_attendance_report'); ?>">
                        <span><i class="entypo-dot"></i><?php echo get_phrase('daily_attendance_report'); ?></span>
                    </a>
                </li>

                <li class="<?php if (( $page_name == 'attendance_report' || $page_name == 'attendance_report_view')) echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/attendance_report'); ?>">
                        <span><i class="entypo-dot"></i><?php echo get_phrase('attendance_report'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'report/guest_student/form') echo 'active'; ?>">
                    <a href="<?php echo site_url('report/guest_student'); ?>">
                        <span><i class="entypo-dot"></i><?php echo get_phrase('guest_student_attendance'); ?></span>
                    </a>
                </li>

            </ul>
        </li>


        <!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'exam' ||
                $page_name == 'grade' ||
                $page_name == 'marks_manage' ||
                    $page_name == 'exam_marks_sms' ||
                        $page_name == 'tabulation_sheet' ||
                            $page_name == 'marks_manage_view' || $page_name == 'question_paper' || $page_name == 'manage_extra_curriculum_grade' || $page_name == 'extra_curriculum' ||
        $page_name == 'extra_curriculum_gradings_manage')
                                echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'grade') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/grade'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/marks_manage'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_marks'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/exam_marks_sms'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'tabulation_sheet') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/tabulation_sheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('tabulation_sheet'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'question_paper') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/question_paper'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('question_paper'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'extra_curriculum_gradings_manage') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/curriculum_grade_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('grade_extra_curriculum'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'extra_curriculum') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/extra_curriculum'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('extra_curriculum'); ?></span>
                    </a>
                </li>
            </ul>
        </li>



        <!-- ONLINE EXAMS -->
        <li class="<?php if ($page_name == 'manage_online_exam' || $page_name == 'add_online_exam' || $page_name == 'edit_online_exam' || $page_name == 'manage_online_exam_question' || $page_name == 'update_online_exam_question' || $page_name == 'view_online_exam_results') echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-feed"></i>
                <span><?php echo get_phrase('online_exam'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'add_online_exam') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/create_online_exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_online_exam'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'manage_online_exam' || $page_name == 'edit_online_exam' || $page_name == 'manage_online_exam_question' || $page_name == 'view_online_exam_results') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/manage_online_exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_online_exam'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNTING -->
        <li class="<?php
        if ($page_name == 'income' ||
                $page_name == 'expense' ||
                $page_name == 'income_category' ||
                $page_name == 'income_other' ||
                $page_name == 'expense_category' ||
                $page_name == 'student_payment' || $page_name == 'payment/payment_settings' ||
                $page_name == 'payment/fee_table' || $page_name == 'employee_advance_salary')
                            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('accounting'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_payment'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income/invoices_student_multiple_fee'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payments'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income_other') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income_other'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('income'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('income_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'employee_advance_salary') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/employee_advance_salary'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('advance_salary_deduction'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payment/payment_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_payment_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payment_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payment/fee_table') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_payment_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_payment_settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Reports -->
        <li class="<?php
        if ($page_name == 'report/transfer/transfer-page' || $page_name == "report/testimonial/testimonial-page" ||
            $page_name == "report/admit_card/admit_card_page" || $page_name == "report/signature_sheet/signature_sheet_page" ||
            $page_name == "report/exam_schedule/examschedule" ||
            $page_name == "report/other_income_report/other_income" ||
            $page_name == "report/academic_transcript/academic_transcript_page" || $page_name == "report/tabulation_sheet/tabulation_sheet_page" ||
            $page_name == "report/due_report/due_report" || $page_name == "report/income_report/income_report" ||
            $page_name == "report/expense_report/expense_report" || $page_name == "report/expense_report_by_date/expense_report_by_date" ||
            $page_name == "report/tuition_fee/tuition_fee_search" || $page_name == "report/occasional_expense_report/occasional_expense" ||
            $page_name == "report/employee_salary/salary_report" || $page_name == "report/progress_report/progress_report"
        )
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-book-open"></i>
                <span><?php echo get_phrase('reports'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'report/transfer/transfer-page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/transfer'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('transfer_certificate'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/testimonial/testimonial-page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/testimonial'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('testimonial_certificate'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/admit_card/admit_card_page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/admit_card'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('Admit_card'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/signature_sheet/signature_sheet_page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/signature_sheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('Signature_sheet'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'report/exam_schedule/examschedule') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/exam_schedule'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_schedule'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'report/academic_transcript/academic_transcript_page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/academic_transcript'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('academic_transcript'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/tabulation_sheet/tabulation_sheet_page') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/tabulation_sheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('tabulation_sheet'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/due_report/due_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/student_due_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_due_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/income_report/income_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/income_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_income_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/other_income_report/other_income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/other_income_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('income_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/expense_report/expense_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/expense_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/expense_report_by_date/expense_report_by_date') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/expense_reportBydate'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_report_by_date'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/occasional_expense_report/occasional_expense') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/occasional_expense_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('occasional_expense_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'report/tuition_fee/tuition_fee_search') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/tuition_fee'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_fee_collection'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'report/progress_report/progress_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('report/progress_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('progress_report'); ?></span>
                    </a>
                </li>

            </ul>
        </li>


        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard' || $page_name == 'noticeboard_edit') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/noticeboard'); ?>">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class="<?php
        if ($page_name == 'message' ||
            $page_name == 'group_message' || $page_name == 'group_message_time' || $page_name == 'group_message_custom' || $page_name == 'time_alert_settings')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/message'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('private_message'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'group_message') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/group_message'); ?>">
                        <span><i class="entypo-dot"></i> Group Message (Batch Wise)</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'group_message_custom') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/group_message_custom'); ?>">
                        <span><i class="entypo-dot"></i> Group Message (Custom)</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'group_message_time') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/batch_time_alert_message'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('time_alert_notification'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'time_alert_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/time_alert_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('time_alert_settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' ||
              $page_name == 'manage_language' ||
                $page_name == 'sms_settings'||
                  $page_name == 'payment_settings'|| $page_name == 'designation'
        )
                    echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/system_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('general_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/sms_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_language'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payment_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/payment_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payment_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'designation') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/designation'); ?>">
                        <span><i class="entypo-dot"></i>
                        <span><?php echo get_phrase('signature'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- FRONTEND SETTINGS -->
        <li class="<?php
        if ($page_name == 'frontend_pages' ||
                $page_name == 'frontend_themes')
                    echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-monitor"></i>
                <span><?php echo get_phrase('frontend'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'frontend_pages') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/frontend_pages'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('pages'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'frontend_themes') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/frontend_themes'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('themes'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/manage_profile'); ?>">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>
