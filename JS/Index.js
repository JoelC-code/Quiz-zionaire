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

    $("#addQuestionBtn").click(function (e) {
        e.preventDefault();
        questionCount++;
        const newCard = $(`<div id="card-${questionCount}" class="p-3 rounded-lg flex flex-col gap-3 shadow-lg w-full bg-gray-200">
            <p class="font-bold mb-2 text-xl">Nomor ${questionCount}</p>
            <input type="hidden" name="questionSet[${questionCount}][cardId]" value="${questionCount}">
            <div>
                <label class="font-semibold">Image (optional): </label>
                <input type="file" name="image[]" accept="image/*" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white"><br>
            </div>
            <div>
                <label class="font-semibold">Question: </label>
                <input  name="questionSet[${questionCount}][soal]" type="text" class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 1: </label>
                <input name="questionSet[${questionCount}][Jawaban_1]" type="text" class="ml-2 p-1 border-1 rounded-lg bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 2: </label>
                <input name="questionSet[${questionCount}][Jawaban_2]" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer 3: </label>
                <input name="questionSet[${questionCount}][Jawaban_3]" type="text" class="ml-2 p-1 border-1 rounded-lg w-48 bg-white" required><br>
            </div>
            <div>
                <label class="font-semibold">Answer: </label>
                <select name="questionSet[${questionCount}][Jawaban]" class="bg-white border-1 rounded-lg w-10 text-center">
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
        const $card = $(this).closest("div[id^='card-']");
        const questionIdInput = $card.find("input[name$='[question_id]']");

        // If it's an existing question (has a question_id), add it to deletedQuestions
        if (questionIdInput.length > 0) {
            const questionId = questionIdInput.val();
            const hiddenInput = $(`<input type="hidden" name="deletedQuestions[]" value="${questionId}">`);
            $("#quizForm").append(hiddenInput);
        }

        $card.remove();
        questionCount--;
    });

    $("#confirmDelete").click(function () {
        if (questionToDelete) {
            questionToDelete.remove();
            questionToDelete = null;
        }
    });

    $("#cancelDelete").click(function () {
        questionToDelete = null;
    });
});
