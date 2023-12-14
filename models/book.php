<?php

require_once 'config/database.php';

class Book{

    //DB
    private $connection;
    private $table;
    public $id;
    public $title;
    public $description;
    public $author_id;
    public $category_id;

    public function __construct()
    {
        $this->table = 'book';
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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     */
    public function setCategoryId($category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of author_id
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     */
    public function setAuthorId($author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Find all books
     */
    public function findAll()
    {
        $query = 'SELECT b.id, b.title, b.description, a.id as author_id, a.author_name,c.id as category_id, c.name as category_name 
                FROM '.$this->table.' b
                LEFT JOIN category c ON c.id = b.category_id
                LEFT JOIN author a ON a.id = b.author_id
                ORDER BY
                    b.id DESC';
        //prepare statement
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    /**
     * Find One Book
     */
    public function findOne()
    {
        $query = 'SELECT b.id, b.title, b.description, a.id as author_id, a.author_name,c.id as category_id, c.name as category_name 
                FROM '.$this->table.' b
                LEFT JOIN category c ON c.id = b.category_id
                LEFT JOIN author a ON a.id = b.author_id
                WHERE b.id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id',$this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Create book
     */
    public function create()
    {   
        $sql = 'INSERT INTO '.$this->table.'(title,description,author_id,category_id) VALUES (:title,:description,:author_id,:category_id)';
        $stmt   = $this->connection->prepare($sql);
        $title          = $this->getTitle();
        $description    = $this->getDescription();
        $author_id      = $this->getAuthorId();
        $category_id    = $this->getCategoryId();
        $stmt->bindParam(':title',$title, PDO::PARAM_STR);
        $stmt->bindParam(':description',$description, PDO::PARAM_STR);
        $stmt->bindParam(':author_id',$author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id',$category_id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $this->setId($this->connection->lastInsertId());
            return true;
        }
        return false;
    }
    /**
     * Update book
     */
    public function update()
    {
        try{
            $sql = 'UPDATE '.$this->table.' SET title = :title, description = :description, author_id = :author_id, category_id = :category_id WHERE id = :id';
            $stmt = $this->connection->prepare($sql);
            $title          = $this->getTitle();
            $description    = $this->getDescription();
            $author_id      = $this->getAuthorId();
            $category_id    = $this->getCategoryId();
            $stmt->bindParam(':title',$title, PDO::PARAM_STR);
            $stmt->bindParam(':description',$description, PDO::PARAM_STR);
            $stmt->bindParam(':author_id',$author_id, PDO::PARAM_INT);
            $stmt->bindParam(':category_id',$category_id, PDO::PARAM_INT);
            $stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $stmt->execute();

        }catch(Exception $e){
            return ['error'=> true,'message'=>$e->getMessage()];
        }
        return ['error'=> false];
    }
    /**
     * Delete book
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
        return ['error'=> false,'message'=>'The book was delete succesfully'];
    }
}