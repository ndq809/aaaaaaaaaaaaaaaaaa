$(function(){
	try{
		init_s002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_s002(){
	initevent_s002();
	initImageUpload();
}

function initevent_s002(){
	$(document).on('click','#btn-list',function(){
		s002_execute(1);
	})

	$(document).on('click','#btn-save',function(){
        if($('.table-focus tbody tr td.edit-row').length!=0){
            showMessage(1,function(){
                s002_update();
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
                s002_update(false);
                s002_execute(parseInt(page, 10));
           });
        }else{
            s002_execute(parseInt(page, 10));
        }
        
    })
    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
    $(document).on('click','#btn-delete',function(){
        if($('.sub-checkbox:checked').length!=0){
           showMessage(3,function(){
                s002_delete();
           }); 
        }
    })

     $(document).on('change','.search-block #system_div_s',function(){
        getTarget_s();
    })

     $(document).on('change','.update-block #system_div',function(){
        getTarget($('.update-row td:nth-child(7)').text());
    })
}

function s002_execute(page){
	var data=getInputData();
    _pageSize=10;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/system/s002/list',
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

function s002_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/system/s002/delete',
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

function s002_update(trigger){
    clearFailedDataTable();
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/system/s002/update',
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
                case 207:
                    clearFailedValidate();
                    showFailedDataTable(res.data);
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

function getTarget(sub_item_text){
    var selectize_sub= $('.update-block #account_div')[0].selectize;
    if($('.update-block #system_div').val()==0){
        selectize_sub.setValue('', true);
        selectize_sub.clearOptions();
        selectize_sub.disable();
        return;
    }
    var data={};
    data['system_div'] = $('.update-block #system_div').val();
    $.ajax({
        type: 'POST',
        url: '/master/system/s001/target',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            selectize_sub.setValue('', true);
            selectize_sub.clearOptions();
            selectize_sub.addOption(res.data);
            selectize_sub.removeOption(0);
            if ($('.update-block #system_div').val() == 0) {
                selectize_sub.disable();
            } else {
                selectize_sub.enable();
                selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getTarget_s(){
    var selectize_sub= $('.search-block #account_div_s')[0].selectize;
    if($('.search-block #system_div_s').val()==0){
        selectize_sub.setValue('', true);
        selectize_sub.clearOptions();
        selectize_sub.disable();
        return;
    }
    var data={};
    data['system_div'] = $('.search-block #system_div_s').val();
    $.ajax({
        type: 'POST',
        url: '/master/system/s001/target',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            selectize_sub.setValue('', true);
            selectize_sub.clearOptions();
            selectize_sub.addOption(res.data);
            selectize_sub.removeOption(0);
            if ($('.search-block #system_div_s').val() == 0) {
                selectize_sub.disable();
            } else {
                selectize_sub.enable();
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

