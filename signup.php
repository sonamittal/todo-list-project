<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include("connection.php");
$success = false;
$userExists = false;

function sendmail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'example@gmail.com'; 
        $mail->Password   = 'ubthnui123'; 
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587; 
        $mail->setFrom('example@gmail.com', 'todo list Web Team'); 
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Enquiry from demo todolist website';
        $mail->Body    = "Click the link below to verify your email: <a href='http://localhost/todo-list/signup.php?token=" . urlencode($verify_token) . "'>Verify Email</a>";
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verify_token = bin2hex(random_bytes(16));

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $select_sql = $sql->prepare("SELECT * FROM `r_form` WHERE form_email = ?");
        $select_sql->bind_param("s", $email);
        $select_sql->execute();
        $result = $select_sql->get_result();
        if ($result->num_rows > 0) {
            $userExists = true;
        } else {
            // Proceed with data insertion
            $insert_sql = $sql->prepare("INSERT INTO `r_form`(`form_name`, `form_email`, `form_password`, `form_confirm_password`, `verify_token`) VALUES (?, ?, ?, ?, ?)");
            $insert_sql->bind_param('sssss', $name, $email, $hashed_password, $confirm_password, $verify_token);

            $insert_result = $insert_sql->execute();
            if ($insert_result) {
                // Send verification email
                $mail_sent = sendmail_verify($name, $email, $verify_token);
            }
        }
    } else {
        // Passwords don't match
        echo "Passwords do not match.";
    }

    if (!$userExists) {
        echo '<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-white-800 dark:text-green-400" role="alert">
        <span class="font-medium">Info alert!</span> user sign up successfully . please  activate your email to verify account.";!
      </div>';
    }
}
?>



<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up to your
                account</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm bg-gray-100 p-5 rounded-md">
            <form class="space-y-6" action="signup.php" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full name</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                        address</label>
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
                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                        Password</label>
                    <div class="mt-2">
                        <input id="confirm_password" name="confirm_password" type="password"
                            autocomplete="confirm-current-password" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                        up</button>
                </div>
            </form>
            <p class="mt-10 text-center text-sm text-gray-500">
                Already have an account?
                <a href="login.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">log in</a>
            </p>
        </div>
    </div>
</body>

</html>