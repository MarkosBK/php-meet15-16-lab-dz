<?php
include_once("../HELPERS/classes.php");
$goodId = $_POST['goodId'];

$pdo = Tools::connect();
$ps = $pdo->prepare("SELECT * FROM Images where goodId=?");
$ps->execute(array($goodId));
$row = $ps->fetch();
$image = new Image(
    $row['goodId'],
    $row['imagepath'],
    $row['id']
);
echo json_encode($image);