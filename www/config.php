<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 28.10.2016
 * Time: 13:31
 */


require_once 'classes/User.php';
require_once 'classes/User_tools.php';
require_once 'classes/DB.php';

//connect to the database
$db = new DB();
$db -> connect();


//initialize UserTools object
$user_tools = new User_tools();

session_start();
//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {

    $user = unserialize($_SESSION['user']);
    $_SESSION['user'] = serialize($user_tools->get($user->id));
}
require_once "include/Twig/Autoloader.php";
Twig_Autoloader::register();
$loader= new Twig_Loader_Filesystem('theme');

$twig = new Twig_Environment($loader);
/*$twig = new Twig_Environment($loader, array(
    'cache' => '/path/to/compilation_cache'));
*/
