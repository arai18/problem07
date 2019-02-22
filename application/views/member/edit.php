<!DOCTYPE html>
<html>
    <head>
        <title>社員情報更新</title>
    </head>
    <body>
        <h1>社員情報更新</h1>
        
        <?php echo validation_errors();?>
        
        <?php 
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
        ?>
        
        <form action="/member/edit/<?php echo $member->id; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $member->id;?>">
            <label>氏</label>
            <input type="text" name="first_name" value="<?php echo set_value('first_name', $member->first_name) ;?>"><br />
            
            <label>名</label>
            <input type="text" name="last_name" value="<?php echo set_value('last_name', $member->last_name) ;?>"><br />
            
            <label>生年月日</label>
            <input type="text" name="age" value="<?php echo set_value('age', $member->age) ;?>"><br />
            
            <label>出身地</label>
            <input type="text" name="home" value="<?php echo set_value('home', $member->home) ;?>"><br />
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <input type="submit" value="登録">
            
        </form>
        
       
    </body>
</html>
