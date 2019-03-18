<h1>社員情報更新</h1>

<?php echo validation_errors(); ?>

<?php echo form_open("/member/edit"); ?>
    <?php echo form_label('氏'); ?>
    <?php echo form_input('first_name', set_value('first_name', $member->first_name)); ?>
    <?php echo form_label('名'); ?>
    <?php echo form_input('last_name', set_value('last_name', $member->last_name)); ?><br />

    <?php echo form_label('氏(カナ)'); ?>
    <?php echo form_input('first_name_kana', set_value('first_name_kana', $member->first_name_kana)); ?>
    <?php echo form_label('名(カナ)'); ?>
    <?php echo form_input('last_name_kana', set_value('last_name_kana', $member->last_name_kana)); ?><br />

    <?php echo form_label('性別'); ?>
    <?php echo form_dropdown('gender', [ 1 => '男', 2 => '女' ], set_value('gender', $member->gender)); ?><br />

    <?php echo form_label('生年月日'); ?>
    <?php 
        $birthday = [
            'name' => 'birthday', 
            'value' => set_value('birthday', $member->birthday), 
            'placeholder' => '1990-01-01'
        ];
    ?>
    <?php echo form_input($birthday); ?><br />

    <?php echo form_label('住所'); ?>
    <?php echo form_input('address', set_value('address', set_value('住所', $member->address))); ?><br />

    <?php echo form_label('入社日'); ?>
    <?php
        $entering_company_date = [
            'name' => 'entering_company_date',
            'value' => set_value('entering_company_date', set_value('entering_company_date', $member->entering_company_date)),
            'placeholder' => '2019-01-01'
        ];
    ?>
    <?php echo form_input($entering_company_date); ?>

    <?php echo form_label('退職日'); ?>
    <?php
        $retirement_date = [
            'name' => 'retirement_date',
            'value' => set_value('retirement_date', $member->retirement_date),
            'placeholder' => '2019-01-01'
        ];
    ?>
    <?php echo form_input($retirement_date); ?><br />

    <?php echo form_label('部署ID'); ?>
    <?php 
        foreach ($divisions as $division) {
            $division_options[$division->id] = "{$division->id} : {$division->division_name}"; 
        }
    ?>
    <?php echo form_dropdown('division_id', $division_options, set_value('division_id', $member->division_id)); ?>

    <?php echo form_label('役職ID'); ?>
    <?php 
        foreach ($positions as $position) {
            $position_options[$position->id] = "{$position->id} : {$position->position_name}"; 
        }
    ?>
    <?php echo form_dropdown('position', $position_options, set_value('position', $member->position)); ?><br />

    <?php echo form_label('メールアドレス'); ?>
    <?php echo form_input('email', set_value('email', $member->email)); ?><br />

    <?php echo form_label('緊急連絡先電話番号'); ?>
    <?php 
        $emergency_contact_address = [
            'name' => 'emergency_contact_address', 
            'value' => set_value('emergency_contact_address', $member->emergency_contact_address), 
            'placeholder' => 'ハイフンなし'
        ]; 
    ?>
    <?php echo form_input($emergency_contact_address); ?><br />

    <?php echo form_submit('submit', '更新'); ?><br />
<?php echo form_close(); ?> 