<h1>admin</h1>
<h2>更新画面</h2>

<?php echo validation_errors();?>

<?php echo form_open('/admin/edit'); ?>
    <?php echo form_label('メールアドレス'); ?>
    <?php echo form_input('email', set_value('email', $admin->email)); ?><br />

    <?php echo form_label('氏名'); ?>
    <?php echo form_input('name', set_value('name', $admin->name)); ?><br />
    <?php echo form_submit('submit', '更新'); ?>
<?php echo form_close(); ?>