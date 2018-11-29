var selectedTab = "#tab1"; var countComment = 1;
var _popup_transfer_array=[];
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
    if(jqXHR.responseJSON.status =='206'){
        showMessage(9,function(){
            window.location.reload();
        })
    }

    $('.table-fixed-width table').each(function(){
        $(this).css('min-width',$(this).parent().attr('min-width'));
    })

    $('.btn-disabled').attr('data-toggle','tooltip');
    $('.btn-disabled').attr('data-placement','bottom');
    $('.btn-disabled').attr('data-original-title','Bạn chưa đăng nhập hoặc rank chưa đủ để sử dụng tính năng này!');
    $('.btn-disabled').tooltip();
    $('.btn-disabled').addClass('disabled');
    // $('.btn-disabled').removeAttr('title');
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
    $('a.btn-disabled').click(function(e){
        e.stopPropagation();
    });
    $("#dtBox").DateTimePicker();
    $(".datetimepicker").on("click", function() {
        $("#dtBox").DateTimePicker();
    })
    menuController();
    setRightMenuHeight();
    $("select.allow-selectize").each(function() {
        var select = $(this).selectize({
            allowEmptyOption: false,
            create: false,
            openOnFocus: false,
            plugins: ['restore_on_backspace'],
            render: {
                option: function (data, escape) {
                    return "<div data-parent-id='" + data.catalogue_id + "'>" + data.text + "</div>"
                }
            }
        });
        var selectize = select[0].selectize;
        selectize.on('blur', function() {
            if (selectize.getValue() === '') {
                var defaultOption = selectize.options[Object.keys(selectize.options)[0]];
                selectize.setValue(defaultOption.value);
            }
        });
    });
    $("select.tag-selectize").each(function() {
        var select = $(this).selectize({
            delimiter: ',',
            persist: false,
            plugins: ['restore_on_backspace'],
            
            create: function(input) {
                return {
                    value: input+'**++**eplus',
                    text: input
                }
            }
        });
    });
    if($('textarea[name=new-question-content]').length!=0){
        editor1 = CKEDITOR.replace('new-question-content',{language:"vi",customConfig: '/web-content/ckeditor/custom_config1.js'});
    }
    $('.open-when-small').parent().prev('.right-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-down" style="float: right;margin-right:2px;"></i');
    if($(window).width() < 550){
        $('.menu-btn').css('display','inline-block');
        $('#menu').removeClass('in');
    }else{
        $('.menu-btn').css('display','none');
    }
    if($('.file-caption').parents('.new-item').hasClass('required')){
        $('.file-caption').addClass('required');
    }

    $('#menu li').each(function(){
        if(typeof $(this).find('a').attr('href')!='undefined'&&$(this).find('a').attr('href').split('/')[1]===window.location.href.split('?')[0].split('/')[3].replace('#','')){
            $(this).addClass('active-menu');
        }
    })
    checkError();
    $('.btn-disabled').addClass('disabled');
    $('.btn-disabled').attr('data-toggle','tooltip');
    $('.btn-disabled').attr('data-placement','bottom');
    $('.btn-disabled').attr('data-original-title','Bạn chưa đăng nhập hoặc rank chưa đủ để sử dụng tính năng này!');
    $('.btn-disabled').tooltip();
    $('.btn-disabled').removeAttr('title');
    setInterval(keepTokenAlive, 1000 * 60*100); // every 15 mins
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
        setCollapse();
        if($(window).width() < 550){
            $('.menu-btn').css('display','inline-block');
            $('#menu').removeClass('in');
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
    $('.web-main').sizeChanged(function() {
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

    $(document).on('click','.btn-reply',function(){
        if($(this).parents('.commentList').length>1){
            $(this).parents('.commentList').siblings('.comment-input').removeClass('hidden');
            $(this).parents('.commentList').next().find('.input-sm').focus();
        }else{
            $(this).parent().siblings('.comment-input').removeClass('hidden');
            $(this).parent().siblings('.comment-input').find('input:first-child').focus();
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

    $(document).on('dblclick','.table-click tbody tr:not(.no-data)',function(){
        $('.table-click tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');
        var selectize_temp= $('#catalogue_nm')[0].selectize;
        selectize_temp.setValue(selectize_temp.getValueByText($(this).find('td').eq(1).text().trim()),true);
        updateGroup($('#catalogue_nm'),$(this).find('td').eq(2).text().trim());
    })

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $(document).on('doubletap','.table-click tbody tr',function(e){
            $(this).trigger('dblclick');
        })
    }

    $(document).on('click','.delete-tr-row',function(){
        tableTemp=$(this).parents('table');
        $(this).closest('tr').remove();
        reIndex(tableTemp);
    })

    $(document).on('click','.btn-del-lesson',function(){
        _this=this;
        showMessage(3,function(){
            deleteLesson($(_this).parents('tr'));
        })

    })

     $(document).on('click','#btn_login',function(){
        checkLogin('Quy Nguyen');
    })

     $(document).on('click','#btn-logout',function(){
        logout('Quy Nguyen');
    })

     $(document).on('keydown', function(e) {
        switch (e.which) {
            case 13:
                if(!e.shiftKey && $('.comment-input:focus').length!=0){
                    $('.comment-input:focus').next().find('button').trigger('click');
                }
                break;
            default:
                break;
        }
    })

     $(document).on('change','.pager select',function(){
        $(this).next().attr('page',$(this).val().trim());
        $(this).next().click();
     })

     window.onscroll = function() {
        if($('.right-header:visible').length!=0){
            sticky();
        }
    };

}

function setFooter() {
    $('.body-content').css('min-height','calc(100vh - '+($('.bottom-content').height()+1)+'px)');
    // var temp = $('.header-content').height() + $('.middle-content').height() + $('.bottom-content').height()+10;
    // if (temp < $('body').height()) {
    //     $('.bottom-content').css('position','absolute');
    // } else {
    //     $('.bottom-content').css('position','relative');
    //     // $('.container-fluid .navbar-nav').addClass('in');
    // }
}

function menuController() {
    if ($(window).width() < 680) {
        var temp = Math.floor(($('.container-fluid').width()+10) / 110);
        $('#menu>li').css('width', ($('.container-fluid').width()+10)/temp);
    } else {
        $('#menu>li').css('width', 'auto');
    }
}

function setNextItem(item_of_table,show_index) {
	if(typeof item_of_table =='undefined')
		item_of_table="tbody tr";
	if(typeof show_index =='undefined')
		show_index=0;
    listItem = $(selectedTab + " table " + item_of_table +":visible");
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
    $("html, body").animate({scrollTop: $('.change-content').offset().top}, 100);
    return nextItem.attr("id");
}

function setPreviousItem(item_of_table,show_index) {
	if(typeof item_of_table =='undefined')
		item_of_table="tbody tr";
	if(typeof show_index =='undefined')
		show_index=0;
    listItem = $(selectedTab + " table " + item_of_table+":visible");
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
    $("html, body").animate({scrollTop: $('.change-content').offset().top}, 100);
    return nextItem.attr("id");
}

function selectItem(selectItem,tab) {
    if(typeof tab =='undefined'){
        tab ='';
    }
    currentSelectItem = $(tab+" .activeItem");
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

function rememberItem(tr_Element, btn_label ,item_infor,callback) {
    data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/remembervoc',
        dataType: 'json',
        loading:true,
        container:tr_Element,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var cloneTr = tr_Element.clone();
                    cloneTr.removeClass('activeItem');
                    cloneTr.find("button").removeClass("btn-remember");
                    cloneTr.find("button").addClass("btn-forget");
                    cloneTr.find("button").text(btn_label);
                    tr_Element.addClass('animated fadeOutRight');
                    tr_Element.delay(0).fadeOut(120, function(){
                        tr_Element.remove();
                        if (selectedTab == "#tab1") {
                            if($("#tab1 table tbody tr:visible").length==0){
                                $("#tab1 table tbody .no-row").removeClass('hidden').addClass('activeItem');
                            }
                            $("#tab2 table tbody .no-row").addClass('hidden').removeClass('activeItem');
                            $("#tab2 table tbody").prepend(cloneTr);
                        } else {
                            if($("#tab2 table tbody tr:visible").length==0){
                                $("#tab2 table tbody tr:last-child").removeClass('hidden').addClass('activeItem');
                            }
                            $("#tab1 table tbody .no-row").addClass('hidden').removeClass('activeItem');
                            $("#tab1 table tbody").prepend(cloneTr);
                        }
                    });
                    callback();
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function forgetItem(tr_Element, btn_label ,item_infor,callback) {
    data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/forgetvoc',
        dataType: 'json',
        loading:true,
        container:tr_Element,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var cloneTr = tr_Element.clone();
                    cloneTr.removeClass('activeItem');
                    cloneTr.find("button").addClass("btn-remember");
                    cloneTr.find("button").removeClass("btn-forget");
                    cloneTr.find("button").text(btn_label);
                    tr_Element.addClass('animated fadeOutRight');
                    tr_Element.delay(0).fadeOut(120, function(){
                        tr_Element.remove();
                         if (selectedTab == "#tab1") {
                            if($("#tab1 table tbody tr:visible").length==0){
                                $("#tab1 table tbody .no-row").removeClass('hidden').addClass('activeItem');
                            }
                            $("#tab2 table tbody .no-row").addClass('hidden').removeClass('activeItem');
                            $("#tab2 table tbody").prepend(cloneTr);
                        } else {
                            if($("#tab2 table tbody tr:visible").length==0){
                                $("#tab2 table tbody tr:last-child").removeClass('hidden').addClass('activeItem');
                            }
                            $("#tab1 table tbody .no-row").addClass('hidden').removeClass('activeItem');
                            $("#tab1 table tbody").prepend(cloneTr);
                        }
                    });
                   
                    callback();
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
    
}

function addLesson(screen_div, catalogue_nm , group_nm) {
    var data=[];
    data.push(screen_div);
    data.push(catalogue_nm);
    data.push(group_nm);
    $.ajax({
        type: 'POST',
        url: '/common/addLesson',
        dataType: 'json',
        loading:true,
        container:'.btn-add-lesson',
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.table-click tbody tr').remove();
                    for(i=0;i<res.data.length;i++){
                        if(catalogue_nm==res.data[i].item_1 && group_nm==res.data[i].item_2){
                            $('.table-click tbody').append('<tr class="selected-row"></tr>');
                        }else{
                            $('.table-click tbody').append('<tr></tr>');
                        }
                        $('.table-click tbody tr:last-child').append('<td></td><td></td><td></td><td></td>');
                        $('.table-click tbody tr:last-child td:nth-child(1)').html('<input type="hidden" class="lesson-id"/><i class="glyphicon glyphicon-hand-right"></i>');
                        $('.table-click tbody tr:last-child td:nth-child(1) .lesson-id').attr('value',res.data[i].id);
                        $('.table-click tbody tr:last-child td:nth-child(2)').text(res.data[i].catalogue_nm);
                        $('.table-click tbody tr:last-child td:nth-child(3)').text(res.data[i].group_nm);
                        $('.table-click tbody tr:last-child td:nth-child(4)').html('<button type="button" class="btn-danger btn-del-lesson"><span class="fa fa-close"></span></button>');
                    }
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function deleteLesson(lession_row){
    var data=[];
    data.push(lession_row.find('.lesson-id').attr('value'));
    $.ajax({
        type: 'POST',
        url: '/common/deleteLesson',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    lession_row.delay(0).fadeOut(500, function(){
                        if(lession_row.next().length != 0){
                            lession_row.next().addClass('selected-row');
                            lession_row.next().trigger('dblclick');
                        }else {
                            if(lession_row.prev().length != 0){
                            lession_row.prev().addClass('selected-row');
                            lession_row.prev().trigger('dblclick');
                            }else{
                                lession_row.parent().append('<tr class="no-data"><td><i class="glyphicon glyphicon-hand-right"></i></td><td colspan="3">Bạn chưa đăng nhập hoặc chưa đăng ký mục nào</td></tr>');
                                $('.btn-add-lesson').removeAttr('disabled');
                            }
                        }
                        lession_row.remove();
                    });
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getExample(page,item_infor,callback){
    var data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/getExample',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data) ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('#example-list .example-item:visible').remove();
                    $('#example-list .panel-contribute').remove();
                    $('#example-list').prepend(res.view1);
                    $('.paging-list .paging-item:visible').remove();
                    $('.paging-list').prepend(res.view2);
                    callback();
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function addExample(item_infor,callback){
    var data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/addExample',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    callback();
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function addReport(item_infor,callback){
    var data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/addReport',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    callback();
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function toggleEffect(item_infor,callback){
    var data=item_infor;
    $.ajax({
        type: 'POST',
        url: '/common/toggleEffect',
        dataType: 'json',
        // loading:true,
        data:$.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    callback(res.data[0]['effected_count']);
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function setCollapse() {
    if ($(window).width() < 1025) {
        $('.close-when-small').removeClass('in');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").html('');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-up" style="float: right;margin-right:2px;"></i');
    } else {
        $('.close-when-small').prev('.left-header').find(".collapse-icon").html('');
        $('.close-when-small').prev('.left-header').find(".collapse-icon").append('<i class="glyphicon glyphicon-menu-down" style="float: right;margin-right:2px;"></i');
        $('.close-when-small').addClass('in');
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
        var item_height=$('.right-tab .tab-content table tbody:visible').first().height();
    }else{
        var item_height=$('.right-tab .tab-content table tbody tr:visible').first().height();
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
        $('.right-tab .tab-content').height((number_of_item-1)*item_height);
    }

    $('.right-tab .tab-content').css('display','block');
}

function addComment(btn_comment,item_infor,callback){
    $.ajax({
        type: 'POST',
        url: '/common/addcomment',
        loading:true,
        container:btn_comment,
        dataType: 'json',
        data: $.extend({}, item_infor),
        success: function (res) {
            switch(res.status){
                case 200:
                    if(btn_comment.closest('.input-group').hasClass('comment-input')){
                        btn_comment.closest('.input-group').prev().append(res.view);
                    }else{
                        btn_comment.closest('.actionBox').find('.commentList').first().append(res.view);
                    }
                    btn_comment.parent().prev().val('');
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (res) {
        }
    });
}

function loadMoreComment(btn_load_more,item_infor,callback){
    $.ajax({
        type: 'POST',
        url: '/common/loadMoreComment',
        loading:true,
        container:btn_load_more,
        dataType: 'json',
        data: $.extend({}, item_infor),
        success: function (res) {
            switch(res.status){
                case 200:
                    if(btn_load_more.hasClass('prev')){
                        btn_load_more.next().html(res.view);
                    }else{
                        btn_load_more.prev().prev().html(res.view);
                    }
                    if(res.data[0]['page_prev']==0){
                        btn_load_more.parent().find('.load-more.prev').addClass('hidden');
                    }else{
                        btn_load_more.parent().find('.load-more.prev').removeClass('hidden');
                        btn_load_more.parent().find('.load-more.prev').attr('page',res.data[0]['page_prev']);
                    }
                    console.log(btn_load_more.parent());
                    if(res.data[0]['page_next']==0){
                        btn_load_more.parent().find('.load-more.next').addClass('hidden');
                    }else{
                        btn_load_more.parent().find('.load-more.next').removeClass('hidden');
                        btn_load_more.parent().find('.load-more.next').attr('page',res.data[0]['page_next']);
                    }
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (res) {
        }
    });
}

function getComment(item_infor,callback){
    $.ajax({
        type: 'POST',
        url: '/common/getcomment',
        loading:true,
        container:'.commentbox .right-header',
        dataType: 'json',
        data: $.extend({}, item_infor),
        success: function (res) {
            $('.commentList:first .commentItem:visible').remove();
            $('.commentList:first').prepend(res.view1);
            $('.paging-list .paging-item:visible').remove();
            $('.paging-list').prepend(res.view2);
            // callback();
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
    table.find('tbody > tr:not(.hidden)').each(function(i) {
        $(this).find('td:not(.hidden)').first().text(i+1);
    });
}

function checkLogin(username){
    var data={};
        data['account_nm']=$('#account_nm').val();
        data['password']=$('#password').val();
        data['remember']=$('#remember').val();
    $.ajax({
        type: 'POST',
        url: '/master/checkLogin',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    window.location.reload();
                    break;
                case 201:
                    // alert('lỗi validate');
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                case 202:
                    // alert('sai tên đăng nhập hoặc mật khẩu');
                    $.each( $('#account_nm,#password'), function( key) {
                      $(this).addClass('input-error');
                      $(this).attr('data-toggle','tooltip');
                      $(this).attr('data-placement','top');
                      $(this).attr('data-original-title','sai tên đăng nhập hoặc mật khẩu');
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                    $('#account_nm,#password').first().focus();
                    break;
                 case 203:
                    var counter = parseInt(res.seconds);
                    $('.login-message').removeClass('hidden');
                    $('.login-message').html("Tài khoản đã bị khóa <span class='countdown'>"+counter+"</span>s do đăng nhập sai quá nhiều lần");
                    if(counter==60||typeof interval==='undefined'){
                        var interval = setInterval(function() {
                        counter--;
                        // Display 'counter' wherever you want to display it.
                        $('.login-message .countdown').text(counter);
                        if (counter == 0) {
                            // Display a login box
                            $('.login-message').addClass('hidden');
                            clearInterval(interval);
                        }
                    }, 1000);
                    }
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
             $.sweetModal({
            title:'thao tác thất bại',
            content: 'Phát sinh lỗi hệ thống không thể đăng nhập!!!',
            icon: $.sweetModal.ICON_ERROR,
            buttons: [
                {
                    label: 'Đã hiểu',
                    classes: 'btn btn-sm btn-danger',
                },
            ]
        });
        }
    });
}

function showFailedValidate(error_array){
    $.each( error_array, function( key, value ) {
      $('#'+key).addClass('input-error');
      $('#'+key).attr('data-toggle','tooltip');
      $('#'+key).attr('data-placement','top');
      $('#'+key).attr('data-original-title',value);
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('.input-error').first().focus(); 
}

function showFailedData(error_array){
    for (var i = 0; i < error_array.length; i++) {
        if(error_array[i]['Id']==0){
            var target=$('#'+error_array[i]['Data']);
        }else if(error_array[i]['Id']==1){
            var target=$('.'+error_array[i]['Data']+' tbody tr:visible').eq(error_array[i]['Message']);
        }else{
            showMessage(Number(error_array[i]['Code']));
            return;
        }
        if(target.prop("tagName") == 'SELECT' && target.hasClass('allow-selectize')){
            target=target.next('.selectize-control').find('.selectize-input');
        }
        target.addClass('input-error');
        target.attr('data-toggle','tooltip');
        target.attr('data-placement','top');
        target.attr('data-original-title',_text[error_array[i]['Code']]);
    }
    $('[data-toggle="tooltip"]').tooltip();
    if($('.input-error').first().hasClass('selectize-input')){
        $('.input-error').first().parent().prev('select')[0].selectize.focus();
    }else
    $('.input-error').first().focus(); 
}

function clearFailedValidate(){
    $('input:not([readonly],[disabled],:hidden)').each(function(){
        $(this).removeClass('input-error');
        $(this).removeAttr('data-toggle');
        $(this).removeAttr('data-placement');
        $(this).removeAttr('data-original-title');
    })
}

function logout(username){
    $.ajax({
        type: 'POST',
        url: '/master/logout',
        dataType: 'json',
        loading:true,
        data: {
            username:username,
        },
        success: function (res) {
            switch(res.status){
                case 200:
                    window.location.reload();
                    break;
                case 208:
                    alert('lỗi hệ thống');
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function checkError(){
    switch($('#check-error').val()){
        case '206':
            showMessage(9);
            break;
    }
}

function keepTokenAlive() {
    $.ajax({
        url: '/keep-token-alive', //https://stackoverflow.com/q/31449434/470749
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).then(function (result) {
        // console.log(new Date() + ' ' + result + ' ' + $('meta[name="csrf-token"]').attr('content'));
    });
}

function showMessage(message_code,ok_callback,cancel_callback){
    switch(typeof _type!='undefined'?_type[message_code]:parent._type[message_code]){
        case 1:
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?_text[message_code]:parent._text[message_code],
            icon: $.sweetModal.ICON_CONFIRM,
            buttons: [
                {
                    label: 'Đồng ý',
                    classes: 'btn btn-sm btn-info float-left',
                    action: ok_callback,
                },
                {
                    label: 'Từ chối',
                    classes: 'btn btn-sm btn-default float-right',
                    action: cancel_callback,
                }
            ]
        });
        break;
        case 2:
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?_text[message_code]:parent._text[message_code],
            icon: $.sweetModal.ICON_SUCCESS,
            buttons: [
                {
                    label: 'Ok',
                    classes: 'btn btn-sm btn-success',
                    action: ok_callback,
                },
            ]
        });
        break; 
        case 3:
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?_text[message_code]:parent._text[message_code],
            icon: $.sweetModal.ICON_WARNING,
            buttons: [
                {
                    label: 'Thực hiện',
                    classes: 'btn btn-sm btn-warning float-left',
                    action: ok_callback,
                },
                {
                    label: 'Hủy',
                    classes: 'btn btn-sm btn-default float-right',
                    action: cancel_callback,
                }
            ]
        });
        break; 
        case 4:
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?_text[message_code]:parent._text[message_code],
            icon: $.sweetModal.ICON_ERROR,
            buttons: [
                {
                    label: 'Đã hiểu',
                    classes: 'btn btn-sm btn-danger',
                },
            ]
        });
        break;  
    }
}

function switchTab(tab_number){
    $('.right-tab ul li').removeClass('active');
    $('.right-tab ul li a').attr('aria-expanded',false);
    $('.right-tab .tab-content .tab-pane').removeClass('active in');
    $('.right-tab ul li:nth-child('+tab_number+')').addClass('active');
    $('.right-tab ul li:nth-child('+tab_number+') a').attr('aria-expanded',true);
    $('.right-tab .tab-content #tab'+tab_number).addClass('active in');
    selectedTab = "#tab"+tab_number;
}

function getInputData(){
    var data={};
    var value;
    $(document).find('input.submit-item,select.submit-item,textarea.submit-item').each(function(){
        if($(this).hasClass('ckeditor')){
            value=CKEDITOR.instances[$(this).attr('id')].getData()
        }else
        if($(this).hasClass('money')){
            var text = jQuery.grep($(this).val().split(','), function(item) {
              return item;
            });
            value=text.join('');
        }else
        if($(this).hasClass('tel')){
            var text = jQuery.grep($(this).val().split('-'), function(item) {
              return item;
            });
            value=text.join('');
        }else{
            if($(this).val()===null){
                value='';
            }else{
                value=$(this).val();
                if(!$.isArray([value]) || $(this).attr('id')!='post_tag'){
                    value = value.trim();
                }else{
                    value = $.map(value, function(val){
                        if(val.indexOf('**++**eplus')!=-1){
                            return {'tag_nm':val.split('**++**eplus')[0],'is_new':1};
                        }else{
                            return {'tag_id':val,'is_new':0};
                        }
                    });
                }
                if($(this).hasClass('input-refer')){
                    value=$(this).val().split('_')[0];
                }
            }
        }
        data[$(this).attr('id').trim()]=value;
    })
    return data;
}

function throttle(f, delay){
    var timer = null;
    return function(){
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = window.setTimeout(function(){
            f.apply(context, args);
        },
        delay || 500);
    };
}

function sticky(){
    var sticky_postion = $('.change-content:not(.no-fixed)').offset().top;
      if (sticky_postion-$(window).scrollTop() < 0) {
        $('.right-header:not(.no-fixed)').first().addClass('sticky col-lg-9 col-xs-12');
        $('.change-content .temp').removeClass('hidden');
      }else{
        $('.change-content .temp').addClass('hidden');
        $('.right-header:not(.no-fixed)').first().removeClass('sticky col-lg-9 col-xs-12');
      }
}