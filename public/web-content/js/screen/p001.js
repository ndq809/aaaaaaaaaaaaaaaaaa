$(function(){
	try{
		init_p001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p001(){
	initevent_p001();
    p001_load();
}

function initevent_p001(){
	$(document).on('click','#btn-list',function(){
		p001_execute(1);
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p001_execute(parseInt(page, 10));
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
        p001_refer();
    })
}

function p001_execute(page){
	var data=getInputData();
    data['row_id'] = parent._popup_transfer_array['row_id']==undefined?-1:parent._popup_transfer_array['row_id'];
    data['selected_list'] = typeof getVocabularyList()[0]!='undefined'?getVocabularyList():'';
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/popup/p001',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res).promise().done(function(){
                $('#result .preview').tooltip({
                    animated: 'fade',
                    trigger: 'hover',
                    placement: 'left',
                    delay: { show: 100, hide: 100 },
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

function p001_load(){
    var data = {};
    data['voc_array'] =  parent._popup_transfer_array['voc_array'];
    $.ajax({
        type: 'POST',
        url: '/popup/p001/load',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result1').html(res).promise().done(function(){
                $('#result1 .preview').tooltip({
                    trigger: 'hover',
                    animated: 'fade',
                    placement: 'left',
                    delay: { show: 100, hide: 100 },
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

function p001_refer(){
    var data = getVocabularyList();
    data['row_id_parent'] = parent._popup_transfer_array['row_id'];
    $.ajax({
        type: 'POST',
        url: '/popup/p001/refer',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            parent.$('#voc-content .vocabulary-box[target-id='+(res.row_id==''?-1:res.row_id)+']').removeClass('vocabulary-box').addClass('old-content hidden');
            parent.$('#voc-content').append(res.view);
            parent.$('#voc-content .vocabulary-box[target-id='+(res.row_id==''?-1:res.row_id)+']:not(.old-content)').addClass('new-content');
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
        data.push({'row_id':$(this).find('td[refer_id=row_id]').text(),'id':$(this).find('td[refer_id=id]').text()});
    })
    if(data.length==0){
        return {};
    }
    return $.extend({}, data);
}