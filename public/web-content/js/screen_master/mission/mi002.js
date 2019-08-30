var catalogue_id=0;
var group_id=0;
var rank_to= 0;
var first_time = 0;
$(function(){
	try{
		init_mi002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_mi002(){
    $('#catalogue_nm')[0].selectize.disable();
    $('#group_nm')[0].selectize.disable();
	initevent_mi002();
    initImageUpload();
    if(typeof window.location.href.split('?')[1] != 'undefined'){
        $('#vocabulary_id').val(window.location.href.split('?')[1]);
        $('#vocabulary_dtl_id').val(window.location.href.split('?')[2]);
        $('#vocabulary_id').trigger('change');
    }else{
        $('#vocabulary_nm').focus();
    }
}

function initevent_mi002(){
	$(document).on('click','#btn-save',function(){
		showMessage(1,function(){
            mi002_addNew();
       });
	})

    $(document).on('click','#btn-delete',function(){
        if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
            showMessage(3,function(){
                mi002_delete();
           });
        }
    })

    $(document).on('click','#btn-add',function(){
        showMessage(1,function(){
            mi002_addNew(1);
       });
    })

    $(document).on('click','.btn-copy',function(){
        var copy_row=$(this).parents('tr').clone();
        copy_row.addClass('copy-tr');
        copy_row.find('input,select').prop('disabled',false);
        copy_row.find('input[type=checkbox]').prop('checked',true);
        copy_row.find('input[type=checkbox]').prop('disabled',true);
        $(this).parents('tbody').append(copy_row);
        reIndex($('.submit-table'));
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })

    $(document).on('change','#mission_user_div',function(){
        if($(this).val()*1!=2){
            $('.mission-user-panel').addClass('hidden');
            $('#rank-from').prop('disabled',false);
            $('#rank-to').prop('disabled',false);
        }else{
            $('.mission-user-panel').removeClass('hidden');
            $('#rank-from').prop('disabled',true).val(0);
            $('#rank-to').prop('disabled',true).val(0);
        }
    })

    $(document).on('change','#mission_data_div',function(){
        switch(true){
            case ($(this).val()*1==1&&$('#catalogue_div').val()*1!=0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.setValue(0,false); 
                $('#group_nm')[0].selectize.disable(); 
                break;
            case ($(this).val()*1==2&&$('#catalogue_div').val()*1!=0&&$('#catalogue_nm').val()*1==0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.setValue(0,false); 
                $('#group_nm')[0].selectize.disable(); 
                break;
            case ($(this).val()*1==2&&$('#catalogue_div').val()*1!=0&&$('#catalogue_nm').val()*1!=0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.enable(); 
                break;
            case ($(this).val()*1==3) :
                $('#catalogue_nm')[0].selectize.setValue(0,false);
                $('#catalogue_nm')[0].selectize.disable();
                $('#group_nm')[0].selectize.setValue(0,false); 
                $('#group_nm')[0].selectize.disable(); 
                break;
            default :
                $('#catalogue_nm')[0].selectize.setValue(0,false);
                $('#catalogue_nm')[0].selectize.disable();
                $('#group_nm')[0].selectize.setValue(0,false); 
                $('#group_nm')[0].selectize.disable(); 
                break;
        }

    })

    $(document).on('change','#catalogue_div',function(){
        _this = this;
        updateCatalogue(this,function(){
            switch(true){
                case ($('#mission_data_div').val()*1==3&&$(_this).val()*1==1) :
                    $('.transform-content[type=0]').removeClass('hidden');
                    $('.transform-content[type!=0]').addClass('hidden');
                    $('#catalogue_nm')[0].selectize.setValue(0,false);
                    $('#catalogue_nm')[0].selectize.disable();
                    $('#group_nm')[0].selectize.setValue(0,false); 
                    $('#group_nm')[0].selectize.disable(); 
                    break;
                case ($('#mission_data_div').val()*1==3&&$(_this).val()*1!=1) :
                    $('.transform-content[type=1]').removeClass('hidden');
                    $('.transform-content[type!=1]').addClass('hidden');
                    $('#catalogue_nm')[0].selectize.setValue(0,false);
                    $('#catalogue_nm')[0].selectize.disable();
                    $('#group_nm')[0].selectize.setValue(0,false); 
                    $('#group_nm')[0].selectize.disable(); 
                    $('.btn-popup:visible').attr('href',$('.btn-popup:visible').attr('href').split('?')[0]+'?catalogue_div='+$('#catalogue_div').val());
                    break;
                case ($('#mission_data_div').val()*1!=3) :
                    $('.transform-content[type=2]').removeClass('hidden');
                    $('.transform-content[type!=2]').addClass('hidden');
                    break;
                default :
                    break;
            }
        });
    })

    $(document).on('change','#catalogue_nm',function(){
        if($('#mission_data_div').val()*1==1){
            referCatalogue(this); 
        }else{
            updateGroup(this);
        }
    })

    $(document).on('change','#group_nm',function(){
        if($('#mission_data_div').val()*1==2){
            referGroup(this); 
        }
    })

    $(document).on('change','#rank-from',function(){
        _this = this;
        $('#rank-to').val(0);
        $('#rank-to option').filter(function(){
            return $(this).attr('value')*1 >= $(_this).val()*1;
        }).removeClass('hidden');

        $('#rank-to option').filter(function(){
            return $(this).attr('value')*1 < $(_this).val()*1;
        }).addClass('hidden');
        if(rank_to!=0){
            $('#rank-to').val(rank_to);
        }
    })

    $(document).on('addrow','.btn-add',function(){
        var temp = $(this).parents('table').find('tbody tr:last-child');
        createAutocomplete(temp.find('.auto-fill'),function(event, ui){
            event.preventDefault();
            temp.find('.auto-fill').val(ui.item.vocabulary_nm);
            temp.find('td[refer-id]').each(function(){
                $(this).text(ui.item[$(this).attr('refer-id')]);
            })
        });
    })

    $(document).on('change','#mission_id',function(){
        mi002_refer();
    })

    $(document).on('change','#post_title',function(){
        if($(this).val()!=''){
            $('.title-header span').text($(this).val());
        }else{
            $('.title-header span').text('Tiêu đề bài viết');
        }
    })

    $(document).on('click','.transform-content .btn-popup',function(){
         _popup_transfer_array['post_array']=getTableTdData($(this).closest('.panel').find('.submit-table:visible'));
         _popup_transfer_array['voc_array']=getTableTdData($(this).closest('.panel').find('.submit-table:visible'));
        _popup_transfer_array['catalogue_div'] = $('#catalogue_div').val();
         _popup_transfer_array['result']=$(this).closest('.panel').find('.result');
    })

    $(document).on('click','.mission-user-panel .btn-popup',function(){
         _popup_transfer_array['user_array']=getTableTdData($(this).closest('.panel').find('.submit-table:visible'));
         _popup_transfer_array['result']=$(this).closest('.panel').find('.result');

    })

    $(document).on('change','#exp',function(){
        $('#failed_exp').val(Number($(this).val())*20/100).tofix(0);
    })

    $(document).on('change','#cop',function(){
        $('#failed_ctp').val(Number($(this).val())*20/100).tofix(0);
    })

}

function mi002_addNew(mode){
    var data_addnew={};
    var detail_data1 = $.map(getTableTdData($('.mission-user-panel .submit-table:visible')),function(value,key){
        return {'id':value['account_id']};
    })
    var detail_data2 = $.map(getTableTdData($('.transform-content .submit-table:visible')),function(value,key){
        return {'id':value['id']};
    })
    data_addnew['header_data']=getInputData(1);
    if(mode!=undefined&&mode==1){
        data_addnew['header_data']['mission_id']= '';
    }
    data_addnew['header_data']['total_unit'] = $('.transform-content:not(.hidden) .total_unit').first().val();
    data_addnew['detail_data1']=detail_data1;
    data_addnew['detail_data2']=detail_data2;
	$.ajax({
        type: 'POST',
        url: '/master/mission/mi002/addnew',
        dataType: 'json',
        loading:true,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(2,function(){
                        $('#mission_id').val(res.data[0].mission_id);
                        $('#mission_id').trigger('change');
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
                case 209:
                    clearFailedValidate();
                    showMessage(12);
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

function mi002_upgrage(){
    var data_addnew=new FormData($("#upload_form")[0]);
    var header_data=getInputData(1);
    data_addnew.append('header_data',JSON.stringify(header_data));
    data_addnew.append('detail_body_data',JSON.stringify(getTableBodyData($('.submit-table-body'))));
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/mi002/upgrage',
        dataType: 'json',
        loading:true,
        processData: false,
        contentType : false,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#vocabulary_id').val(res.data[0].vocabulary_id);
                    $('#vocabulary_dtl_id').val(res.data[0].vocabulary_dtl_id);
                    showMessage(2,function(){
                        $('#vocabulary_id').trigger('change');
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
                case 209:
                    clearFailedValidate();
                    showMessage(12);
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

function mi002_delete(){
     var data=[];
    data.push($('#vocabulary_id').val());
    data.push($('#vocabulary_dtl_id').val());
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/mi002/delete',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(2,function(){
                        $('#vocabulary_id').trigger('change');
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

function mi002_refer(){
    var data={};
    data['mission_id']=$('#mission_id').val();
    $.ajax({
        type: 'POST',
        url: '/master/mission/mi002/refer',
        dataType: 'json',
        loading:true,
        data: data,//convert to object
        success: function (res) {
            $('.result').html('');
            $('.update-block').html(res.view1);
            if(res.data.catalogue_div==1){
                $('.transform-content[type=0] .result').html(res.view2);
            }else{
                $('.transform-content[type=1] .result').html(res.view2);
            }
            if(res.data.mission_user_div==2){
                $('.mission-user-panel .result').html(res.view3);
            }
            initFlugin();
            // $('.result').html(res.view2);
            catalogue_id = res.data.catalogue_id;
            group_id = res.data.group_id;
            rank_to = res.data.rank_to;
            $('#rank-from').trigger('change');
            $('#catalogue_div').trigger('change');
            $('#mission_data_div').trigger('change');
            // if($('#mission_user_div').val()==2){
                $('#mission_user_div').trigger('change');
            // }
        }
    });
}

function getWorData(table){
    var data = [];
    table.find('tbody tr:visible').each(function(i){
        var row_data={};
        row_data['row_id'] = i+1;
        row_data['word_id'] = $(this).find('td[refer-id=vocabulary_id]').text();
        row_data['word_dtl_id'] = $(this).find('td[refer-id=vocabulary_dtl_id]').text();
        if(row_data['word_id']!=''){
            data.push(row_data);
        }
    })
    if(data.length==0){
        return null;
    }else{
        return $.extend({}, data);
    }
}

function updateCatalogue(change_item,callback){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/writing/w002/getcatalogue',
        dataType: 'json',
        loading:false,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #catalogue_nm')[0].selectize.setValue('',true);
                    $('.update-block #group_nm')[0].selectize.setValue('',true);
                    $('.update-block #catalogue_nm')[0].selectize.clearOptions();
                    $('.update-block #catalogue_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('.update-block #catalogue_nm')[0].selectize.disable();
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #catalogue_nm')[0].selectize.enable();
                        if(catalogue_id!=0){
                            $('.update-block #catalogue_nm')[0].selectize.setValue(catalogue_id);
                        }
                    }
                    callback();
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

function referCatalogue(change_item){
    var data={};
    data['catalogue_div'] = $('#catalogue_div').val();
    data['catalogue_nm'] = $('#catalogue_nm').val();
    $.ajax({
        type: 'POST',
        url: '/master/mission/mi002/refer_catalogue',
        dataType: 'html',
        loading:false,
        data:data ,//convert to object
        success: function (res) {
            $('.result:visible').html(res);
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function updateGroup(change_item){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getgroup',
        dataType: 'json',
        loading:false,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #group_nm')[0].selectize.setValue('',true);
                    $('.update-block #group_nm')[0].selectize.clearOptions();
                    $('.update-block #group_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0||$('#mission_data_div').val()==1){
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #group_nm')[0].selectize.enable();
                        if(group_id!=0){
                            $('.update-block #group_nm')[0].selectize.setValue(group_id);
                        }
                    }
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

function referGroup(change_item){
    var data={};
    data['catalogue_div'] = $('#catalogue_div').val();
    data['catalogue_nm'] = $('#catalogue_nm').val();
    data['group_nm'] = $('#group_nm').val();
    $.ajax({
        type: 'POST',
        url: '/master/mission/mi002/refer_group',
        dataType: 'html',
        loading:false,
        data:data ,//convert to object
        success: function (res) {
            $('.result:visible').html(res);
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function transform(target){
    var sub_item=$('.transform-content').filter(function(){
        return $.inArray(target.val(),$(this).attr('transform-div').split(','))!=-1;
    })
    sub_item.show();
    sub_item.each(function(){
        $(this).find('select.allow-selectize,#post_media').addClass('submit-item');
        $(this).find('#post_media').attr('name','post_media');
    })
    var sub_item=$('.transform-content').filter(function(){
        return $.inArray(target.val(),$(this).attr('transform-div').split(','))==-1;
    })
     sub_item.each(function(){
        $(this).find('select.allow-selectize,#post_media').removeClass('submit-item');
        $(this).find('#post_media').removeAttr('name');
    })
    sub_item.hide();
}
