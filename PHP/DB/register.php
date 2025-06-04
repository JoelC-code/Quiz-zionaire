<?php
include_once('connect.php');

function insertAccount($name, $password, $role)
{
    if (isset($_POST['register_submit'])) {
        $conn = connectDB();
        $username = $_POST['userAccount'];
        $password = $_POST['pwdAccount'];
        $status = $_POST['statusAccount'];

        $statement = mysqli_prepare($conn, "INSERT INTO users (Username, Password, Status) VALUES ('$username', '$password', '$status'");
        if ($statement) {
            mysqli_stmt_bind_param($statement, "sss", $username, $password, $status);
            mysqli_stmt_execute($statement);


        if (mysqli_stmt_affected_rows($statement) > 0) {
            echo "<script>
                    alert('Registered and added to Database');
                    window.location.href='../UI/Login.php';
                  </script>";
        } else {
            echo "<script>alert('Insert failed. Please try again.');</script>";
        }
        } else {
            echo "Statement prep fail: ". mysqli_error($conn);
        }
    }
}
