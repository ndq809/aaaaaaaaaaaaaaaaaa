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
    menuController()
    $("#dtBox").DateTimePicker();
    $(".datetimepicker").on("click", function() {
        $("#dtBox").DateTimePicker();
    })
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
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("select").selectize({
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
        if(this.checked){
            $('.sub-checkbox').prop('checked', true);
        }else{
            $('.sub-checkbox').prop('checked', false);
        }
    })
    $(document).on('change','.sub-checkbox',function(){
        if($("input.sub-checkbox:visible:not(:checked)").length!=0){
            $('.super-checkbox').prop('checked', false);
        }else{
            $('.super-checkbox').prop('checked', true);
        }
    })
    $(document).on('click','#btn-list,#btn-update,#btn-search',function(){
        showContent($(this));
    })

    $(document).on('click','#btn-cancel',function(){
        location.reload();
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
        if(confirm("Delete all selected item?")){
            $('.sub-checkbox:checked').closest('tr').remove();
            $('.table-focus tbody tr:first').addClass('active-row');
        }
    })

    $(document).on('click','.delete-tr-row',function(){
        if(confirm("Delete selected row?")){
            $(this).closest('tr').remove();
        }
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
                if(!$('input').is(':focus')){
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
                if(!$('input').is(':focus')){
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
}


