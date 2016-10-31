<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 29.10.2016
 * Time: 13:23
 */
require_once 'config.php';

$user_tools = new User_tools();
    $user_tools->logout();

header("Location: index.php");