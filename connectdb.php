<?php
class ConnectDB{
//ตัวแปรที่ใข้ติดต่อฐานข้อมูล
    public $connDB;
//ตัวแปรที่ใช้เก็บข้อมูลของฐานข้อมูล
    private $host = "localhost"; //or ip address , domain name
    private $username = "root"; //username DB
    private $password = ""; //password DB
    private $dbname = "saucafe_db"; //ชื่อฐานข้อมูล

    //function connect to database
    public function getConnectionDB(){
        $this->connDB = null;
        try{
            $this->connDB = new PDO ("mysql:host=$this->host;dbname=$this->dbname",$this->username,$this->password);
            $this->connDB->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connDB;
    }



        
}
?>

