<?php

include('./connection.php');
include('./model/modelPessoa.php');

$conn = new connection();
$modelPessoa = new modelPessoa($conn->returnConnection());

$dados = $modelPessoa->findAll();


