<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=base", "root", "");
    $pdo->exec('SET CHARACTER SET utf8');    
    
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>