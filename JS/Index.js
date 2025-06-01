$(document).ready(function () {
    $("#hamburgerBtn").click(function (e) {
        e.stopPropagation();
        $("#dropdownMenu").toggleClass("translate-x-0 translate-x-full");
    });

    // Click outside to close
    $(document).click(function (e) {
        if (!$(e.target).closest("#dropdownMenu").length && !$(e.target).is("#hamburgerBtn")) {
            $("#dropdownMenu").addClass("translate-x-full").removeClass("translate-x-0");
        }
    });

    window.showDialog = function () {
        $("#modal").removeClass("hidden");
    }

    window.closeDialog = function () {
        $("#modal").addClass("hidden");
    }

    window.showWarning = function () {
        $("#Warning").removeClass("hidden");
    }
    window.closeWarning = function () {
        $("#Warning").addClass("hidden");
    }
});
