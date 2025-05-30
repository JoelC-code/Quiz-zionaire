$(document).on('click', function (e) {
    const $menu = $('#dropdownMenu');
    const $toggleButton = $('.group');

    if ($toggleButton.has(e.target).length > 0 || $toggleButton.is(e.target)) {
        $menu.toggleClass('translate-x-0');
    } else if (!$menu.is(e.target) && $menu.has(e.target).length === 0) {
        $menu.removeClass('translate-x-0');
    }
});