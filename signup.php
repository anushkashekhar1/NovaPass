<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['user'] = [
        'name' => $_POST['name'],
        'email' => $_POST['email']
    ];

    header("Location: events.php");
    exit();
}
?>
