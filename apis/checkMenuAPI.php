<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/menu.php";

//create instant object
$connDB = new ConnectDB();
$menu = new Menu($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$menu->itemId = $data->itemId;
$menu->itemName = $data->itemName;

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $menu->checkMenu();

//ตรวจสอบข้อมูลจากการเรัยกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
if ($result->rowCount() > 0) {
    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    //สร้างตัวแปรอาร์เรย์เก็บข้อมูล
    $resultArray = array(
        "message" => "1",
        "itemId" => $itemId,
        "itemName" => $itemName,
        "catId" => $catId,
        "itemImage" => $itemImage,
        "itemSize" => $itemSize,
        "itemSize" => $itemSize
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    //echo json_encode(array("message" => "เข้าสู่ระบบ!!"));
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode(array("message" => "ชื่อหรือไอดีไม่ถูกต้อง"));
}
