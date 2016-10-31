<?php
error_reporting( E_ERROR );
require_once 'config.php';

/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 29.10.2016
 * Time: 12:31
 */
    if(!isset($_SESSION['logged_in'])) {
        header("Location: index.php");}
        //take user object from session
        $user = unserialize($_SESSION['user']);
        // echo $user->username;
         $db = new DB();
         $id = $user->id;
        $row = $db->select('user', "id = $id");
        $user = $row["login"];
        $name = $row["name"];
        $education = $row["education"];
        $address = $row["address"];
        $phone = $row["phone"];

        if($_POST) {
            $name_us=trim($_POST["name"]);
            $education_us=trim($_POST["education"]);
            $address_us = trim($_POST["address"]);
            $phone_us = trim($_POST["phone"]);
            $data = array(
                "name" => "'$name_us'",
                "education" => "'$education_us'",
                "address" => "'$address_us'",
                "phone" => "'$phone_us'"
            );
            $db->update($data, 'user', "id = $id");
            header("Location: user_information.php");
        }

$templ = $twig->loadTemplate('user_information.html');
echo $templ->render(array('user'=>$user,'name'=>$name,'education'=>$education,'address'=>$address,'phone'=>$phone));
?>