<?php
session_start();

if(!isset($_SESSION['user_id'])){
    die("You must be logged in to access this page!");
}

require './inc/db.php';
require 'user.php';

$db = getConnection();
$user = new User($db);

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int) $_GET['id'];
    $user->delete($id);
}

header("Location: dashboard.php");
exit;
?>
