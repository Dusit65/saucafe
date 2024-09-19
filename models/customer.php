<?php

class Customer{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $custId;
    public $custName;
    public $custEmail;
    public $custImage;
    public $custPhonenum;
    public $custPassword;
     //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }

    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis
    public function checkUserPasswordCust(){
        $strSQL = "SELECT * FROM customer_tb WHERE custPhonenum = :custPhonenum AND custPassword = :custPassword";

    $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
    $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":custPhonenum", $this->custPhonenum);
    $stmt->bindParam(":custPassword", $this->custPassword);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }

    //function newCust
    public function newCust()
    {
        //ตัวแปรคำสั่งsql
        $strSQL = "INSERT INTO customer_tb
        (custName,custEmail,custImage,custPhonenum,custPassword) 
        VALUES
        (:custName,:custEmail,:custImage,:custPhonenum,:custPassword)";
        
    $this->custName = htmlspecialchars(strip_tags($this->custName));
    $this->custEmail = htmlspecialchars(strip_tags($this->custEmail));
    $this->custImage = htmlspecialchars(strip_tags($this->custImage));
    $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
    $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":custName", $this->custName);
    $stmt->bindParam(":custEmail", $this->custEmail);
    $stmt->bindParam(":custImage", $this->custImage);
    $stmt->bindParam(":custPhonenum", $this->custPhonenum);
    $stmt->bindParam(":custPassword", $this->custPassword);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

//function updateCustAPI
public function updateCust(){   
    $strSQL = "";
    if($this->custImage == ""){
    $strSQL = "UPDATE customer_tb SET 
    custName = :custName, 
    custEmail = :custEmail, 
    custPhonenum = :custPhonenum, 
    custPassword = :custPassword 
    WHERE custId = :custId;";

}else{
    $strSQL = "UPDATE customer_tb SET 
    custName = :custName, 
    custEmail = :custEmail, 
    custImage = :custImage, 
    custPhonenum = :custPhonenum, 
    custPassword = :custPassword 
    WHERE custId = :custId;";
}
    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    $this->custId = intval(htmlspecialchars(strip_tags($this->custId)));
    $this->custName = htmlspecialchars(strip_tags($this->custName));
    if($this->custImage != ""){$this->custImage = htmlspecialchars(strip_tags($this->custImage));}
    $this->custEmail = intval(htmlspecialchars(strip_tags($this->custEmail)));
    $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
    $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
    $stmt->bindParam(":custId", $this->custId);
    $stmt->bindParam(":custName", $this->custName);
    $stmt->bindParam(":custEmail", $this->custEmail);
    if($this->custImage != ""){$stmt->bindParam(":custImage", $this->custImage);}
    $stmt->bindParam(":custPhonenum", $this->custPhonenum);
    $stmt->bindParam(":custPassword", $this->custPassword);

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
}