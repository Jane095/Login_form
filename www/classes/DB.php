<?php
/**
 * Created by PhpStorm.
 * User: Евгения
 * Date: 28.10.2016
 * Time: 11:05
 */

class DB{
    protected $db_host = 'localhost:3307';
    protected $db_name = 'login_form';
    protected $db_user = 'root';
    protected $db_pass = '';

    //connect to DB
    public function connect() {
        $connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        if (mysqli_connect_error()) {
            die('Ошибка подключения (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }else {
            return $connect;
        }
    }
    //select row from table
    public function select($table, $where) {
        $sql = "SELECT * FROM $table WHERE $where";
        $connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        $res = mysqli_query($connect, $sql);
        return mysqli_fetch_array($res, MYSQLI_ASSOC);
    }

    //update information in DB
    public function update($data, $table, $where) {
        $connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            mysqli_query($connect, $sql) or die(mysqli_error($connect));
        }
        return true;
    }

    //insert new values to the DB
    public function insert($data, $table) {
        $connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        $columns = "";
        $values = "";
        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        $sql = "INSERT INTO $table ($columns) values ($values)";
        mysqli_query($connect,$sql) or die(mysqli_error($connect));

        return mysqli_insert_id($connect);
    }

} 