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

function runQuery($conn, $sql)
{
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}

function readTest($conn)
{
    $sql = "SELECT * FROM `tests`";
    return runQuery($conn, $sql);
}

//Function to get questions
function getQuestions($conn, int $testId): array {
    $result = [
        'testName' => null,
        'questions' => []
    ];

    // Fetch test name
    $testQuery = "SELECT Test_Name FROM tests WHERE Test_ID = ?";
    $stmtTest = mysqli_prepare($conn, $testQuery);
    mysqli_stmt_bind_param($stmtTest, "i", $testId);
    mysqli_stmt_execute($stmtTest);
    $testResult = mysqli_stmt_get_result($stmtTest);
    if ($testRow = mysqli_fetch_assoc($testResult)) {
        $result['testName'] = $testRow['Test_Name'];
    }
    mysqli_stmt_close($stmtTest);

    // Fetch questions
    $questionQuery = "SELECT * FROM question WHERE Test_ID = ?";
    $stmt = mysqli_prepare($conn, $questionQuery);
    mysqli_stmt_bind_param($stmt, "i", $testId);
    mysqli_stmt_execute($stmt);
    $questionsResult = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($questionsResult)) {
        $result['questions'][] = $row;
    }

    mysqli_stmt_close($stmt);

    return $result;
}
