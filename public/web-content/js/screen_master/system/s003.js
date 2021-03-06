$(function(){
	try{
		init_s003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_s003(){
	initevent_s003();
}

function initevent_s003(){
	$(document).on('click','#btn-add',function(){
		s003_addNew();
	})

    $(document).on('click','#btn-delete',function(){
       if($('.sub-checkbox:visible:checked').length!=0){
            showMessage(3,function(){
                s003_delete();
           });
        }
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })

    $(document).on('change','#system_div',function(){
        getTarget();
    })
}

function s003_addNew(){
	var data_addnew=getInputData(1);

	$.ajax({
        type: 'POST',
        url: '/master/system/s003/addnew',
        dataType: 'json',
        loading:true,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#account_id').val(res.data[0].acc_id);
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

function s003_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/system/s003/delete',
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

function getTarget(){
    var selectize_sub= $('#account_div')[0].selectize;
    if($('#system_div').val()==0){
        selectize_sub.setValue('', true);
        selectize_sub.clearOptions();
        selectize_sub.disable();
        return;
    }
    var data={};
    data['system_div'] = $('#system_div').val();
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
            if ($('#target_div').val() == 0) {
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