<?php 


class Database
{
    //define database
    
    

    private $database;
    private $username;
    private $password;
    private $server;

    public $secret;

    protected $connection;
    
    /*
    * Set connection config
    */
    function __construct()
    {
        $config = require dirname(__DIR__) . '/config.php';

        //define database
        $databaseConfig = $config['connection'][$config['database']];
        $driver = $databaseConfig['driver'];

        $this->database = $databaseConfig['database'];
        $this->username = $databaseConfig['username'];
        $this->password = $databaseConfig['password'];
        $this->server = $databaseConfig['host'];
        $this->secret = $config['secret'];
        
    }

    /*
    * connect to the database
    */
    private function connect()
    {
        $info = 'mysql:host='.$this->server.';dbname='.$this->database;
        
        try {
            $this->connection = new PDO($info, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $exception) {
            header('HTTP/1.1 500 database Error');
            echo "Verbinding mislukt: " . $exception->getMessage();
            exit;
        }

        if (!$this->connection)
        {
            die('Kon geen verding maken: ' . mysqli_connect_error());
        }

    }
    
    /**
    * disconnect from database 
    */   
    private function disconnect()
    {
        $this->connection = null;
    }

    /**
     * quoting string
     * @param string $args
     * @return string $args
     */

    public function quote($args)
    {

        $this->connect();
        $args = $this->connection->quote($args);
        $this->disconnect();

        return $args;

    }

    /**
     * prepare statemane for single fetch
     * @param string $sql
     * @param array $args
     * @return array $query, $lastInsertId
     */

    public function prepare($sql, $args)
    {

        $this->connect();
        $query = $this->connection->prepare($sql);
        $query->execute($args);
        $lastInsertId = $this->connection->lastInsertId();
        $rowCount = $query->rowCount();
        $this->disconnect();

        return $query = ['query' => $query, 'lastInsertId' => $lastInsertId, 'rowCount' => $rowCount];
    }

    /**
     * Return array of results
     * @param string $sql
     * @param array $args
     * @return query array $rows
     */

    public function getResults($sql, $args = [])
    {

        $this->connect();
        $query = $this->connection->prepare($sql);
        $query->execute($args);
        $rows = $query->fetchALL(PDO::FETCH_ASSOC);
        $this->disconnect();

        return $rows;

    }

    /**
     * Return single result
     * @param string $sql
     * @param array $args
     * @return query string $row
     */

    public function getResult($sql, $args)
    {

        $this->connect();
        $query = $this->connection->prepare($sql);
        $query->execute($args);
        $row = $query->fetch();        
        $this->disconnect();
        
        return $row;

    }
    

}