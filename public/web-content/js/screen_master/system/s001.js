$(function(){
	try{
		init_s001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_s001(){
	initevent_s001();
    if($('#account_div').val()!=0){
        $('#account_div').trigger('change');
    }
}

function initevent_s001(){
	$(document).on('change','#account_div',function(){
		getPermission();
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

function setPermission(){
    var data=getPermissionArray();
    $.ajax({
        type: 'POST',
        url: '/master/system/s001/update',
        dataType: 'json',
        loading:true,
        data: {
            data: $.extend({}, data),
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