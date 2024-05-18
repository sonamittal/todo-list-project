<?php
include('connection.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
$email = $_POST['email'];
$password = $_POST['password'];
$select_user = $sql->prepare("SELECT * FROM `r_form` WHERE form_email = ? ");
$select_user->bind_param('s' , $email);
$select_user->execute();
$result_user = $select_user->get_result();
if($result_user->num_rows > 0 ){
$user_data = $result_user->fetch_assoc();
$hased_password = $user_data['form_password'];
if (password_verify($password , $hased_password)){
    echo '<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-white-800 dark:text-green-400" role="alert">
    <span class="font-medium">Info alert!</span> user sign up successfully . please  activate your email to verify account.";!
  </div>';
  session_start();
  $_SESSION['email'] = $email;
   header('location:index.php');
}else{
    echo '<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-white-800 dark:text-green-400" role="alert">
    <span class="font-medium">Info alert!</span> "invalid email and password";
  </div>';
}
}
else{
    echo '<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-white-300 text-center dark:bg-white-800 dark:text-red-700" role="alert">
    <span class="font-medium">Info alert!</span> "invalid email and password";
  </div>';
}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Log in to your
                account</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm bg-gray-100 p-5 rounded-md">
            <form class="space-y-6" action="login.php" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Log
                        in</button>
                </div>
            </form>
            <p class="mt-10 text-center text-sm text-gray-500">
                Don’t have an account yet? <a href="signup.php"
                    class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign up</a>
            </p>
        </div>
    </div>
</body>

</html>