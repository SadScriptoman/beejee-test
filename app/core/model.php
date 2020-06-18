
<?
    class Model {

        const connectionInfo = [
            'host' => 'localhost',
            'dbName' => 'beejee',
            'userName' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ];
        
        private $db;
        public $application;
        
        function __construct($application) {

            $this->application = $application;

            try{
                $this->db = new PDO('mysql:host='.self::connectionInfo['host'].';dbname='.self::connectionInfo['dbName'].';charset='.self::connectionInfo['charset'], self::connectionInfo['userName'], self::connectionInfo['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
            }catch(PDOException $e){
                echo 'Подключение к бд завершилось с ошибкой:<br>'.$e->getMessage().'<br>';
            }
    
        }

        public function getDB(){
            return $this->db;
        }

        public function getData(){

	    }
    }