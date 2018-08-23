$(function(){
	try{
		init_v002();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v002(){
	initevent_v002();
    initImageUpload();
    if(typeof window.location.href.split('?')[1] != 'undefined'){
        $('#vocabulary_id').val(window.location.href.split('?')[1]);
        $('#vocabulary_dtl_id').val(window.location.href.split('?')[2]);
        $('#vocabulary_id').trigger('change');
    }else{
        $('#vocabulary_nm').focus();
    }
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

    $(document).on('change','#catalogue_div',function(){
        $('.old-content').addClass('hidden');
        switch(media_div){
        case 0:
            break;
        case 1:
            $(".old-input-audio").closest('.old-content[transform-div='+$(this).val()+']').removeClass('hidden');
            break;
        case 2:
            $(".old-input-image-custom").closest('.old-content[transform-div='+$(this).val()+']').removeClass('hidden');
            break;

        }
        _this=$(this);
        var sub_item=$('.transform-content').filter(function(){
            return $(this).attr('transform-div').indexOf(_this.val())>=0;
        })
        sub_item.show();
        transform();

        updateCatalogue(this);
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
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
    data_addnew.append('header_data',JSON.stringify(header_data));
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
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}