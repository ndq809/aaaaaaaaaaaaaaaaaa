$(function(){
	try{
		init_d001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_d001(){
	initevent_d001();
	initImageUpload();
}

function initevent_d001(){
	$(document).on('click','#btn-list',function(){
		d001_execute(1);
	})

	$(document).on('click','#btn-save',function(){
        if($('.table-focus tbody tr td.edit-row').length!=0){
            showMessage(1,function(){
                d001_update();
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
                d001_update(false);
                d001_execute(parseInt(page, 10));
           });
        }else{
            d001_execute(parseInt(page, 10));
        }
        
    })
    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })

    $(document).on('change','.do-denounce',function(){
        if($(this).val()!=0){
            $(this).closest('tr').find('input[type=checkbox]').prop('checked',true);
        }else{
            $(this).closest('tr').find('input[type=checkbox]').prop('checked',false);
        }
        $(this).closest('tr').find('input[type=checkbox]').trigger('change');
    })

    $(document).on('change','#time_div_s',function(){
        if($(this).val()==0||$(this).val()==4){
            $('#date-from').prop('disabled',false);
            $('#date-to').prop('disabled',false);
        }else{
            var d = new Date();
            var now = new Date();
            $('#date-from').prop('disabled',true);
            $('#date-to').prop('disabled',true);
            switch ($(this).val()) {
                case '1':
                    $('#date-from').val($.datepicker.formatDate('dd/m/yy',new Date(d.setDate(d.getDate()))));
                    $('#date-to').val($.datepicker.formatDate('dd/m/yy',new Date(now.setDate(now.getDate() + 1))));
                    break;
                case '2':
                    $('#date-from').val($.datepicker.formatDate('dd/m/yy',new Date(d.setDate(d.getDate() - 7))));
                    $('#date-to').val($.datepicker.formatDate('dd/m/yy',new Date(now.setDate(now.getDate() + 1))));
                    break;
                case '3':
                    $('#date-from').val($.datepicker.formatDate('dd/m/yy',new Date(d.setMonth(d.getMonth() - 1))));
                    $('#date-to').val($.datepicker.formatDate('dd/m/yy',new Date(now.setDate(now.getDate() + 1))));
                    break;
                default:
                    break;
            }
        }
    })
    $(document).on('click','#btn-delete',function(){
        if($('.sub-checkbox:checked').length!=0){
           showMessage(3,function(){
                d001_delete();
           }); 
        }
    })

    $(document).on('click','.data-filter',function(){
        var filteredTbody = $('#denounce-detail tbody');
        if($(this).attr('role')==undefined){
            filteredTbody.find('tr[own='+$(this).attr("own")+']').removeClass('hidden');
            filteredTbody.find('tr[own!='+$(this).attr("own")+']').addClass('hidden');
        }else{
            filteredTbody.find('tr[own='+$(this).attr("own")+'][role='+$(this).attr("role")+']').removeClass('hidden');
            filteredTbody.find('tr[own!='+$(this).attr("own")+'],tr[role!='+$(this).attr("role")+']').addClass('hidden');
            console.log(filteredTbody.find('tr[own='+$(this).attr("own")+'][role='+$(this).attr("role")+']'));
            console.log(filteredTbody.find('tr[own!='+$(this).attr("own")+'],tr[role!='+$(this).attr("role")+']'));
        }
    })

     $(document).on('change','.search-block #system_div_s',function(){
        getTarget_s();
    })

     $(document).on('change','.update-block #system_div',function(){
        getTarget($('.update-row td:nth-child(7)').text());
    })
}

function d001_execute(page){
	var data=getInputData();
    _pageSize=2;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/denounce/d001/list',
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

function d001_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/denounce/d001/delete',
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

function d001_update(trigger){
    clearFailedDataTable();
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/denounce/d001/update',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_delete),//convert to object
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
