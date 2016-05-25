// IIFE - Immediately Invoked Function Expression
(function (yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {

    function removeActiveMenu() {
        $('#main-menu a.active').removeClass('active');
    }

    function setActiveMenu(menuName) {
        removeActiveMenu();
        
        if (menuName === 'intro') {
            $('#menu-intro').addClass('active');
        } else if(menuName === 'search') {
            $('#menu-search').addClass('active');
        }
    }

    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 250) {
            $('#main-menu').addClass('fixed');
        } else {
            $('#main-menu').removeClass('fixed');
        }
    });

    var lastSelected = $('#main-menu a.active');

    $('#main-menu a').mouseover(function () {
        removeActiveMenu();
    });

    $('#menu-intro').click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#intro-header").offset().top
        }, 1000);
    });

    $('#menu-search').click(function (e) {
        e.preventDefault();
        var offsetTop = $("#search-form").offset().top - 100;
        $('html, body').animate({
            scrollTop: offsetTop
        }, 1000);
    });

    $('#main-menu a').click(function (e) {
        removeActiveMenu();
        $(this).addClass('active');
    });
    
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        
        if (scroll >= ($("#intro-header").offset().top)) {
            setActiveMenu('intro');                             
        }
        
        if (scroll >= ($("#search-form").offset().top - 60 )) {
            setActiveMenu('search');
        }                               
        
    });

}));

