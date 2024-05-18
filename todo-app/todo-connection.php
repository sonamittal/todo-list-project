<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "todo-app";
$todo_sql = new mysqli($host , $username , $password , $database);
if($todo_sql->connect_error){
    die($todo_sql->connect_error);
} 
?>