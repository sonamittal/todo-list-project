<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "signupform";
$sql = new mysqli($host , $username , $password , $database);
if($sql->connect_error){
    die($sql->connect_error);
}
?>