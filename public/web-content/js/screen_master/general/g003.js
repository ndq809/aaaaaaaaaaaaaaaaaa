$(function(){
	try{
		init_g003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g003(){
	initevent_g003();
}

function initevent_g003(){
	$(document).on('click','#btn-list',function(){
		g003_execute(1);
	})

	$(document).on('click','#btn-save',function(){
        if($('.table-focus tbody tr td.edit-row').length!=0){
            showMessage(1,function(){
                g003_update();
           });
        }
	})

    $(document).on('click','#btn-refresh',function(){
        clearDataSearch();
    })
    $(document).on('click', '.pager li a', function () {
        var page = $(this).attr('page');
        if($('.table-focus tbody tr td.edit-row').length!=0&&!$(this).parent('li').hasClass('active')){
            showMessage(3,function(){
                g003_update(false);
                g003_execute(parseInt(page, 10));
           });
        }else{
            g003_execute(parseInt(page, 10));
        }
        
    })
    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
    $(document).on('click','#btn-delete',function(){
        if($('.sub-checkbox:checked').length!=0){
           showMessage(3,function(){
                g003_delete();
           }); 
        }
    })
    $(document).on('click','.edit-save',function(e){
        updateEditArray();
    })
}

function g003_execute(page){
	var data=getInputData();
    _pageSize=10;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/general/g003/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
            clearUpdateBlock();
            _data_delete=[];
            _data_edit=[];
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function g003_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/general/g003/delete',
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

function g003_update(trigger){
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/general/g003/update',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_edit),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    if(trigger)
                    $('.pager li.active a').trigger('click');
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

