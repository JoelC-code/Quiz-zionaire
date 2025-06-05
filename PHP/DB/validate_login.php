<?php
session_start();
include_once('connect.php');

function loginSystem($username, $password)
{
    $conn = connectDB();
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql_query = "SELECT * FROM users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql_query);

    if ($result && mysqli_num_rows($result) === 1) {
        $account = mysqli_fetch_assoc($result);

        if ($password === $account['Password']) {

            $_SESSION['username'] = $account['Username'];
            $_SESSION['status'] = $account['Status'];
            $_SESSION['id_user'] = $account['Users_ID'];

            if ($account['Status'] === 'Users') {
                header("Location: ../UI/MainMenu.php");
            } else {
                header("Location: ../UI/TeacherMenu.php");
            }
            exit();
        } else {
            // Wrong password
            echo "Wrong Password Inputted";
            exit();
        }
    } else {
        // Username not found
        echo "Wrong Username is Inputted";
        exit();
    }
}

if (isset($_POST['login_submit'])) {
    $username = $_POST['loginUsername'] ?? '';
    $password = $_POST['loginPassword'] ?? '';

    loginSystem($username, $password);
}
?>