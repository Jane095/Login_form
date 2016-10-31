<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 28.10.2016
 * Time: 12:58
 */

require_once 'DB.php';
require_once 'User.php';


class User_tools {
//Log the user in. First checks to see if the
    //username and password match a row in the database.
    //If it is successful, set the session variables
    //and store the user object within.
    public function login($login, $password){
        $db = new DB();
        $connect = $db->connect();
        $sql = "SELECT * FROM user WHERE login = '$login'";
        $res = mysqli_query($connect,$sql);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $hash = $row['password'];
        $id_user = $row['id'];
        if(password_verify($password, $hash) == true){
            $_SESSION["user"] = serialize(new User($row));
            $_SESSION["login_time"] = time();
            $_SESSION["logged_in"] = 1;
            $ret = true;
        }else{
            $ret = false;
        }
        return $ret;
    }
   /* public function id_User($login){
        $db = new DB();
        $connect = $db->connect();
        $sql = "SELECT * FROM user WHERE login = '$login'";
        $res = mysqli_query($connect,$sql);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $id_user = $row['id'];
       if ($id_user!=0){
           //echo "<a href='user_information.php?id=".$row['id']."'/>";
            echo $id_user;
           return $id_user;
       }else
           return false;
    }*/

    //Log the user out. Destroy the session variables.
    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['login_time']);
        unset($_SESSION['logged_in']);
        session_destroy();
    }

    //Check to see if a username exists.
    //This is called during registration to make sure all user names are unique.
    public function checkUsernameExists($us_login) {
        $db = new DB();
        $connect = $db->connect();
        $sql_query = "SELECT id_user FROM user WHERE login='$us_login'";
        $res = mysqli_query($connect, $sql_query);
        if(mysqli_num_rows($res) == 0){
            return false;
        }else{
            return true;
        }
    }
    public function checkEmailExists($us_email) {
        $db = new DB();
        $connect = $db->connect();
        $sql_query = "SELECT id_user FROM user WHERE email='$us_email'";
        $res = mysqli_query($connect, $sql_query);
        if(mysqli_num_rows($res) == 0){
            return false;
        }else{
            return true;
        }
    }
    //get a user
    //returns a User object. Takes the users id as an input
    public function get($id)
    {
        $db = new DB();
        $res = $db->select('user', "id = $id");
        return new User($res);
    }
} 