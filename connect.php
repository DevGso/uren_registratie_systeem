<?php 
$dbhost = 'localhost';
    $dbname = 'uren_registratie';
    $dbuser = '-----';
    $dbpass = '-----';
    $is_error = false;
    $error_detail = "l";
    try {
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $is_error = false;
    } catch (PDOException $e) {
        $is_error = true;
        $error_Message = $e->getMessage();
    }
?>