<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>

    <?php
    session_start();
    include "../DB/connect.php";
    $conn = connectDB();

    $quizID = null;
    $quizData = null;
    $questions = [];
    $index = 0;


    if (isset($_POST['topic'])) {
        $quizID = $_POST['topic'];

        // Fetch quiz details
        $stmt = $conn->prepare("SELECT Test_Name, Test_Topic FROM tests WHERE Test_ID = ?");
        $stmt->bind_param("i", $quizID);
        $stmt->execute();
        $result = $stmt->get_result();
        $quizData = $result->fetch_assoc();
        $stmt->close();

        // Fetch existing questions
        $stmt = $conn->prepare("SELECT * FROM question_test WHERE Test_ID = ?");
        $stmt->bind_param("i", $quizID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
            $index++;
        }
        $stmt->close();
    }
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

    <main class="p-5">
        <p class="pb-5 text-center text-xl">Edit Quiz</p>
        <form method="post" id="quizForm" enctype="multipart/form-data" action="../DB/submitQuiz.php">
            <div class="flex flex-col mb-5">
                <div class="flex flex-row">
                    <label class="font-semibold">Name: </label>
                    <input name="nameQuiz" class="ml-2 w-full" type="text"
                        value="<?= htmlspecialchars($quizData['Test_Name'] ?? '') ?>" placeholder="Your Quiz Name">
                </div>
                <div class="flex flex-row">
                    <label class="font-semibold">Topic:</label>
                    <textarea name="descriptionQuiz" class="ml-2 resize-none w-full h-[2.5rem] overflow-hidden"
                        placeholder="The Topic"><?= htmlspecialchars($quizData['Test_Topic'] ?? '') ?></textarea>
                </div>
            </div>

            <div id="listCards" class="flex flex-col gap-5">
                <input type="hidden" name="quiz_id" value="<?= $quizID ?>" />
                <?php
                $index = 0;
                foreach ($questions as $q):
                    $index++;
                ?>
                    <div id="card-<?= $index ?>" class="p-3 rounded-lg flex flex-col gap-3 shadow-lg w-full bg-gray-200">

                        <p class="font-bold mb-2 text-xl">Nomor <?= $index ?></p>
                        <input type="hidden" name="questionSet[<?= $index ?>][question_id]" value="<?= $q['Question_TestID'] ?>">
                        <input type="hidden" name="questionSet[<?= $index ?>][cardId]" value="<?= $index ?>">
                        <input type="hidden" id="deletedQuestionsInput" name="deletedQuestions[]" value="">
                        <div>
                            <label class="font-semibold">Image (optional): </label>
                            <input type="file" name="image[]" accept="image/*"
                                class="ml-2 p-1 border-1 rounded-lg w-48 bg-white">
                            <?php if (!empty($q['Image'])): ?>
                                <p class="ml-2 text-sm text-gray-600">Existing: <?= htmlspecialchars($q['Image']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="font-semibold">Question: </label>
                            <input name="questionSet[<?= $index ?>][soal]" type="text"
                                value="<?= htmlspecialchars($q['Question']) ?>"
                                class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
                        </div>
                        <div>
                            <label class="font-semibold">Answer 1: </label>
                            <input name="questionSet[<?= $index ?>][Jawaban_1]" type="text"
                                value="<?= htmlspecialchars($q['Answer_1']) ?>"
                                class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
                        </div>
                        <div>
                            <label class="font-semibold">Answer 2: </label>
                            <input name="questionSet[<?= $index ?>][Jawaban_2]" type="text"
                                value="<?= htmlspecialchars($q['Answer_2']) ?>"
                                class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
                        </div>
                        <div>
                            <label class="font-semibold">Answer 3: </label>
                            <input name="questionSet[<?= $index ?>][Jawaban_3]" type="text"
                                value="<?= htmlspecialchars($q['Answer_3']) ?>"
                                class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
                        </div>
                        <div>
                            <label class="font-semibold">Answer: </label>
                            <select name="questionSet[<?= $index ?>][Jawaban]" class="bg-white border-1 rounded-lg w-10 text-center">
                                <option value="A" <?= $q['Correct_Answers'] === 'A' ? 'selected' : '' ?>>1</option>
                                <option value="B" <?= $q['Correct_Answers'] === 'B' ? 'selected' : '' ?>>2</option>
                                <option value="C" <?= $q['Correct_Answers'] === 'C' ? 'selected' : '' ?>>3</option>
                            </select>
                        </div>
                        <div class="w-full flex justify-end">
                            <p class="delete-btn flex cursor-pointer p-2 font-semibold text-white rounded-lg bg-red-700">
                                Delete this Question</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="w-full mt-10 gap-5 flex md:flex-row flex-col">
                <button id="addQuestionBtn"
                    class="rounded-lg w-full p-5 bg-gradient-to-b from-blue-700 cursor-pointer to-blue-800 font-semibold text-white text-xl"
                    value="addQestion">Add Question</button>
                <button
                    class="rounded-lg w-full p-5 bg-gradient-to-b from-green-700 cursor-pointer to-green-800 font-semibold text-white text-xl"
                    name="publishQuiz">Publish Quiz</button>
            </div>
        </form>
    </main>

    <div id="modal" class="fixed hidden inset-0 bg-black bg-opacity-80 flex justify-center items-center z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're going to stop the quiz midway (progress can't be saved) are you
                sure?</p>
            <div class="flex justify-end gap-4">
                <a href="TeacherMenu.php">
                    <button onclick="closeDialog()"
                        class="cursor-pointer bg-red-700 text-white px-4 py-2 rounded-lg">Yes</button>
                </a>
                <button onclick="closeDialog()"
                    class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg">No</button>

            </div>
        </div>
    </div>

    <script>
        let questionCount = <?= $index ?? 0 ?>;
    </script>

    <script src="../../JS/Index.js"></script>

</body>

</html>