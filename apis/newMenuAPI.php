<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //POST, PUT, DELETE
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
$menu->itemName = $data->itemName;
$menu->catId = $data->catId;
$menu->itemImage = $data->itemImage;
$menu->itemSize = $data->itemSize;
$menu->itemPrice = $data->itemPrice;

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

//call newMenu function
$result = $menu ->newMenu();

if ($result == true){
    $resultArray = array("message" => "1");
    
    //insert complete
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE);   
}else{
    //insert fail  
    $resultArray = array("message" => "0");  
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE); 
    
}