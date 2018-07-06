$(function(){
	try{
		init_m007();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_m007(){
	initevent_m007();
}

function initevent_m007(){
	$(document).on('click','#btn-save',function(){
        showMessage(1,function(){
		  m007_save();
        });
	})

    $(document).on('click','#btn-delete',function(){
       if($('.sub-checkbox:visible:checked').length!=0){
            showMessage(3,function(){
                m007_delete();
           });
        }
    })

    $(document).on('change','.search-block #name_div',function(){
        m007_list();
    })

}

function m007_save(){
	var data={};
	data[0]=getTableData($('.submit-table'));
	data['name_div']=$('.search-block #name_div').val();
	$.ajax({
        type: 'POST',
        url: '/master/data/m007/save',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(2,function(){
                    	$('.search-block #name_div').trigger('change');
                    });
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

function m007_delete(change_item){
    $.ajax({
        type: 'POST',
        url: '/master/general/m007/delete',
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

function m007_list(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/data/m007/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
            _data_delete=[];
            _data_edit=[];
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}