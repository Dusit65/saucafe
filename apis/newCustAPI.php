<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/customer.php";

//create instant object
$connDB = new ConnectDB();
$customer = new Customer($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$customer->custName = $data->custName;
$customer->custEmail = $data->custEmail;
$customer->custImage = $data->custImage;
$customer->custPhonenum = $data->custPhonenum;
$customer->custPassword = $data->custPassword;

//------------------------จัดการรูป อัปโหลด ใช้base64---------------------------------
//เอารูปที่ส่งมาซึ่งเป็นbase64 เก็บไว้ในตัวแปรตัวหนึ่ง
$picture_temp = $data->custImage;
//ตั้งชื่อรูปใหม่เพื่อใช้กับbase 64
$picture_filename = "pic_" . uniqid() . "_" . round(microtime(true)*1000) . ".jpg";
//เอารูปที่ส่งมาซึ้งเป็นbase64 แปลงให้เป็นรูปภาพ แล้วเอาไปไว้ที่ pickupload/food/
//file_putcontents(ที่อยู่ของรูป, ตัวไฟล์ที่จะอัพโหลด);
file_put_contents( "./../pickupload/customer/".$picture_filename, base64_decode(string: $picture_temp));
//เอาชื่อไฟล์ไปกำหนให้กับตัวแปรที่จะเก็บลงตารางฐานข้อมูล
$customer->custImage = $picture_filename;
//---------------------------------------------------------------------------------


//call newCust function
$result = $customer ->newCust();

if ($result == true){
    $resultArray = array("message" => "1");
    
    //inset update delete complete
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE);   
}else{
    //inset update delete fail  
    $resultArray = array("message" => "0");  
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE); 
    
}