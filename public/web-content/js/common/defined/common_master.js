var selectedTab = "#tab1";
$(function() {
    try {
        initCommonMaster();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initCommonMaster() {
    initEvent();
    setMenuRight();
    menuController();
}

function initEvent() {
    $.fn.sizeChanged = function(handleFunction) {
        var element = this;
        var lastWidth = element.width();
        var lastHeight = element.height();
        setInterval(function() {
            if (lastWidth === element.width() && lastHeight === element.height()) return;
            if (typeof(handleFunction) == 'function') {
                handleFunction({
                    width: lastWidth,
                    height: lastHeight
                }, {
                    width: element.width(),
                    height: element.height()
                });
                lastWidth = element.width();
                lastHeight = element.height();
            }
        }, 100);
        return element;
    };
    $('.top-header').sizeChanged(function() {
        setMenuRight();
    })

    $(window).resize(function(){
        if ($(window).width() >550) {
            if(!$('#menu').hasClass('in')){
               $('#menu').addClass('in'); 
            }
        }
        menuController();
    })
}

function setMenuRight(){
    $('.gw-sidebar').css('top',$('.top-header').height());
}

function menuController() {
    if ($(window).width() < 680) {
        var temp = Math.floor((145 / $('.container-fluid ul').width()) * 100);
        $('.navbar-nav>li').css('width', temp + '%');
    } else {
        $('.navbar-nav>li').css('width', 'auto');
    }
}

