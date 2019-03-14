<h1>部署名</h1>
<h2>更新画面</h2>

<?php echo validation_errors();?>

<?php echo form_open("/division/edit/{$division->id}"); ?>
    <?php echo form_label('部署名'); ?>
    <?php echo form_input('name', set_value('name', $division->division_name)); ?><br />

    <?php echo form_submit('submit', '更新'); ?>
<?php echo form_close(); ?>
