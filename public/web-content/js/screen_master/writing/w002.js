var catalogue_id=0;
var group_id=0;
var media_div = 0;
var first_time = 0;
var _vocabularyArray = [];
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
        // $('#catalogue_div')[0].selectize.focus();
        $('#catalogue_div').trigger('change');
    }
}

function initevent_w002(){
	$(document).on('click','#btn-add',function(){
		showMessage(1,function(){
            w002_addNew(1);
       });
	})

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
        transform(_this);
        if(_this.val()!=''){
            updateCatalogue(this);
        }
        else{
            first_time = 0;
        }
    })

    $(document).on('change','#catalogue_nm',function(){
        updateGroup(this);
    })

    $(document).on('change','.vocabulary_id',function(){
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
        first_time = 1;
        w002_refer($(this).val());
    })

    $('#catalogue_nm')[0].selectize.on('option_add',function(){
        updateGroup('');
    })

    $(document).on('change','#post_title',function(){
        if($(this).val()!=''){
            $('.title-header span').text($(this).val());
        }else{
            $('.title-header span').text('Tiêu đề bài viết');
        }
    })

    CKEDITOR.instances['post_content'].on("change",function() {
        var post_content = CKEDITOR.instances['post_content'].getData();
        $('.main-content').html(post_content);
        if(CKEDITOR.instances['post_content'].getData()==''){
            $('.main-content').html('nội dung bài viết');
        }
        if($('#catalogue_div').val()==3){
            var doc = nlp(post_content.replace(/<\/?[^>]+>/ig, " "));
            Listen_Cut_Array = doc.sentences().out('array');
            $('.listen-table-body tbody tr:visible').remove();
            for (var i = 0; i < Listen_Cut_Array.length; i++) {
                trClone = $('.listen-table-body tbody tr:first-child').clone();
                trClone.removeClass('hidden');
                trClone.find('td input').first().val(Listen_Cut_Array[i]);
                $('.listen-table-body tbody').append(trClone);
            }
            reIndex($('.listen-table-body')); 
            $('.listen-table-body tbody tr:visible td input').eq(1).focus(); 
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

    $(document).on('click','.btn-popup',function(){
         _popup_transfer_array['voc_array']=getTableTdData($('.submit-table'));
         _popup_transfer_array['result']=$(this).closest('.panel').find('.result');
    })

    $(document).on('addrow','#btn-new-body',function(){
        $(this).parents('table').find('.textarea-temp').remove();
        $(this).parents('table').find('tbody textarea.auto-resize').autoResize();
    })

    $(document).on('keydown', function(e) {
        switch (e.which) {
            case 32:
            e.stopPropagation();
            if($('.file-preview-frame audio')[0].paused){
                $('.file-preview-frame audio')[0].play();
            }else{
                $('.file-preview-frame audio')[0].pause();
            }
                break;
            case 37:
            e.stopPropagation();
            $('.file-preview-frame audio')[0].currentTime = $('.file-preview-frame audio')[0].currentTime-2;
                break;
            case 39:
            e.stopPropagation();
            $('.file-preview-frame audio')[0].currentTime = $('.file-preview-frame audio')[0].currentTime+2;
                break;
            case 40:
                $('input:focus').val($('.file-preview-frame audio')[0].currentTime.toFixed(4)) ;
                break;
            default:
                break;
        }
    })
}

function w002_addNew(mode){
    var data_addnew=new FormData($("#upload_form")[0]);
    var header_data=getInputData(1);
    if(mode!=undefined && mode == 1){
        header_data['post_id'] = '';
    }
    if($('.old-content:visible').length!=0&&header_data['post_media']==''){
        header_data['post_media'] = 'no-data';
    }
	data_addnew.append('header_data',JSON.stringify(header_data));
    data_addnew.append('detail_data',JSON.stringify(getTableTdData($('.submit-table'))));
    data_addnew.append('detail_body_data',JSON.stringify(getTableBodyData($('.exa-table-body'))));
    data_addnew.append('pra_body_data',JSON.stringify(getTableQuestionData($('.pra-table-body'))));
    data_addnew.append('listen_detail_data',JSON.stringify(getTableData($('.listen-table-body'))));
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
                    _vocabularyArray = res.data[2];
                    $('#post_id').val(res.data[0][0]['post_id']);
                    catalogue_id=res.data[0][0]['catalogue_id'];
                    group_id=res.data[0][0]['group_id'];
                    setMedia(res.data);
                    $('.update-block #catalogue_div')[0].selectize.setValue(Number(res.data[0][0]['catalogue_div']));
                    $('#post_title').val(res.data[0][0]['post_title']);
                    $('#post_title').trigger('change');
                    setTimeout(function(){
                      CKEDITOR.instances['post_content'].setData(res.data[0][0]['post_content'],function(){
                        // this.setReadOnly(true);
                        $('.main-content').html(CKEDITOR.instances['post_content'].getData());
                    });
                    }, 100);
                    
                    $('.result:visible').html(res.table_voc);
                    $('#result1').html(res.table_exa);
                    $('#result2').html(res.table_pra);
                    $('#result3').html(res.table_listen);
                    transform($('#catalogue_div'));
                     $(".btn-popup").fancybox({
                        'width'         : '90%',
                        'height'        : '90%',
                        'autoScale'     : true,
                        'transitionIn'  : 'none',
                        'transitionOut' : 'none',
                        'type'          : 'iframe',
                        'autoSize'      : false,
                    });
                     $('.pra-table-body').find('.textarea-temp').remove();
                     $('.pra-table-body').find('tbody textarea.auto-resize').autoResize();
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
        url: '/master/writing/w002/getcatalogue',
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
                    if(first_time != 1){
                        $('#post_tag').selectize()[0].selectize.destroy();
                        $('#post_tag').html('');
                        for (var i = 0; i < res.data[1].length; i++) {
                            $('#post_tag').append('<option value="'+res.data[1][i]['tag_id']+'">'+res.data[1][i]['tag_nm']+'</option>');
                        }
                        $('#post_tag').selectize({
                            delimiter: ',',
                            persist: false,
                            create: function(input) {
                                return {
                                    value: input+'**++**eplus',
                                    text: input
                                }
                            }
                        });
                    }
                    first_time = 0;
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
    media_div= data[0][0]['media_div']*1;
    switch(data[0][0]['media_div']*1){
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
                initialCaption : data[0][0]['post_media_nm'],
                initialPreview: [
                    '<audio controls=""><source src="'+data[0][0]['post_media']+'" type="audio/mp3"></audio>'
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
                initialCaption : data[0][0]['post_media_nm'],
                initialPreview: [
                    "<img src='"+data[0][0]['post_media']+"' class='kv-preview-data file-preview-image'>"
                ],
            }).trigger('previewloaded');
            $(".old-input-image-custom").closest('.old-content').removeClass('hidden');
            $(".input-image-custom").fileinput('clear');
            break;
        default:
            $('.link-media input').val(data[0][0]['post_media']);
    }
    $('#post_tag').selectize()[0].selectize.destroy();
    $('#post_tag').html('');
    for (var i = 0; i < data[5].length; i++) {
        if(data[5][i]['selected']==1){
            $('#post_tag').append('<option value="'+data[5][i]['tag_id']+'" selected = "selected">'+data[5][i]['tag_nm']+'</option>');
        }else{
            $('#post_tag').append('<option value="'+data[5][i]['tag_id']+'">'+data[5][i]['tag_nm']+'</option>');
        }
    }
    $('#post_tag').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input+'**++**eplus',
                text: input
            }
        }
    });
}

function transform(target){
    var sub_item=$('.transform-content').filter(function(){
        return $.inArray(target.val(),$(this).attr('transform-div').split(','))!=-1;
    })
    sub_item.show();
    sub_item.each(function(){
        if($('.old-content:visible').length==0 && ($(this).attr('transform-div')==3||$(this).attr('transform-div')==7)){
            $(this).addClass('required');
        }else{
            $(this).removeClass('required');
        }
        $('.copy-tr').find('input[type=checkbox]').prop('disabled',true);
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

