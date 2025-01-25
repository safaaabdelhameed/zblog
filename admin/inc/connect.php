<?php 
$dsn = "mysql:host=localhost;dbname=zblog";
$username = "root";
$password = "";

try{
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    echo "Error: ". $e->getMessage();
}





?>