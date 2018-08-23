var data_delete=[];
$(function(){
	try{
		init_m004();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_m004(){
	initevent_m004();
    initImageUpload();
}

function initevent_m004(){
	$(document).on('click','#btn-add',function(){
		m004_addNew();
	})

    $(document).on('click','#btn-delete',function(){
         if($('.sub-checkbox:visible:checked').length!=0){
            showMessage(3,function(){
                m004_delete();
           });
        }
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
}

function m004_addNew(){
	var data_addnew=getInputData(1);
	$.ajax({
        type: 'POST',
        url: '/master/data/m004/addnew',
        dataType: 'json',
        loading:true,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#emp_id').val(res.data[0].emp_id);
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

function m004_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/data/m004/delete',
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