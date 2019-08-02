var catalogue_id=0;
var group_id=0;
var first_time = 0;
$(function(){
	try{
		init_v002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v002(){
    $('#catalogue_nm')[0].selectize.disable();
    $('#group_nm')[0].selectize.disable();
	initevent_v002();
    initImageUpload();
    if(typeof window.location.href.split('?')[1] != 'undefined'){
        $('#vocabulary_id').val(window.location.href.split('?')[1]);
        $('#vocabulary_dtl_id').val(window.location.href.split('?')[2]);
        $('#vocabulary_id').trigger('change');
    }else{
        $('#vocabulary_nm').focus();
    }
    createAutocomplete($("#vocabulary_nm"),function(event, ui){
        event.preventDefault();
        $("#vocabulary_nm").val(ui.item.vocabulary_nm);
        $("#vocabulary_id").val(ui.item.vocabulary_id);
        $("#vocabulary_dtl_id").val(ui.item.vocabulary_dtl_id);
        $("#vocabulary_id").trigger('change');
    });
}

function initevent_v002(){
	$(document).on('click','#btn-save',function(){
		showMessage(1,function(){
            v002_addNew();
       });
	})

    $(document).on('click','#btn-delete',function(){
        if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
            showMessage(3,function(){
                v002_delete();
           });
        }
    })

    $(document).on('click','#btn-upgrade',function(){
        if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
            showMessage(15,function(){
                v002_upgrage();
           });
        }
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

    $(document).on('change','#mission_data_div',function(){
        switch(true){
            case ($(this).val()*1==1&&$('#catalogue_div').val()*1!=0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.setValue(0); 
                $('#group_nm')[0].selectize.disable(); 
                break;
            case ($(this).val()*1==2&&$('#catalogue_div').val()*1!=0&&$('#catalogue_nm').val()*1==0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.setValue(0); 
                $('#group_nm')[0].selectize.disable(); 
                break;
            case ($(this).val()*1==2&&$('#catalogue_div').val()*1!=0&&$('#catalogue_nm').val()*1!=0) :
                $('#catalogue_nm')[0].selectize.enable();
                $('#group_nm')[0].selectize.enable(); 
                break;
            default :
                $('#catalogue_nm')[0].selectize.setValue(0);
                $('#catalogue_nm')[0].selectize.disable();
                $('#group_nm')[0].selectize.setValue(0); 
                $('#group_nm')[0].selectize.disable(); 
                break;
        }
    })

    $(document).on('change','#catalogue_div',function(){
        updateCatalogue(this);
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
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

    $(document).on('change','#vocabulary_id,#vocabulary_dtl_id',function(){
        if($('#vocabulary_id').val()!='' && $('#vocabulary_dtl_id').val()!=''){
            v002_refer();
        }
        })

    $(document).on('change','#post_title',function(){
        if($(this).val()!=''){
            $('.title-header span').text($(this).val());
        }else{
            $('.title-header span').text('Tiêu đề bài viết');
        }
    })

}

function v002_addNew(){
    var data_addnew=new FormData($("#upload_form")[0]);
    var header_data=getInputData(1);
    var same_data = getWorData($('#same-data'));
    var different_data = getWorData($('#different-data'));
    data_addnew.append('header_data',JSON.stringify(header_data));
    data_addnew.append('same_data',JSON.stringify(same_data));
    data_addnew.append('different_data',JSON.stringify(different_data));
    data_addnew.append('detail_body_data',JSON.stringify(getTableBodyData($('.submit-table-body'))));
	$.ajax({
        type: 'POST',
        url: '/master/vocabulary/v002/addnew',
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

function v002_upgrage(){
    var data_addnew=new FormData($("#upload_form")[0]);
    var header_data=getInputData(1);
    data_addnew.append('header_data',JSON.stringify(header_data));
    data_addnew.append('detail_body_data',JSON.stringify(getTableBodyData($('.submit-table-body'))));
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v002/upgrage',
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

function v002_delete(){
     var data=[];
    data.push($('#vocabulary_id').val());
    data.push($('#vocabulary_dtl_id').val());
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v002/delete',
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

function v002_refer(){
    var data={};
    data['vocabulary_id']=$('#vocabulary_id').val();
    data['vocabulary_dtl_id']=$('#vocabulary_dtl_id').val();
    $.ajax({
        type: 'POST',
        url: '/master/vocabulary/v002/refer',
        dataType: 'html',
        loading:true,
        data: data,//convert to object
        success: function (res) {
            $('#result').html(res);
            initFlugin();
            initImageUpload();
            $(".old-input-audio").fileinput({
                showCaption: true,
                showPreview: true,
                showRemove: false,
                showUpload: false,
                showCancel: false,
                showBrowse : false,
                showUploadedThumbs: false,
                initialCaption : 'Âm thanh cũ của từ vựng',
                initialPreview: [
                    '<audio controls=""><source src="'+$(".old-input-audio").attr('value')+'" type="audio/mp3"></audio>'
                ],
            });
            createAutocomplete($("#vocabulary_nm"),function(event, ui){
                event.preventDefault();
                $("#vocabulary_nm").val(ui.item.vocabulary_nm);
                $("#vocabulary_id").val(ui.item.vocabulary_id);
                $("#vocabulary_dtl_id").val(ui.item.vocabulary_dtl_id);
                $("#vocabulary_id").trigger('change');
            });
        }
    });
}

function createAutocomplete(target,callback){
    target.autocomplete({
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: "/master/vocabulary/v002/getAutocomplete",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    var temp = [];
                    if (data[0]['vocabulary_nm'] != '') {
                        for (var i = 0; i < data.length; i++) {
                            temp.push
                            ({
                                    label: data[i]['Vocabulary_nm']+' ---- '+data[i]['mean']
                                ,   vocabulary_id: data[i]['Vocabulary_id']
                                ,   vocabulary_dtl_id: data[i]['Vocabulary_dtl_id']
                                ,   vocabulary_nm: data[i]['Vocabulary_nm'] 
                                ,   vocabulary_div: data[i]['Vocabulary_div'] 
                                ,   specialized: data[i]['specialized'] 
                                ,   field: data[i]['field'] 
                                ,   spelling: data[i]['spelling'] 
                                ,   mean: data[i]['mean'] 
                            });
                        }
                    }
                    response(temp);
                }
            });
        },
        select: function(event, ui){
            callback(event, ui)
        },
        // open: function(event, ui){
        //     $('#ui-id-1').css('top',($("#vocabulary_nm").offset().top+50)+'px');
        // },
        // minLength: 3,
        delay: 500,
        autoFocus: true
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

function updateCatalogue(change_item){
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
