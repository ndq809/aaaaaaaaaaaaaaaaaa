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
    $('.sidebar-cover').mouseenter(function() {
        if (!$('.gw-sidebar').hasClass('pin-menu')) {
            $('.gw-sidebar').addClass('visible');
            checkMenuBar();
        }
    })
    $('.sidebar-cover').mouseleave(function() {
        if (!$('.gw-sidebar').hasClass('pin-menu')) {
            $('.gw-sidebar').removeClass('visible');
            $('.gw-nav > li.active').each(function() {
                checkActive($(this).find('a'));
            })
        }
    })
    $(document).on('click','.btn-mobile',function(){
        $('.gw-sidebar').show();
        $('.gw-sidebar').addClass('visible');
        $('.gw-sidebar').css('right','-320px');
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $('.sidebar-cover').hover();
            checkMenuBar();
         // some code..
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

function checkMenuBar(tr_list){
    current_link=location.href.split('/');
    current_menu=current_link[current_link.length-1];
    $('.gw-submenu a').each(function(){
        if(typeof $(this).attr('href')!='undefined'){
            if($(this).attr('href').indexOf(current_menu)>0){
                $(this).parent().addClass('active-submenu');
                checkActive($(this).parents('li').find('.menu-title'));
            }
            return;
        }
    })
}