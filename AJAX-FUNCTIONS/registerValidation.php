<?php
include_once("../HELPERS/classes.php");
$login = $_POST['login'];
$pass = $_POST['pass'];
$passConf = $_POST['passConf'];
$email = $_POST['email'];

$result["login"] = '';
$result["pass"] = '';
$result["passConf"] = '';
$result["email"] = '';

$loginRegex = '/^[a-zA-Z0-9._-]+/';
$passRegex = '/^[a-zA-Z0-9]+/';
$emailRegex = '/[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+/';

$pdo = Tools::connect();
$ps = $pdo->prepare("SELECT * FROM Customers WHERE login=?");
$ps->execute(array($login));
if ($ps->rowCount() > 0) {
    $result['login'] = "This login is taken";
} else if (strlen($login) < 3 || strlen($login) > 24) {
    $result['login'] = "Login must be from 3 to 24 characters";
} else if (!preg_match($loginRegex, $login)) {
    $result['login'] = "Invalid login characters '!,&^...'";
} else if (strlen($pass) < 4 || strlen($pass) > 24) {
    $result['pass'] = "Password must be from 3 to 24 characters";
} else if (!preg_match($passRegex, $pass)) {
    $result['pass'] = "Invalid pass characters '^,_-...'";
} else if ($pass != $passConf) {
    $result["passConf"] = 'Passwords do not match';
} else if (!preg_match($emailRegex, $email)) {
    $result["email"] = 'Invalid email';
}

echo json_encode($result);
// echo json_encode(preg_match($loginRegex, $login));