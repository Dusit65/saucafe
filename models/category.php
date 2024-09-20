<?php

class Category{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $catId;
    public $catName;
   
     //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }

    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis
    public function checkCate(){
    $strSQL = "SELECT * FROM category_tb WHERE catId = :catId AND catName = :catName";

    $this->catId = htmlspecialchars(strip_tags($this->catId));
    $this->catName = htmlspecialchars(strip_tags($this->catName));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":catId", $this->catId);
    $stmt->bindParam(":catName", $this->catName);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }

//function newCate
public function newCate()
    {
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO category_tb
    (catId,catName) 
    VALUES
    (:catId,:catName)";  

    $this->catId = htmlspecialchars(strip_tags($this->catId));
    $this->catName = htmlspecialchars(strip_tags($this->catName));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 
    $stmt->bindParam(":catId", $this->catId);
    $stmt->bindParam(":catName", $this->catName);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

//function updateCustAPI
public function updateCate(){   
    
    $strSQL = "UPDATE category_tb SET 
    catName = :catName 
    WHERE catId = :catId;";
    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    
    $this->catId = htmlspecialchars(strip_tags($this->catId));
    $this->catName = htmlspecialchars(strip_tags($this->catName));

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
    $stmt->bindParam(":catId", $this->catId);
    $stmt->bindParam(":catName", $this->catName);

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}   

    //function deleteCust
    public function deleteCate()
    {
        $strSQL = "DELETE FROM category_tb WHERE catId = :catId";
        $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":catId", $this->catId);
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
}

}