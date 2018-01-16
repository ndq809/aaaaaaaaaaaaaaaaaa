var selectedTab = "#tab1";
$(function() {
    try {
        initCommon();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initCommon() {
    setCollapse();
    initEvent();
    $("#dtBox").DateTimePicker();
    $(".datetimepicker").on("click", function() {
        $("#dtBox").DateTimePicker();
    })
    menuController();
    setFooter();
    setRightMenuHeight();
    $("select.flexselect").flexselect();
    $('.open-when-small').parent().prev('.right-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-down" style="float: right;margin-right:2px;"></i');
    if($(window).width() < 550){
        $('.menu-btn').css('display','inline-block');
    }else{
        $('.menu-btn').css('display','none');
    }
}

function initEvent() {
    $(document).on('click', "div[data-toggle='collapse']", function(e) {
        icon_class = $(this).find(".collapse-icon").find("i").attr("class");
        if (icon_class == "glyphicon glyphicon-menu-down") {
            $(this).find(".collapse-icon").find("i").removeClass("glyphicon-menu-down");
            $(this).find(".collapse-icon").find("i").addClass("glyphicon-menu-up");
        } else {
            $(this).find(".collapse-icon").find("i").addClass("glyphicon-menu-down");
            $(this).find(".collapse-icon").find("i").removeClass("glyphicon-menu-up");
        }
    })
    $(document).on('click', '.btn-popup', function(e) {
        e.preventDefault();
        var popupId=$(this).attr('popup-id');
        $('#'+popupId).modal('show')
    })
    $(window).resize(function() {
        menuController();
        setFooter();
        if($(window).width() < 550){
            $('.menu-btn').css('display','inline-block');
        }else{
            $('.menu-btn').css('display','none');
        }
    });
    $(document).on('click', '.div-link', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr("href");
    })
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
    $('.main-content').sizeChanged(function() {
        setRightMenuHeight();
        setFooter();
    })
    $('.left-tab .tab-content').sizeChanged(function() {
        setFooter();
    })
    $('.right-tab .tab-content').sizeChanged(function() {
        setRightMenuHeight();
    })
    $(document).on('change','.media-select',function(){
        if($('.media-select').val()!='3'){
            $('.link').show();
            $('.non-link').hide();
        }else{
            $('.link').hide();
            $('.non-link').show();
        }
    })

}

function setFooter() {
    var temp = $('.header-content').height() + $('.middle-content').height() + $('.bottom-content').height()+10;
    if (temp < $('body').height()) {
        $('.bottom-content').addClass('pin-footer');
    } else {
        $('.bottom-content').removeClass('pin-footer');
    }
}

function menuController() {
    if ($(window).width() < 680) {
        var temp = Math.floor((130 / $('.container-fluid').width()) * 100);
        $('#menu>li').css('width', temp + '%');
    } else {
        $('#menu>li').css('width', 'auto');
    }
}

function setNextItem(item_of_table,show_index) {
	if(typeof item_of_table =='undefined')
		item_of_table="tr";
	if(typeof show_index =='undefined')
		show_index=0;
    listItem = $(selectedTab + " table tbody " + item_of_table);
    currentSelectItem = $(selectedTab + " table .activeItem");
    itemId = currentSelectItem.attr("id");
    var nextItem;
    for (var i = 0; i < listItem.length; i++) {
        if (itemId == listItem.eq(i).attr("id")) {
            if (i == listItem.length - 1) {
                nextItem = listItem.first();
                i = 0;
                show_index=0;
            } else {
                nextItem = listItem.eq(i + 1);
            }
            break;
        }
    }
    currentSelectItem.removeClass("activeItem");
    nextItem.addClass("activeItem");
    $(".right-tab .tab-content").animate({
        scrollTop: nextItem.height() * (i+show_index)
    }, 200);
    return nextItem.attr("id");
}

function setPreviousItem(item_of_table,show_index) {
	if(typeof item_of_table =='undefined')
		item_of_table="tr";
	if(typeof show_index =='undefined')
		show_index=0;
    listItem = $(selectedTab + " table tbody " + item_of_table);
    currentSelectItem = $(selectedTab + " table .activeItem");
    itemId = currentSelectItem.attr("id");
    var nextItem;
    for (var i = 0; i < listItem.length; i++) {
        if (itemId == listItem.eq(i).attr("id")) {
            if (i == 0) {
                nextItem = listItem.last();
                i = listItem.length;
            } else {
                nextItem = listItem.eq(i - 1);
            }
            break;
        }
    }
    currentSelectItem.removeClass("activeItem");
    nextItem.addClass("activeItem");
    $(".right-tab .tab-content").animate({
        scrollTop: nextItem.height() * (i - 2+show_index)
    }, 200);
    return nextItem.attr("id");
}

function selectItem(selectItem) {
    currentSelectItem = $(selectedTab + " table .activeItem");
    currentSelectItem.removeClass("activeItem");
    selectItem.addClass("activeItem");
    return selectItem.attr("id");
}

function getDataCommon(data_Array, excute_link) {
    $.ajax({
        type: "POST",
        url: excute_link,
        dataType: "json",
        data: {
            data: data_Array
        },
        beforeSend: function() {
            $("#while-load").show();
        },
        success: function(response) {
            $("#while-load").hide();
            return response;
        },
        error: function(e) {
            $("#while-load").hide();
            return response;
        },
    });
}

function rememberItem(tr_Element, btn_label) {
    var cloneTr = tr_Element.clone();
    cloneTr.find("button").attr("type-btn", "btn-forget");
    cloneTr.find("button").text(btn_label);
    tr_Element.remove();
    if (selectedTab == "#tab1") {
        $("#tab2 table tbody").prepend(cloneTr);
    } else {
        $("#tab1 table tbody").prepend(cloneTr);
    }
    return $(selectedTab + " table tbody tr").first();
}

function forgetItem(tr_Element, btn_label) {
    var cloneTr = tr_Element.clone();
    cloneTr.find("button").attr("type-btn", "btn-remember");
    cloneTr.find("button").text(btn_label);
    tr_Element.remove();
    if (selectedTab == "#tab1") {
        $("#tab2 table tbody").prepend(cloneTr);
    } else {
        $("#tab1 table tbody").prepend(cloneTr);
    }
    return $(selectedTab + " table tbody tr").first();
}

function setCollapse() {
    if ($(window).width() < 768) {
        $('.close-when-small').addClass('in').removeClass('in');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").html('');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-up" style="float: right;margin-right:2px;"></i');
    } else {
        $('.close-when-small').prev('.left-header').find(".collapse-icon").html('');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-down" style="float: right;margin-right:2px;"></i');
    }

    if ($(window).width() >550) {
        if(!$('#menu').hasClass('in')){
           $('#menu').addClass('in'); 
        }
    }
        
}

function setRightMenuHeight(){
    var number_of_item;
    if($('.right-tab .tab-content table').hasClass("relax-table")){
        var item_height=$('.right-tab .tab-content table tbody').first().height();
    }else{
        var item_height=$('.right-tab .tab-content table tbody tr').first().height();
    }
    
    if(item_height<50){
        number_of_item=8;
    }else{
        number_of_item=4;
    }
    number_of_item_temp=parseInt(($('.web-main').height() - $('.select-group').height())/item_height);
    if(number_of_item<number_of_item_temp){
        number_of_item=number_of_item_temp;
    }
    if ($('.right-tab .tab-content').length != 0) {
        $('.right-tab .tab-content').height(number_of_item*item_height);
    }
}