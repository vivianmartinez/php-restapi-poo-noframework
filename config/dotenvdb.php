<?php

require '../../vendor/autoload.php';

class DotenvDB{
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1));
        $this->dotenv->load();
    }
}