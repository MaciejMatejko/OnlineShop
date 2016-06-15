<?php

class User {
    
    //static method validating User by email and password
    public static function login(mysqli $conn, $email, $password){
        
        if($row=User::getUserByEmail($conn, $email)){
            if(password_verify($password, $row['password'])){
                return $row['id'];
            }
        }
        return false;
    }
    
    //static method loading from db User with given email
    public static function getUserByEmail(mysqli $conn, $email){
        $sql="SELECT * FROM User WHERE email='{$email}'";
        $result=$conn->query($sql);
        if($result->num_rows ==1){
            return $result->fetch_assoc();
        }
        else{
            return false;
        }
    }
    
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $address;
    
    public function __construct() {
        $this->id =-1;
        $this->name = "";
        $this->surname = "";
        $this->email = "";
        $this->password = "";
        $this->address = "";
    }
    
    //getters and setters
    public function getId(){
        return $this->id;
    }
    
    public function setName($newName){
        if(strlen(trim($newName))>0){
            $this->name=$newName;
        }
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setSurname($newSurname){
        if(strlen(trim($newSurname))>0){
            $this->surname=$newSurname;
        }
    }
    
    public function getSurname(){
        return $this->surname;
    }
    
    public function setEmail($newEmail){
        if(strlen(trim($newEmail))>0){
            $this->email=$newEmail;
        }
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setPassword($newPassword, $retypedPassword){
        if($newPassword != $retypedPassword){
            return false;
        }
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT);
        return true;
    }
    
    public function setAddress($newAddress){
        if(strlen(trim($newAddress))>0){
            $this->address=$newAddress;
        }
    }
    
    public function getAddress(){
        return $this->address;
    }
    
    //method loading from db User with given id 
    public function loadUserFromDB(mysqli $conn, $id){
        $sql="SELECT *FROM User WHERE id='{$id}'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['id'];
            $this->name=$row['name'];
            $this->surname=$row['surname'];
            $this->email=$row['email'];
            $this->password=$row['password'];
            $this->address=$row['address'];
            return true;
        }
        else{
            return false;
        }
    }
    
    ////method creating new or updating existing User to db
    public function saveUserToDB(mysqli $conn){
        if($this->id ===-1){
            $sql="INSERT INTO User (name, surname, email, password, address) VALUES ('{$this->name}', '{$this->surname}', '{$this->email}', '{$this->password}', '{$this->address}')";
            if($conn->query($sql)){
                $this->id=$conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE User SET name='{$this->name}', surname='{$this->surname}', email='{$this->email}', password='{$this->password}', address='{$this->address}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    //method loading User's order history and returning it in array
    public function getOrdersHistory(mysqli $conn){
        $ordersHistory=[];
        $sql="SELECT * FROM `Order` JOIN Product_Order ON order_id=id WHERE user_id='{$this->id}'";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            $ordersHistory[]=$row;
        }
        return $ordersHistory;
    }
    
}
