<?php
try {
    $connection = new PDO('mysql:host=localhost;dbname=conferencedb', "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
