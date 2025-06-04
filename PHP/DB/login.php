<?php
include_once('connect.php');

function insertAccount($name, $password, $role) {
    if(isset($_POST['register_submit'])) {
        $conn = connectDB();
        $username = $_POST['userAccount'];
        $password = $_POST['pwdAccount'];

    }
}
?>