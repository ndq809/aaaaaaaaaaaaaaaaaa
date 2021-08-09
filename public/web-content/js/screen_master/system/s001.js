$(function(){
	try{
		init_s001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_s001(){
	initevent_s001();
    $('#target_div').trigger('change');
}

function initevent_s001(){
	$(document).on('change','#account_div',function(){
        if($('#target_div').val()==1){
            getPermissionUser();
        }else{
            getPermission();
        }
	})

    $(document).on('change','#target_div',function(){
        getTarget();
    })
    $(document).on('click','#btn-save',function(){
        showMessage(1,function(){
            setPermission();
        });
    })
}

function getPermission(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/system/s001/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            $('#result').html(res);
            $('.sub-checkbox:not(.super-checkbox)').trigger('change');
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getPermissionUser(){
    var data=getInputData();
    $.ajax({
        type: 'POST',
        url: '/master/system/s001/list-user',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            $('#result').html(res);
            $('.sub-checkbox:not(.super-checkbox)').trigger('change');
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getTarget(){
    var selectize_sub= $('#account_div')[0].selectize;
    if($('#target_div').val()==0){
        selectize_sub.setValue('', true);
        selectize_sub.clearOptions();
        selectize_sub.disable();
        return;
    }
    var data={};
    data['system_div'] = $('#target_div').val();
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
            $('#account_div').trigger('change');
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function setPermission(){
    var data=getPermissionArray();
    $.ajax({
        type: 'POST',
        url: '/master/system/s001/update',
        dataType: 'json',
        loading:true,
        data: {
            data: $.extend({}, data),
            system_div:$('#target_div').val(),
            account_div:$('#account_div').val()
        },
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(2,function(){
                        window.location.reload();
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error,1);
                    break;
                case 207:
                    clearFailedValidate();
                    showFailedData(res.data,1);
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

function getPermissionArray(){
    var PermissionArray=[];
    $('.table-multicheckbox tbody tr:not(".tr-header")').each(function(){
        if($(this).find('input[type=checkbox]').is(":checked")){
            var element = {};
            element['screen_id']=$(this).find('td').first().text();
            element['remark']=$(this).find('input#remark').val();
            $(this).find('input[type=checkbox]').each(function(){
                element[$(this).attr('id')]=$(this).prop('checked')==true?1:0;
            })
            PermissionArray[PermissionArray.length]=element;
        }
    })
    return PermissionArray;
}