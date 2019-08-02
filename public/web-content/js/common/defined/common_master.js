var selectedTab = "#tab1";
var _pageSize=50;
var _selectize;
var _data_delete=[];
var _data_edit=[];
var _page = 0;
var cropperBox;
var _popup_transfer_array=[];
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
        var result=[];
        if (settings.loading) {
            if(settings.container){
                $(settings.container).LoadingOverlay("hide");
            }else{
                $.LoadingOverlay("hide");
            }
        }
        try{
            result=$.parseJSON(jqXHR.responseText);
        }catch(e){

        }
        if(typeof result.status!='undefined'&& result.status==204){
            window.location.href='/master';
        }

        if(typeof result.status!='undefined'&& result.status==205){
            window.location.href='/master';
        }
        $('.table-fixed-width table').each(function(){
            $(this).css('min-width',$(this).parent().attr('min-width'));
        })

        // if(settings.url.split('/')[settings.url.split('/').length-1]=='list'){
        //     var param = parseQueryString(settings.data);
        //     history.pushState({}, null, window.location.href.split('?')[0]+'?p='+param.page);
        // }
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
    initFlugin();
    $('.table-fixed-width table').each(function(){
        $(this).css('min-width',$(this).parent().attr('min-width'))
    });
    if($('.file-caption').parents('.file-subitem').hasClass('required')){
        $('.file-caption').addClass('required');
    }
    $("select:not('.allow-selectize,.custom-selectized,.tag-selectize')").addClass("form-control input-sm");
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
    $(document).on('change','.super-all-checkbox',function(){
        var parent_group=$(this);
        var sub_item=$('.super-checkbox').filter(function(){
            return $(this).attr('group').substring(0,parent_group.attr('group').length)===parent_group.attr('group');
        })
        if(this.checked){
            sub_item.prop('checked',true);
        }else{
            sub_item.prop('checked',false);
        }
        sub_item.trigger('change');
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
        }else{
            var temp=$(this).attr('group');
            var parent_group=$(this).parents('tr').prevAll('.tr-header').first().find('td').eq($(this).parent().index()-1);
            var sub_item=$('.sub-checkbox').filter(function(){
                return $(this).attr('group').substring(0,parent_group.find('input').attr('group').length)===parent_group.find('input').attr('group')&&!$(this).prop('checked');
            })
            if(sub_item.length==0){
                parent_group.find('input').prop('checked',true);
                parent_group=$('.super-all-checkbox').eq($(this).parent().index()-2);
                if(parent_group.length != 0){
                    var sub_item=$('.super-checkbox').filter(function(){
                    return $(this).attr('group').substring(0,parent_group.attr('group').length)===parent_group.attr('group')&&!$(this).prop('checked');
                    })
                    if(sub_item.length==0){
                        parent_group.prop('checked',true);
                    }
                }
            }else{
                parent_group.find('input').prop('checked',false);
                $('.super-all-checkbox').eq($(this).parent().index()-2).prop('checked',false);
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
        'width'         : '90%',
        'height'        : '90%',
        'autoScale'     : true,
        'transitionIn'  : 'none',
        'transitionOut' : 'none',
        'type'          : 'iframe',
        'autoSize'      : false,
    });

    $(document).on('click','.table-checkbox tr td',function(){
        if($(this).find('a,button').length!=0){
            return;
        }
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

    $(document).on('click','.delete-tr-body',function(){
        tableTemp=$(this).parents('table');
        $(this).closest('tbody').remove();
        reIndexBody(tableTemp);
    })

    $(document).on('refer-image','.update-block #avarta',function(){
        $('#imageContainer').attr('style', 'background-image: url("' + $(this).val() +'")');
    })

    $(document).on('click','#btn-new-row',function(){
        $(this).parents('table').find('tbody').append("<tr></tr>");
        $(this).parents('table').find('tbody tr:last-child').append($(this).parents('table').find('tbody tr:first').html());
        $(this).parents('table').find('tbody tr:last-child input:first').focus();
        reIndex($(this).parents('table'));
        $(".btn-popup").fancybox({
            'width'         : '90%',
            'height'        : '90%',
            'autoScale'     : true,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'type'          : 'iframe',
            'autoSize'      : false,
        });
        $(this).trigger('addrow');
    })
    $(document).on('click','#btn-new-body',function(){
        $(this).parents('table').append("<tbody></tbody>");
        $(this).parents('table').find('tbody:last-child').append($(this).parents('table').find('tbody:first').html());
        reIndexBody($(this).parents('table'));
        $(".btn-popup").fancybox({
            'width'         : '90%',
            'height'        : '90%',
            'autoScale'     : true,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'type'          : 'iframe',
            'autoSize'      : false,
        });
        $(this).trigger('addrow');

    })

    // $(document).on('click','#btn-add',function(){
    //     $('.table-new-row tbody').append("<tr></tr>");
    //     $('.table-new-row tbody tr:last-child').append($('.table-new-row tbody tr:first').html());
    //     reIndex($('.table-new-row'));
    // })

    $(document).on('dblclick','.table-focus tbody tr',function(){
        clearUpdateBlock();
        clearFailedValidate();
         $('.table-focus tbody tr.update-row').removeClass('update-row');
        $('.table-focus tbody tr.active-row').addClass('update-row');
        $(this).find('td[refer-id]').each(function(){
            _this=$(this);
            if($(this).find('span').length!=0){
                _this=$(this).find('span');
            }
            var temp=$('.update-block #'+$(this).attr('refer-id'));
            if(temp.prop('tagName')!=='SELECT'){
                temp.val($(_this).text());
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
            $(this).trigger('dblclick');
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
        _popup_transfer_array['called_item']=$(this).parent().prev();
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
                if(e.shiftKey){
                    $('.edit-save').trigger('click');
                    break;
                }
                e.preventDefault();
                $('#btn_login').trigger('click');
                if($('.fancybox-opened').length!=0)
                $('#btn-list').trigger('click');
                break;
            case 38 :
                e.preventDefault();
                if($('.submit-table input').is(':focus')){
                    var row_now = $('input:focus').closest('tbody').find('tr:visible').index($('input:focus').closest('tr:visible'));
                    var input_now = $('input:focus').closest('tr').find('td:has(input):visible').index( $('input:focus').closest('td'));
                    var row_length = $('input:focus').closest('tbody').find('tr:visible').length;
                    if(row_now==0){
                        $('input:focus').closest('tbody').find('tr:visible').eq(row_length-1).find('input:visible').eq(input_now).focus();
                    }else{
                        $('input:focus').closest('tbody').find('tr:visible').eq(row_now-1).find('input:visible').eq(input_now).focus();
                    }
                }
                prevRow($('.table-focus tbody'));
                break;
            case 40 :
                if(e.ctrlKey){
                    e.preventDefault();
                    $('.table-focus tbody tr.active-row').trigger('dblclick');
                    break;
                }
                if($('.submit-table input').is(':focus')){
                    var row_now = $('input:focus').closest('tbody').find('tr:visible').index($('input:focus').closest('tr:visible'));
                    var input_now = $('input:focus').closest('tr').find('td:has(input):visible').index( $('input:focus').closest('td'));
                    var row_length = $('input:focus').closest('tbody').find('tr:visible').length;
                    if(row_now==row_length-1){
                        $('input:focus').closest('tbody').find('tr:visible').eq(0).find('input:visible').eq(input_now).focus();
                    }else{
                        $('input:focus').closest('tbody').find('tr:visible').eq(row_now+1).find('input:visible').eq(input_now).focus();
                    }
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
            if(typeof value[1] !='undefined'&&value[1]!=0)
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

    $(document).on('blur','.money-format',function (e) {
        var value=$(this).text().split('.');
        var valueLength = value[0].length;
        for(var i=valueLength-3;i>0;i=i-3){
            value[0]=value[0].substr(0, i) + ',' + value[0].substr(i);
        }
        if(typeof value[1] !='undefined')
            $(this).text(value[0]+'.'+value[1]);
        else
            $(this).text(value[0]);
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

function reIndexBody(table)
{
    var tab=0;
    var col=1;
    table.find('tbody:visible').each(function(i) {
        $(this).find('tr:first td:nth-child('+col+')').html('').html(i+1);
        
    });
}
function nextRow(tr_list){
    current_row=tr_list.find('.active-row');
    if(!tr_list.find('tr:visible:last-child').hasClass('active-row')){
        current_row.next().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:visible:first').addClass('active-row');
        current_row.removeClass('active-row');
    }

}

function prevRow(tr_list){
    current_row=tr_list.find('.active-row');
    if(!tr_list.find('tr:visible:first').hasClass('active-row')){
        current_row.prev().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:visible:last-child').addClass('active-row');
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

function showMessage(message_code,ok_callback,cancel_callback,parameter){
    if (parameter==undefined) {
        parameter={};
    }
    if(typeof _text!='undefined'){
        content = parameter.value!=undefined?fixMessage(_text[message_code],parameter):_text[message_code];
    }else{
        parent_content = parameter.value!=undefined?fixMessage(parent._text[message_code],parameter):parent._text[message_code];
    }
    switch(typeof _type!='undefined'?_type[message_code]:parent._type[message_code]){
        case 1:
            var buttons = [
                {
                    label: parameter['label']!=undefined&&parameter['label'][0]!=undefined?parameter['label'][0]:'Đồng ý',
                    classes: 'btn btn-sm btn-info float-left',
                    action: ok_callback,
                },
                {
                    label: parameter['label']!=undefined&&parameter['label'][1]!=undefined?parameter['label'][1]:'Từ chối',
                    classes: 'btn btn-sm btn-default float-right',
                    action: cancel_callback,
                }
            ]
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?content:parent_content,
            icon: $.sweetModal.ICON_CONFIRM,
            buttons: parameter['buttons']!=undefined?parameter['buttons']:buttons
        });
        break;
        case 2:
            var buttons = [
                {
                    label: parameter['label']!=undefined&&parameter['label'][0]!=undefined?parameter['label'][0]:'Ok',
                    classes: 'btn btn-sm btn-success',
                    action: ok_callback,
                },
            ]
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?content:parent_content,
            icon: $.sweetModal.ICON_SUCCESS,
            buttons: parameter['buttons']!=undefined?parameter['buttons']:buttons
        });
        break; 
        case 3:
            var buttons = [
                {
                    label: parameter['label']!=undefined&&parameter['label'][0]!=undefined?parameter['label'][0]:'Thực hiện',
                    classes: 'btn btn-sm btn-warning float-left',
                    action: ok_callback,
                },
                {
                    label: parameter['label']!=undefined&&parameter['label'][1]!=undefined?parameter['label'][1]:'Hủy',
                    classes: 'btn btn-sm btn-default float-right',
                    action: cancel_callback,
                }
            ]
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?content:parent_content,
            icon: $.sweetModal.ICON_WARNING,
            buttons: parameter['buttons']!=undefined?parameter['buttons']:buttons
        });
        break; 
        case 4:
            var buttons = [
                {
                    label: parameter['label']!=undefined&&parameter['label'][0]!=undefined?parameter['label'][0]:'Đã hiểu',
                    classes: 'btn btn-sm btn-danger',
                },
            ]
           $.sweetModal({
            title:typeof _title!='undefined'?_title[message_code]:parent._title[message_code],
            content: typeof _text!='undefined'?content:parent_content,
            icon: $.sweetModal.ICON_ERROR,
            buttons: parameter['buttons']!=undefined?parameter['buttons']:buttons
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

function showFailedValidate(error_array,exe_mode,parent_class){
    var parent_div='.update-block';
    if(exe_mode===1){
        parent_div='.search-block';
    }else{
        if(exe_mode==2){
            parent_div=parent_class;
        }
    }
    $.each( error_array, function( key, value ) {
        if(key.includes('.')){
            var target=$(parent_div+' table tbody tr:visible').eq(Number(key.split('.')[0])).find('.'+key.split('.')[1]);
        }else
        var target=$(parent_div).find('.form-group:visible').find('#'+key);
        if(target.prop("tagName") == 'SELECT' && target.hasClass('allow-selectize')||target.hasClass('custom-selectized')){
            target=target.next('.selectize-control').find('.selectize-input');
        }else
        if(target.attr('type') == 'file'){
            target=target.closest('.input-group').find('.file-caption');
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

function showFailedData(error_array,exe_mode,error_div){
    var parent_div='.update-block';
    if(exe_mode===2){
        parent_div = error_div;
    }
    if(exe_mode===1){
        parent_div='.search-block';
    }
    for (var i = 0; i < error_array.length; i++) {
        if(error_array[i]['Id']==0){
            var target=$(parent_div).find('#'+error_array[i]['Data']);
        }else{
            var target=$(parent_div).find('.'+error_array[i]['Data']+' tbody tr:visible').eq(error_array[i]['Message']);
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
    $('.input-error').each(function(){
        $(this).removeClass('input-error');
        $(this).removeAttr('data-toggle');
        $(this).removeAttr('data-placement');
        $(this).removeAttr('data-original-title');
    })
}

function clearFailedDataTable(table_id){
    $(typeof table_id!='undefined'?'#'+table_id:'.table').find('tbody .input-error').each(function(){
        $(this).find('span').removeAttr('data-toggle');
        $(this).find('span').removeAttr('data-placement');
        $(this).find('span').removeAttr('data-original-title');
        $(this).removeClass('input-error');
    })

}

function showFailedDataTable(error_array,table_id){
    for (var i = 0; i < error_array.length; i++) {
        var target=$(typeof table_id!='undefined'?'#'+table_id:'.table').find('tbody tr td[refer-id='+error_array[i]['Data']+']').eq(Number(error_array[i]['Message'])-1);
        target.addClass('input-error');
        target.find('span').attr('data-toggle','tooltip');
        target.find('span').attr('data-placement','top');
        target.find('span').attr('data-original-title',_text[error_array[i]['Code']]);
    }
    $('[data-toggle="tooltip"]').tooltip();
    // if($('.input-error').first().hasClass('selectize-input')){
    //     $('.input-error').first().parent().prev('select')[0].selectize.focus();
    // }else
    // $('.input-error').first().focus(); 
}

function clearFailedValidate(){
    $('.input-error').each(function(){
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
            $('.sub-checkbox').trigger('change');
        }else{
            var parent_group=$(super_checkbox);
            var sub_item=$('.sub-checkbox').filter(function(){
                return $(this).attr('group').substring(0,parent_group.attr('group').length)===parent_group.attr('group');
            })
            sub_item.prop('checked',true);
            parent_group=$('.super-all-checkbox').eq($(super_checkbox).parent().index()-1);
            if(parent_group.length != 0){
                var sub_item=$('.super-checkbox').filter(function(){
                return $(this).attr('group').substring(0,parent_group.attr('group').length)===parent_group.attr('group')&&!$(this).prop('checked');
                })
                if(sub_item.length==0){
                    parent_group.prop('checked',true);
                }
            }
        }
    }else{
        if(typeof $(super_checkbox).attr('group')=='undefined'){
            $('.sub-checkbox').prop('checked', false);
        }else{
            var parent_group=$(super_checkbox);
            var sub_item=$('.sub-checkbox').filter(function(){
                return $(this).attr('group').substring(0,parent_group.attr('group').length)===parent_group.attr('group');
            })
            sub_item.prop('checked',false);
            parent_group=$('.super-all-checkbox').eq($(super_checkbox).parent().index()-1);
            parent_group.prop('checked',false);
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

function getInputData(exe_mode,parent_class){
    var data={};
    var value;
    var parent_div='.search-block';
    if(exe_mode===1){
        parent_div='.update-block';
    }else{
        if(exe_mode==2){
            parent_div=parent_class;
        }
    }
    $(parent_div).find('input.submit-item,select.submit-item,textarea.submit-item').each(function(){
        if($(this).hasClass('ckeditor')){
            value=CKEDITOR.instances[$(this).attr('id')].getData();
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

function getTableData(table){
    var data=[];
    table.find('tbody tr:visible').each(function(i){
        var row_data={};
        var temp='';
        row_data['row_id']=i;
        $(this).find('input[refer-id],textarea[refer-id],select[refer-id],input[type=checkbox]').each(function(){
            if($(this).hasClass('money')){
                var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).hasClass('tel')){
                var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).is(":checkbox")){
                if(this.checked){
                    row_data[$(this).attr('refer-id')]=1;
                }
            }else{
                row_data[$(this).attr('refer-id')]=$(this).val();
            }
            if(($(this).prop("tagName")=='SELECT' && $(this).val()==0)||$(this).is(":checkbox")){
                temp+='';
            }else{
                temp+=$(this).val().trim();
            }
        })
        if(temp!='')
        data.push(row_data);
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function getTableTdData(table){
    var data=[];
    table.find('tbody tr:visible').each(function(i){
        var row_data={};
        row_data['row_id']=i;
        $(this).find('td[refer-id]').each(function(){
            row_data[$(this).attr('refer-id')]=$(this).text();
        })
        data.push(row_data);
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function getTableBodyData(table){
    var data=[];
    table.find('tbody:visible').each(function(){
        var row_data={};
        var temp='';
        $(this).find('input[refer-id],select[refer-id],input[type=checkbox]').each(function(){
            if($(this).hasClass('money')){
                var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).hasClass('tel')){
                var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).is(":checkbox")){
                if(this.checked){
                    row_data[$(this).attr('refer-id')]=1;
                }else{
                    row_data[$(this).attr('refer-id')]=0;
                }
            }else{
                row_data[$(this).attr('refer-id')]=$(this).val();
            }
            if(($(this).prop("tagName")=='SELECT' && $(this).val()==0)||$(this).is(":checkbox")){
                temp+='';
            }else{
                temp+=$(this).val().trim();
            }
        })
        if(temp!='')
        data.push(row_data);
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function getTableQuestionData(table){
    var data=[];
    table.find('tbody:visible').each(function(i){
        var count = $(this).find('input[type=checkbox]:checked').length;
        $(this).find('tr:visible').each(function(){
            var row_data={};
            var temp='';
            row_data['row_id'] = i+1;
            $(this).find('input[refer-id],select[refer-id],input[type=checkbox]').each(function(){
                if($(this).hasClass('money')){
                    var text = jQuery.grep($(this).val().split(','), function(value) {
                      return value;
                    });
                    row_data[$(this).attr('refer-id')]=text.join('');
                }else
                if($(this).hasClass('tel')){
                    var text = jQuery.grep($(this).val().split('-'), function(value) {
                      return value;
                    });
                    row_data[$(this).attr('refer-id')]=text.join('');
                }else
                if($(this).is(":checkbox")){
                    if(this.checked){
                        row_data[$(this).attr('refer-id')]=1;
                    }else{
                        row_data[$(this).attr('refer-id')]=0;
                    }
                }else{
                    row_data[$(this).attr('refer-id')]=$(this).val();
                }
                if(($(this).prop("tagName")=='SELECT' && $(this).val()==0)||$(this).is(":checkbox")){
                    temp+='';
                }else{
                    temp+=$(this).val().trim();
                }
                if($(this).hasClass('question')){
                    row_data['explan']=$(this).closest('tbody').find('textarea:not(.textarea-temp)').first().val(); 
                }
            })
            if(count>1){
                row_data['question_div'] =1;
            }else{
                row_data['question_div'] =0;
            }
            if(temp!='')
            data.push(row_data);
        })
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function getMediaData(form){
   
}

// function loadPopup(screen_name){
//     $(".btn-popup").fancybox({
       
//         'fitToView'   : false,
//         'autoSize'    : false,
//         afterLoad: function () {
//             this.width = '75%';
//             this.height = '75%';
//         }
//     });
// }

function clearDataSearch(){
    $('input.submit-item,select.submit-item').val('');
    $('#result table tbody').html('<tr><td colspan="100">Xin nhập điều kiện tìm kiếm</td></tr>');
    $('.pager').remove();
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
        rotateControls: false,
        cropData:{
            'width' : imageContainer.width(),
            'height': imageContainer.height()
        },
        onAfterImgCrop:function(){
            $('#avarta,#image').val($('#imageContainer .croppedImg').attr('src'));
        },
        onAfterRemoveCroppedImg: function(){
            $('#avarta,#image').val('');
        },
        onError: function(){
            showMessage(14);
        },
    };
    cropperBox = new Croppic('imageContainer', croppedOptions);
}

function updateDeleteArray(checkbox,mode){
    var element = {};
    var notIn=-1;
    var item_id=$(checkbox).parent().next().next().text();
    element.row_id=$(checkbox).closest('tr').index();
    element.id=item_id;
    if(typeof mode!='undefined'){
        var item_dtl_id=$(checkbox).parent().next().next().next().text();
        element.dtl_id=item_dtl_id;
    }
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
    element['row_id']=$('.table-focus').find('.update-row td').eq(1).text();
    $('.update-block .submit-item[id]').each(function(){
        if($(this).hasClass('input-refer')){
            element[$(this).attr('id')]=$(this).val().split('_')[0];
        }else{
            if(!$(this).hasClass('get-text')){
                element[$(this).attr('id')]=$(this).val();
            }else{
                element[$(this).attr('id')]=$(this).text();
            }
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
                selectize_temp.setValue(0,true);
            }else{
                $(this).val(0);
            }
        }
    })
    if(typeof cropperBox!='undefined'){
        cropperBox.reset();
    }
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
                        _this=$(this);
                        if($(this).find('span').length!=0){
                            _this=$(this).find('span');
                        }
                        var temp=$('.update-block #'+$(this).attr('refer-id'));
                        if(temp.prop('tagName')!=='SELECT'){
                            $(_this).text(temp.val());
                        }else{
                            $(_this).text(temp.find('option:selected').text());
                        }
                    })
                    $('.table-focus').find('.update-row td.edit-flag').addClass('edit-row');
                    if($('.table-focus').find('.update-row td.edit-flag').text()=='Không'){
                        $('.table-focus').find('.update-row td.edit-flag').html('Đã sửa(<span class="edit-num">1</span>)')
                    }else{
                        $('.table-focus').find('.update-row td.edit-flag .edit-num').text(Number($('.table-focus').find('.update-row td.edit-flag .edit-num').text())+1);
                    }
                    updateEditArray();
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

var parseQueryString = function( queryString ) {
    var params = {}, queries, temp, i, l;
    // Split into key/value pairs
    queries = queryString.split("&");
    // Convert the array of strings into an object
    for ( i = 0, l = queries.length; i < l; i++ ) {
        temp = queries[i].split('=');
        params[temp[0]] = temp[1];
    }
    return params;
};

function initFlugin(){
    $("#dtBox").DateTimePicker();
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
        // initialPreview: [
        //     '<audio controls=""> <source src="/web-content/audio/listeningAudio/audio_5b58278fbeaca.mp3" type="audio/mp3"> </audio>'
        // ],
    });
    $("select:not('.allow-selectize,.custom-selectized,.tag-selectize')").addClass("form-control input-sm");
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        _selectize=$("select.allow-selectize:not([class*='new-allow'])").selectize({
            allowEmptyOption: true,
            create: false,
            openOnFocus: true,
            plugins: ['restore_on_backspace'],
            onFocus: function () {
                if(this.getItem((this.getValue())[0]!=undefined?this.getItem(this.getValue())[0].innerHTML.trim():'')==''){
                    this.clear();
                }
            }
        });

        _selectize=$("select.allow-selectize.new-allow").selectize({
            allowEmptyOption: true,
            create: true,
            isDisabled: true,
            plugins: ['restore_on_backspace'],
            onFocus: function () {
                if(this.getItem((this.getValue())[0]!=undefined?this.getItem(this.getValue())[0].innerHTML.trim():'')==''){
                    this.clear();
                }
            }
        });

        _selectize=$("select.tag-selectize").each(function() {
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
    }else{
        $("select:not('.custom-selectized,.tag-selectize')").addClass("form-control input-sm");
    }
    $(".ckeditor").each(function(){
        try{
          CKEDITOR.inline($(this).attr('name'),{language:"vi"});  
        }catch(e){

        }
    })
}

function fixMessage(mes,parameter){
    for (var i = 0; i < parameter.value.length; i++) {
        mes = mes.replace('xxx',parameter.value[i]);
    }
    return mes;
}

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}




