var selectedTab = "#tab1";
var _pageSize=50;
var _selectize;
var _data_delete=[];
var _data_edit=[];
var cropperBox;
var _character=[81, 231, 69, 82, 84, 89, 85, 73, 79, 80, 65, 83, 68, 70, 71, 72, 74, 75, 76, 90, 88, 67, 86, 66, 78, 77,32,188, 190, 191, 226, 187, 186, 221, 192, 219, 111, 106, 109, 107, 110, 220, 222, 189,87];
var _number=[49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];

$(function() {
    try {
        initCommonMaster();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initCommonMaster() {
    $(document).ajaxComplete(function (evt, jqXHR, settings) {
        if (settings.loading) {
            if(settings.container){
                $(settings.container).LoadingOverlay("hide");
            }else{
                $.LoadingOverlay("hide");
            }
        }
        if(typeof jqXHR.responseJSON!='undefined'&&jqXHR.responseJSON.status==204){
            window.location.href='/master';
        }

        if(typeof jqXHR.responseJSON!='undefined'&&jqXHR.responseJSON.status==205){
            window.location.href='/master';
        }
        $('.table-fixed-width table').each(function(){
            $(this).css('min-width',$(this).parent().attr('min-width'));
        })
        // $('.table-focus tbody tr').first().addClass('active-row');
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
    initEvent();
    setLayout();
    menuController();
    $("#dtBox").DateTimePicker();
    $('.table-fixed-width table').each(function(){
        $(this).css('min-width',$(this).parent().attr('min-width'))
    });
    $(".input-image").fileinput({
        browseIcon : "<i class=\"glyphicon glyphicon-picture\"></i> ",
        browseLabel : "Duyệt ảnh",
        allowedFileTypes:['image'],
        showFileFooterCaption:false,
        previewClass: 'no-footer-caption',
    });
    $(".input-audio").fileinput({
        browseIcon : "<i class=\"glyphicon glyphicon-headphones\"></i> ",
        browseLabel : "Duyệt audio",
        allowedFileTypes:['audio'],
        showFileFooterCaption:true,
    });
    if($('.file-caption').parents('.file-subitem').hasClass('required')){
        $('.file-caption').addClass('required');
    }
    $("select:not('.allow-selectize,.custom-selectized')").addClass("form-control input-sm");
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        _selectize=$("select.allow-selectize:not([class*='new-allow'])").selectize({
            allowEmptyOption: true,
            create: false,
            openOnFocus: false,
            onInitialize: function () {
                this.clear();
            }
        });

        _selectize=$("select.allow-selectize.new-allow").selectize({
            allowEmptyOption: true,
            create: true,
            openOnFocus: false,
            isDisabled: true,
            onInitialize: function () {
                this.clear();
            }
        });
    }else{
        $("select:not('.custom-selectized')").addClass("form-control input-sm");
    }
    $('select.required').prev('label').addClass('required');
    $('input.required,textarea.required').parent().prev('label').addClass('required');

    $('.link-div').each(function(){
        $('#btn-manager a').attr('href',$(this).attr('btn-manager-page-link'));
        $('#btn-add-page a').attr('href',$(this).attr('btn-add-page-link'));
    })
    if($(window).width() < 550){
        $('.menu-btn').css('display','inline-block');
    }else{
        $('.menu-btn').css('display','none');
    }
    $(".ckeditor").each(function(){
        try{
          CKEDITOR.replace($(this).attr('name'),{language:"vi"});  
        }catch(e){

        }
    })
    $(":input:not([readonly],[disabled],:hidden)").first().focus();
    setInterval(keepTokenAlive, 1000 * 60*100); // every 100 mins
    checkError();
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
    $('.top-header,.popup-header').sizeChanged(function() {
        setLayout();
    })

    $('.menu-btn-list').sizeChanged(function() {
        setLayout();
    })

    $('.middle-content').sizeChanged(function() {
        setFooter();
    })

    $(window).resize(function(){
        if ($(window).width() >550) {
            if(!$('#menu').hasClass('in')){
               $('#menu').addClass('in'); 
            }
        }else{
            if($('.menu-btn-list ul').height()==0)
                $('#menu').removeClass('in'); 
        }
        menuController();
        if($(window).width() < 550){
            $('.menu-btn').css('display','inline-block');
        }else{
            $('.menu-btn').css('display','none');
        }
        setFooter();
        $('.table-fixed-width table').each(function(){
            $(this).css('min-width',$(this).parent().attr('min-width'))
        });
    })
    $(document).on('change','.super-checkbox',function(){
        setCheckBox(this);
        
    })
    $(document).on('change','.sub-checkbox',function(){
        var _this=$(this);
        if(typeof _this.attr('group')=='undefined'){
            if($('.sub-checkbox:visible').not(':checked').length!=0){
                $('.super-checkbox').prop('checked',false);
            }else{
                $('.super-checkbox').prop('checked',true);
            }
        }else if(this.checked){
            var temp=Number($(this).attr('group'));
            if(temp>100){
                var sub_item=$('.sub-checkbox').filter(function(){
                    return parseInt($(this).not(':checked').attr('group')/10)===parseInt(_this.attr('group')/10);
                })
                if(sub_item.length==0){
                    $(".super-checkbox[group="+parseInt(temp/10)+"]").prop('checked',true);
                    sub_item=$('.sub-checkbox').filter(function(){
                        return parseInt($(this).not(':checked').attr('group')/100)===parseInt(_this.attr('group')/100);
                    })
                    if(sub_item.length==0){
                        $(".super-checkbox[group="+parseInt(temp/100)+"]").prop('checked',true);
                    }
                }
            }else if(temp>10){
                 var sub_item=$('.sub-checkbox').filter(function(){
                    return parseInt($(this).not(':checked').attr('group')/10)===parseInt(_this.attr('group')/10);
                })
                if(sub_item.length==0){
                    $(".super-checkbox[group="+parseInt(temp/10)+"]").prop('checked',true);
                }
            }
        }else{
            var temp=Number($(this).attr('group'));
            if(temp>100){
                $(".super-checkbox[group="+parseInt(temp/100)+"]").prop('checked',false);
                 $(".super-checkbox[group="+parseInt(temp/10)+"]").prop('checked',false);
            }else
            if(temp>10){
                 $(".super-checkbox[group="+parseInt(temp/10)+"]").prop('checked',false);
            }
        }
    })

    $(document).on('click','#btn-cancel',function(){
        location.reload();
    })

    $(document).on('click','#btn_login',function(){
        checkLogin('Quy Nguyen');
    })

    $(document).on('click','#btn-logout',function(){
        logout('Quy Nguyen');
    })

    $(document).on('focus','.input-refer',function(){
        if($(this).val()!==''){
            $(this).val($(this).val().split('_')[0]);
        }
    })

     $(document).on('blur','.input-refer',function(){
        if($(this).val()!==''){
            refer_value($(this));
        }
    })
    //  $(document).on('click','.btn-popup',function(){
    //     loadPopup('p001');
    // })

     $(".btn-popup").fancybox({
        'width'         : '80%',
        'height'        : '80%',
        'autoScale'     : true,
        'transitionIn'  : 'none',
        'transitionOut' : 'none',
        'type'          : 'iframe'
    });

    $(document).on('click','.table-checkbox tr td',function(){
        if($(this).find('input[type=checkbox]').length==0){
            checkbox=$(this).parent().find('input.sub-checkbox');
            if(checkbox.is(':checked')){
                checkbox.prop('checked', false);
            }else{
                checkbox.prop('checked', true);
            }
            checkbox.trigger('change');
        }
    })

    // $(document).on('click','#btn-delete',function(){
    //    showMessage(3,function(){
    //         $('.sub-checkbox:checked').closest('tr').remove();
    //    });
    // })

    $(document).on('click','.delete-tr-row',function(){
        tableTemp=$(this).parents('table');
        $(this).closest('tr').remove();
        reIndex(tableTemp);
    })

    $(document).on('refer-image','.update-block #avarta',function(){
        $('#imageContainer').attr('style', 'background-image: url("' + $(this).val() +'")');
    })

    $(document).on('click','#btn-new-row',function(){
        $(this).parents('table').find('tbody').append("<tr></tr>");
        $(this).parents('table').find('tbody tr:last-child').append($(this).parents('table').find('tbody tr:first').html());
        reIndex($(this).parents('table'));
    })

    // $(document).on('click','#btn-add',function(){
    //     $('.table-new-row tbody').append("<tr></tr>");
    //     $('.table-new-row tbody tr:last-child').append($('.table-new-row tbody tr:first').html());
    //     reIndex($('.table-new-row'));
    // })

    $(document).on('dblclick','.table-focus tbody tr',function(){
        clearUpdateBlock();
        $(this).find('td[refer-id]').each(function(){
            _this=$(this);
            var temp=$('.update-block #'+$(this).attr('refer-id'));
            if(temp.prop('tagName')!=='SELECT'){
                temp.val($(this).text());
                if(temp.attr('id')=='avarta'){
                    temp.trigger('refer-image');
                }
            }else{
                if(temp.hasClass('allow-selectize')){
                    var selectize_temp=temp[0].selectize;
                    selectize_temp.setValue(selectize_temp.getValueByText(_this.text()));
                }else{
                    temp.find("option").prop("selected", false);
                    temp.find("option").filter(function() {
                        return this.innerHTML.trim() == _this.text().trim();
                    }).prop("selected", true);
                }
            }
        })
        $('.table-focus tbody tr.update-row').removeClass('update-row');
        $('.table-focus tbody tr.active-row').addClass('update-row');
    })

    $(document).on('click','#btn-change-pass',function(){
        if($('.table-focus tbody tr.update-row').length!=0){
            showMessage(8,function(){
                changePassword();
           });
        }
    })
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $(document).on('doubletap','.table-focus tbody tr.active-row',function(e){
            $('.table-focus tbody tr.active-row').trigger('dblclick');
        })
    }

    $(document).on('click','.table-focus tbody tr',function(){
        updateInput=$('.update-content').find('input,textarea,select');
        if($(this).hasClass('active-row')){
            return;
        }
        $('.table-focus tbody tr.active-row').removeClass('active-row');
        $(this).addClass('active-row');
    })

     $(document).on('click','.edit-save',function(e){
        if($('.table-focus tbody tr.update-row').length!=0){
            checkValidate();
        }
    })

    $(document).on('input propertychange paste change','.submit-item',function(){
        $('.identity-item').val('');
    })

    $(document).on('click', '.btn-popup', function(e) {
        e.preventDefault();
        var popupId=$(this).attr('popup-id');
        $('#'+popupId).modal('show')
    })

    $(document).on('click','#btn-role',function(){
        text_role='';
        checked_role=$(this).parents('.modal-content').find('input[type=checkbox]:checked');
        checked_role.each(function(){
            text_role+=$(this).val();
        })
        $('.table-focus tbody tr.active-row .update-role').text(text_role);
        $('#'+$(this).parents('.modal').attr('id')).modal('hide')
        
    })

    $(document).on('keydown',function(e){
        switch(e.which){
            case 13 :
                e.preventDefault();
                $('#btn_login').trigger('click');
                if($('.fancybox-opened').length!=0)
                $('#btn-list').trigger('click');
                break;
            case 38 :
                e.preventDefault();
                prevRow($('.table-focus tbody'));
                break;
            case 40 :
                if(e.ctrlKey){
                    e.preventDefault();
                    $('.table-focus tbody tr.active-row').trigger('dblclick');
                    break;
                }
                e.preventDefault();
                nextRow($('.table-focus tbody'));
                break;
            default:
                break;
        }
    })

    $(document).on('blur','input',function (e) {
        if($(this).hasClass('money')){
            var value=$(this).val().split('.');
            var valueLength = value[0].length;
            for(var i=valueLength-3;i>0;i=i-3){
                value[0]=value[0].substr(0, i) + ',' + value[0].substr(i);
            }
            if(typeof value[1] !='undefined')
                $(this).val(value[0]+'.'+value[1]);
            else
                $(this).val(value[0]);
        }else
        if($(this).hasClass('tel')){
            var value=$(this).val();
            var valueLength = value.length;
            if(valueLength<12&&valueLength>8){
                for(var i=valueLength-3;i>=3;i=i-3){
                    value=value.substr(0, i) + '-' + value.substr(i);
                }
            }else{
                value='';
            }
            $(this).val(value);
        }else
        if($(e.target).hasClass('numberic')){
            // if(e.shiftKey){
            //     if($.inArray(e.which,character)>=0||$.inArray(e.which,number)>=0){
            //         e.preventDefault();
            //     }
            // }else{
            //     if($.inArray(e.which,character)>=0){
            //         e.preventDefault();
            //     }
            // }
        }
        // special_char.push(e.which);
        // console.log(special_char);
    })

    $(document).on('focus','input',function (e) {
        if($(this).hasClass('money')){
            var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
            $(this).val(text.join(''));
        }else
        if($(this).hasClass('tel')){
            var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
            $(this).val(text.join(''));
        }else
        if($(e.target).hasClass('numberic')){
            // if(e.shiftKey){
            //     if($.inArray(e.which,character)>=0||$.inArray(e.which,number)>=0){
            //         e.preventDefault();
            //     }
            // }else{
            //     if($.inArray(e.which,character)>=0){
            //         e.preventDefault();
            //     }
            // }
        }
        // special_char.push(e.which);
        // console.log(special_char);
    })
}

function setLayout(){
    $('.change-content').css('padding-top',$('.menu-btn-list').height()+50);
    $('.change-content-popup').css('padding-top',$('.popup-header .menu-btn-list').height()+7);
}

function menuController() {
    try{
        if ($(window).width() < 680) {
            var temp = Math.floor((90 / $('.menu-btn-list').width()) * 100);
            $('#menu>li').css('width', temp + '%');
        } else {
            $('#menu>li').css('width', '100px');
        }

        if ($(window).width() < 680) {
            $('.navbar-right').width('100%');
        }else{
            $('.navbar-right').width('auto');
        }
    }catch(e){
        alert('menuController:'+ e);
    }
    
}


function reIndex(table)
{
    var tab=0;
    var col=2;
    if(table.find('input[type=checkbox]').length==0){
        col=1;
    }
    table.find('tbody > tr:visible').each(function(i) {
        $(this).find('td:nth-child('+col+')').html('').html(i+1);
        
    });
}
function nextRow(tr_list){
    current_row=tr_list.find('.active-row');
    if(!tr_list.find('tr:last-child').hasClass('active-row')){
        current_row.next().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:first').addClass('active-row');
        current_row.removeClass('active-row');
    }

}

function prevRow(tr_list){
    current_row=tr_list.find('.active-row');
    if(!tr_list.find('tr:first').hasClass('active-row')){
        current_row.prev().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:last-child').addClass('active-row');
        current_row.removeClass('active-row');
    }
}

function setFooter() {
    var temp = $('.header-content').height() + $('.middle-content').height() + $('.bottom-content').height()+10;
    if (temp < $('body').height()) {
        $('.bottom-content').css('position','absolute');
    } else {
        $('.bottom-content').css('position','relative');
    }
    $('.bottom-content').removeClass('hidden');
}

function changePassword(){
    var user_id=$('#account_id').val();
    $.ajax({
        type: 'POST',
        url: '/master/common/changepass',
        dataType: 'json',
        loading:true,
        data: {
            user_id:user_id,
        },
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(7);
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

function showMessage(message_code,ok_callback,cancel_callback){
    switch(_type[message_code]){
        case 1:
           $.sweetModal({
            title:_title[message_code],
            content: _text[message_code],
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
            title:_title[message_code],
            content: _text[message_code],
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
            title:_title[message_code],
            content: _text[message_code],
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
            title:_title[message_code],
            content: _text[message_code],
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

function checkLogin(username){
    var data={};
        data['account_nm']=$('#account_nm').val();
        data['password']=$('#password').val();
        data['remember']=$('#remember').prop('checked');
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
                    $.each( $('input'), function( key) {
                      $(this).addClass('input-error');
                      $(this).attr('data-toggle','tooltip');
                      $(this).attr('data-placement','top');
                      $(this).attr('data-original-title','sai tên đăng nhập hoặc mật khẩu');
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                    $('input').first().focus();
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

function showFailedValidate(error_array,exe_mode){
    var parent_div='.update-block';
    if(exe_mode===1)
        parent_div='.search-block';
    $.each( error_array, function( key, value ) {
        if(key.includes('.')){
            var target=$(parent_div+' table tbody tr:visible').eq(Number(key.split('.')[0])).find('#'+key.split('.')[1]);
        }else
        var target=$(parent_div).find('#'+key);
        if(target.prop("tagName") == 'SELECT' && target.hasClass('allow-selectize')||target.hasClass('custom-selectized')){
            target=target.next('.selectize-control').find('.selectize-input');
        }
      target.addClass('input-error');
      target.attr('data-toggle','tooltip');
      target.attr('data-placement','top');
      target.attr('data-original-title',value);
    });
    $('[data-toggle="tooltip"]').tooltip();
    if($('.input-error').first().hasClass('selectize-input')){
        $('.input-error').first().parent().prev('select')[0].selectize.focus();
    }else
    $('.input-error').first().focus(); 
}

function showFailedData(error_array,exe_mode){
    var parent_div='.update-block';
    if(exe_mode===1)
        parent_div='.search-block';
    for (var i = 0; i < error_array.length; i++) {
        var target=$(parent_div).find('#'+error_array[i]['Data']);
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
    $('input:not([readonly],[disabled],:hidden),.selectize-input').each(function(){
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

function setCheckBox(super_checkbox){
    if(super_checkbox.checked){
        if(typeof $(super_checkbox).attr('group')=='undefined'){
            $('.sub-checkbox').prop('checked', true);
        }else{
            var temp=Number($(super_checkbox).attr('group'));
            $(".sub-checkbox").each(function(){
                if(parseInt(Number($(this).attr('group'))/100)==temp||parseInt(Number($(this).attr('group'))/10)==temp){
                    $(this).prop('checked', true);
                }
            });
        }
    }else{
        if(typeof $(super_checkbox).attr('group')=='undefined'){
            $('.sub-checkbox').prop('checked', false);
        }else{
            var temp=Number($(super_checkbox).attr('group'));
            $(".sub-checkbox").each(function(){
                if(parseInt(Number($(this).attr('group'))/100)==temp||parseInt(Number($(this).attr('group'))/10)==temp){
                    $(this).prop('checked', false);

                }
            });
        }
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

function getInputData(exe_mode){
    var data={};
    var value;
    var parent_div='.search-block';
    if(exe_mode===1)
        parent_div='.update-block';
    $(parent_div).find('input.submit-item,select.submit-item,textarea.submit-item').each(function(){
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
                value=$(this).val().trim();
                if($(this).hasClass('input-refer')){
                    value=$(this).val().split('_')[0];
                }
            }
        }
        data[$(this).attr('id').trim()]=value;
    })
    return data;
}

function getTableData(table){
    var data=[];
    table.find('tbody tr:visible').each(function(){
        var row_data={};
        $(this).find('input,select').each(function(){
            if($(this).hasClass('money')){
                var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
                row_data[$(this).attr('id')]=text.join('');
            }else
            if($(this).hasClass('tel')){
                var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
                row_data[$(this).attr('id')]=text.join('');
            }else{
                row_data[$(this).attr('id')]=$(this).val();
            }
        })
        data.push(row_data);
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function loadPopup(screen_name){
    $(".btn-popup").fancybox({
        'width'         : '75%',
        'height'        : '75%',
        'autoScale'     : false,
        'transitionIn'  : 'none',
        'transitionOut' : 'none',
        'type'          : 'iframe'
    });
}

function clearDataSearch(){
    $('input.submit-item,select.submit-item').val('');
    $('#result table tbody').html('<tr><td colspan="7">Xin nhập điều kiện tìm kiếm</td></tr>');
    $('.paging').remove();
    $('input.submit-item,select.submit-item').first().focus();
}

function refer_value(input_refer){
    var data={};
    data['key']=input_refer.attr('data-refer');
    data['value']=input_refer.val();
    $.ajax({
        type: 'POST',
        url: '/master/common/refer',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function (res) {
            var temp='';
            for(x in res.refer_data[0][0]){
                temp+=res.refer_data[0][0][x]+"_";
            }
            temp=temp.substring(0,temp.length-1);
            if(temp==='_'){
                temp='';
                input_refer.focus();
            }
            input_refer.val(temp);
            input_refer.trigger('change');
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function addNewRecordRow(){
    var refer_id='';
    $('.table-new-row tbody tr:first td[refer-id]').each(function(){
        refer_id=$(this).attr('refer-id');
        if($('#'+refer_id).prop("tagName")!='SELECT'){
            $(this).text($('#'+refer_id).val());
        }else{
            $(this).text($('#'+refer_id +' option:selected').text());
        }
    })
    $('.table-new-row tbody').append("<tr></tr>");
    $('.table-new-row tbody tr:last-child').append($('.table-new-row tbody tr:first').html());
    reIndex($('.table-new-row'));
}

function initImageUpload(){
    var imageContainer = $('#imageContainer');
    var croppedOptions = {
        uploadUrl: '/master/common/upload-image',
        cropUrl: '/master/common/crop-image',
        cropData:{
            'width' : imageContainer.width(),
            'height': imageContainer.height()
        },
        onAfterImgCrop:function(){
            $('#avarta').val($('#imageContainer .croppedImg').attr('src'));
        },
    };
    cropperBox = new Croppic('imageContainer', croppedOptions);
}

function updateDeleteArray(checkbox){
    var item_id=$(checkbox).parent().next().next().text();
    var element = {};
    var notIn=-1;
    element.id=item_id;
    for(i=0;i<_data_delete.length;i++){
        if(JSON.stringify(_data_delete[i])===JSON.stringify(element)){
            notIn=i;
            break;
        }
    }
    if(checkbox.checked){
        if(notIn==-1){
            _data_delete[_data_delete.length]=element;
        }
    }else{
        if(notIn!==-1){
            _data_delete.splice(notIn,1);
        }
    }
}

function updateEditArray(){
    var element = {};
    var key_item={};
    var notIn=-1;
    $('.update-block .submit-item[id]').each(function(){
        if($(this).hasClass('input-refer')){
            element[$(this).attr('id')]=$(this).val().split('_')[0];
        }else{
            element[$(this).attr('id')]=$(this).val();
        }
    })
    $('.update-block .key-item[id]').each(function(){
        if($(this).hasClass('input-refer')){
            key_item[$(this).attr('id')]=$(this).val().split('_')[0];
        }else{
            key_item[$(this).attr('id')]=$(this).val();
        }
    })
    for(i=0;i<_data_edit.length;i++){
        for(check in key_item){
            if(key_item[check]==_data_edit[i][check]){
                continue;
            }
            notIn=0;
        }
        if(notIn==-1){
            notIn=i;
            break;
        }else{
            notIn=-1;
        }
    }
    if(notIn==-1){
        _data_edit[_data_edit.length]=element;
    }
    if(notIn!==-1){
        _data_edit.splice(notIn,1);
        _data_edit[_data_edit.length]=element;
    }
}

function clearUpdateBlock(){
    $('.update-block .submit-item[id]').each(function(){
        if($(this).prop("tagName")!='SELECT'){
            if($(this).attr('id')!='avarta'){
                $(this).val('');
            }else{
                $(this).val('/web-content/images/avarta/default_avarta.jpg');
            }
        }else{
            if($(this).hasClass('allow-selectize')){
                var selectize_temp=this.selectize;
                selectize_temp.setValue(0);
            }else{
                $(this).val(0);
            }
        }
    })
    if($('.cropControlRemoveCroppedImage:visible').length !=0)
        cropperBox.cropControlRemoveCroppedImage.trigger('click');
    $('#imageContainer').attr('style', 'background-image: url("/web-content/images/avarta/default_avarta.jpg")');
}

function checkValidate(){
    data=getInputData(1);
     $.ajax({
        type: 'POST',
        url: '/master/common/checkvalidate',
        dataType: 'json',
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.table-focus tbody tr.update-row td[refer-id]').each(function(){
                        var temp=$('.update-block #'+$(this).attr('refer-id'));
                        if(temp.prop('tagName')!=='SELECT'){
                            $(this).text(temp.val());
                        }else{
                            $(this).text(temp.find('option:selected').text());
                        }
                    })
                    $('.table-focus').find('.update-row td.edit-flag').addClass('edit-row');
                    $('.table-focus').find('.update-row td.edit-flag').text('Đã sửa');
                    break;
                case 201:
                    // alert('lỗi validate');
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                default :
                    break;
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
             $.sweetModal({
            title:'thao tác thất bại',
            content: 'Phát sinh lỗi hệ thống!!!',
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

function checkError(){
    switch($('#check-error').val()){
        case '209':
            showMessage(10);
            break;
        case '210':
            showMessage(11);
            break;
    }
}

document.addEventListener('keydown', function (e) {
    var character = _character;
    var number = _number;
    var dotIndex = 1000;
    if($(e.target).hasClass('money')){
        var decimal=Number($(e.target).attr('decimal'));
        if(e.shiftKey){
            if($.inArray(e.which,character)>=0||$.inArray(e.which,number)>=0){
                e.preventDefault();
            }
        }else{
            if(typeof $(e.target).attr('decimal')!='undefined' && $(e.target).val().indexOf('.')==-1){
                character = jQuery.grep(character, function(value) {
                  return value != 190 && value != 110;
                });
            }else{
                dotIndex=$(e.target).val().indexOf('.');
            }
            if(typeof $(e.target).attr('negative')!='undefined' && $(e.target).val().indexOf('-')==-1){
                 character = jQuery.grep(character, function(value) {
                  return value != 189 && value != 109;
                });
            }
            if($.inArray(e.which,character)>=0||($.inArray(e.which,number)>=0&&$(e.target).val().length>dotIndex+decimal)){
                e.preventDefault();
            }
        }
    }else
    if($(e.target).hasClass('numberic')){
        if(e.shiftKey){
            if($.inArray(e.which,character)>=0||$.inArray(e.which,number)>=0){
                e.preventDefault();
            }
        }else{
            if($.inArray(e.which,character)>=0){
                e.preventDefault();
            }
        }
    }
})




