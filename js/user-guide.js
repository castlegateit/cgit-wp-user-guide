(function($) {
    $(document).ready(function() {

        var button = $('<button class="button">Print the User Guide</button>');

        button.on('click', function() {
            window.print();
        });

        $('.cgit-user-guide').append(button);

    });
})(jQuery);
