<?php
/**
 * Тестовое задание для B2B Center
 */
require_once $_SERVER["DOCUMENT_ROOT"] . "/users.class.php";

$users = new Users();
$users->print_users_data();
