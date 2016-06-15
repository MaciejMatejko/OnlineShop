<?php

class Item {
    private $id;
    private $name;
    private $price;
    private $stock;
    private $description;
    
    public function __construct() {
        $this->id = -1;
        $this->name = '';
        $this->price = null;
        $this->stock= null;
        $this->description = '';
    }
    
    //getters and setters
    public function getId(){
        return $this->id;
    }
    
    public function setName($newName){
        if(strlen(trim($newName))>0){
            $this->name = $newName;
        }
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setPrice($newPrice){
        if(intval($newPrice)>=0){
            $this->price = $newPrice;
        }
    }
    
    public function getPrice(){
        return $this->price;
    }
    
    public function setStock($newStock){
        if(intval($newStock)>=0){
            $this->stock = $newStock;
        }
    }
    
    public function getStock(){
        return $this->stock;
    }
    
    public function setDescription($newDescription){
        if(strlen(trim($newDescription))>0){
            $this->description = $newDescription;
        }
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    //method loading from db Item with given id 
    public function loadItemFromDB(mysqli $conn, $id){
        $sql="SELECT *FROM Item WHERE id='{$id}'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['id'];
            $this->name=$row['name'];
            $this->price=$row['price'];
            $this->stock=$row['stock'];
            $this->description=$row['description'];
        }
        else{
            return false;
        }
    }
    
    //method creating new or updating existing Item to db
    public function saveItemToDB(mysqli $conn){
        if($this->id===-1){
            $sql="INSERT INTO Item (name, price, stock, description) VALUES ('{$this->name}', '{$this->price}', '{$this->stock}', '{$this->description}')";
            if($conn->query($sql)){
                $this->id=$conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql="UPDATE Item SET name='{$this->name}', price='{$this->price}', stock='{$this->stock}', description='{$this->description}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    
    
}

