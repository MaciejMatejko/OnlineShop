<?php

class Message{
    
    //static method loading from db all messages sent to user with given id
    public static function LoadAllUserMessages(mysqli $conn, $userId){
        $sql="SELECT * FROM Message WHERE user_id = {$userId}";
        $userMessages=[];
        $result=$conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $message= new Message();
                $message->id = $row['id'];
                $message->setAdminIdt($row['admin_id']);
                $message->setUserId($row['user_id']);
                $message->setOrderId($row['order_id']);
                $message->setText($row['text']);
                $userMessages[]=$message;
            }
            return $userMessages;
        }
        return false;
    }
    
    //static method loading from db all messages sent by admin with given id
    public static function LoadAllAdminMessages(mysqli $conn, $adminId){
        $sql="SELECT * FROM Message WHERE admin_id = {$adminId}";
        $userMessages=[];
        $result=$conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $message= new Message();
                $message->id = $row['id'];
                $message->setAdminIdt($row['admin_id']);
                $message->setUserId($row['user_id']);
                $message->setOrderId($row['order_id']);
                $message->setText($row['text']);
                $userMessages[]=$message;
            }
            return $userMessages;
        }
        return false;
    }
    
    private $id;
    private $admin_id;
    private $user_id;
    private $order_id;
    private $text;
    
    public function __construct() {
        $this->id =-1;
        $this->admin_id = null;
        $this->user_id = null;
        $this->order_id = null;
        $this->text = "";
    }
    
    //getters and setters
    public function getId(){
        return $this->id;
    }
    
    public function setAdminId($adminId){
        $this->admin_id = $adminId;
    }
    
    public function getAdminId(){
        return $this->admin_id;
    }
    
    public function setUserId($userId){
        $this->user_id = $userId;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function setOrderId($orderId){
        $this->order_id = $orderId;
    }
    
    public function getOrderId(){
        return $this->order_id;
    }
    
    public function setText($text){
        if(strlen(trim($text))>0){
            $this->text = $text;
        }
    }
    
    public function getText(){
        return $this->text;
    }
    
    //method loading from db Mesage with given id 
    public function loadMessageFromDB(mysqli $conn, $id){
        $sql="SELECT *FROM Message WHERE id='{$id}'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['id'];
            $this->admin_id=$row['admin_id'];
            $this->user_id=$row['user_id'];
            $this->order_id=$row['order_id'];
            $this->text=$row['text'];
            return true;
        }
        else{
            return false;
        }
    }
    
    ////method creating new or updating existing User to db
    public function saveMessageToDB(mysqli $conn){
        if($this->id ===-1){
            $sql="INSERT INTO Message (admin_id, user_id, order_id, text) VALUES ('{$this->admin_id}', '{$this->user_id}', '{$this->order_id}', '{$this->text})";
            if($conn->query($sql)){
                $this->id=$conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE Message SET admin_id='{$this->admin_id}', user_id='{$this->user_id}', order_id='{$this->order_id}', text='{$this->text}' WHERE id='{$this->id}'";
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
}

