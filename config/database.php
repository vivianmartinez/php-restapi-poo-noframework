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
}