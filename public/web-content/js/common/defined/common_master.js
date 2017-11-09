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
    setLayout();
    menuController();
    $('.table-fixed-width table').css('min-width',$('.table-fixed-width').attr('min-width'));
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
        setLayout();
    })

    $(window).resize(function(){
        if ($(window).width() >550) {
            if(!$('#menu').hasClass('in')){
               $('#menu').addClass('in'); 
            }
        }
        menuController();
    })
    $(document).on('change','.super-checkbox',function(){
        if(this.checked){
            $('.sub-checkbox').prop('checked', true);
        }else{
            $('.sub-checkbox').prop('checked', false);
        }
    })
    $(document).on('change','.sub-checkbox',function(){
        if($("input.sub-checkbox:not(:checked)").length!=0){
            $('.super-checkbox').prop('checked', false);
        }else{
            $('.super-checkbox').prop('checked', true);
        }
    })
    $(document).on('click','#btn-list',function(){
        $('.fa-spin').show();
        setTimeout(function() {
            $(".table-fixed-width").removeClass('hidden');
            $('.fa-spin').hide();
            $('.btn-disable').removeClass('btn-disable');
        }, 1000);
    })
}

function setLayout(){
    $('.gw-sidebar').css('top',$('.top-header').height());
    $('.change-content').css('padding-top',$('.top-header').height()+10);
}

function menuController() {
    if ($(window).width() < 680) {
        var temp = Math.floor((140 / $('.container-fluid #menu').width()) * 100);
        $('#menu>li').css('width', temp + '%');
    } else {
        $('#menu>li').css('width', 'auto');
    }

    if ($(window).width() < 845) {
        $('.navbar-right').width('100%');
    }else{
        $('.navbar-right').width('auto');
    }
}

