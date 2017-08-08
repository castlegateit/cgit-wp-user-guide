(function ($) {
    // Add a button to print the user guide
    $(function () {
        var guide = $('.cgit-user-guide');
        var button = $('.cgit-user-guide-print');

        if (button.length === 0) {
            button = $('<button class="button cgit-user-guide-print">Print the User Guide</button>');
            guide.append(button);
        }

        button.on('click', function () {
            window.print();
        });
    });

    // Smooth scroll
    $(function () {
        var page = $('html, body');

        $('.cgit-user-guide-section.-index a').on('click', function (e) {
            var hash = $(this).attr('href');
            var target = $(hash);
            var offset = $('#wpadminbar').height() + 20;

            e.preventDefault();

            page.animate({
                scrollTop: target.offset().top - offset
            });
        });

        $('.cgit-user-guide-section-back a').on('click', function (e) {
            e.preventDefault();
            page.animate({scrollTop: 0});
        });
    });
})(jQuery);
