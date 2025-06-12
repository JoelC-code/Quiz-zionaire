<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Quizzionaire | Welcome!</title>
    <?php
    session_start();
    include "../DB/connect.php";
    $conn = connectDB();
    if (!isset($_SESSION['username'])) {
        header("Location: ../UI/LoginPage.php"); // redirect if not logged in
        exit();
    }

    $username = $_SESSION['username'];
    $id = $_SESSION['user_id'];
    ?>

    <?php
    $sql = "SELECT * FROM `tests`";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    ?>

    <?php
    $sql_query = "SELECT * FROM `tests` ORDER BY `Test_ID` DESC LIMIT 3";
    $resultTop3 = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
    ?>

    <?php
    $sql_query = "SELECT * FROM `tests` ORDER BY `Test_ID` ASC";
    $readTest = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
    ?>
</head>

<body class="overflow-x-hidden">
    <nav class="p-5 bg-blue-700 rounded-b-xl flex flex-row justify-between">
        <p class="text-2xl font-semibold text-white pl-5">Quizzionaire</p>
        <div id="navBar" class="text-white gap-8 h-full mt-1 pr-5 hidden md:block">
            <a href="MainMenu.php">Home</a>
            <a href="listScore.php" class="md:ml-8">List Nilai</a>
            <a href="../DB/logout.php" class="md:ml-8">Logout</a>
        </div>
        <div class="block md:hidden group">
            <svg id="hamburgerBtn" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white"
                class="bi bi-list mt-1 cursor-pointer" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>

            <!-- This menu slides in from the right -->
            <div id="dropdownMenu"
                class="fixed top-0 right-0 w-60 h-full bg-blue-800 z-50 transform translate-x-full transition-transform duration-300">
                <ul class="p-4 gap-4">
                    <li><a href="#"
                            class="text-white w-full h-15 hover:bg-white hover:text-blue-800 rounded-lg block p-2">Home</a>
                    </li>
                    <li><a href="listScore.php"
                            class="text-white w-full h-15 hover:bg-white hover:text-blue-800 rounded-lg block p-2">List
                            Nilai</a></li>
                    <li><a href="../DB/logout.php"
                            class="text-white w-full h-15 hover:bg-white hover:text-blue-800 rounded-lg block p-2">Logout</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <header class="flex flex-col justify-center items-center bg-gray-100 w-full h-50">
        <p class="text-3xl font-semibold">Welcome, <?= $username ?>!</p>
        <p>Let's start your day with some quiz!</p>
    </header>


    <main>
        <form method="post" action="quiz.php">
            <!--TODO: Jika kesusahan, hapus bagian ini-->
            <div class="p-5">
                <p class="pb-5 text-center text-xl">Let's start with some new challenge!</p>
                <div id="cardList" class="w-full flex md:flex-row flex-col flex-wrap justify-between gap-5">
                    <?php while ($row = mysqli_fetch_assoc($resultTop3)): ?>
                        <div class="md:w-[30%] rounded-lg p-3 bg-gradient-to-b from-blue-700 to-blue-800">
                            <p class="text-white font-semibold text-xl"><?= htmlspecialchars($row['Test_Name']) ?></p>
                            <p class="text-white mb-6"><?= htmlspecialchars($row['Test_Topic']) ?></p>
                            <button type="submit" name="enter_test" value="<?= $row['Test_ID'] ?>"
                                class="text-sky-800 font-semibold md:p-1 p-2 w-full cursor-pointer bg-white border-1 rounded-md">
                                Enter Test
                            </button>
                        </div>
                    <?php endwhile; ?>
                </div>
                <!--TODO: Sampai sini Ini cuman untuk nunjukin 3 test terbaru yang udah dibuat (di chatGPT pake TOP untuk sql-nya)-->
            </div>
            <hr class="mt-10 mb-10 border-t-4 ml-5 mr-5 border-gray-200">
            <div class="p-5">
                <!--!Ini sampai kebawah hanya untuk nunjukin semua tabelnya-->
                <p class="pb-5 text-center text-xl">Let's start with some new challenge!</p>
                <div id="cardList" class="flex md:flex-row flex-col flex-wrap justify-between gap-5">
                    <?php while ($row = mysqli_fetch_assoc($readTest)): ?>
                        <div class="md:w-[47%] rounded-lg p-3 bg-gradient-to-b from-sky-700 to-sky-800">
                            <p class="text-white font-semibold text-xl"><?= htmlspecialchars($row['Test_Name']) ?></p>
                            <p class="text-white mb-6"><?= htmlspecialchars($row['Test_Topic']) ?></p>
                            <button type="submit" name="enter_test" value="<?= $row['Test_ID'] ?>"
                                class="text-sky-800 font-semibold md:p-1 p-2 w-full cursor-pointer bg-white border-1 rounded-md">
                                Enter Test
                            </button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </form>
    </main>
    <script src="../../JS/Index.js"></script>
</body>

</html>