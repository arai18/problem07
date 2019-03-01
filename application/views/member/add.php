<!DOCTYPE html>
<html>
    <head>
        <title>社員情報登録</title>
    </head>
    <body>
        <h1>社員情報登録</h1>
        <h3><a href="/user/logout">ログアウト</a></h3>
        
        <?php echo validation_errors(); ?>
        
        <?php echo form_open('/member/add'); ?>
            <?php echo form_label('氏'); ?>
            <?php echo form_input('first_name', set_value('first_name')); ?>
            <?php echo form_label('名'); ?>
            <?php echo form_input('last_name', set_value('last_name')); ?><br />
            
            <?php echo form_label('氏(カナ)'); ?>
            <?php echo form_input('first_name_kana', set_value('first_name_kana')); ?>
            <?php echo form_label('名(カナ)'); ?>
            <?php echo form_input('last_name_kana', set_value('last_name_kana')); ?><br />
            
            <?php echo form_label('性別'); ?>
            <?php echo form_dropdown('gender', [ 1 => '男', 2 => '女' ], 1); ?><br />
           
            <?php echo form_label('生年月日'); ?>
            <?php 
                $birthday = [
                    'name' => 'birthday', 
                    'value' => set_value('birthday'), 
                    'placeholder' => '1990-01-01'
                ];
            ?>
            <?php echo form_input($birthday); ?><br />
            
            <?php echo form_label('住所'); ?>
            <?php echo form_input('address', set_value('address')); ?><br />
            
            <?php echo form_label('入社日'); ?>
            <?php echo form_input('entering_company_date', set_value('entering_company_date')); ?>
            <?php echo form_label('退職日'); ?>
            <?php echo form_input('retirement_date', set_value('retirement_date')); ?><br />
            
            <?php echo form_label('部署ID'); ?>
            <?php 
                $division_options = [
                    0 => '0 : 開発部',
                    1 => '1 : 総務部'
                ]; 
            ?>
            <?php echo form_dropdown('division_id', $division_options, 0); ?>
            
            <?php echo form_label('役職ID'); ?>
            <?php 
                $position_options = [
                    0 => '0 : 社員',
                    1 => '1 : 部長'
                ];
            ?>
            <?php echo form_dropdown('position', $position_options, 0); ?><br />
            
            <?php echo form_label('メールアドレス'); ?>
            <?php echo form_input('email', set_value('email')); ?><br />
            <?php echo form_label('パスワード'); ?>
            <?php echo form_password('password', set_value('password')); ?><br />
            
            <?php echo form_label('緊急連絡先電話番号'); ?>
            <?php 
                $emergency_contact_address = [
                    'name' => 'emergency_contact_address', 
                    'value' => set_value('emergency_contact_address'), 
                    'placeholder' => 'ハイフンなし'
                ]; 
            ?>
            <?php echo form_input($emergency_contact_address, set_value('emergency_contact_address')); ?><br />
            
            <?php echo form_submit('submit', '登録'); ?><br />
        <?php echo form_close(); ?>   
    </body>
</html>
