<?php

require_once 'config/database.php';

class Category{

    //DB
    private $connection;
    private $table;
    public $id;
    public $category_name;

    public function __construct()
    {
        $this->table = 'category';
        $db = new DataBaseConnect();
        $this->connection = $db->connect();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of category_name
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * Set the value of category_name
     */
    public function setCategoryName($category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }
    /**
     * all categories
     */
    public function findAll()
    {
        $sql = 'SELECT * FROM '.$this->table;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Get single
     */
    public function findOne()
    {
        $sql = 'SELECT c.id,c.name as category_name FROM '.$this->table.' c WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * create new category
     */
    public function create()
    {
        $sql = 'INSERT INTO '.$this->table.' (name) VALUES (:name)';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':name',$this->category_name,PDO::PARAM_STR);
        if($stmt->execute()){
            $this->setId($this->connection->lastInsertId());
            return true;
        }
        return false;
    }
    /**
     * delete category
     */
    public function delete()
    {

    }
}