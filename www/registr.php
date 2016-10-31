<?php
error_reporting( E_ERROR );
require_once 'config.php';
//initialize php variables used in the form
$form_name = "";
$form_email = "";
$form_pswd1 = "";
$form_pswd2 = "";
$name_exist = "";
$email_exist="";
$email_err="";
$pasw_err_match="";
$pasw_err="";

//check to see that the form has been submitted
if(isset($_POST["create_user"])) {
    //retrieve the $_POST variables
    $username = trim($_POST['form_name']);
    $email = trim($_POST['form_email']);
    $password =trim($_POST['form_pswd1']);
    $password_confirm = trim($_POST['form_pswd2']);
    //initialize variables for form validation
    $success = true;
   // $user_tools = new User_tools();

    //validate that the form was filled out correctly
    //check to see if user name already exists
    if($user_tools->checkUsernameExists($username))
    {
        $name_exist  = "К сожалению, логин уже занят!";
        $success = false;
    }
    //check to see if email already exists
    if($user_tools->checkEmailExists($email))
    {
        $email_exist  = "К сожалению, почта уже занята!";
        $success = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {// filters a variable with a specified filter
        $email_err = "Неправильный формат почты!";
        $success = false;
    }
    //Check to see if passwords match
    if($password != $password_confirm) {
        $pasw_err_match = "Пароль не соответсвует!";
        $success = false;
    }
    if(mb_strlen($password)!=6){ //gets the length of the string
        $pasw_err = "Пароль должен содержать 6 символов!";
        $success = false;
    }

    if($success)
    {
        //prep the data for saving in a new user object
        $data['us_login'] = $username;
        $data['us_email'] = $email;
        $data['us_encoded_pasw'] = password_hash($password, PASSWORD_DEFAULT); //encrypt the password for storage
        //create the new user object
        $new_user = new User($data);
        //save the new user to the database
        $new_user->save(true);
        $db = new DB();
        $active = $db->select("user","login = $username");
        $id_active = $active["id"];
        $activation = md5($id_active);
        $subject = "Подтверждение регистрации";
        $message = "Здравствуйте! Спасибо за регистрацию !\nВаш логин: ".$username."\n Перейдите по ссылке, чтобы активировать ваш аккаунт:\n
http://localhost/Login_form/www/activation_user.php".$username."&activation=".$activation."\n\n";
        //automatically sends the message
        mail($email, $subject, $message, "Content-type:text/plain; Charset=windows-1251\r\n");
        header("Location: index.php");
    }
}
$templ = $twig->loadTemplate('registr.html');
echo $templ->render(array('name_exist'=>$name_exist,'email_exist'=>$email_exist,'email_err'=>$email_err,'pasw_err_match'=>$pasw_err_match,'pasw_err'=>$pasw_err));

?>
