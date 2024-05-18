<?php
include("./todo-app/todo-connection.php");
$id = null;
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $task_update_select = $todo_sql->prepare("SELECT `id`, `title`, `status` FROM `todo` WHERE `id` = ?");
    $task_update_select->bind_param('s', $id); 
    $task_update_select->execute();
    $result_task_update_select = $task_update_select->get_result();
    if ($result_task_update_select->num_rows > 0) {
        $data_result = $result_task_update_select->fetch_assoc();
    } else {
        echo "Task not found.";
    }
} else {
    echo "Task ID is required.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_title = $_POST['task_title'];
    
    // Prepare update statement
    $task_update = $todo_sql->prepare("UPDATE `todo` SET `title` = ? WHERE `id` = ?");
    $task_update->bind_param('ss', $task_title, $id);
    $task_update->execute();
    // Check if update was successful
    if ($task_update->affected_rows > 0) {
        echo "Task updated successfully.";
        header("Location: index.php");
    } else {
        echo "Failed to update task.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="mt-20">
        <h2 class="text-center text-2xl font-semibold dark:text-green-700">Update To Do List Task</h2>
    </div>
    <form method="POST" action="edit.php?ID=<?php echo $id; ?>" class="w-full max-w-xl mx-auto mt-24">
        <div class="relative">
            <input type="text" id="task_title" name="task_title" autocomplete="task_title" class="block w-full p-4 ps-5 text-sm border border-gray-400 rounded-md focus:outline-none dark:placeholder-gray-800 dark:text-gray" placeholder="Enter the updated task title.." value="<?php if (isset($data_result['title'])) echo $data_result['title']; ?>" required />
            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-green-700 hover:bg-green-800 focus:outline-none font-medium rounded-md text-sm px-4 py-2">Update Task</button>
        </div>
    </form>
</body>

</html>
