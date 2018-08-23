$(function(){
	try{
		init_v001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v001(){
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