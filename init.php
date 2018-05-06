<?php

require_once 'config.php';
require_once 'credentials-manager.php';
require_once 'page-manager.php';


$mysqli = new mysqli(
    sprintf("%s:%d", $database['host'], $database['port']),
    $database['user'],
    $database['pass'],
    $database['database']
);

if($mysqli->connect_error) {
    die('mysql error: ' . $mysqli->connect_errno);
}

$credentialsManager = new CredentialsManager($mysqli);
$pageManager = new PageManager($mysqli);

if(isset($_GET['logout'])) {
    $credentialsManager->logout();
    header("Location: index.php");
}

if(isset($_POST['username']) && isset($_POST['password'])) {
    $credentialsManager->login($_POST['username'], $_POST['password']);
    header("Location: index.php");
}

require_once 'header.php';
