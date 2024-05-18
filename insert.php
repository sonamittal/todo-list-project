<?php
include("./todo-app/todo-connection.php");
// Data insert in todo list
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];

    if(empty($title)){
        echo "Task title cannot be empty";
    } else{
        $todo_insert_sql  = $todo_sql->prepare("INSERT INTO `todo`(`title`) VALUES (?)");
        $todo_insert_sql->bind_param('s', $title);
        $todo_result = $todo_insert_sql->execute(); 

        if($todo_result){
            echo "Task inserted successfully";
            header('location:index.php');
        } else{
            echo "Error inserting task";
        }
    }
}
?>


