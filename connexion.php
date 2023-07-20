<?php 
try {
    $db = new PDO("mysql:host=localhost;dbname=auth","root", NULL);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>