<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Quizzionaire | Quiz Session</title>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include "../DB/connect.php";
    $conn = connectDB();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../UI/Login.php");
        exit();
    }

    // Handle submitted answers
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
        $selectedAnswer = $_POST['answer'];
        $questionID = $_POST['question_id'];
        $testID = $_POST['enter_test'];

        // Store answer in session
        $_SESSION['answers'][$questionID] = $selectedAnswer;

        // Track progress
        if (!isset($_SESSION['question_index'])) {
            $_SESSION['question_index'] = 1;
        } else {
            $_SESSION['question_index']++;
        }

        header("Location: quiz.php");
        exit();
    }

    if (isset($_POST['enter_test'])) {
        $_SESSION['test_id'] = $_POST['enter_test'];
    }

    $tests = $_SESSION['test_id'] ?? null;

    $questions = [];
    $testName = "";
    if ($tests !== null) {
        $sql = "SELECT * FROM `question_test` WHERE `Test_ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tests);
        $stmt->execute();
        $result = $stmt->get_result();
        $questions = $result->fetch_all(MYSQLI_ASSOC);

        $stmt = $conn->prepare("SELECT Test_Name FROM tests WHERE Test_ID = ?");
        $stmt->bind_param("i", $tests);
        $stmt->execute();
        $testResult = $stmt->get_result();
        if ($row = $testResult->fetch_assoc()) {
            $testName = $row['Test_Name'];
        }
    }

    $index = $_SESSION['question_index'] ?? 0;
    $currentQuestion = $questions[$index] ?? null;
    ?>

</head>

<body>
    <nav class="p-5 bg-blue-700 rounded-b-xl flex flex-row justify-between">
        <p class="text-2xl font-semibold text-white pl-5">Quizzionaire</p>
        <div id="navBar" class="text-white gap-8 h-full mt-1 pr-5 hidden md:block">
            <p onclick="showDialog()" class="cursor-pointer">Return to Menu</p>
        </div>
        <div class="block md:hidden group">
            <svg id="hamburgerBtn" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white"
                class="bi bi-list mt-1 cursor-pointer" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
            <div id="dropdownMenu"
                class="fixed top-0 right-0 w-60 h-full bg-blue-800 z-50 transform translate-x-full transition-transform duration-300">
                <ul class="p-4 gap-4">
                    <li>
                        <p onclick="showDialog()"
                            class="text-white w-full h-15 hover:bg-white hover:text-blue-800 rounded-lg block p-2 cursor-pointer">
                            Return to Menu</p>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div>
            <div class="w-full h-50 flex flex-col justify-center items-center bg-gray-100">
                <p class="text-xl font-semibold">Quiz:</p>
                <p class="text-3xl font-semibold text-center"><?= htmlspecialchars($testName) ?></p>
                <hr class="border-t-1 border-1 w-auto mt-2 mb-2">
            </div>

            <div class="mt-5 p-5 flex flex-col w-full items-center">
                <?php if ($currentQuestion): ?>

                    <?php if (!empty($currentQuestion['Image'])): ?>
                        <div class="w-full flex justify-center mb-5">
                            <img src="../Images/<?= htmlspecialchars($currentQuestion['Image']) ?>" alt="Question Image" class="border-1 h-52 w-auto object-contain" />
                        </div>
                    <?php endif; ?>

                    <p class="text-lg text-center pb-5"><?= htmlspecialchars($currentQuestion['Question']) ?></p>
                    <form method="post" action="quiz.php">
                        <input type="hidden" name="enter_test" value="<?= htmlspecialchars($tests) ?>">
                        <input type="hidden" name="question_id" value="<?= htmlspecialchars($currentQuestion['Question_TestID']) ?>">

                        <div class="p-3 flex bg-gray-100 rounded-xl gap-3 flex-col md:flex-row">
                            <button name="answer" type="submit" value="A"
                                class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white">
                                <?= htmlspecialchars($currentQuestion['Answer_1']) ?>
                            </button>

                            <button name="answer" type="submit" value="B"
                                class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white">
                                <?= htmlspecialchars($currentQuestion['Answer_2']) ?>
                            </button>

                            <button name="answer" type="submit" value="C"
                                class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white">
                                <?= htmlspecialchars($currentQuestion['Answer_3']) ?>
                            </button>
                        </div>
                    </form>

                <?php else: ?>
                    <?php
                    $userID = $_SESSION['user_id'] ?? null;

                    if ($userID && $tests && !empty($_SESSION['answers'])) {
                        $correct = 0;
                        $total = count($questions);

                        foreach ($questions as $q) {
                            $qid = $q['Question_TestID'];
                            $correctAnswer = $q['Correct_Answers'];
                            $userAnswer = $_SESSION['answers'][$qid] ?? null;

                            if ($userAnswer == $correctAnswer) {
                                $correct++;
                            }
                        }

                        $rawScore = ($correct / $total);
                        $score = ceil($rawScore * 100);

                        error_log("User ID: " . $userID);
                        error_log("Test ID: " . $tests);
                        error_log("Score: " . $score);
                        error_log("Answers: " . print_r($_SESSION['answers'], true));

                        $stmt = $conn->prepare("INSERT INTO assigned_tests (Test_ID, Users_ID, Score) VALUES (?, ?, ?)");
                        $stmt->bind_param("iii", $tests, $userID, $score);
                        $stmt->execute();

                        $_SESSION['score'] = $score;
                        unset($_SESSION['answers']);
                        unset($_SESSION['question_index']);

                        header("Location: selesaiquiz.php");
                        exit();
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <div id="modal" class="fixed hidden inset-0 bg-black bg-opacity-80 flex justify-center items-center z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're going to stop the quiz midway (progress can't be saved) are you sure?</p>
            <div class="flex justify-end gap-4">
                <a href="MainMenu.php">
                    <button onclick="closeDialog()" class="cursor-pointer bg-red-700 text-white px-4 py-2 rounded-lg">Yes</button>
                </a>
                <button onclick="closeDialog()" class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg">No</button>

            </div>
        </div>
    </div>
    <script src="../../JS/Index.js"></script>
</body>

</html>