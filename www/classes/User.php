<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 28.10.2016
 * Time: 12:33
 */
require_once 'DB.php';

class User {
    public $id;
    public $us_login;
    public $us_name;
    public $us_email;
    public $us_encoded_pasw;
    public $us_education;
    public $us_address;
    public $us_phone;

    //Takes an associative array with the DB row as an argument.
    function User($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->us_login = (isset($data['us_login'])) ? $data['us_login'] : "";
        $this->us_email = (isset($data['us_email'])) ? $data['us_email'] : "";
        $this->us_encoded_pasw = (isset($data['us_encoded_pasw'])) ? $data['us_encoded_pasw'] : "";
    }

    public function save($is_new_user = false) {
        //create a new database object.
        $db = new DB();

        //if the user is already registered and we're
        //just updating their info.
        if(!$is_new_user) {
            //set the data array
            $data = array(
                "login" =>"'$this->us_login'",
                "email" =>"'$this->us_email'",
                "password" =>"'$this->us_encoded_pasw'"
            );

            //update the row in the database
            $db->update($data, 'user', 'id = '.$this->id);
        }else {
            //if the user is being registered for the first time.
            $data = array(
                "login" =>"'$this->us_login'",
                "email" =>"'$this->us_email'",
                "password" =>"'$this->us_encoded_pasw'"
            );
            $this->id_us = $db->insert($data, 'user');
        }
        return true;
    }

} 