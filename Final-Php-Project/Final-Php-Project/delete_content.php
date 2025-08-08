<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page!");
}
require './inc/db.php';
require 'content_class.php';

$db = getConnection();
$contentObj = new Content($db);

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $contentObj->delete($_POST['id']);
}
header("Location: content.php");
exit;
?>
