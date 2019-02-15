<!doctype html>
<html lang="ja">
<head>
    <title>社員一覧画面</title>
</head>
<body>
    <h1>社員一覧画面</h1>
    
    <h2><a href="http://local.problem07.com/member/add">新規登録</a></h2>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>氏名</th>
            <th>出身</th>
            <th>コメント</th>
            <th>削除</th>
            <th>登録日時</th>
            <th>更新日時</th>
        <tr>
        
        <?php foreach($members as $member): ?>
        <tr>
            <td><?= $member->id ?></td>
            <td><a href="http://local.problem07.com/member/update/<?php echo $member->id; ?>"><?= $member->first_name . $member->last_name  ?></a></td>
            <td><?= $member->home ?></td>
            <td><a href="#">コメント</a></td>
            <td><a href="http://local.problem07.com/member/destroy/<?php echo $member->id; ?>">削除</a></td>
            <td><?= $member->created ?></td>
            <td><?= $member->modified ?></td>
        </tr>
        
        <?php endforeach; ?>
    </table>
</body>
    
</html>