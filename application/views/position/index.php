<?php echo $this->session->flashdata('flash_message'); ?>

<h1>役職名一覧</h1>

<h2><a href="/position/add">役職名追加</a></h2>

<table border="1">
    <tr>
        <th>No</th>
        <th>役職名</th>
        <th>編集</th>
        <th>削除</th>
        <th>作成日時</th>
        <th>更新日時</th>
    </tr>
    <?php foreach ($positions as $position): ?>
        <tr>
            <td><?php echo $position->id; ?></td>
            <td><?php echo $position->position_name; ?></td>
            <td><a href="/position/edit/<?php echo $position->id; ?>">編集</a></td>
            <td><a href="/position/delete/<?php echo $position->id; ?>" class="delete">削除</a></td>
            <td><?php echo $position->created; ?></td>
            <td><?php echo $position->modified; ?></td>
        </tr>
    <?php endforeach; ?>
</table>