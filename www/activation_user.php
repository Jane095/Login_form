<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 28.10.2016
 * Time: 22:50
 */
require_once "classes/DB.php";

if(isset($_GET['activation']) AND isset($_GET['login'])) {
    $act = $_GET['activation'];
    $act = stripslashes($act);
    $act = htmlspecialchars($act);

    $login = $_GET['login'];
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
}
else{
    exit("Вы зашли на страницу без кода подтверждения!");
}

$db = new DB();
$activ = $db->select("user", "login =$login");
$id_activ = $activ["id"];
$activation = md5($id_activ);
if ($activation == $act) {//сравниваем полученный из url и сгенерированный код
    $data = array("activation" => "'1'");
    $db->update($data, "user", "login = $login");
    echo "Ваш аккуант <strong>".$login."</strong> успешно активирован! Теперь вы можете зайти на сайт под своим логином и паролем!<br><a href='index.php'>Главная страница</a>";
}
else {
    echo "Ошибка! Ваш аккуант не активирован. <br><a href='index.php'>Главная страница</a>";
}