<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/employee.php";

//create instant object
$connDB = new ConnectDB();
$employee = new Employee($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$employee->empPhonenum = $data->empPhonenum;
$employee->empPassword = $data->empPassword;

//call checking username and password function
$result = $employee->checkUserPasswordEmp();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
    $resultArray = array(
        "message" => "1",
        "empId" => $empId,
        "empName" => $empName,
        "empImage" => $empImage,
        "empPhonenum" => $empPhonenum,
        "empPassword" => $empPassword
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    //echo json_encode(array("message" => "เข้าสู่ระบบ!!"));
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง"));
}
