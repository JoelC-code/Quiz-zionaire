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

            <!-- This menu slides in from the right -->
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
        <p class="pb-5 text-center text-xl">Let's make a quiz</p>
        <form method="post" id="quizForm" enctype="multipart/form-data" action="../DB/submitQuiz.php">
            <div class="flex flex-col mb-5">
                <div class="flex flex-row">
                    <label class="font-semibold">Name: </label>
                    <input name="nameQuiz" class="ml-2 w-full" type="text" placeholder="Your Quiz Name">
                </div>
                <div class="flex flex-row">
                    <label class="font-semibold">Topic:</label>
                    <textarea name="descriptionQuiz" class="ml-2 resize-none w-full h-[2.5rem] overflow-hidden"
                        placeholder="The Topic"></textarea>
                </div>
            </div>
            <div id="listCards" class="flex flex-col gap-5">
                <!--Used for showing the list-->
            </div>
            <div class="w-full mt-10 gap-5 flex md:flex-row flex-col">
                <button id="addQuestionBtn"
                    class="rounded-lg w-full p-5 bg-gradient-to-b from-blue-700 cursor-pointer to-blue-800 font-semibold text-white text-xl"
                    value="addQestion">Add Question</button>
                <button
                    class="rounded-lg w-full p-5 bg-gradient-to-b from-green-700 cursor-pointer to-green-800 font-semibold text-white text-xl"
                    name="publishQuiz">Publish Quiz</button>
                <input type="hidden" name="quiz_id" value="<?= $quizID ?>" />
                <button
                    class="rounded-lg w-full p-5 bg-gradient-to-b from-red-700 cursor-pointer to-red-800 font-semibold text-white text-xl"
                    name="deleteQuiz" type="submit" onclick="showQuizDeleteWarning()">Delete Quiz
                </button>
        </form>
        </div>
    </main>
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're about to leave while creating/editing quiz, are you sure? (no
                save will be done in this way)</p>
            <div class="flex justify-end gap-4">
                <button onclick="closeDialog()"
                    class="cursor-pointer bg-gray-300 px-4 py-2 rounded-lg text-white">Cancel</button>
                <a href="TeacherMenu.php">
                    <button onclick="closeDialog()"
                        class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">Exit</button>
                </a>
            </div>
        </div>
    </div>
    <div id="QuizDeleteWarning" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're about to delete the WHOLE quiz, are you sure (can't be undo)?
            </p>
            <div class="flex justify-end gap-4">
                <form action="../DB/delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                    <button onclick="closeQuizWarningDelete()" class="cursor-pointer bg-gray-300 text-white px-4 py-2 rounded-lg"
                        type="submit" name="delete_quiz">Yes</button>
                    <button onclick="closeQuizWarningDelete()"
                        class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">No</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../JS/Index.js"></script>

</body>

</html>