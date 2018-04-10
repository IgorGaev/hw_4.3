<?php
session_start();
if (!isset($_SESSION['name'])) {
    echo '<p><a href="register.php">Войдите на сайт</a></p>';
    exit;
}
$login = $_SESSION['name'];
include_once 'database.php';

if (!empty($_POST)) {
    $description = strip_tags($_POST['description']);
    $date_added = $_POST['date'];
    
    $pdo->exec("INSERT INTO task(description, date_added) VALUES ('$description', '$date_added')");
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $pdo->exec("DELETE FROM task WHERE id='$id'");
}
?>
<h1>Здравствуйте, <?= $login?>! Вот ваш список дел:</h1>


<form method="POST" >
    <input type="text" name="description" placeholder="Описание задачи">
    <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
    <input type="submit" value="Добавить">
</form>

<div style="clear: both"></div>
<style>
    table { 
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }

    table th {
        background: #eee;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>
            <th>Статус</th>
            <th>Действие</th>
            <th>Ответственный</th>
            <th>Автор</th>
            <th>Закрепить задачу за пользователем</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sql = 'SELECT task.description, task.date_added, task.is_done, task.id, user.login '
                . 'FROM task JOIN user ON task.user_id=user.id';
//        $dt=$pdo->query($sql);
//        $dts = $dt->fetch(PDO::FETCH_ASSOC);
//        print_r($dts);
        foreach ($pdo->query($sql) as $row) : ?>
            <tr>
                <td><?= $row['description'] ?></td>
                <td><?= $row['date_added'] ?></td>
                <td><?= ($row['is_done'] == 0) ? 
                '<span style="color: green;">Выполнено</span>' : 'В процессе';?></td>
                <td>
                    <a>Выполнить</a>
                    <a href='index.php?id=<?= $row['id'] ?>'>Удалить</a>
                </td>
                <td><?= $row['login'] ?></td>
                <td><?= $row['login'] ?></td>
            </tr>
        <?php endforeach; ?>   
            
    </tbody>
</table>
<p><a href="logout.php">Выход</a></p>


