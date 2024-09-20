<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/category.php";

//create instant object
$connDB = new ConnectDB();
$category = new Category($connDB->getConnectionDB());

//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$category->catId = $data->catId;
$category->catName = $data->catName;


//call newcategory function
$result = $category ->newCate();

if ($result == true){
    $resultArray = array("message" => "1");
    
    //insert complete
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE);   
}else{
    //insert fail  
    $resultArray = array("message" => "0");  
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE); 
    
}