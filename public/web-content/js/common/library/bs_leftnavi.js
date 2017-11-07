$(document).ready(function() {
    var nav = function() {
        $('.gw-nav > li > a').click(function() {
            checkActive($(this));
        });
        $('.gw-nav > li > ul > li > a').click(function() {
            $(this).parent().parent().parent().removeClass('active');
            $('.gw-nav > li > ul > li').removeClass('active');
            $(this).parent().addClass('active')
        });
    };
    nav();
    $('.left-menu-btn').on('click', function(e) {
        if ($('.gw-sidebar').hasClass('pin-menu')) {
            $('.gw-sidebar').removeClass('pin-menu');
        } else {
            $('.gw-sidebar').addClass('pin-menu');
        }
    })
    $('.gw-sidebar').hover(function() {
        if (!$('.gw-sidebar').hasClass('pin-menu')) {
            $('.gw-sidebar').addClass('visible');
        }
    })
    $('.gw-sidebar').mouseleave(function() {
        if (!$('.gw-sidebar').hasClass('pin-menu')) {
            $('.gw-sidebar').removeClass('visible');
            $('.gw-nav > li.active').each(function() {
                checkActive($(this).find('a'));
            })
        }
    })
});

function checkActive(a_tag) {
    var gw_nav = $('.gw-nav');
    gw_nav.find('li').removeClass('active');
    var checkElement = a_tag.parent();
    var ulDom = checkElement.find('.gw-submenu')[0];
    if (ulDom == undefined) {
        checkElement.addClass('active');
        $('.gw-nav').find('li').find('ul:visible').slideUp();
        return;
    }
    if (ulDom.style.display != 'block') {
        gw_nav.find('li').find('ul:visible').slideUp();
        gw_nav.find('li.init-arrow-up').removeClass('init-arrow-up').addClass('arrow-down');
        gw_nav.find('li.arrow-up').removeClass('arrow-up').addClass('arrow-down');
        checkElement.removeClass('init-arrow-down');
        checkElement.removeClass('arrow-down');
        checkElement.addClass('arrow-up');
        checkElement.addClass('active');
        checkElement.find('ul').slideDown(300);
    } else {
        checkElement.removeClass('init-arrow-up');
        checkElement.removeClass('arrow-up');
        checkElement.removeClass('active');
        checkElement.addClass('arrow-down');
        checkElement.find('ul').slideUp(300);
    }
}