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

    $('.fa-spin').hide();

    $('.link-div').each(function(){
        $('#btn-manager a').attr('href',$(this).attr('btn-manager-page-link'));
        $('#btn-add-page a').attr('href',$(this).attr('btn-add-page-link'));
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
        }
    })

    $(document).on('click','.delete-tr-row',function(){
        if(confirm("Delete selected row?")){
            $(this).closest('tr').remove();
        }
    })

    $(document).on('click','#btn-new-row,#btn-add',function(){
        $('.table-new-row tbody').append("<tr></tr>");
        $('.table-new-row tbody tr:last-child').append($('.table-new-row tbody tr:first').html());
        reIndex();
    })

    $(document).on('click','.table-focus tbody tr',function(){
        updateInput=$('.update-content').find('input,textarea,select');
        if($(this).hasClass('active-row')){
            return;
        }
        $('.table-focus tbody tr.active-row .update-item').each(function(i){
            $(this).text(updateInput.eq(i).val());
        })
        $('.table-focus tbody tr.active-row').removeClass('active-row');
        $(this).addClass('active-row');
        $('.table-focus tbody tr.active-row .update-item').each(function(i){
            updateInput.eq(i).val($(this).text());
        })
    })

    $(document).on('change','.update-content input,.update-content select,.update-content textarea',function(){
        $('.table-focus').find('.active-row').addClass('active-update');
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
        e.preventDefault();
        switch(e.which){
            case 38 :
                prevRow($('.table-focus tbody'));
                break;
            case 40 :
                nextRow($('.table-focus tbody'));
                break;
            default:
                break;
        }
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

    if ($(window).width() < 900) {
        $('.navbar-right').width('100%');
    }else{
        $('.navbar-right').width('auto');
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
    $('.table-focus tbody tr:first .update-item').each(function(i){
        updateInput.eq(i).val($(this).text());
    })
}

function reIndex()
{
    var tab=0;
    $(document).find('.table-new-row > tbody > tr:not(:first)').each(function(i) {
        var index = ('00' + (i+1)).slice(-4);
        $(this).find('td:nth-child(2)').html('').html(index);
        
    });
}

function nextRow(tr_list){
    current_row=tr_list.find('.active-row');
    $('.table-focus tbody tr.active-row .update-item').each(function(i){
            $(this).text(updateInput.eq(i).val());
        })
    if(!tr_list.find('tr:last-child').hasClass('active-row')){
        current_row.next().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:first').addClass('active-row');
        current_row.removeClass('active-row');
    }

    $('.table-focus tbody tr.active-row .update-item').each(function(i){
        updateInput.eq(i).val($(this).text());
    })
    
}

function prevRow(tr_list){
    current_row=tr_list.find('.active-row');
    $('.table-focus tbody tr.active-row .update-item').each(function(i){
            $(this).text(updateInput.eq(i).val());
        })
    if(!tr_list.find('tr:first').hasClass('active-row')){
        current_row.prev().addClass('active-row');
        current_row.removeClass('active-row'); 
    }else{
        tr_list.find('tr:last-child').addClass('active-row');
        current_row.removeClass('active-row');
    }
    $('.table-focus tbody tr.active-row .update-item').each(function(i){
        updateInput.eq(i).val($(this).text());
    })
}

