var catalogue_id=0;
var group_id=0;
var media_div = 0;
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
        defaultPreviewContent: "<img src='/web-content/images/background/tuchoitruycap.jpg' class='kv-preview-data file-preview-image'>",
        overwriteInitial: true,
    });
    CKEDITOR.instances['post_content'].on("instanceReady",function() {
        $('.preview-box').height($('.content-box').height()-2);
        $('.preview-box .main-content').css('max-height',$('.content-box').height()-$('.preview-box .title-header').height()-8);
         $('.content-box').sizeChanged(function() {
            $('.preview-box').height($('.content-box').height()-2);
            $('.preview-box .main-content').css('max-height',$('.content-box').height()-$('.preview-box .title-header').height()-8);
        })
    });
    if(typeof window.location.href.split('?')[1] != 'undefined'){
        $('#post_id').val(window.location.href.split('?')[1]);
        $('#post_id').trigger('change');
    }else{
        $('#catalogue_div')[0].selectize.focus();
    }
}

function initevent_w002(){
	$(document).on('click','#btn-save',function(){
		showMessage(1,function(){
            w002_addNew();
       });
	})

    $(document).on('click','#btn-delete',function(){
        if($('#post_id').val()!=''){
            showMessage(3,function(){
                w002_delete();
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

    $(document).on('change','.vocabulary_id',function(){
        console.log($(this).val());
        var temp = $(this).val();
        if(temp!=''){
            $(this).parents('tr').find('td .btn-copy').attr('title','Thêm 1 phiên bản khác của từ đang được chọn khi từ đó không có trong danh sách tìm kiếm và muốn chuyển đổi từ loại,cách dùng...(vd: Game->Gamer)');
            $(this).parents('tr').find('td .btn-copy').prop('disabled',false);
        }else{
            $(this).parents('tr').find('td .btn-copy').attr('title','Từ vựng chưa tồn tại trong hệ thống bạn phải lưu trước khi có thể thêm phiên bản');
            $(this).parents('tr').find('td .btn-copy').prop('disabled',true);
        }
    })

    $(document).on('change','#post_id',function(){
        w002_refer($(this).val());
    })

    $(document).on('change','#post_title',function(){
        if($(this).val()!=''){
            $('.title-header span').text($(this).val());
        }else{
            $('.title-header span').text('Tiêu đề bài viết');
        }
    })

    CKEDITOR.instances['post_content'].on("change",function() {
        $('.main-content').html(CKEDITOR.instances['post_content'].getData());
        if(CKEDITOR.instances['post_content'].getData()==''){
            $('.main-content').html('nội dung bài viết');
        }
    });

    $(document).on('change','.edit-confirm',function(){
        if(this.checked){
            $(this).parents('tr').find('input,select').val('');
            $(this).parents('tr').find('input,select').removeAttr('disabled');
        }else{
            $(this).parents('tr').find('input,select').val('');
            $(this).parents('tr').find('input:not([type=checkbox]),select').prop('disabled',true);
        }
        $(this).parents('tr').find('.vocabulary_id').trigger('change');
    })

    $('.input-image-custom').on('fileselect', function(event, numFiles, label) {
        $('.new-image').removeClass('image-custom-cover-w');
        $('.new-image').removeClass('image-custom-cover-h');
        if($('.new-image .file-preview-image:visible').height()>$('.new-image .file-preview-image:visible').width()){
           $('.new-image').removeClass('image-custom-cover-w').addClass('image-custom-cover-h');
        }else{
            $('.new-image').removeClass('image-custom-cover-h').addClass('image-custom-cover-w');
        }
    });

    $('.old-input-image-custom').on('previewloaded', function(event, numFiles, label) {
        $('.old-image').removeClass('image-custom-cover-w');
        $('.old-image').removeClass('image-custom-cover-h');
        $('.old-image img').on('load',function(){
            if($('.old-image img')[0]['height']>$('.old-image img')[0]['width']){
                $('.old-image').removeClass('image-custom-cover-w').addClass('image-custom-cover-h');
            }else{
                $('.old-image').removeClass('image-custom-cover-h').addClass('image-custom-cover-w');
            }
        })
        
    });

    

    $(document).on('click','.table .btn-popup',function(){
        _popup_transfer_array['row_id']=$(this).parents('tr').index();
        _popup_transfer_array['vocabulary_div']=$(this).parents('tr').find('.vocabulary_div').val();
        _popup_transfer_array['vocabulary_nm']=$(this).parents('tr').find('.vocabulary_nm').val();
        _popup_transfer_array['mean']=$(this).parents('tr').find('.mean').val();
    })
}

function w002_addNew(){
    var data_addnew=new FormData($("#upload_form")[0]);
    var header_data=getInputData(1);
    header_data.post_media=($('input[name=post_media]').val()!='')?$('input[name=post_media]').val():'no data';
	data_addnew.append('header_data',JSON.stringify(header_data));
    data_addnew.append('detail_data',JSON.stringify(getTableData($('.submit-table'))));
    data_addnew.append('detail_body_data',JSON.stringify(getTableBodyData($('.exa-table-body'))));
    data_addnew.append('pra_body_data',JSON.stringify(getTableQuestionData($('.pra-table-body'))));
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
                    $('#post_id').val(res.data[0].post_id);
                    showMessage(2,function(){
                        $('#post_id').trigger('change');
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

function w002_delete(){
     var data=[];
    data.push($('#post_id').val());
    $.ajax({
        type: 'POST',
        url: '/master/writing/w002/delete',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    showMessage(2,function(){
                        $('#post_id').trigger('change');
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

function w002_refer(post_id){
    var data=[];
    data.push(post_id);
    $.ajax({
        type: 'POST',
        url: '/master/writing/w002/refer',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data),//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    // if(res.data[0][0]['post_id']==''){
                    //     showMessage(5);
                    //     $('#post_id').val('');
                    //     return;
                    // }
                    $('#post_id').val(res.data[0][0]['post_id']);
                    catalogue_id=res.data[0][0]['catalogue_id'];
                    group_id=res.data[0][0]['group_id'];
                    setMedia(res.data[0][0]);
                    $('.update-block #catalogue_div')[0].selectize.setValue(Number(res.data[0][0]['catalogue_div']));
                    $('#post_title').val(res.data[0][0]['post_title']);
                    $('#post_title').trigger('change');
                    CKEDITOR.instances['post_content'].setData(res.data[0][0]['post_content']);
                    $('#result').html(res.table_voc);
                    $('#result1').html(res.table_exa);
                    $('#result2').html(res.table_pra);
                    transform();
                     $(".btn-popup").fancybox({
                        'width'         : '90%',
                        'height'        : '90%',
                        'autoScale'     : true,
                        'transitionIn'  : 'none',
                        'transitionOut' : 'none',
                        'type'          : 'iframe',
                        'autoSize'      : false,
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
        loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('.update-block #group_nm')[0].selectize.setValue('',true);
                    $('.update-block #group_nm')[0].selectize.clearOptions();
                    $('.update-block #group_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
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

function setMedia(data){
    media_div= data['media_div']*1;
    switch(data['media_div']*1){
        case 0:
            break;
        case 1:
            $(".old-input-audio").fileinput('refresh',{
                showCaption: true,
                showPreview: true,
                showRemove: false,
                showUpload: false,
                showCancel: false,
                showBrowse : false,
                showUploadedThumbs: false,
                initialCaption : data['post_media_nm'],
                initialPreview: [
                    '<audio controls=""><source src="'+data['post_media']+'" type="audio/mp3"></audio>'
                ],
            });
            $(".old-input-audio").closest('.old-content').removeClass('hidden');
            $(".input-audio").fileinput('clear');
            break;
        case 2:
            $(".old-input-image-custom").fileinput('refresh',{
                showCaption: true,
                showPreview: true,
                showRemove: false,
                showUpload: false,
                showCancel: false,
                showBrowse : false,
                showUploadedThumbs: false,
                initialCaption : data['post_media_nm'],
                initialPreview: [
                    "<img src='"+data['post_media']+"' class='kv-preview-data file-preview-image'>"
                ],
            }).trigger('previewloaded');
            $(".old-input-image-custom").closest('.old-content').removeClass('hidden');
            $(".input-image-custom").fileinput('clear');
            break;
    }
}

function transform(){
    $('.transform-content').each(function(){
        if($(this).attr('transform-div')<0){
            check = $(this).attr('transform-div').indexOf($('#catalogue_div').val()*-1)<0 && $('#catalogue_div').val()!='';
        }else{
            check = $(this).attr('transform-div').indexOf($('#catalogue_div').val())>=0 && $('#catalogue_div').val()!='';
        }
        if(check){
            $(this).show();
            if($('.old-content:visible').length==0 && ($(this).attr('transform-div')==3||$(this).attr('transform-div')==7)){
                $(this).addClass('required');
            }else{
                $(this).removeClass('required');
            }
            $(this).find('input').removeAttr('disabled');
            $('.copy-tr').find('input[type=checkbox]').prop('disabled',true);

        }else{
            $(this).hide();
            $(this).find('input').prop('disabled',true);
        }
    })
}