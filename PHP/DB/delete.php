<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../DB/connect.php";
$conn = connectDB();

if (!isset($_SESSION['username'])) {
    header("Location: ../UI/Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $testId = intval($_POST['delete']);

    $sql = "DELETE FROM tests WHERE Test_ID = $testId";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../UI/TeacherMenu.php?deleted=1"); // Redirect back to main menu with success flag
        exit();
    } else {
        header("Location: ../UI/TeacherMenu.php?deleted=0"); // Failed
        exit();
    }
}
?>
