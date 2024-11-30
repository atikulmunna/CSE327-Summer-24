<?php
class Database {
private static $instance = null;
private $conn;

private $host = 'your_host';
private $user = 'your_username';
private $pass = 'your_password';
private $name = 'your_database';

private function __construct() {
$this->conn = new mysqli($this->host, $this->user, $this-
>pass, $this->name);

if ($this->conn->connect_error) {
die("Connection failed: " . $this->conn->connect_error);
}
}

public static function getInstance() {
if (!self::$instance) {
self::$instance = new Database();

}

return self::$instance;
}

public function getConnection() {
return $this->conn;
}
}
?>