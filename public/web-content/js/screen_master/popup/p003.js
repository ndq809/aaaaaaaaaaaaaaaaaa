$(function(){
	try{
		init_p003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p003(){
	initevent_p003();
    p003_load();
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

    $(document).on('click','.btn-add',function(){
        var tr_clone = $(this).closest('tr');
        tr_clone.find('.btn-add').find('span').removeClass().addClass('fa fa-close');
        tr_clone.find('.btn-add').removeClass().addClass('btn btn-danger btn-delete-row');
        $('.table-refer tbody').append(tr_clone);
    })

    $(document).on('click','.btn-delete-row',function(){
        $(this).closest('tr').remove();
    })

    $(document).on('click','#btn-save',function(){
        p003_refer();
    })
}

function p003_execute(page){
	var data=getInputData();
    data['selected_list'] = getVocabularyList();
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
                $('.preview').attr('data-placement','left');
                $('.preview').tooltip({
                    animated: 'fade',
                    placement: 'left',
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

function p003_load(){
    var data = {};
    data['voc_array'] =  parent._popup_transfer_array['voc_array'];
    $.ajax({
        type: 'POST',
        url: '/master/popup/p003/load',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result1').html(res).promise().done(function(){
                $('.preview').attr('data-toggle','tooltip');
                $('.preview').attr('data-placement','left');
                $('.preview').tooltip({
                    animated: 'fade',
                    placement: 'left',
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

function p003_refer(){
    var data = getVocabularyList();
    $.ajax({
        type: 'POST',
        url: '/master/popup/p003/refer',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            parent.$('#result').html(res);
            parent.jQuery.fancybox.close();
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getVocabularyList(){
    var data =[];
    $('.table-refer tbody tr:visible').each(function(){
        data.push({'vocabulary_code':$(this).find('td[refer_id=vocabulary_code]').text()});
    })
    if(data.length==0){
        return null;
    }
    return $.extend({}, data);
}