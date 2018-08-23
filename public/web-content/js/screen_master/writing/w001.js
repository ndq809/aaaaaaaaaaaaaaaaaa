$(function(){
	try{
		init_w001();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_w001(){
	initevent_w001();
    // selectize_sub.disable();
}

function initevent_w001(){
	$(document).on('click','#btn-list',function(){
		w001_execute(1);
	})

	$(document).on('click','#btn-save',function(){
        if($('.table-focus tbody tr td.edit-row').length!=0){
            showMessage(1,function(){
                w001_update();
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
                w001_update(false);
                w001_execute(parseInt(page, 10));
                // history.pushState({}, null, window.location.href.split('?')[0]+'?p='+page);
           });
        }else{
            w001_execute(parseInt(page, 10));
            // history.pushState({}, null, window.location.href.split('?')[0]+'?p='+page);
        }
        
    })
    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })
    $(document).on('click','#btn-delete',function(){
        if($('.sub-checkbox:checked').length!=0){
           showMessage(3,function(){
                w001_delete();
           }); 
        }
    })

    $(document).on('change','.search-block #catalogue_div_s',function(){
        updateCatalogue_s(this);
    })

     $(document).on('change','#catalogue_nm_s',function(){
        updateGroup_s(this);
    })

     $(document).on('click','.btn-preview',function(){
       _popup_transfer_array['post_id']=$(this).parents('tr').find('td').eq(2).text();
    })
}

function w001_execute(page){
	var data=getInputData();
    _pageSize=10;
    data['page_size'] = _pageSize;
    data['page'] = page;
	$.ajax({
        type: 'POST',
        url: '/master/writing/w001/list',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
            $(".btn-preview").fancybox({
                'width'         : '60%',
                'height'        : '90%',
                'autoScale'     : true,
                'transitionIn'  : 'none',
                'transitionOut' : 'none',
                'type'          : 'iframe',
                'autoSize'      : false,
            });
            _data_delete=[];
            _data_edit=[];
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function w001_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/general/w001/delete',
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

function w001_update(trigger){
    clearFailedDataTable();
    if(typeof trigger=='undefined')
        trigger=true;
    $.ajax({
        type: 'POST',
        url: '/master/general/w001/update',
        dataType: 'json',
        loading:true,
        data: $.extend({}, _data_edit),//convert to object
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

function updateCatalogue_s(change_item){
     var parent_div='.search-block';
     var sub_item='#catalogue_nm_s';
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getcatalogue',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
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

function updateGroup_s(change_item){
    var parent_div='.search-block';
    var sub_item='#group_nm_s';
    var data=$(change_item).val();
    var selectize_sub=$(parent_div).find(sub_item)[0].selectize;
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    selectize_sub.clearOptions();
                    selectize_sub.addOption(res.data);
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

