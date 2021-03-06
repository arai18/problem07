<?php echo validation_errors(); ?>
    
    <?php echo form_open('/target/add'); ?>
        <?php echo form_label('年度'); ?>
        <?php
            $year = [
                'name' => 'year',
                'value' => set_value('year'),
                'placeholder' => date('Y')
            ];
        ?>
        <?php echo form_input($year); ?><br />
    
        <?php echo form_label('期間'); ?>
        <?php
            $term_options = [
                1 => '4月~6月',
                2 => '7月~9月',
                3 => '10月~12月',
                4 => '1月~3月'
            ];
        ?>
        <?php echo form_dropdown('term', $term_options, set_value('term')); ?><br />
    
        <?php echo form_label('目標'); ?><br />
        <?php
            $target = [
                'name' => 'target',
                'value' => set_value('target'),
                'placeholder' => 'ここに目標を記入してください。'
            ];
        ?>
        <?php echo form_textarea($target); ?><br />
   
        <?php echo form_submit('submit', '追加'); ?>
    <?php echo form_close(); ?>