<?php

class Admin{
    
    public static function login(mysqli $conn, $email, $password){
        if($row=Admin::getAdminByEmail($conn, $email)){
            if(password_verify($password, $row['password'])){
                return $row['id'];
            }
        }
        return false;
    }
    
    public static function getAdminByEmail(mysqli $conn, $email){
        $sql="SELECT * FROM Admin WHERE email='{$email}'";
        $result=$conn->query($sql);
        if($result->num_rows ==1){
            return $result->fetch_assoc();
        }
        else{
            return false;
        }
    }
    
    private $id;
    private $email;
    private $password;
    
    public function __construct() {
        $this->id=-1;
        $this->email="";
        $this->password="";
    }
    
    //settery i gettery
    public function getId(){
        return $this->id;
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
    
    //funkcja ładuje z db Admina o danym id
    public function loadAdminFromDB(mysqli $conn, $id){
        $sql="SELECT * FROM Admin WHERE id='{$id}'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['id'];
            $this->email=$row['email'];
            $this->password=$row['password'];
            return true;
        }
        else{
            return false;
        }
    }
    
    //funkcja tworzy nowego lub edytuje stniejącego Admina w db
    public function saveToDB(mysqli $conn){
        if($this->id===-1){
            $sql="INSERT INTO Admin (email, password) VALUES ('{$this->email}', '{$this->password}')";
            if($conn->query($sql)){
                $this->id=$conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE User SET email='{$this->email}', password='{$this->password}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
}