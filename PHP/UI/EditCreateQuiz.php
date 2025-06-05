<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>

    <?php
    include "../DB/connect.php";
    ?>
</head>

<body>
    <nav class="p-5 bg-blue-700 rounded-b-xl flex flex-row justify-between">
        <p class="text-2xl font-semibold text-white pl-5">Quizzionaire</p>
        <div id="navBar" class="text-white gap-8 h-full mt-1 pr-5 hidden md:block">
            <p onclick="showDialog()">Return to Menu</p>
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
        <div class="flex flex-col mb-5">
            <div class="flex flex-row">
                <label class="font-semibold">Quiz Name: </label>
                <input class="ml-2 w-[83%]" type="text" placeholder="Your Quiz Name">
            </div>
            <div class="flex flex-row">
                <label class="font-semibold">The Topic:</label>
                <textarea class="ml-2 resize-none w-[85%] h-[2.5rem] overflow-hidden"
                    placeholder="The Topic"></textarea>
            </div>
        </div>
        <div id="listCards" class="flex flex-col gap-5">
            <div id="1" class="p-3 rounded-lg flex flex-col gap-3 shadow-lg w-full bg-gray-200">
                <p class="font-bold mb-2 text-xl">Nomor_Pertanyaan</p>
                <div>
                    <label class="font-semibold">Image (optional): </label>
                    <input type="file" accept="image/*" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white"><br>
                </div>
                <div>
                    <label class="font-semibold">Question: </label>
                    <input name="Soal" type="text" class="ml-2 p-1 border-1 rounded-lg  bg-white" required><br>
                </div>
                <div>
                    <label class="font-semibold">Answer 1: </label>
                    <input name="Answer_1" type="text" class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
                </div>
                <div>
                    <label class="font-semibold">Answer 2: </label>
                    <input name="Answer_2" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
                </div>
                <div>
                    <label class="font-semibold">Answer 3: </label>
                    <input name="Answer_3" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
                </div>
                <div>
                    <label class="font-semibold">Answer: </label>
                    <select class="bg-white border-1 rounded-lg w-10 text-center">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="w-full flex justify-end">
                    <p onclick="showQuestionDeleteWarning()" class="flex cursor-pointer p-2 font-semibold text-white rounded-lg bg-red-700">Delete
                        this Question</p>
                </div>
            </div>
        </div>
        <div class="w-full mt-10 gap-5 flex md:flex-row flex-col">
            <button
                class="rounded-lg w-full p-5 bg-gradient-to-b from-blue-700 cursor-pointer to-blue-800 font-semibold text-white text-xl"
                value="addQestion">Add Question</button>
            <button
                class="rounded-lg w-full p-5 bg-gradient-to-b from-green-700 cursor-pointer to-green-800 font-semibold text-white text-xl"
                value="publishQuiz">Publish Quiz</button>
            <button
                class="rounded-lg w-full p-5 bg-gradient-to-b from-red-700 cursor-pointer to-red-800 font-semibold text-white text-xl"
                value="publishQuiz" onclick="showQuizWarningDelete()">Delete Quiz</button>
        </div>
    </main>
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're about to leave while creating/editing quiz, are you sure? (no
                save will be done in this way)</p>
            <div class="flex justify-end gap-4">
                <button onclick="closeDialog()"
                    class="cursor-pointer bg-green-700 px-4 py-2 rounded-lg text-white">Cancel</button>
                <a href="TeacherMenu.html">
                    <button onclick="closeDialog()"
                        class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">Exit</button>
                </a>
            </div>
        </div>
    </div>
    <div id="DeleteQuestionWarning" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're about to delete this question, are you sure (can't be undo)?
            </p>
            <div class="flex justify-end gap-4">
                <button onclick="closeQuestionDeleteWarning()" class="cursor-pointer bg-green-700 text-white px-4 py-2 rounded-lg"
                    type="submit" value="-1">Yes</button>
                <button onclick="closeQuestionDeleteWarning()"
                    class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">No</button>
            </div>
        </div>
    </div>
    <div id="QuizDeleteWarning" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're about to delete the WHOLE quiz, are you sure (can't be undo)?
            </p>
            <div class="flex justify-end gap-4">
                <a href="TeacherMenu.html">
                <button onclick="closeQuizDeleteWarning()" class="cursor-pointer bg-green-700 text-white px-4 py-2 rounded-lg"
                    type="submit" value="-1">Yes</button></a>
                <button onclick="closeQuizDeleteWarning()"
                    class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">No</button>
            </div>
        </div>
    </div>
    <script src="../JS/Index.js"></script>
</body>

</html>