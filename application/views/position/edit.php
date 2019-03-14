        <h1>役職名</h1>
        <h2>更新画面</h2>
        
        <?php echo validation_errors();?>
        
        <?php echo form_open("/position/edit/{$position->id}"); ?>
            <?php echo form_label('役職名'); ?>
            <?php echo form_input('name', set_value('name', $position->position_name)); ?><br />
            
            <?php echo form_submit('submit', '更新'); ?>
        <?php echo form_close(); ?>