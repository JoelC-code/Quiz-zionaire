$(document).ready(function () {
    const $menu = $("#dropdownMenu");
    const $button = $("#hamburgerBtn");

    $button.on("click", function (e) {
        e.stopPropagation();
        $menu.toggleClass("translate-x-full translate-x-0");
    });

    $(document).on("click", function (e) {
        if (!$menu.is(e.target) && $menu.has(e.target).length === 0 && !$button.is(e.target)) {
            $menu.removeClass("translate-x-0").addClass("translate-x-full");
        }
    });

    window.showDialog = function () {
        $("#modal").removeClass("hidden");
    }
    window.closeDialog = function () {
        $("#modal").addClass("hidden");
    }

    window.showQuizDeleteWarning = function () {
        $("#QuizDeleteWarning").removeClass("hidden");
    }

    window.closeQuizWarningDelete = function () {
        $("#QuizDeleteWarning").addClass("hidden");
    }

    let questionCount = 0;

    $("#addQuestionBtn").click(function () {
        questionCount++;
        const newCard = $(`<div id="card-${questionCount}" class="p-3 rounded-lg flex flex-col gap-3 shadow-lg w-full bg-gray-200">
            <p class="font-bold mb-2 text-xl">Nomor-${questionCount}</p>
            <div>
                <label class="font-semibold">Image (optional): </label>
                <input type="file" name="imageFile" accept="image/*" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white"><br>
            </div>
            <div>
                <label class="font-semibold">Question: </label>
                <input name="Soal" type="text" class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 1: </label>
                <input name="Jawaban_1" type="text" class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 2: </label>
                <input name="Jawaban_2" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 3: </label>
                <input name="Jawaban_3" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer: </label>
                <select class="bg-white border-1 rounded-lg w-10 text-center">
                    <option value="A">1</option>
                    <option value="B">2</option>
                    <option value="C">3</option>
                </select>
            </div>
            <div class="w-full flex justify-end">
                <p class="delete-btn flex cursor-pointer p-2 font-semibold text-white rounded-lg bg-red-700">
                    Delete this Question</p>
            </div>
        </div>
        `);

        $("#listCards").append(newCard);
    });

    let questionToDelete = null;

    $("#listCards").on("click", ".delete-btn", function () {
        $(this).closest("div[id^='card-']").remove();
        $("#QuizDeleteWarning").removeClass("hidden");
    });

    $("#confirmDelete").click(function () {
        if (questionToDelete) {
            questionToDelete.remove();
            questionToDelete = null;
        }
        $("#QuizDeleteWarning").addClass("hidden");
    });

    $("#cancelDelete").click(function () {
        questionToDelete = null;
        $("#DeleteQuestionWarning").addClass("hidden");
    });
});
