<?php

class DBConn
{
    private static $_instance = null;

    public static function getIntanceOfDBConn()
    {
        if(self::$instance==null) {
            self::$instance = new DBConn();
        }
        return self::$instance;
    }

    public static function getDBConn()
    {
        $servername = "localhost";
        $username = "root";
        $password = "tejas";
        $dbname = "user";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>