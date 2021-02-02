<?php
$ps1 = $pdo->prepare("INSERT INTO Roles(role) VALUES(?)");
$role1 = "Admin";
$ps1->bindParam(1, $role1);
$ps1->execute();
$ps2 = $pdo->prepare("INSERT INTO Roles(role) VALUES(:role)");
$role2 = "Customer";
$ps2->bindParam(":role", $role2);
$ps2->execute();
$admin = new Customer('admin', md5('admin'), 'admin@gmail.com', '');
$admin->roleId = 1;
$admin->push_to_db();
$category1 = new Category('Databases');
$category2 = new Category('Computers');
$category3 = new Category('Audio');
$category4 = new Category('Phones');
$category5 = new Category('Programs');
$category1->push_to_db();
$category2->push_to_db();
$category3->push_to_db();
$category4->push_to_db();
$category5->push_to_db();

$info = 'very looong info, very looong info, very looong info, very looong info, very looong info, very looong info, very looong info, very looong info, very looong info';
$good1 = new Good('Pentagon', 1, 1000, 7000, $info);
$good2 = new Good('Google customers', 1, 1000, 5000, $info);
$good3 = new Good('Netflix films database', 1, 300, 1000, $info);
$good4 = new Good('Artline 2021 PRO GAMING', 2, 1000, 1300, $info);
$good5 = new Good('Artline 2020 WorkStation', 2, 1000, 7000, $info);
$good6 = new Good('Artline 2021 CyberPunk', 2, 1000, 7000, $info);
$good7 = new Good('Top za svoi dengi', 2, 600, 650, $info);
$good8 = new Good('Apple PC', 2, 1700, 2500, $info);
$good9 = new Good('Headphone 2.0', 3, 150, 180, $info);
$good10 = new Good('JBL headphones', 3, 200, 250, $info);
$good11 = new Good('Iphone 12 PRO MAX', 4, 1000, 1500, $info);
$good12 = new Good('Galaxy S21', 4, 1000, 1500, $info);
$good13 = new Good('Bruteforce moment xD', 5, 20, 300, $info);

$good1->push_to_db();
$good2->push_to_db();
$good3->push_to_db();
$good4->push_to_db();
$good5->push_to_db();
$good6->push_to_db();
$good7->push_to_db();
$good8->push_to_db();
$good9->push_to_db();
$good10->push_to_db();
$good11->push_to_db();
$good12->push_to_db();
$good13->push_to_db();



echo "<h1 align='center' style='color: green'>Таблицы БД успешно проинициализированны</h1>";
echo "<h2 align='center' style='color: brown'>При инициализации у товаров нет изображения</h2>";
echo "<h2 align='center' style='color: brown'>login/password админа (admin/admin) </h2>";
echo "<a style='font-size: 32px' class='btn btn-dark' href='../index.php?page=1'>На главную</a>";