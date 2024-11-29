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