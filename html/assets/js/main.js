!(function ($) {

    // When Document is Ready call site init function.
    $(document).ready(function () {
        init();
    });

    // Site Init //
    function init() {
        if ($('.carousel').length) {
            carousel();
        }
        if ($('.list-carousel').length) {
            listCarousel();
        }

        if ($('.list-carousel-lg').length) {
            listCarouselLarge();
        }

        if ($('.list-carousel-md').length) {
            listCarouselMedim();
        }

        if ($('.price-slider').length) {
            priceSlider();
        }

        if ($('.wish-btn').length) {
            wishButton();
        }

        if ($('.i-check').length || $('.i-radio').length) {
            iCheck();
        }

        if ($('.main-home-search').length) {
            mainHomePageSearch();
        }

        if ($('.section.img').length) {
            sectionImg();
        }

        if ($('.sticky-sidebar').length) {
            stickySideBar();
        }

        if ($('#map-canvas').length) {
            googleMap();
        }

        if ($('header .navbar').length) {
            headerNav();
        }

        if ($('.countdown').length) {
            countdown();
        }
    }

    // Carousel //
    function listCarousel() {
        $(".list-carousel").owlCarousel({
            items: 4,
            margin: 30,
            nav: false,
            lazyLoad: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false
                }
            }
        });
    }

    // listCarouselMD //
    function listCarouselMedim() {
        $(".list-carousel-md").owlCarousel({
            items: 4,
            margin: 30,
            nav: false,
            lazyLoad: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: false
                }
            }
        });
    }

    // listCarouselLarge //
    function listCarouselLarge() {
        $(".list-carousel-lg").owlCarousel({
            items: 4,
            margin: 30,
            nav: false,
            lazyLoad: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 2,
                    nav: true,
                    loop: false
                }
            }
        });
    }

    // Price Silder //
    function priceSlider() {
        $(".price-slider").ionRangeSlider({
            min: 130,
            max: 575,
            type: 'double',
            prefix: "$",
            prettify: false,
            hasGrid: true
        });
    }

    // Wish Button //
    function wishButton() {
        $('.wish-btn').on('click', function () {
            $(this).toggleClass('check');
        });
    }

    // I Check //
    function iCheck() {
        $('.i-check, .i-radio').iCheck({
            checkboxClass: 'icheckbox_square-aero',
            radioClass: 'iradio_square-aero',
        });
    }

    // Main Home Page Search //
    function mainHomePageSearch() {
        var element = $('.main-home-search .search-input');
        element.on('focus', function (e) {
            e.stopPropagation();
            $('.main-home-search').addClass('active');
            if (e.target.value.length > 1) {
                $(this).parent().find('.search-result-drop-down').addClass('show');
            }
        });

        $('.main-home-search').find('.search-result-item').on('click', function () {
           $('.search-result-drop-down').toggleClass('show');
        });
        element.on('focusout', function () {
            $('.main-home-search').removeClass('active');
        });
        element.on('keyup', function (e) {

            if (e.target.value.length > 1) {
                $(this).parent().find('.search-result-drop-down').addClass('show');
            } else {
                $(this).parent().find('.search-result-drop-down').removeClass('show');
            }
        });
    }

    // Section Img //
    function sectionImg() {
        var element = $('.section.img');
        element.css({'background-image': 'url(' + element.attr('data-image-src') + ')'});
    }

    // Sticky Sidebar //
    function stickySideBar() {

        $('.sticky-sidebar').stickySidebar({
            topSpacing: 110,
            bottomSpacing: 60
        });

    }


    // Google Map //
    function googleMap() {
        var map,
            service;
        var latlng = new google.maps.LatLng(34.0201613, -117.6919205);
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };

        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);


        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
        marker.setMap(map);


        $('a[href="#google-map-tab"]').on('shown.bs.tab', function (e) {
            google.maps.event.trigger(map, 'resize');
            map.setCenter(latlng);
        });
    }

    // Header Nav //
    function headerNav() {
        $(window).scroll(function (e) {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > 65) {
                $('header .navbar').addClass('sticky');
            } else {
                $('header .navbar').removeClass('sticky');
            }
        });
    }

    // Carousel //
    function carousel() {
        $('.carousel').carousel();
    }

    // countdown //
    function countdown() {
        var element = $('.countdown');
        element.countdown(element.attr('data-date'), function (event) {
            $(this).html(
                event.strftime("<div class='v'>%D <span>days</span></div><div class='s'>:</div><div class='v'>%H <span>hours</span></div><div class='s'>:</div><div class='v'>%M <span>minit</span></div><div class='s'>:</div><div class='v'>%S <span>Second</span></div>")
            );
        });
    }
})(jQuery);