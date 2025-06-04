<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Quizzionaire | Quiz Session</title>

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
    <main>
        <div>
            <div class="w-full h-50 flex flex-col justify-center items-center bg-gray-100">
                <p class="text-xl font-semibold">Quiz:</p>
                <p class="text-3xl font-semibold text-center">DB Topic_name</p>
                <hr class="border-t-1 border-1 w-auto mt-2 mb-2">
            </div>
            <div class="mt-5 p-5 flex flex-col w-full items">
                <div class="w-full flex justify-center mb-5">
                    <img src="https://github.com/JoelC-code/Webprog_AFL3_images/blob/main/login.png?raw=true"
                        alt="Quiz Image" class="border-1 h-52 w-auto object-contain" />
                </div>
                <p class="text-lg text-center pb-5">Ambil soal dari database</p>
                <div class="p-3 flex bg-gray-100 rounded-xl gap-3 flex-col md:flex-row">
                    <button name="answer" type="submit"
                        class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white"
                        value="1">Jawaban_1</button>
                    <button name="answer" type="submit"
                        class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white"
                        value="2">Jawaban_2</button>
                    <button name="answer" type="submit"
                        class="bg-blue-500 w-full z-10 rounded-lg p-3 font-semibold text-white"
                        value="3">Jawaban_3</button>
                </div>
            </div>
        </div>
    </main>
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center hidden z-50">
        <div class="relative bg-white rounded-lg overflow-hidden max-w-3xl w-[90%] p-6">
            <p class="text-lg font-semibold mb-4">You're going to stop the quiz midway (progress can't be saved) are you sure?</p>
            <div class="flex justify-end gap-4">
                <button onclick="closeDialog()" class="cursor-pointer bg-green-700 text-white px-4 py-2 rounded-lg">Yes</button>
                <a href="MainMenu.html">
                    <button onclick="closeDialog()" class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg">No</button>
                </a>
            </div>
        </div>
    </div>
    <script src="../JS/Index.js"></script>
</body>

</html>