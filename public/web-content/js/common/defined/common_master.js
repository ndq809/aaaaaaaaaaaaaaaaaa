var selectedTab = "#tab1";
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
    menuController()
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
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("select:not([class*='new-allow'])").selectize({
            allowEmptyOption: true,
            create: false
        });
    }else{
        $("select").addClass("form-control input-sm");
    }
    $('.selectize-control.required .selectize-input').css('border','1px solid #d9534f');
    $('select.required').prev('label').addClass('required');
    $('input.required,textarea.required').parent().prev('label').addClass('required');
    $('.fa-spin').hide();

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
    $(document).on('click','#btn-list,#btn-update,#btn-search',function(){
        showContent($(this));
    })

    $(document).on('click','#btn-cancel',function(){
        location.reload();
    })

    $(document).on('click','#btn_login',function(){
        checkLogin('Quy Nguyen');
    })

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

    $(document).on('click','#btn-delete',function(){
       showMessage(3,function(){
            $('.sub-checkbox:checked').closest('tr').remove();
       });
    })

    $(document).on('click','.delete-tr-row',function(){
        tableTemp=$(this).parents('table');
        if(confirm("Delete selected row?")){
            $(this).closest('tr').remove();
        }
        reIndex(tableTemp);
    })

    $(document).on('click','#btn-new-row',function(){
        $(this).parents('table').find('tbody').append("<tr></tr>");
        $(this).parents('table').find('tbody tr:last-child').append($(this).parents('table').find('tbody tr:first').html());
        reIndex($(this).parents('table'));
    })

    $(document).on('click','#btn-add',function(){
        $('.table-new-row tbody').append("<tr></tr>");
        $('.table-new-row tbody tr:last-child').append($('.table-new-row tbody tr:first').html());
        reIndex($('.table-new-row'));
    })

    $(document).on('dblclick','.table-focus tbody tr',function(){
        if(!$(this).hasClass('update-row')){
            updateInput=$('.update-content').find('input,textarea,select');
            if($('.table-focus tbody tr.update-row' ).length!=0){
                $('.table-focus tbody tr.update-row .update-item').each(function(i){
                    $(this).text(updateInput.eq(i).val());
                })
            }
            $('.table-focus tbody tr.active-row .update-item').each(function(i){
                if(updateInput.eq(i).attr('type')!='file'){
                    updateInput.eq(i).val($(this).text());
                }
            })
            updateInput.eq(0).focus();
            $('.table-focus tbody tr.update-row').removeClass('update-row');
            $('.table-focus tbody tr.active-row').addClass('update-row');
        }
    })

    $(document).on('click','#btn-change-pass',function(){
        changePassword('Khoai lang nướng');
    })
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $(document).on('doubletap','.table-focus tbody tr.active-row',function(e){
            if(!$(this).hasClass('update-row')){
                updateInput=$('.update-content').find('input,textarea,select');
                if($('.table-focus tbody tr.update-row' ).length!=0){
                    $('.table-focus tbody tr.update-row .update-item').each(function(i){
                        $(this).text(updateInput.eq(i).val());
                    })
                }
                $('.table-focus tbody tr.active-row .update-item').each(function(i){
                    if(updateInput.eq(i).attr('type')!='file'){
                        updateInput.eq(i).val($(this).text());
                    }
                })
                updateInput.eq(0).focus();
                $('.table-focus tbody tr.update-row').removeClass('update-row');
                $('.table-focus tbody tr.active-row').addClass('update-row');
            }
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

     $(document).on('input propertychange paste change','.update-content input,.update-content textarea,.update-content select',function(){
        $('.table-focus').find('.update-row').addClass('active-update');
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
            case 38 :
                if(e.altKey){
                    e.preventDefault();
                    prevRow($('.table-focus tbody'));
                }
                break;
            case 40 :
                if(e.ctrlKey){
                    e.preventDefault();
                    if($('.table-focus tbody tr.update-row' ).length!=0){
                        $('.table-focus tbody tr.update-row .update-item').each(function(i){
                            $(this).text(updateInput.eq(i).val());
                        })
                    }
                    $('.table-focus tbody tr.active-row .update-item').each(function(i){
                        if(updateInput.eq(i).attr('type')!='file'){
                            updateInput.eq(i).val($(this).text());
                        }
                    })
                    updateInput.eq(0).focus();
                    $('.table-focus tbody tr.update-row').removeClass('update-row');
                    $('.table-focus tbody tr.active-row').addClass('update-row');
                    break;
                }
                if(e.altKey){
                    e.preventDefault();
                    nextRow($('.table-focus tbody'));
                }
                break;
            default:
                break;
        }
    })
}

function setLayout(){
    $('.change-content').css('padding-top',$('.menu-btn-list').height()+50);
}

function menuController() {
    try{
        if ($(window).width() < 680) {
            var temp = Math.floor((90 / $('.menu-btn-list').width()) * 100);
            $('#menu>li').css('width', temp + '%');
        } else {
            $('#menu>li').css('width', '100px');
        }

        if ($(window).width() < 900) {
            $('.navbar-right').width('100%');
        }else{
            $('.navbar-right').width('auto');
        }
    }catch(e){
        alert('menuController:'+ e);
    }
    
}

function showContent(click_btn){
    _this=click_btn;
    showElement=".show-on-click[click-btn='"+_this.attr('id')+"']";
    $('.fa-spin').show();
    $(showElement).hide();
    setTimeout(function() {
        $(showElement).show();
        $('.fa-spin').hide();
        $('.btn-disable').removeClass('btn-disable');
    }, 500);
    $('.table-focus tbody tr:first').addClass('active-row');
    updateInput=$('.update-content').find('input,textarea,select');
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

function changePassword(username){
    $.ajax({
        type: 'POST',
        url: '/common/changepass',
        dataType: 'json',
        loading:true,
        data: {
            username:username,
        },
        success: function (res) {
            switch(res.status){
                case 200:
                    alert("Đã gửi email bao gồm mk mới");
                    break;
                case 201:
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
    switch(message_code){
        case 1:
           $.sweetModal({
            title:'xác nhận',
            content: 'Đây chỉ là bản demo thôi nhá người theo hương hoa mây mù giăng lối làn sương khói phôi pha lê bước ai xa rồi',
            icon: $.sweetModal.ICON_CONFIRM,
            buttons: [
                {
                    label: 'Đồng ý',
                    classes: 'btn btn-sm btn-danger float-left',
                    action: ok_callback,
                },
                {
                    label: 'Từ chối',
                    classes: 'btn btn-sm btn-warning float-right',
                    action: cancel_callback,
                }
            ]
        });
        break;
        case 2:
           $.sweetModal({
            title:'Thao tác thành công',
            content: 'Đây chỉ là bản demo thôi nhá người theo hương hoa mây mù giăng lối làn sương khói phôi pha lê bước ai xa rồi',
            icon: $.sweetModal.ICON_SUCCESS,
            buttons: [
                {
                    label: 'Ok',
                    classes: 'btn btn-sm btn-danger',
                },
            ]
        });
        break; 
        case 3:
           $.sweetModal({
            title:'cảnh báo',
            content: 'Đây chỉ là bản demo thôi nhá người theo hương hoa mây mù giăng lối làn sương khói phôi pha lê bước ai xa rồi',
            icon: $.sweetModal.ICON_WARNING,
            buttons: [
                {
                    label: 'Thực hiện',
                    classes: 'btn btn-sm btn-danger float-left',
                    action: ok_callback,
                },
                {
                    label: 'Hủy',
                    classes: 'btn btn-sm btn-warning float-right',
                    action: cancel_callback,
                }
            ]
        });
        break; 
        case 4:
           $.sweetModal({
            title:'thao tác thất bại',
            content: 'Đây chỉ là bản demo thôi nhá người theo hương hoa mây mù giăng lối làn sương khói phôi pha lê bước ai xa rồi',
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
        data['email']=$('#email').val();
        data['password']=$('#password').val();
    $.ajax({
        type: 'POST',
        url: '/master/checkLogin',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    window.location.href='/master/general/g001';
                    break;
                case 201:
                    // alert('lỗi validate');
                    showFailedValidate(res.error);
                    break;
                case 202:
                    alert('sai tên đăng nhập hoặc mật khẩu');
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

function showFailedValidate(error_array){
    $.each( error_array, function( key, value ) {
      $('#'+key).css('background','#d9534f');
      $('#'+key).attr('data-toggle','tooltip');
      $('#'+key).attr('data-placement','top');
      $('#'+key).attr('data-original-title',value);
    });
    $('[data-toggle="tooltip"]').tooltip(); 
    console.log();
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



