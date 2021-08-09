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
        showMessage(3,function(){
            m007_delete();
       });
    })

    $(document).on('click','#btn-add',function(){
        showMessage(1,function(){
            m007_add();
       });
    })

    $(document).on('change','.search-block #name_div',function(){
        m007_list();
    })

    $('.search-block #name_div')[0].selectize.on('option_add',function(){
        $('#btn-add').removeClass('btn-disable-custom');
        $('#btn-save').addClass('btn-disable-custom');
        $('#btn-delete').addClass('btn-disable-custom');
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

function m007_delete(){
    var data={};
    data['name_div']=$('.search-block #name_div').val();
    $.ajax({
        type: 'POST',
        url: '/master/data/m007/delete',
        dataType: 'json',
        loading:true,
        data: data,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(2,function(){
                        $('.search-block #name_div')[0].selectize.setValue('');
                        $('.search-block #name_div')[0].selectize.clearOptions();
                        $('.search-block #name_div')[0].selectize.addOption(res.data);
                        $('.search-block #name_div')[0].selectize.removeOption(0);
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

function m007_add(){
    var data={};
    data['name_div']=$('.search-block #name_div').val();
    data['data']=getTableData($('.submit-table'));
    $.ajax({
        type: 'POST',
        url: '/master/data/m007/add',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(2,function(){
                        $('.search-block #name_div')[0].selectize.setValue('');
                        $('.search-block #name_div')[0].selectize.clearOptions();
                        $('.search-block #name_div')[0].selectize.addOption(res.data);
                        $('.search-block #name_div')[0].selectize.removeOption(0)
                        $('.search-block #name_div')[0].selectize.setValue(res.data[res.data.length-1].value);
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

function m007_list(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/data/m007/list',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('.search-block #name_div')[0].selectize.setValue('',true);
            $('.search-block #name_div')[0].selectize.clearOptions();
            $('.search-block #name_div')[0].selectize.addOption(res.data);
            $('.search-block #name_div')[0].selectize.removeOption(0)
            $('.search-block #name_div')[0].selectize.setValue(data.name_div,true);
            $('#result').html(res.view);
            $('#btn-add').addClass('btn-disable-custom');
            $('#btn-save').removeClass('btn-disable-custom');
            $('#btn-delete').removeClass('btn-disable-custom');
            _data_delete=[];
            _data_edit=[];
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}