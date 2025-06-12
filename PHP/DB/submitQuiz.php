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

            $image = $q['image'];

            echo "<pre>";
            print_r($_POST);
            print_r($_FILES);
            echo "</pre>";
            if (isset($_FILES['image']['error'][$index]) && $_FILES['image']['error'][$index] === 0) {
                $imageName = $_FILES['image']['name'][$index];
                $tmpPath = $_FILES['image']['tmp_name'][$index];
                $image = '../uploads/' . uniqid() . '_' . basename($imageName);
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

function updateQuiz($quizId, $title, $description)
{
    $conn = connectDB();

    // Update quiz info
    $stmt = mysqli_prepare($conn, "UPDATE tests SET Test_Name = ?, Test_Topic = ? WHERE Test_ID = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $quizId);
    mysqli_stmt_execute($stmt);

    foreach ($_POST['questionSet'] as $index => $q) {
        $soal = $q['soal'];
        $jawaban1 = $q['Jawaban_1'];
        $jawaban2 = $q['Jawaban_2'];
        $jawaban3 = $q['Jawaban_3'];
        $correct = $q['Jawaban'];

        $questionId = $q['question_id'] ?? null;
        $image = '';

        // Handle image upload if provided
        if (isset($_FILES['image']['error'][$index]) && $_FILES['image']['error'][$index] === 0) {
            $imageName = $_FILES['image']['name'][$index];
            $tmpPath = $_FILES['image']['tmp_name'][$index];
            $image = 'uploads/' . uniqid() . '_' . basename($imageName);
            move_uploaded_file($tmpPath, $image);
        }

        if (!empty($questionId)) {
            // UPDATE existing question
            if ($image !== '') {
                $stmtQ = mysqli_prepare($conn, "UPDATE question_test SET Question = ?, Image = ?, Answer_1 = ?, Answer_2 = ?, Answer_3 = ?, Correct_Answers = ? WHERE Question_TestID = ?");
                mysqli_stmt_bind_param($stmtQ, "ssssssi", $soal, $image, $jawaban1, $jawaban2, $jawaban3, $correct, $questionId);
            } else {
                $stmtQ = mysqli_prepare($conn, "UPDATE question_test SET Question = ?, Answer_1 = ?, Answer_2 = ?, Answer_3 = ?, Correct_Answers = ? WHERE Question_TestID = ?");
                mysqli_stmt_bind_param($stmtQ, "sssssi", $soal, $jawaban1, $jawaban2, $jawaban3, $correct, $questionId);
            }
            mysqli_stmt_execute($stmtQ);
        } else {
            // INSERT new question
            $stmtQ = mysqli_prepare($conn, "INSERT INTO question_test (Test_ID, Question, Image, Answer_1, Answer_2, Answer_3, Correct_Answers) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtQ, "issssss", $quizId, $soal, $image, $jawaban1, $jawaban2, $jawaban3, $correct);
            mysqli_stmt_execute($stmtQ);
        }
    }

    mysqli_close($conn);
    header("Location: ../UI/TeacherMenu.php");
    exit();
}

// Deleting quiz
function deleteQuiz($conn, $deletedQuestions)
{
    if (!empty($deletedQuestions)) {
        $placeholders = implode(',', array_fill(0, count($deletedQuestions), '?'));
        $types = str_repeat('i', count($deletedQuestions));
        $stmt = $conn->prepare("DELETE FROM question_test WHERE Question_TestID IN ($placeholders)");
        $stmt->bind_param($types, ...$deletedQuestions);
        $stmt->execute();
        $stmt->close();
    }
}

// Check if form is submitted
if (isset($_POST['publishQuiz'])) {
    $conn = connectDB();
    $titleQuiz = $_POST['nameQuiz'];
    $descQuiz = $_POST['descriptionQuiz'];
    $quizId = $_POST['quiz_id'] ?? null;

    if (!empty($_POST['deletedQuestions'])) {
        $deleted = array_filter($_POST['deletedQuestions'], 'is_numeric');
        deleteQuiz($conn, $deleted);
    }
    
    if (isset($quizId) && $quizId !== "") {
        updateQuiz($quizId, $titleQuiz, $descQuiz);
    } else {
        makeQuiz($titleQuiz, $descQuiz);
    }
}
