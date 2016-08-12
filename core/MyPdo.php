<?PHP

require_once "Config.php";

class MyPdo
{
     private static $connection = NULL;

     public function __construct()
     {
          $config = new Config();
          $pdo = new PDO("mysql:host=" . $config->db['host'] . ":" . $config->db['port']
               . ";dbname=" . $config->db['dbname'], $config->db['username'], $config->db['password']);
          $pdo->exec("SET CHARACTER SET utf8");
          self::$connection = $pdo;
          $config = null;
          $pdo = null;
     }

     public function getConnection()
     {
          return self::$connection;
     }

     public function closeConnection()
     {
          self::$connection = NULL;
     }
}
