<?php
include("./todo-app/todo-connection.php");
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-green-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Todolist</span>
            </a>
            <div class="hidden w-full md:block md:w-auto">
                <a href="logout.php"><button
                        class="py-2 px-5 bg-green-800 text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none ">
                        logout
                    </button></a>
            </div>
        </div>
    </nav>
    <h2 class=" text-2xl font-semibold whitespace-nowrap dark:text-black text-center mt-10">Welcome
        <?php
        session_start();
        echo $_SESSION['email']; ?>
    </h2>
    <!--- todo list task --->
    <div class="mt-20">
        <h2 class="text-center text-2xl font-semibold  dark:text-green-700 ">My To Do List App</h2>
    </div>
    <form method="POST" action="insert.php" id="myForm" class=" w-full max-w-prose mx-auto mt-24">
        <div class="relative">
            <input type="text" id="title" name="title" autocomplete="title"
                class="block w-full p-4 ps-5 text-sm  border border-gray-400  rounded-md focus:outline-none   dark:placeholder-gray-800 dark:text-gray"
                placeholder="Enter Something..." required />
            <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-green-700 hover:bg-green-800  focus:outline-none  font-medium rounded-md text-sm px-4 py-2">Add
                Task
            </button>
        </div>
    </form>
    <!--- todo list task in display in data  --->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-screen-xl mx-auto mt-28 mb-28">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-[#F9FAFB] dark:text-black-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        tasks
                    </th>
                    <th scope="col" class="px-6 py-3">
                        status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching task data from the database
                $select_sql = $todo_sql->prepare("SELECT `id`, `title`, `status` FROM `todo`");
                $select_sql->execute();
                $task_result = $select_sql->get_result();

                if ($task_result->num_rows > 0) {
                    while ($task_data = $task_result->fetch_assoc()) {
                        // Determine the status text based on the status value
                        $status_text = ($task_data['status'] == 1) ? 'complete' : 'pending';
                ?>
                <tr class="bg-white border-b  dark:border-gray-700 hover:bg-gray-50 dark:bg-gray-[#F9FAFB]">
                    <td class="px-6 py-4">
                        <input type="checkbox" required name="<?php echo $task_data['id']; ?>"
                            data-id='<?php echo $task_data['id']; ?>' value="1" <?php 
                               if ($task_data['status'] == 1) {
                                echo "checked";
                            } else {
                                echo 'false';
                            }
                            ?> id="task_delete">
                    </td>
                    <td class="px-6 py-4 dark:text-black font-medium task-title
                     <?php
                        if ($task_data['status'] == 1) {
                            echo "line-through";
                        }
                        ?>" id="text<?php echo $task_data['id']; ?>">
                        <?php echo $task_data['title']; ?>
                    </td>
                    <td class="px-6 py-4 dark:text-black font-medium task-status"
                        id="status<?php echo $task_data['id']; ?>">
                        <?php echo $status_text; ?>
                    </td>
                    <td class="px-6 py-4 text-right flex items-center gap-2.5">
                        <a href="edit.php?ID=<?php echo $task_data['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-pen-line">
                                <path d="m18 5-3-3H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2" />
                                <path d="M8 18h1" />
                                <path d="M18.4 9.6a2 2 0 1 1 3 3L17 17l-4 1 1-4Z" />
                            </svg>
                        </a>

                        <a href="delete.php?ID=<?php echo $task_data['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trash-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>


        </table>
    </div>
    <script>
    const checkboxBtns = document.querySelectorAll('input[type="checkbox"]');
    for (const checkboxBtn of checkboxBtns) {
        checkboxBtn.addEventListener('click', function() {
            const taskRow = $(this).closest('tr');
            const taskTitle = taskRow.querySelector('.task-title');
            const taskStatus = taskTitle.nextElementSibling;

            if (taskTitle.style.textDecoration) {
                taskStatus.textContent = "pending";
                taskTitle.style.textDecoration = "none";
                this.checked = false;
            } else {
                taskStatus.textContent = "complete";
                taskTitle.style.textDecoration = "line-through";
            }
        });
    }
    </script>
    <script>
    $(document).ready(function() {
        $("input[type=checkbox]").click(function() {
            var id = $(this).data("id");
            var status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: 'update-task.php',
                type: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function(response) {
                    if (response == 'success') {
                        if (status == 0) {
                            $('#text' + id).removeClass('line-through');
                            $('#status' + id).html('pending');
                        } else if (status == 1) {
                            $('#text' + id).addClass('line-through');
                            $('#status' + id).html('complete');
                        }
                        alert("Task completed.")
                    } else {
                        alert("Failed try again!")
                    }

                }
            });
        });
    });
    </script>



</body>

</html>