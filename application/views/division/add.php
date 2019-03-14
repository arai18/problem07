<h1>部署名</h1>
<h2>登録画面</h2>

<?php echo validation_errors();?>

<?php echo form_open('/division/add'); ?>
    <?php echo form_label('部署名'); ?>
    <?php echo form_input('name', set_value('name')); ?><br />

    <?php echo form_submit('submit', '登録'); ?>
<?php echo form_close(); ?>
