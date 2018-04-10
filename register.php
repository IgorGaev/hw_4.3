<?php
session_start();
include_once 'database.php';

if (isset($_POST['register'])) {
    $login = strip_tags(trim($_POST['login']));
    $password = md5(trim($_POST['password']));
    $pdo->exec("INSERT INTO user(login,password ) "
            . "VALUES ('$login', '$password')");
}
if (isset($_POST['sign_in'])) {
    $enteredLogin = strip_tags(trim($_POST['login']));
    $enteredPassword = md5(trim($_POST['password']));
    $sql = "SELECT * FROM user WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["login" => "$enteredLogin"]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData['password'] == $enteredPassword) {
        
        $_SESSION['name'] = $userData['login'];
        header('Location: index.php');
        exit();
    }
    else {
        echo 'Неправильный пароль или логин'; 
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            if(isset($_SESSION['name'])){
                echo 'Вы авторизовались';
            } else {
                 echo '<h3>Введите данные для регистрации или войдите, если уже регистрировались:</h3>';
            }    
        ?>
        
        

        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required/>
            <input type="password" name="password" placeholder="Пароль" required />
            <input type="submit" name="sign_in" value="Вход"/>
            <input type="submit" name="register" value="Регистрация"/>
        </form>
        
    </body>
</html>
