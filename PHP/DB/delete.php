<?php
include_once('connect.php');
$conn = connectDB();

if (isset($_POST['delete_quiz'])) {
    $quizID = $_POST['quiz_id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM tests WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $quizID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../UI/TeacherMenu.php?deleted=success");
        exit();
    } else {
        echo "Error deleting quiz: " . mysqli_error($conn);
    }
}
?>
