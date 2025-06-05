<?php
//Function connect DB
function connectDB()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "webquiz";
    $conn = mysqli_connect($host, $user, $pass, $db) or die("Failed to connect, contact us");

    return $conn;
}

//Function close DB
function my_closeDB($conn)
{
    mysqli_close($conn);
}