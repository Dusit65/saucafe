<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT"); //POST, PUT, DELETE
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
$menu->catId = $data->catId;
// $menu->itemImage = $data->itemImage;
$menu->itemSize = $data->itemSize;
$menu->itemPrice = $data->itemPrice;

//กรณี แก้ไข ต้องตรวจสอบก่อนว่ามีการอัพโหลดรูปภาพหรือไม่
if(isset($data->itemImage)){
//------------------------จัดการรูป อัปโหลด ใช้base64---------------------------------
//เอารูปที่ส่งมาซึ่งเป็นbase64 เก็บไว้ในตัวแปรตัวหนึ่ง
$picture_temp = $data->itemImage;
//ตั้งชื่อรูปใหม่เพื่อใช้กับbase 64
$picture_filename = "pic_" . uniqid() . "_" . round(microtime(true)*1000) . ".jpg";
//เอารูปที่ส่งมาซึ้งเป็นbase64 แปลงให้เป็นรูปภาพ แล้วเอาไปไว้ที่ pickupload/food/
//file_putcontents(ที่อยู่ของรูป, ตัวไฟล์ที่จะอัพโหลด);
file_put_contents( "./../pickupload/menu/".$picture_filename, base64_decode(string: $picture_temp));
//เอาชื่อไฟล์ไปกำหนให้กับตัวแปรที่จะเก็บลงตารางฐานข้อมูล
$menu->itemImage = $picture_filename;
//---------------------------------------------------------------------------------
}else{
    $menu->itemImage = "";
}


//call checking username and PitemPrice function
$result = $menu ->updateMenu();

if ($result == true){
    //inset update delete complete
    echo json_encode(array("message" => "1"));
}else{
    //inset update delete fail  
    echo json_encode(array("message" => "0"));
}
