<?php
// filepath: c:\laragon\www\Final-Project---Web-Programming-main\Final-Project-Web-Programming\check_login.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>