<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('connect.php');

function makeQuiz($title, $description)
{
    $conn = connectDB();

    $statement = mysqli_prepare($conn, "INSERT INTO tests (Test_Name, Test_Topic) VALUES (?, ?)");

    if ($statement) {
        mysqli_stmt_bind_param($statement, "ss", $title, $description);
        mysqli_stmt_execute($statement);

        $testID = mysqli_insert_id($conn);

        foreach ($_POST['questionSet'] as $index => $q) {
            $soal = $q['soal'];
            $jawaban1 = $q['Jawaban_1'];
            $jawaban2 = $q['Jawaban_2'];
            $jawaban3 = $q['Jawaban_3'];
            $correct = $q['Jawaban'];

            $image = '';

            echo "<pre>";
            print_r($_POST);
            print_r($_FILES);
            echo "</pre>";
            if (isset($_FILES['images']['error'][$index]) && $_FILES['images']['error'][$index] === 0) {
                $imageName = $_FILES['images']['name'][$index];
                $tmpPath = $_FILES['images']['tmp_name'][$index];
                $image = 'uploads/' . uniqid() . '_' . basename($imageName);
                move_uploaded_file($tmpPath, $image);
            }

            $stmtQ = mysqli_prepare($conn, "INSERT INTO question_test (Test_ID, Question, Image, Answer_1, Answer_2, Answer_3, Correct_Answers)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtQ, "issssss", $testID, $soal, $image, $jawaban1, $jawaban2, $jawaban3, $correct);
            mysqli_stmt_execute($stmtQ);
        }
        header("location: ../UI/TeacherMenu.php");
        exit();
    } else {
        die("Statement prep fail: " . mysqli_error($conn));
    }
}

if (isset($_POST['publishQuiz'])) {
    $titleQuiz = $_POST['nameQuiz'];
    $descQuiz = $_POST['descriptionQuiz'];

    makeQuiz($titleQuiz, $descQuiz);
}
