<?php
error_reporting( E_ERROR );
require_once 'config.php';
//initialization of the variables
$form_login = "";
$form_password = "";
$email_err="";
$pasw_err="";


if(isset($_POST["enter_form"])) {
    //retrieve the $_POST variables
    $login = trim($_POST['form_login']);
    $password = trim($_POST['form_password']);
    //initialize variables for form validation
    $success = true;

   if (mb_strlen($password) != 6) { //gets the length of the string
        $pasw_err = "Пароль должен содержать 6 символов!";
        $success = false;
   }
   if ($success) {
       //$user_tools = new User_tools();
       if ($user_tools->login($login, $password)) {
           //удачный вход, редирект на страницу
           header("Location: user_information.php");
       } else {
           $error = "Неправильный логин или пароль! Попробуйте еще раз";
       }
   }
}
$templ = $twig->loadTemplate('index.html');
echo $templ->render(array('pasw_err'=>$pasw_err));

?>
