<?

class ConnectDB {
  private $server = "";
  private $db = "ttd";
  private $username = "root";
  private $password = "12345678";

  protected $pdo;

  public function __construct() {
    try {
      $this->pdo = new PDO("mysql:host=$server;dbname=$db", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connection successfully";
    } catch(PDOException $e) {
      echo "Connection failed : ". $e->getMessage();
    }
  }
}

?>