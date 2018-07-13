$(function(){
	try{
		init_w002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_w002(){
	initevent_w002();
    initImageUpload();
    $('#catalogue_nm')[0].selectize.disable();
    $('#group_nm')[0].selectize.disable();
    $(".input-image-custom").fileinput({
        browseIcon : "<i class=\"glyphicon glyphicon-picture\"></i> ",
        browseLabel : "Duyệt ảnh",
        allowedFileTypes:['image'],
        showFileFooterCaption:false,
        previewClass: 'no-footer-caption',
    });
}

function initevent_w002(){
	$(document).on('click','#btn-add',function(){
		w002_addNew();
	})

    $(document).on('click','#btn-delete',function(){
       if($('.sub-checkbox:visible:checked').length!=0){
            showMessage(3,function(){
                w002_delete();
           });
        }
    })

    $(document).on('change','.sub-checkbox',function(){
        updateDeleteArray(this);
    })

    $(document).on('change','#catalogue_div',function(){
        _this=$(this);
        var sub_item=$('.transform-content').filter(function(){
            return $(this).attr('transform-div').indexOf(_this.val())>=0;
        })
        sub_item.show();
        $('.transform-content').each(function(){
            if($(this).attr('transform-div').indexOf($('#catalogue_div').val())>=0){
                $(this).show();
            }else{
                $(this).hide();
            }
        })
        updateCatalogue(this);
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
    })

    $(document).on('change','.edit-confirm',function(){
        if(this.checked){
            $(this).parents('tr').find('input,select').val('');
            $(this).parents('tr').find('input,select').removeAttr('disabled');
        }else{
            $(this).parents('tr').find('input:not([type=checkbox]),select').prop('disabled',true);
        }
    })

    $('.image-custom-cover-w,.image-custom-cover-h').sizeChanged(function() {
        if($('.file-preview-image').height()>$('.file-preview-image').width()){
           $('.image-custom-cover-w').removeClass('image-custom-cover-w').addClass('image-custom-cover-h');
        }else{
            $('.image-custom-cover-h').removeClass('image-custom-cover-h').addClass('image-custom-cover-w');
        }
    })

    $(document).on('click','.table .btn-popup',function(){
        _popup_transfer_array['row_id']=$(this).parents('tr').index();
        _popup_transfer_array['vocabulary_div']=$(this).parents('tr').find('.vocabulary_div').val();
        _popup_transfer_array['vocabulary_nm']=$(this).parents('tr').find('.vocabulary_nm').val();
        _popup_transfer_array['mean']=$(this).parents('tr').find('.mean').val();
    })
}

function w002_addNew(){
    var data_addnew=new FormData($("#upload_form")[0]);
	data_addnew.append('header_data',JSON.stringify(getInputData(1)));
    data_addnew.append('detail_data',JSON.stringify(getTableData($('.submit-table'))));
    console.log(data_addnew);
	$.ajax({
        type: 'POST',
        url: '/master/writing/w002/addnew',
        dataType: 'json',
        loading:true,
        processData: false,
        contentType : false,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#group_id').val(res.data[0].gro_id);
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

function w002_delete(){
    $.ajax({
        type: 'POST',
        url: '/master/general/w002/delete',
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

function updateCatalogue(change_item){
    var data=$(change_item).val();
    $.ajax({
        type: 'POST',
        url: '/master/common/getcatalogue',
        dataType: 'json',
        loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #catalogue_nm')[0].selectize.setValue('');
                    $('.update-block #catalogue_nm')[0].selectize.clearOptions();
                    $('.update-block #catalogue_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('.update-block #catalogue_nm')[0].selectize.disable();
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #catalogue_nm')[0].selectize.enable();
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
        loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #group_nm')[0].selectize.setValue('');
                    $('.update-block #group_nm')[0].selectize.clearOptions();
                    $('.update-block #group_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('.update-block #group_nm')[0].selectize.disable();
                    }else{
                        $('.update-block #group_nm')[0].selectize.enable();
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