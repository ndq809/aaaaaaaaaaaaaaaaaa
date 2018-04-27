var selectedTab = "#tab1";
var countComment = 1;
$(function() {
    try {
        initCommon();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initCommon() {
    $(document).ajaxComplete(function (evt, jqXHR, settings) {
      if (settings.loading) {
        if(settings.container){
            $(settings.container).LoadingOverlay("hide");
        }else{
            $.LoadingOverlay("hide");
        }
    }
    });
    $(document).ajaxError(function (evt, jqXHR, settings, err) {
      if (settings.loading) {
        if(settings.container){
            $(settings.container).LoadingOverlay("hide");
        }else{
            $.LoadingOverlay("hide");
        }
    }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        //HungNV add
        beforeSend: function () {
            if (this.loading) {
                if(this.container){
                    $(this.container).LoadingOverlay("show");
                }else{
                    $.LoadingOverlay("show");
                }
            }
        },
        success: function (res) {
            if(this.container){
                $(this.container).LoadingOverlay("hide");
            }else{
                $.LoadingOverlay("hide");
            }
        },
        error: function (response) {
            if(this.container){
                $(this.container).LoadingOverlay("hide");
            }else{
                $.LoadingOverlay("hide");
            }
            return false;
        },
        // DuyTP 2017/02/09 Add event back to login when session expires
        complete: function (res) {
            if (res.status != null && res.status == 404) {
                location.href = '/';
            } else if (res.status == 409) {
                location.href = '/example';
            }
            // if (res.status != null && res.status == 401) {
            //     location.href = '/';
            // }
        }
    });
    setCollapse();
    initEvent();
    setFooter();
    $("#dtBox").DateTimePicker();
    $(".datetimepicker").on("click", function() {
        $("#dtBox").DateTimePicker();
    })
    menuController();
    setRightMenuHeight();
   if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("select").selectize({
            allowEmptyOption: true,
            create: false
        });
    }else{
        $("select").addClass("form-control input-sm");
    }
    $('.open-when-small').parent().prev('.right-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-down" style="float: right;margin-right:2px;"></i');
    if($(window).width() < 550){
        $('.menu-btn').css('display','inline-block');
    }else{
        $('.menu-btn').css('display','none');
    }
    if($('.file-caption').parents('.new-item').hasClass('required')){
        $('.file-caption').addClass('required');
    }

    $('#menu li').each(function(){
        if(typeof $(this).find('a').attr('href')!='undefined'&&$(this).find('a').attr('href').split('/')[1]===window.location.href.split('/')[3].replace('#','')){
            $(this).addClass('active-menu');
        }
    })
     
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
        if($(window).width() < 550){
            $('.menu-btn').css('display','inline-block');
        }else{
            $('.menu-btn').css('display','none');
        }
        setFooter();
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
    $('.right-tab .tab-content').sizeChanged(function() {
        setRightMenuHeight();
    })
    $('.middle-content').sizeChanged(function() {
        setFooter();
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

    $(document).on('click','.btn-comment',function(){
        addComment($(this));
    })
    $(document).on('click','.btn-reply',function(){
        if($(this).parents('.commentList').length>1){
            $(this).parents('.commentList').next().find('.input-sm').focus();
        }else{
            $(this).parent().next().next().removeClass('hidden');
        }
    })

    $(document).on('click','.btn-more-cmt',function(){
        getComment($(this));
    })

    $('.close-when-small').on('show.bs.collapse', function (e) {
        if ($(window).width() <=550) {
            $('.close-when-small').each(function(){
                if($(this).attr('class').split(" ")[0]!=e.currentTarget.className.split(" ")[0]){
                    $(this).collapse("hide");
                    $(this).prev().find(".collapse-icon").find("i").removeClass("glyphicon-menu-down");
                    $(this).prev().find(".collapse-icon").find("i").addClass("glyphicon-menu-up");
                }
            })
        }
    })

    $(document).on('click','#btn-new-row',function(){
        $(this).parents('table').find('tbody').append("<tr></tr>");
        $(this).parents('table').find('tbody tr:last-child').append($(this).parents('table').find('tbody tr:first').html());
        reIndex($(this).parents('table'));
    })

    $(document).on('click','.delete-tr-row',function(){
        tableTemp=$(this).parents('table');
        $(this).closest('tr').remove();
        reIndex(tableTemp);
    })

}

function setFooter() {
    var temp = $('.header-content').height() + $('.middle-content').height() + $('.bottom-content').height()+10;
    if (temp < $('body').height()) {
        $('.bottom-content').css('position','absolute');
    } else {
        $('.bottom-content').css('position','relative');
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
    tr_Element.addClass('animated fadeOutRight');
    tr_Element.delay(0).fadeOut(500, function(){
        tr_Element.remove();
    });
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
    tr_Element.addClass('animated fadeOutRight');
    tr_Element.delay(0).fadeOut(500, function(){
        tr_Element.remove();
    });
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

    $('.right-tab .tab-content').css('display','block');
}

function addComment(btn_comment){
    var comment_content=$('.new-comment').html();
    if(btn_comment.closest('.input-group').hasClass('comment-input')){
        btn_comment.closest('.input-group').prev().append(comment_content);
    }else{
        btn_comment.closest('.input-group').next().next().append(comment_content);
    }
}

function getComment(btn_show){
    $.ajax({
        type: 'POST',
        url: '/common/getcomment',
        loading:true,
        container:'.commentbox',
        dataType: 'html',
        data: {},
        success: function (res) {
            temp=$.parseHTML(res);
            btn_show.prev(".commentList:first").empty();
            btn_show.prev(".commentList:first").append(temp[0].children);
            $('a.see-back').removeClass('hidden');
        },
        // Ajax error
        error: function (res) {
        }
    });
}

function changePassword(username){
    $.ajax({
        type: 'POST',
        url: '/common/changepass',
        dataType: 'json',
        data: {},
        success: function (res) {
            alert("Đã gửi email bao gồm mk mới");
        },
        // Ajax error
        error: function (res) {
        }
    });
}

function reIndex(table)
{
    var tab=0;
    var col=2;
    if(table.find('input[type=checkbox]').length==0){
        col=1;
    }
    table.find('tbody > tr:not(:first)').each(function(i) {
        $(this).find('td:nth-child('+col+')').html('').html(i+1);
        
    });
}