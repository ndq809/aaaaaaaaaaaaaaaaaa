$(function(){
	try{
		init_p003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p003(){
	initevent_p003();
    $('#vocabulary_div').val(parent._popup_transfer_array['vocabulary_div']);
    $('#vocabulary_nm').val(parent._popup_transfer_array['vocabulary_nm']);
    $('#mean').val(parent._popup_transfer_array['mean']);
    p003_execute();
}

function initevent_p003(){
	$(document).on('click','#btn-list',function(){
		p003_execute(1);
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p003_execute(parseInt(page, 10));
    })

    $(document).on('click','.preview-audio',function(){
        $(this).parents('table').find('audio').each(function(){
            if(!$(this)[0].paused){
                $(this)[0].pause();
                $(this)[0].currentTime = 0;
            }
        });
        $(this).parent().find('audio')[0].play();
    })

    $(document).on('dblclick','.table-refer tr',function(){
        var refer_text='';
        _this=$(this);
        parents = parent.$('[data-refer=p003]');
        if(_this.find('.refer-item').length==0){
            return;
        }
        $(this).find('.refer-item').each(function(i){
            var item = parent.$('.table tbody tr').eq(parent._popup_transfer_array['row_id']).find("."+$(this).attr('refer_id'));
            if(item.prop("tagName")=='SELECT' && $(this).text()==''){
                item.val(0);
            }else{
                item.val($(this).text());
            }
            if(item.is(":hidden")){
                item.attr('value',$(this).text());
                item.trigger('change');
            }
        })
        parent.jQuery.fancybox.close();
    })
}

function p003_execute(page){
	var data=getInputData();
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/popup/p003',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res).promise().done(function(){
                $('.preview').attr('data-toggle','tooltip');
                $('.preview').attr('data-placement','top');
                $('.preview').tooltip({
                    animated: 'fade',
                    placement: 'right',
                    html: true
                });
            });
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}