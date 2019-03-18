<?php echo $this->session->flashdata('flash_message');?>

<h1>部署名一覧</h1>

<h2><a href="/division/add">部署名追加</a></h2>

<table border="1">
    <tr>
        <th>No</th>
        <th>部署名</th>
        <th>編集</th>
        <th>削除</th>
        <th>作成日時</th>
        <th>更新日時</th>
    </tr>
    <?php foreach ($divisions as $division): ?>
        <tr>
            <td><?php echo $division->id; ?></td>
            <td><?php echo $division->division_name; ?></td>
            <td><a href="/division/edit/<?php echo $division->id; ?>">編集</a></td>
            <td><a href="/division/delete/<?php echo $division->id; ?>" class="delete">削除</a></td>
            <td><?php echo $division->created; ?></td>
            <td><?php echo $division->modified; ?></td>
        </tr>
    <?php endforeach; ?>
</table>