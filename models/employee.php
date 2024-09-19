<?php

class Employee{
    // ตัวแปรที่เก็บการติดต่อฐานข้อมูล
    private $connDB;

    // ตัวแปรที่ทำงานกับคอลัมน์ในตาราง 
    public $empId;
    public $empName;
    public $empImage;
    public $empPhonenum;
    public $empPassword;

     //ตัวแปรสารพัดประโยชน์
    public $message;

    //constructor
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

     //----------------------------------------------------------
    //function การทำงานที่ล้อกับส่วนของ apis
    public function checkUserPasswordEmp(){
        $strSQL = "SELECT * FROM employee_tb WHERE empPhonenum = :empPhonenum AND empPassword = :empPassword";

    $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
    $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":empPhonenum", $this->empPhonenum);
    $stmt->bindParam(":empPassword", $this->empPassword);

    //สั่งsqlให้ทำงาน
    $stmt->execute();
    //ส่งค่าการทำงานกลับไปยังจุดเรียกใช้งานฟังก์ชั่น 
    return $stmt;
    }
    
    //function add data new register user
    public function newEmp()
    {
        //ตัวแปรคำสั่งsql
        $strSQL = "INSERT INTO employee_tb
        (empName,empImage,empPhonenum,empPassword) 
        VALUES
        (:empName,:empImage,:empPhonenum,:empPassword)";
        
    $this->empName = htmlspecialchars(strip_tags($this->empName));
    $this->empImage = htmlspecialchars(strip_tags($this->empImage));
    $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
    $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));

    //สร้างตัวแปรสที่ใช้ทำงานกับคำสั่งsql
    $stmt = $this->connDB->prepare($strSQL);

    //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter 

    $stmt->bindParam(":empName", $this->empName);
    $stmt->bindParam(":empImage", $this->empImage);
    $stmt->bindParam(":empPhonenum", $this->empPhonenum);
    $stmt->bindParam(":empPassword", $this->empPassword);

    //สั่งsqlให้ทำงาน
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    }

    //function update employee
    public function updateEmp(){   
        $strSQL = "";
        if($this->empImage == ""){
        $strSQL = "UPDATE employee_tb SET 
        `empName` = :empName, 
        `empPhonenum` = :empPhonenum, 
        `empPassword` = :empPassword 
        WHERE `empId` = :empId;";

    }else{
        $strSQL = "UPDATE employee_tb SET 
        `empName` = :empName, 
        `empImage` = :empImage, 
        `empPhonenum` = :empPhonenum, 
        `empPassword` = :empPassword 
        WHERE `empId` = :empId;";
    }
        
        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters 
        $this->empId = intval(htmlspecialchars(strip_tags($this->empId)));
        $this->empName = htmlspecialchars(strip_tags($this->empName));
        if($this->empImage != ""){$this->empImage = htmlspecialchars(strip_tags($this->empImage));}
        $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
        $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":empId", $this->empId);
        $stmt->bindParam(":empName", $this->empName);
        if($this->empImage != ""){$stmt->bindParam(":empImage", $this->empImage);}
        $stmt->bindParam(":empPhonenum", $this->empPhonenum);
        $stmt->bindParam(":empPassword", $this->empPassword);

        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}