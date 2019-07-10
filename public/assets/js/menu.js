

/****** MOBILE MENU JS Start *********/
$(document).ready(function () {
    // append plus symbol to every list item that has children
    $('#mobile-nav .parent').append('<span class="open-menu fa fa-plus"></span>');
    
    // fix non-scrolling overflow issue on mobile devices
    $('#mobile-nav > ul').wrap('<div class="overflow"></div>');
    $(window).on('load resize', function () {
        var vph = $(window).height() - 70; // 57px - height of #mobile-nav
        $('#mobile-nav .overflow').css('max-height', vph);
    });
    
    // global variables
    var menu = $('#mobile-nav .overflow > ul');
    var bg = $('html, body');
    
    // toggle background scrolling
    function bgScrolling() {
        // if menu has toggled class... *
        if (menu.hasClass('open')) {
            // * disable background scrolling
            bg.css({
                'overflow-y': 'hidden',
                'height': 'auto'
            });
        // if menu does not have toggled class... *
        } else {
            // * enable background scrolling
            bg.css({
                'overflow-y': 'visible',
                'height': '100%'
            });
        }
    }
    
    // menu button click events
    $('.menu-button').on('click', function (e) {
        e.preventDefault();
        // activate toggles
        menu.slideToggle(250);
        menu.toggleClass('open');
        $(this).children().toggleClass('fa-reorder fa-remove');
        bgScrolling();
    });
    
    // list item click events
    $('.open-menu').on('click', function (e) {
        e.preventDefault();
        $(this).prev('#mobile-nav ul').slideToggle(250);
        $(this).toggleClass('rotate');
    });
});
/****** MOBILE MENU JS END *********/