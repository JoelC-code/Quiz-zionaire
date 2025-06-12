<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Quizzionaire | Quiz Session</title>

    <?php
    session_start();
    include "../DB/connect.php";

    $conn = connectDB();

    $score = $_SESSION['score'] ?? null;
    $testID = $_SESSION['test_id'] ?? null;
    $testName = "";

    if ($testID !== null) {
        $stmt = $conn->prepare("SELECT Test_Name FROM tests WHERE Test_ID = ?");
        $stmt->bind_param("i", $testID);
        $stmt->execute();
        $testResult = $stmt->get_result();
        if ($row = $testResult->fetch_assoc()) {
            $testName = $row['Test_Name'];
        }
    }

    unset($_SESSION['score']);
    unset($_SESSION['test_id']);
    unset($_SESSION['question_index']);
    unset($_SESSION['answers']);
    ?>

</head>

<body>
    <nav class="p-5 bg-blue-700 rounded-b-xl flex flex-row justify-between">
        <p class="text-2xl font-semibold text-white pl-5">Quizzionaire</p>
        <div id="navBar" class="text-white gap-8 h-full mt-1 pr-5 hidden md:block">
            <a href="MainMenu.php" class="cursor-pointer">Return to Menu</a>
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
                        <a href="MainMenu.php" class="text-white w-full h-15 hover:bg-white hover:text-blue-800 rounded-lg block p-2 cursor-pointer">Return to Menu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div>
            <div class="w-full h-50 flex flex-col justify-center items-center bg-gray-100">
                <p class="text-xl font-semibold">Quiz:</p>
                <p class="text-lg font-large mb-2"><?= htmlspecialchars($testName ?: 'Unknown Test') ?></p>
                <hr class="border-t-1 border-1 w-auto mt-2 mb-2">
            </div>
            <div class="mt-5 p-5 flex flex-col w-full items">
                <p class="text-2xl text-center">Score anda adalah:</p>
                <p class="text-2xl font-bold text-center"><?= $score ?? "N/A" ?>/100</p>
                <a href="MainMenu.php" class="text-center mt-10 text-blue-700 underline">Kembali ke Main Menu</a>
            </div>
        </div>
        </div>
    </main>

    <script src="../../JS/Index.js"></script>
</body>

</html>