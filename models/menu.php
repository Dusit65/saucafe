<?php

class Menu{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $itemId;
    public $itemName;
    public $catId;
    public $itemImage;
    public $itemSize;
    public $itemPrice;
   
     //ตัวแปรสารพัดประโยชน์
    public $message;
     //constructor
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }

    //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis
    public function checkMenu(){
        $strSQL = "SELECT * FROM menu_item_tb WHERE itemId = :itemId AND itemName = :itemName";

    $this->itemId = htmlspecialchars(strip_tags($this->itemId));
    $this->itemName = htmlspecialchars(strip_tags($this->itemName));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":itemId", $this->itemId);
    $stmt->bindParam(":itemName", $this->itemName);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }

    //function newMenu
    public function newMenu()
    {
    //ตัวแปรคำสั่งsql
    $strSQL = "INSERT INTO menu_item_tb
    (itemName,catId,itemImage,itemSize,itemPrice) 
    VALUES
    (:itemName,:catId,:itemImage,:itemSize,:itemPrice)";
        
    $this->itemName = htmlspecialchars(strip_tags($this->itemName));
    $this->catId = htmlspecialchars(strip_tags($this->catId));
    $this->itemImage = htmlspecialchars(strip_tags($this->itemImage));
    $this->itemSize = htmlspecialchars(strip_tags($this->itemSize));
    $this->itemPrice = htmlspecialchars(strip_tags($this->itemPrice));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 
    $stmt->bindParam(":itemName", $this->itemName);
    $stmt->bindParam(":catId", $this->catId);
    $stmt->bindParam(":itemImage", $this->itemImage);
    $stmt->bindParam(":itemSize", $this->itemSize);
    $stmt->bindParam(":itemPrice", $this->itemPrice);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

//function updateMenu
public function updateMenu(){   
    $strSQL = "";
    if($this->itemImage == ""){
    $strSQL = "UPDATE menu_item_tb SET 
    itemName = :itemName, 
    catId = :catId, 
    itemImage = :itemImage,
    itemSize = :itemSize,
    itemPrice = :itemPrice
    WHERE itemId = :itemId;";

}else{
    $strSQL = "UPDATE menu_item_tb SET 
    itemName = :itemName, 
    catId = :catId, 
    itemImage = :itemImage,
    itemSize = :itemSize,
    itemPrice = :itemPrice
    WHERE itemId = :itemId;";
}
    
    //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
    $this->itemId = intval(htmlspecialchars(strip_tags($this->itemId)));
    $this->itemName = htmlspecialchars(strip_tags($this->itemName));
    $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
    if($this->itemImage != ""){
        $this->itemImage = htmlspecialchars(strip_tags($this->itemImage));
    }
    $this->itemSize = htmlspecialchars(strip_tags($this->itemSize));
    $this->itemPrice = htmlspecialchars(strip_tags($this->itemPrice));

    //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
    $stmt->bindParam(":itemId", $this->itemId);
    $stmt->bindParam(":itemName", $this->itemName);
    $stmt->bindParam(":catId", $this->catId);
    if($this->itemImage != ""){
        $stmt->bindParam(":itemImage", $this->itemImage);
    }
    $stmt->bindParam(":itemSize", $this->itemSize);
    $stmt->bindParam(":itemPrice", $this->itemPrice);

    //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}   

    //function deleteMenu
    public function deleteMenu()
    {
        $strSQL = "DELETE FROM menu_item_tb WHERE itemId = :itemId";
        $this->itemId = intval(htmlspecialchars(strip_tags($this->itemId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
}

}