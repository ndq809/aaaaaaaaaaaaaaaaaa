$(function(){
	try{
		init_p006();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_p006(){
	initevent_p006();
    p006_load();
}

function initevent_p006(){
	$(document).on('click','#btn-list',function(){
		p006_execute(1);
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        p006_execute(parseInt(page, 10));
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
        p006_refer();
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
    })
}

function p006_execute(page){
	var data=getInputData();
    data['selected_list'] = getVocabularyList();
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/popup/p006',
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

function p006_load(){
    var data = {};
    data['user_array'] =  parent._popup_transfer_array['user_array'];
    $.ajax({
        type: 'POST',
        url: '/master/popup/p006/load',
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

function p006_refer(){
    var data = {};
    data['user_list'] = getVocabularyList();
    $.ajax({
        type: 'POST',
        url: '/master/popup/p006/refer',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            parent._popup_transfer_array['result'].html(res);
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
        data.push({'account_id':$(this).find('td[refer-id=account_id]').text()});
    })
    if(data.length==0){
        return null;
    }
    return $.extend({}, data);
}

function updateGroup(change_item){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        loading:false,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('#group_nm')[0].selectize.setValue('',true);
                    $('#group_nm')[0].selectize.clearOptions();
                    $('#group_nm')[0].selectize.addOption(res.data);
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