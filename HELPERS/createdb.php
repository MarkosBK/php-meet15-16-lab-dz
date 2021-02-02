<?php
include_once("classes.php");
$pdo = Tools::connect();
$roles = "CREATE TABLE Roles(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role varchar(32) NOT NULL UNIQUE
    ) DEFAULT CHARSET 'UTF8'";

$customers = "CREATE TABLE Customers(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login varchar(32) NOT NULL UNIQUE,
    pass varchar(128) NOT NULL,
    email varchar(128) NOT NULL UNIQUE,
    roleId INT,
    FOREIGN KEY(roleId) REFERENCES Roles(id) ON UPDATE CASCADE,
    avatar varchar(256),
    discount INT DEFAULT 0,
    total DOUBLE
    ) DEFAULT CHARSET 'UTF8'";


$categories = "CREATE TABLE Categories(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category varchar(32) NOT NULL UNIQUE,
    imagepath varchar(256)
    ) DEFAULT CHARSET 'UTF8'";

$goods = "CREATE TABLE Goods(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    good varchar(64) NOT NULL,
    categoryId INT,
    FOREIGN KEY(categoryId) REFERENCES Categories(id) ON UPDATE CASCADE ON DELETE CASCADE,
    priceIn DOUBLE,
    priceSale DOUBLE,
    info varchar(256),
    rate double,
    action INT
    ) DEFAULT CHARSET 'UTF8'";

$images = "CREATE TABLE Images(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    goodId INT,
    FOREIGN KEY(goodId) REFERENCES Goods(id) ON UPDATE CASCADE ON DELETE CASCADE,
    imagepath varchar(256)
    ) DEFAULT CHARSET 'UTF8'";

$sales = "CREATE TABLE Sales(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    goodId INT,
    FOREIGN KEY(goodId) REFERENCES Goods(id) ON UPDATE CASCADE,
    customerId INT,
    FOREIGN KEY(customerId) REFERENCES Customers(id) ON UPDATE CASCADE,
    quantity INT,
    date date
    ) DEFAULT CHARSET 'UTF8'";

$pdo->exec($roles);
$pdo->exec($customers);
$pdo->exec($categories);
$pdo->exec($goods);
$pdo->exec($images);
$pdo->exec($sales);

echo "<h1 align='center' style='color: green'>Таблицы БД успешно созданы</h1>";

include_once('initializeDb.php');