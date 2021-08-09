$(function(){
	try{
		init_g005();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g005(){
	initevent_g005();
    $('.update-block #catalogue_nm')[0].selectize.disable();
    $('.update-block #group_nm')[0].selectize.disable();
}

function initevent_g005(){
	$(document).on('click','#btn-list',function(){
		g005_execute(1);
	})

	$(document).on('click','#btn-save',function(){
        if($('.table-focus tbody tr td.edit-row').length!=0){
            showMessage(1,function(){
                g005_update();
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
                g005_update(false);
                g005_execute(parseInt(page, 10));
           });
        }else{
            g005_execute(parseInt(page, 10));
        }
        
    })
    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
    $(document).on('click','#btn-delete',function(){
        if($('.sub-checkbox:checked').length!=0){
           showMessage(3,function(){
                g005_delete();
           }); 
        }
    })

    $(document).on('change','.search-block #catalogue_div_s',function(){
        updateCatalogue_s(this);
    })

     $(document).on('change','.update-block #catalogue_div',function(){
        updateCatalogue(this,$('.table-focus .update-row td[refer-id=catalogue_nm]').text());
    })

     $(document).on('change','#catalogue_nm_s',function(){
        updateGroup_s(this);
    })

     $(document).on('change','#catalogue_nm',function(){
        updateGroup(this,$('.table-focus .update-row td[refer-id=group_nm]').text());
    })
}

function g005_execute(page){
	var data=getInputData();
    _pageSize=10;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/general/g005/list',
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

function g005_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/general/g005/delete',
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

function g005_update(trigger){
    clearFailedDataTable();
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/general/g005/update',
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

function updateCatalogue(change_item,sub_item_text){
    parent_div='.update-block';
    sub_item='#catalogue_nm';
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getcatalogue',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
                    selectize_sub.setValue('');
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
                    if($(change_item).val()==0){
                        selectize_sub.disable();
                    }else{
                        selectize_sub.enable();
                        selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
                    }
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

function updateGroup(change_item,sub_item_text){
    parent_div='.update-block';
    sub_item='#group_nm';
    var data=$(change_item).val();
    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
    if($(change_item).val()==0){
        selectize_sub.setValue('',true);
        selectize_sub.clearOptions();
        selectize_sub.disable();
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    selectize_sub.setValue('',true);
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
                    if($(change_item).val()==0){
                        selectize_sub.disable();
                    }else{
                        selectize_sub.enable();
                        selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
                    }
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

function updateCatalogue_s(change_item){
     var parent_div='.search-block';
     var sub_item='#catalogue_nm_s';
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getcatalogue',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
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

function updateGroup_s(change_item){
    var parent_div='.search-block';
    var sub_item='#group_nm_s';
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
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
