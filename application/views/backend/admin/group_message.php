
<style media="screen">
.mail-env .mail-sidebar .mail-menu > li:hover a.customize_group {
  background: none;
  color: #607D8B;
}
.mail-env .mail-sidebar .mail-menu > li.active a.customize_group {
    background: none;
    font-weight: bold;
}
</style>
<div class="pull-right" style="text-align: right; margin-top: -30px;">
  <a href="<?php echo site_url('admin/message'); ?>" class="btn btn-blue"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo get_phrase('private_message'); ?></a>
</div>
<hr />
<div class="mail-env">

    <!-- Mail Body -->
    <div class="mail-body">
        <!-- message page body -->
        <?php include $message_inner_page_name . '.php'; ?>
    </div>

    <!-- Sidebar -->
    <div class="mail-sidebar" style="min-height: 800px;">
      <!-- compose new email button -->
      <div class="mail-sidebar-row hidden-xs">
      </div>
        <!-- message user inbox list -->
        <ul class="mail-menu">

    </div>

</div>
