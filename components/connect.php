class DataBase
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $this->connection = mysqli_connect("localhost", "username", "password", "database");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

// Use of it :
$db = Database::getInstance();
$connection = $db->getConnection();



/*<?php

$host = 'localhost';
$db = 'plantverse';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>*/
