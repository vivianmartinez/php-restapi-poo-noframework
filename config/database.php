<?php

require_once 'dotenvdb.php';

class DataBaseConnect extends DotenvDB{
    private $db_host;
    private $db_user;
    private $db_name;
    private $db_password;
    private $connection;

    public function __construct()
    {
        parent::__construct();
        $this->db_host      = $_ENV['DB_HOST'];
        $this->db_name      = $_ENV['DB_NAME'];
        $this->db_user      = $_ENV['DB_USER'];
        $this->db_password  = $_ENV['DB_PASSWORD'];
    }

    public function connect()
    {
        $this->connection = null;
        try{
            $this->connection = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name,
                                        $this->db_user,
                                        $this->db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->connection->exec('set names utf8');
        }catch(PDOException $e){
            echo 'Error connection '.$e->getMessage();

        }
        return $this->connection;
    }

    public function columnsTable($table)
    {
        $query = $this->connect()->query("SELECT COLUMN_NAME AS item 
                                            FROM information_schema.columns 
                                            WHERE table_schema = '$this->db_name' AND table_name = '$table'")
                                            ->fetchAll(PDO::FETCH_OBJ);
        return $query;
    }
}