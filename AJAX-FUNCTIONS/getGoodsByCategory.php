<?php
include_once("../HELPERS/classes.php");
$categoryId = $_POST['categoryId'];

$pdo = Tools::connect();
$ps = $pdo->prepare("SELECT * FROM Goods where categoryId=?");
$ps->execute(array($categoryId));
$goods = [];
while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
    $good = new Good(
        $row['good'],
        $row['categoryId'],
        $row['priceIn'],
        $row['priceSale'],
        $row['info'],
        $row['id'],
        $row['rate'],
        $row['action']
    );
    array_push($goods, $good);
}
echo json_encode($goods);