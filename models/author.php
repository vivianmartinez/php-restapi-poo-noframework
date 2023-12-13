<?php

require_once 'config/database.php';

class Author{

    //DB
    private $connection;
    private $table;
    public $id;
    public $author_name;

    public function __construct()
    {
        $this->table = 'author';
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
     * Get the value of author_name
     */
    public function getAuthorName()
    {
        return $this->author_name;
    }

    /**
     * Set the value of author_name
     */
    public function setAuthorName($author_name): self
    {
        $this->author_name = $author_name;

        return $this;
    }

    /**
     * all authors
     */
    public function findAll()
    {
        $sql = 'SELECT * FROM '.$this->table;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Get single author
     */

    public function findOne()
    {
        $sql = 'SELECT a.id, a.author_name FROM '.$this->table.' a WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create author
     */
    public function create()
    {
        $sql = 'INSERT INTO '.$this->table.'(author_name) VALUES (:author_name)';
        $stmt= $this->connection->prepare($sql);
        $author_name = $this->getAuthorName();
        $stmt->bindParam(':author_name',$author_name, PDO::PARAM_STR);
        
        if($stmt->execute()){
            $this->setId($this->connection->lastInsertId());
            return true;
        }
        return false;
    }
    /**
     * Update author
     */
    public function update()
    {
        
    }
    /**
    * Delete author
    */
    public function delete()
    {
        try{
            $sql = 'DELETE FROM '.$this->table.' WHERE id = :id';
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $stmt->execute();
        }catch(Exception $e)
        {
            return ['error'=> true,'message'=>$e->getMessage()];
        }
        return ['error'=> false,'message'=>'The author was delete succesfully'];
    }

}