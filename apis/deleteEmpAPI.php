<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:DELETE"); //POST, PUT, DELETE
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
$employee->empId = $data->empId;


//call checking username and password function
$result = $employee ->deleteEmp();

if ($result == true){
    //inset update delete complete
    echo json_encode(array("message" => "1"));
}else{
    //inset update delete fail  
    echo json_encode(array("message" => "0"));
}