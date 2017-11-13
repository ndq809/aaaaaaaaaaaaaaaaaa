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
            if($(this).parents('table').hasClass('update-table')){
                $(this).parents('table').find('tbody tr').addClass('active-update');
            }
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
    $(document).on('click','#btn-list,#btn-update,#btn-search',function(){
        showContent($(this));
    })

    $(document).on('click','#btn-cancel',function(){
        location.reload();
    })

    $(document).on('click','.table-checkbox tr td',function(){
        if($(this).find('input[type=checkbox]').length==0){
            checkbox=$(this).parent().find('input[type=checkbox]');
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

    $(document).on('click','#btn-new-row',function(){
        $('.new-row-table tbody').append("<tr></tr>");
        $('.new-row-table tbody tr:last-child').append($('.new-row-table tbody tr:first').html());
        reIndex();
    })

    $(document).on('click','#btn-update',function(){
        if(confirm("update all selected item?")){
            $('.sub-checkbox:not(:checked)').closest('tr').remove();
            $('.sub-checkbox').closest('td').remove();
            $('.super-checkbox').closest('th').remove();
            $('.table-checkbox').addClass('focus-table');
            $('.focus-table tbody tr:first').addClass('active-row');
            updateInput=$('.update-content').find('input,textarea,select');
            $('.focus-table tbody tr:first td').each(function(i){
                updateInput.eq(i).val($(this).text());
            })
        }
    })

    $(document).on('click','.focus-table tbody tr',function(){
        updateInput=$('.update-content').find('input,textarea,select');
        if($(this).hasClass('active-row')){
            return;
        }
        $('.focus-table tbody tr.active-row td').each(function(i){
            $(this).text(updateInput.eq(i).val());
        })
        $('.focus-table tbody tr.active-row').removeClass('active-row');
        $(this).addClass('active-row');
        $('.focus-table tbody tr.active-row td').each(function(i){
            updateInput.eq(i).val($(this).text());
        })
    })

    $(document).on('change','.update-table tbody tr td input,.update-table tbody tr td select,.update-table tbody tr td textarea',function(){
        $(this).parents('tr').addClass('active-update');
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
}

function reIndex()
{
    var tab=0;
    $(document).find('.new-row-table > tbody > tr:not(:first)').each(function(i) {
        var index = ('00' + (i+1)).slice(-4);
        $(this).find('td:nth-child(2)').html('').html(index);
        
    });
}

