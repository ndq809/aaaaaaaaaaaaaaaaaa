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

	$(document).on('click','#btn-execute',function(){
        showMessage(1,function(){
            d001_update();
        });
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
        var status = 0;
        var result = $(this);
        var executeList = $(this).closest('tbody').find('.do-denounce');
        executeList.each(function(){
            if($(this).val()>status){
                status = $(this).val();
                result = $(this);
            }
        })
        $(this).closest('tbody').find('.result-flag span').text(result.find('option:selected').text());
        $(this).closest('tbody').find('.result-flag input').val(status);
    })

    $(document).on('change','.do-denounce-detail',function(){
        var own = $(this).closest('tr').attr('own');
        var role = $(this).closest('tr').attr('role');
        var status = 0;
        var result = $(this);
        var executeList = $(this).closest('tbody').find('tr[own='+own+'][role='+role+'] .do-denounce-detail');
        executeList.each(function(){
            if($(this).val()>status){
                status = $(this).val();
                result = $(this);
            }
        })
        var parent = $('#denounce-header tbody tr').find('.data-filter[own='+own+'][role='+role+']').closest('tr');
        parent.find('.do-denounce').val(status).trigger('change');
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
                case '0':
                    $('#date-from').val('');
                    $('#date-to').val('');
                    break;
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

    $(document).on('click','.btn-detail',function(){
        $(this).next('span').toggle();
    })

    $(document).on('click','.data-filter',function(){
        var filteredTbody = $('#denounce-detail tbody');
        if($(this).attr('role')==undefined){
            filteredTbody.find('tr[own='+$(this).attr("own")+']').removeClass('hidden');
            filteredTbody.find('tr[own!='+$(this).attr("own")+']').addClass('hidden');
        }else{
            filteredTbody.find('tr[own='+$(this).attr("own")+'][role='+$(this).attr("role")+']').removeClass('hidden');
            filteredTbody.find('tr[own!='+$(this).attr("own")+'],tr[role!='+$(this).attr("role")+']').addClass('hidden');
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
    var data={};
    data['data_header'] = getTableBodyData($('#denounce-header'));
    data['data_detail'] = getTableData($('#denounce-detail'),true);
    // data['data_validate']=getValidateTable();
    // console.log(data['data_validate']);
    // return;
    clearFailedDataTable();
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/denounce/d001/update',
        dataType: 'json',
        loading:true,
        data: data,//convert to object
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

function getValidateTable(){
    var data=[];
    var row_data={};
    $('#denounce-header tbody tr:visible').each(function(index){
        row_data={};
        row_data['row_id']=index;
        row_data['denounce_div'] = $(this).find('.do-denounce').val();
        data.push(row_data);
    })
    return data;
}
