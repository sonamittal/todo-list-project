<?php
include("./todo-app/todo-connection.php");
if(isset($_GET['ID'])){
    $id = $_GET['ID'];
    $task_delete = $todo_sql->prepare("DELETE FROM `todo` WHERE id = ?");
    $task_delete->bind_param('s', $id);
    $task_delete->execute();
    $result_task_delete =    $task_delete->execute();
    if($result_task_delete){
        echo "task is successfully delete";
        header('location:index.php');
    }else{
        echo "task is not successfully delete";
    }
}
?>
