<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

include("../connection.php");
include("../model/modelPessoa.php");
include("../controller/controllerPessoa.php");

$conn = new connection();
$model = new modelPessoa($conn->returnConnection());
$controller = new controllerPessoa($model);

$dados = $controller->router();

echo json_encode(array("status"=>"success","data"=>$dados));
?>