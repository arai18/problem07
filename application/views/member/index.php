<!doctype html>
<html lang="ja">
<head>
    <title>社員一覧</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
    <script type="text/javascript" src="/assets/js/script.js"></script>
</head>
<body>
    <a href="/admin/edit">admin情報変更</a>
    <a href="/admin/edit_password">パスワード変更</a>
    <a href="/admin/logout">ログアウト</a>
    
    <h1>社員一覧</h1>
    
    <table border="1">
        <tr>
            <th>社員番号</th>
            <th>氏名</th>
            <th>年齢</th>
            <th>性別</th>
            <th>部署</th>
            <th>役職</th>
            <th>入社日</th>
            <th>目標</th>
            <th>コメント</th>
            <th>削除</th>
            <th>登録日時</th>
            <th>更新日時</th>
        </tr>
        <?php foreach ($members as $member): ?>
            <tr>
                <th><?php echo $member->id; ?></th>
                <th><?php echo $member->first_name . $member->last_name; ?></th>
                <th>
                    <?php 
                        $now = date("Ymd");
                        $birthday = str_replace("-", "", $member->birthday);//ハイフンを除去しています。
                        echo floor(($now-$birthday)/10000);
                    ?>
                </th>
                <th><?php $gender = ($member->gender === '1')? '男':'女'; ?><?php echo $gender; ?></th>
                <th><?php echo $member->division->division_name?></th>
                <th><?php echo $member->position->position_name?></th>
                <th><?php echo $member->entering_company_date;?></th>
                <th><a href="/target/index">一覧</a></th>
                <th><a href="#">コメント</a></th>
                <th><a href="#">削除</a></th>
                <th>
                    <?php
                        $createdTime = $member->created;
                        $unixTime = strtotime($createdTime);
                        echo date("y/m/d H:i", $unixTime); 
                    ?>
                </th>
                <th>
                    <?php
                        $modifiedTime = $member->modified;
                        $unixTime = strtotime($modifiedTime);
                        echo date("y/m/d H:i", $unixTime); 
                    ?>
                </th>
            </tr>
        <?php endforeach; ?>
    </table>
    
</html>