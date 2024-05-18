<?php
include("./todo-app/todo-connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_POST['id'];
    $taskStatus = $_POST['status'];
    // Prepare update statement
    $task_update = $todo_sql->prepare("UPDATE `todo` SET `status` = ? WHERE `id` = ?");
    $task_update->bind_param('ss', $taskStatus, $taskId);
    $task_update->execute();
    // Check if update was successful
    if ($task_update->affected_rows > 0) {
        echo "success";
    } else {
        echo "failed";
    }
}
