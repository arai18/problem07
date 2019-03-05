<!doctype html>
<html lang="ja">
<head>
    <title>目標一覧</title>
</head>
<body>
    <h1>目標一覧</h1>
    
    <h2><a href="/target/add">目標追加</a></h2>
    <h3><a href="/member/logout">ログアウト</a></h3>
     
    <h4><?php echo 2022; ?>年度</h4>
        <table border="1">
            <tr>
                <th>No</th>
                <th>期間</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>コメント</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>

            <?php $number = 0;?>
            <?php foreach ($targets as $target): ?>
                <?php if($target->year == 2020): ?>
                <?php $number++; ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $target->term; ?></td>
                    <td><?php echo $target->target?></td>
                    <td><a href="/target/edit/<?php echo $target->member_id ?>/<?php echo $target->year?>/<?php echo $target->term?>">編集</a></td>
                    <td><a href="/target/delete/<?php echo $target->member_id?>/<?php echo $target->year?>/<?php echo $target->term?>">削除</a></td>
                    <td><a href="#">コメント</a></td>
                    <td><?php echo $target->created; ?></td>
                    <td><?php echo $target->modified; ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>


    <h4><?php echo 2021; ?>年度</h4>
        <table border="1">
            <tr>
                <th>No</th>
                <th>期間</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>コメント</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>

            <?php $number = 0;?>
            <?php foreach ($targets as $target): ?>
                <?php if($target->year == 2021): ?>
                <?php $number++; ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $target->term; ?></td>
                    <td><?php echo $target->target?></td>
                    <td><a href="/target/edit/<?php echo $target->member_id ?>/<?php echo $target->year?>/<?php echo $target->term?>">編集</a></td>
                    <td><a href="/target/delete/<?php echo $target->member_id?>/<?php echo $target->year?>/<?php echo $target->term?>">削除</a></td>
                    <td><a href="#">コメント</a></td>
                    <td><?php echo $target->created; ?></td>
                    <td><?php echo $target->modified; ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>


    <h4><?php echo 2020; ?>年度</h4>
        <table border="1">
            <tr>
                <th>No</th>
                <th>期間</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>コメント</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>

            <?php $number = 0;?>
            <?php foreach ($targets as $target): ?>
                <?php if($target->year == 2020): ?>
                <?php $number++; ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $target->term; ?></td>
                    <td><?php echo $target->target?></td>
                    <td><a href="/target/edit/<?php echo $target->member_id ?>/<?php echo $target->year?>/<?php echo $target->term?>">編集</a></td>
                    <td><a href="/target/delete/<?php echo $target->member_id?>/<?php echo $target->year?>/<?php echo $target->term?>">削除</a></td>
                    <td><a href="#">コメント</a></td>
                    <td><?php echo $target->created; ?></td>
                    <td><?php echo $target->modified; ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

    <h4><?php echo 2019; ?>年度</h4>
        <table border="1">
            <tr>
                <th>No</th>
                <th>期間</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>コメント</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>

            <?php $number = 0;?>
            <?php foreach ($targets as $target): ?>
                <?php if($target->year == 2019): ?>
                <?php $number++; ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $target->term; ?></td>
                    <td><?php echo $target->target?></td>
                    <td><a href="/target/edit/<?php echo $target->member_id ?>/<?php echo $target->year?>/<?php echo $target->term?>">編集</a></td>
                    <td><a href="/target/delete/<?php echo $target->member_id?>/<?php echo $target->year?>/<?php echo $target->term?>">削除</a></td>
                    <td><a href="#">コメント</a></td>
                    <td><?php echo $target->created; ?></td>
                    <td><?php echo $target->modified; ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
</html>