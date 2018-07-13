$(function(){
	try{
		init_g006();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_g006(){
	initevent_g006();
    $('#catalogue_nm')[0].selectize.disable();
    $('#group_nm')[0].selectize.disable();
}

function initevent_g006(){
	$(document).on('click','#btn-add',function(){
		g006_addNew();
	})

    $(document).on('click','#btn-delete',function(){
       if($('.sub-checkbox:visible:checked').length!=0){
            showMessage(3,function(){
                g006_delete();
           });
        }
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })

    $(document).on('change','#catalogue_div',function(){
        updateCatalogue(this);
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
    })
}

function g006_addNew(){
	var data_addnew=getInputData(1);

	$.ajax({
        type: 'POST',
        url: '/master/general/g006/addnew',
        dataType: 'json',
        loading:true,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#group_id').val(res.data[0].gro_id);
                    addNewRecordRow();
                    showMessage(2);
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data);
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

function g006_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/general/g006/delete',
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
                        $('#catalogue_div').trigger('change');
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

function updateCatalogue(change_item){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getcatalogue',
        dataType: 'json',
        loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #catalogue_nm')[0].selectize.setValue('');
                    $('.update-block #catalogue_nm')[0].selectize.clearOptions();
                    $('.update-block #catalogue_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('.update-block #catalogue_nm')[0].selectize.disable();
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #catalogue_nm')[0].selectize.enable();
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

function updateGroup(change_item){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #group_nm')[0].selectize.setValue('');
                    $('.update-block #group_nm')[0].selectize.clearOptions();
                    $('.update-block #group_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #group_nm')[0].selectize.enable();
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