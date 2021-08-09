$(function(){
	try{
		init_v001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v001(){
    $('#btn-confirm').addClass('btn-disable-custom');
    $('#btn-public').addClass('btn-disable-custom');
    $('#btn-reset-status').addClass('btn-disable-custom');
	initevent_v001();
}

function initevent_v001(){
	$(document).on('click','#btn-list',function(){
		v001_execute(1);
	})

	$(document).on('click','#btn-delete',function(){
		if($('.sub-checkbox:visible:checked').length!=0){
           showMessage(3,function(){
                v001_delete();
           }); 
        }
	})

    $(document).on('click','#btn-confirm',function(){
        if($('.sub-checkbox:visible:checked').length!=0){
           showMessage(24,function(){
                v001_confirm();
           }); 
        }
    })

    $(document).on('click','#btn-public',function(){
        if($('.sub-checkbox:visible:checked').length!=0){
           showMessage(25,function(){
                v001_public();
           }); 
        }
    })

    $(document).on('click','#btn-reset-status',function(){
        if($('.sub-checkbox:visible:checked').length!=0){
           showMessage(26,function(){
                v001_reset();
           }); 
        }
    })

    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        v001_execute(parseInt(page, 10));
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

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this,1);
    })

}

function v001_execute(page){
	var data=getInputData();
    _pageSize=50;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/vocabulary/v001/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            switch ($('#record_div').val()*1){
                case 0:
                    $('#btn-confirm').addClass('btn-disable-custom');
                    $('#btn-public').addClass('btn-disable-custom');
                    $('#btn-delete').removeClass('btn-disable-custom');
                    $('#btn-reset-status').addClass('btn-disable-custom');
                    break;
                case 1:
                    $('#btn-confirm').removeClass('btn-disable-custom');
                    $('#btn-public').addClass('btn-disable-custom');
                    $('#btn-delete').removeClass('btn-disable-custom');
                    $('#btn-reset-status').addClass('btn-disable-custom');
                    break;
                case 2:
                    $('#btn-confirm').addClass('btn-disable-custom');
                    $('#btn-public').removeClass('btn-disable-custom');
                    $('#btn-delete').removeClass('btn-disable-custom');
                    $('#btn-reset-status').addClass('btn-disable-custom');
                    break;
                case 3:
                    $('#btn-confirm').addClass('btn-disable-custom');
                    $('#btn-public').addClass('btn-disable-custom');
                    $('#btn-delete').removeClass('btn-disable-custom');
                    $('#btn-reset-status').removeClass('btn-disable-custom');
                    break;
            }
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

function v001_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v001/delete',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_delete),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.sub-checkbox:checked').closest('tr').remove();
                    $('.identity-item').val('');
                    _data_delete=[];
                    showMessage(2);
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

function v001_confirm(){
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v001/confirm',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_delete),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.sub-checkbox:checked').closest('tr').remove();
                    $('.identity-item').val('');
                    _data_delete=[];
                    showMessage(2,function(){
                        $('#record_div').val(2);
                        $('#btn-list').trigger('click');
                    });
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

function v001_public(){
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v001/public',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_delete),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.sub-checkbox:checked').closest('tr').remove();
                    $('.identity-item').val('');
                    _data_delete=[];
                    showMessage(2,function(){
                        $('#record_div').val(3);
                        $('#btn-list').trigger('click');
                    });
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

function v001_reset(){
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v001/reset',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_delete),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.sub-checkbox:checked').closest('tr').remove();
                    $('.identity-item').val('');
                    _data_delete=[];
                    showMessage(2,function(){
                        $('#record_div').val(1);
                        $('#btn-list').trigger('click');
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data,2,'#result');
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