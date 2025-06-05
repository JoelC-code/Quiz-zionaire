<?php
include_once('connect.php');

function insertAccount($name, $password, $role) {
    $conn = connectDB();

    $statement = mysqli_prepare($conn, "INSERT INTO users (Username, Password, Status) VALUES (?, ?, ?)");
    
    if ($statement) {
        mysqli_stmt_bind_param($statement, "sss", $name, $password, $role);
        mysqli_stmt_execute($statement);

        if (mysqli_stmt_affected_rows($statement) > 0) {
            echo "Register account has been made!";
        } else {
            echo "Test";
        }
    } else {
        echo "Statement prep fail: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

if (isset($_POST['register_submit'])) {
    $username = $_POST['userAccount'];
    $password = $_POST['pwdAccount'];
    $status = $_POST['statusAccount'];

    insertAccount($username, $password, $status);
}
?>
