<?php

// config/database.php

class Database
{
    private $host = 'localhost';
    private $db_name = 'stock_productos';
    private $username = 'root';
    private $password = 'root';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public static function crearBaseDatos()
    {
        try {
            $conn = new PDO("mysql:host=localhost", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE DATABASE IF NOT EXISTS stock_productos CHARACTER SET utf8 COLLATE utf8_general_ci";
            $conn->exec($sql);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
