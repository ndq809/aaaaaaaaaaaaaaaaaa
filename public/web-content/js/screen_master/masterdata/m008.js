$(function(){
	try{
		init_m008();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_m008(){
	initevent_m008();
}

function initevent_m008(){
	$(document).on('click','#btn-save',function(){
        showMessage(1,function(){
		  m008_save();
        });
	})

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            m008_delete();
       });
    })

    $(document).on('click','#btn-add',function(){
        showMessage(1,function(){
            m008_add();
       });
    })

    $(document).on('change','.search-block #name_div',function(){
        m008_list();
    })

    $('.search-block #name_div')[0].selectize.on('option_add',function(){
        $('#btn-add').removeClass('btn-disable-custom');
        $('#btn-save').addClass('btn-disable-custom');
        $('#btn-delete').addClass('btn-disable-custom');
    })


}

function m008_save(){
	var data={};
	data[0]=getUnpivotData($('.submit-table'));
	data['name_div']=$('.search-block #name_div').val();
	$.ajax({
        type: 'POST',
        url: '/master/data/m008/save',
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

function m008_delete(){
    var data={};
    data['name_div']=$('.search-block #name_div').val();
    $.ajax({
        type: 'POST',
        url: '/master/data/m008/delete',
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

function m008_add(){
    var data={};
    data['name_div']=$('.search-block #name_div').val();
    data['data']=getTableData($('.submit-table'));
    $.ajax({
        type: 'POST',
        url: '/master/data/m008/add',
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

function m008_list(){
	var data=getInputData();
	$.ajax({
        type: 'POST',
        url: '/master/data/m008/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
            $('#result .money').trigger('blur');
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getUnpivotData(){
    var data = [];
    $('.submit-table tbody tr').each(function(){
        _this = $(this);
        $(this).find('td input:visible').each(function(i){
            var row_data={};
            row_data['name_div']=$('.search-block #name_div').val();
            row_data['target_dtl_div'] = _this.find('input[refer-id=target_dtl_div]').val();
            row_data['price_div'] = i+1;
            row_data['upr'] = $(this).val().replace(/,/g, '');
            if(row_data['upr']!=''){
                data.push(row_data);
            }
        })
    })
    return $.extend({}, data)
}