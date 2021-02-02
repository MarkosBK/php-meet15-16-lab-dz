<?php
include_once("classes.php");
$customers = Customer::getAll();
print_r($customers);