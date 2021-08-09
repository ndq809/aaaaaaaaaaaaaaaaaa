var word_array = [];
var index_array = [0];
$(function(){
	try{
		init_v003();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_v003(){
	initevent_v003();
    $(".input-file").fileinput({
        browseIcon : "<i class=\"glyphicon glyphicon-list-alt\"></i> ",
        browseLabel : "Duyệt file",
        allowedFileTypes:['text'],
        showFileFooterCaption:true,
        // initialPreview: [
        //     '<audio controls=""> <source src="/web-content/audio/listeningAudio/audio_5b58278fbeaca.mp3" type="audio/mp3"> </audio>'
        // ],
    });
    $('.input-file').on('fileselect', function(event, numFiles, label) {
        word_array = [];
        index_array = [0];
        readFile();
    });
    // v003_execute();
}

function initevent_v003(){
	$(document).on('change','#catalogue_nm',function(){
		// showMessage(1,function(){
            updateGroup(this);
       // });
	})

    $(document).on('change','[refer-id=status]',function(){
        if($(this).val()==2){
            var temp = $(this).closest('tr');
            var data = temp.find('.auto-fill').autocomplete( "search", temp.find('.auto-fill').val());
        }
    })

    $(document).on('change','[refer-id]:not(.auto-fill)',function(){
        var temp = $(this).closest('tr');
        if(temp.find('[refer-id=status]').val()==1){
            temp.find('[refer-id=status]').val(2);
            temp.find('.status').text('Thêm phiên bản mới');
        }
    })

    $(document).on('change','#block_no',function(){
        $('#import-data tbody tr:visible').remove();
        $('#render-name').val(word_array[index_array[$(this).val()]]!=undefined&&word_array[index_array[$(this).val()]]!=''?word_array[index_array[$(this).val()]].split('|||')[0].trim():'');
        for (var i = index_array[$(this).val()]+1; i < word_array.length; i++) {
            if(word_array[i]!=''&&word_array[i].charAt(0)=='|'){
                var clone = $('#rowclone').clone();
                clone.find('.row-index').text(i-index_array[$(this).val()]);
                if(word_array[i].split('|||').length>3){
                    clone.find('[refer-id=word]').val(word_array[i]!=''?word_array[i].split('|||')[1]:'');
                    clone.find('[refer-id=spelling]').val(word_array[i]!=''?('/'+word_array[i].split('|||')[2].trim().replace(/[/]/g, '')+'/'):'');
                    clone.find('[refer-id=mean]').val(word_array[i]!=''?word_array[i].split('|||')[3].trim():'');
                }else{
                    clone.find('[refer-id=word]').val(word_array[i]!=''?word_array[i].split('|||')[1]:'');
                    // clone.find('[refer-id=spelling]').val(word_array[i]!=''?('/'+word_array[i].split('|||')[2].trim()+'/'):'');
                    clone.find('[refer-id=mean]').val(word_array[i]!=''?word_array[i].split('|||')[2].trim():'');
                }
                clone.removeClass('hidden');
                clone.removeAttr('id');
                $('#import-data tbody').append(clone);
            }else{
                index_array.push(i);
                $('.ui-autocomplete').remove();
                createAutocomplete($('.auto-fill:visible'),function(event, ui,target){
                    event.preventDefault();
                    var temp = $(target).closest('tr');
                    temp.find('.auto-fill').val(ui.item.vocabulary_nm);
                    temp.find('[refer-id=id]').val(ui.item.id);
                    if(temp.find('[refer-id=status]').val()!=2){
                        temp.find('[refer-id]:not(.auto-fill)').each(function(){
                            $(this).val(ui.item[$(this).attr('refer-id')]);
                        })
                        temp.find('[refer-id=status]').val(1);
                    }
                });
                $( ".autocomplete" ).each(function(){
                    _this = $(this);
                    $(this).autocomplete({
                        minLength: 0,
                        source: _this.attr('source').split(','),
                        select: function(event, ui){
                            $(this).val(ui.item.value);
                            $(this).trigger('change');
                        }
                    }).click(function(){
                        $(this).autocomplete("search","");
                    });
                });
                $('.auto-fill:visible').first().focus();
                return;                
            }
        }
    })

    $(document).on('focus','.table input,.table textarea',function(){
        $('.active-row').removeClass('active-row');
        $(this).closest('tr').addClass('active-row');
    })

    $(document).on('click','.preview-audio',function(){
        $(this).parents('table').find('audio').each(function(){
            if(!$(this)[0].paused){
                $(this)[0].pause();
                $(this)[0].currentTime = 0;
            }
        });
        $(this).parent().find('audio')[0].play();
    })

    $(document).on('click','.btn-prev',function(){
        var temp = (Number($('#block_no').val()==''?0:$('#block_no').val()) - 1)<0?0:(Number($('#block_no').val()==''?0:$('#block_no').val()) - 1);
        $('#block_no').val(temp);
        $('#block_no').trigger('change');
    })

    $(document).on('click','.btn-next',function(){
        var temp = Number($('#block_no').val()==''?0:$('#block_no').val()) + 1;
        $('#block_no').val(temp);
        $('#block_no').trigger('change');
    })

    $(document).on('click','#btn-save',function(){
        showMessage(1,function(){
            v003_save();
       });
    })

    $(document).on('click','#btn-execute',function(){
        showMessage(1,function(){
            readFile();
       });
    })

    $(document).on('focus','#import-data tbody input',function(){
        $(this).select();
    })

    $(document).on('addrow','.btn-add',function(){
        var tr = $(this).parents('table').find('tbody tr:last-child');
        createAutocomplete(tr.find('.auto-fill'),function(event, ui,target){
            event.preventDefault();
            var temp = $(target).closest('tr');
            temp.find('.auto-fill').val(ui.item.vocabulary_nm);
            temp.find('[refer-id=id]').val(ui.item.id);
            if(temp.find('[refer-id=status]').val()!=2){
                temp.find('[refer-id]:not(.auto-fill)').each(function(){
                    $(this).val(ui.item[$(this).attr('refer-id')]);
                })
                temp.find('[refer-id=status]').val(1);
            }
        });
        tr.find( ".autocomplete" ).each(function(){
            _this = $(this);
            $(this).autocomplete({
                minLength: 0,
                source: _this.attr('source').split(','),
                select: function(event, ui){
                    $(this).val(ui.item.value);
                    $(this).trigger('change');
                }
            }).click(function(){
                $(this).autocomplete("search","");
            });
        });
    })
}

function updateCatalogue(change_item){
    var data=1;
    $.ajax({
        type: 'POST',
        url: '/master/writing/w002/getcatalogue',
        dataType: 'json',
        // loading:true,
        data:{
            data:data
        } ,//convert to object
        success: function (res) {
            switch(res.status){
                case 200:
                    $('#catalogue_nm')[0].selectize.setValue('',true);
                    $('#group_nm')[0].selectize.setValue('',true);
                    $('#catalogue_nm')[0].selectize.clearOptions();
                    $('#catalogue_nm')[0].selectize.addOption(res.data);
                    if($(change_item).val()==0){
                        $('#catalogue_nm')[0].selectize.disable();
                        $('#group_nm')[0].selectize.disable();
                    }else{
                        $('#catalogue_nm')[0].selectize.enable();
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
        // loading:true,
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

function v003_save(){
    var data = {};
    data['detail']=getWordTableData($('#import-data'));
    data['catalogue_nm'] = $('#catalogue_nm').val();
    data['group_nm'] = $('#group_nm').val();
	$.ajax({
        type: 'POST',
        url: '/master/writing/w003/save',
        dataType: 'json',
        loading:true,
        data: data,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    showMessage(42,function(){
                        var win = window.open('/master/writing/w002?'+res.post_id, '_blank');
                        win.focus();
                        updateCatalogue();
                        $('.btn-next').trigger('click');
                    },function(){
                        updateCatalogue();
                        $('.btn-next').trigger('click');
                    })
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

function readFile(){
    var data_addnew=new FormData($("#upload_form")[0]);
    $.ajax({
        type: 'POST',
        url: '/master/writing/w003/readFile',
        dataType: 'json',
        loading:true,
        processData: false,
        contentType : false,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    var data = res.data.filter(function(val){
                        return $.trim(val)!='';
                    })
                    word_array = data;
                    $('#block_no').val(0);
                    $('#block_no').trigger('change');
                    // showMessage(41,function(){
                    //     getData($("#key-word").val());
                    // });
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

function createAutocomplete(target,callback){
    target.autocomplete({
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: "/master/writing/w003/getAutocomplete",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    var temp = [];
                    if (data[0]['Vocabulary_nm'] != '') {
                        for (var i = 0; i < data.length; i++) {
                            temp.push
                            ({
                                    label: data[i]['Vocabulary_nm']+' ---- '+data[i]['mean']
                                ,   id: data[i]['id']
                                ,   vocabulary_nm: data[i]['Vocabulary_nm'] 
                                ,   vocabulary_div: data[i]['vocabulary_div'] 
                                ,   specialized: data[i]['specialized'] 
                                ,   field: data[i]['field'] 
                                ,   spelling: data[i]['spelling'] 
                                ,   mean: data[i]['mean'] 
                                ,   audio: data[i]['audio'] 
                            });
                        }
                    }
                    response(temp);
                }
            });
        },
        select: function(event, ui){
            callback(event, ui,this)
        },
        open: function(event, ui){
            if($(this).closest('tr').find('[refer-id=status]').val()==2){
                $('.ui-menu-item:visible').first().click();
            }
        },
        close: function(event, ui){
            if($(this).closest('tr').find('[refer-id=status]').val()!=1){
                $(this).closest('tr').find('[refer-id=status]').val(2)
                $(this).closest('tr').find('[refer-id=status]').trigger('change');
            }
        },
        // minLength: 3,
        delay: 300,
        autoFocus: true
    });
}

function getWordTableData(table){
    var data=[];
    var temp = '';
    var word_id = 0;
    var word_dtl_id = 0;
    table.find('tbody tr:visible').each(function(i){
        var row_data={};
        row_data['row_id']=i;
        if($(this).find('[refer-id=word]').val().trim()!=temp){
            word_id++;
            word_dtl_id = 0;
        }else{
            word_dtl_id++;
        }
        row_data['word_id']=word_id;
        row_data['word_dtl_id']=word_dtl_id;
        $(this).find('[refer-id]').each(function(){
            if($(this).hasClass('money')){
                var text = jQuery.grep($(this).val().split(','), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
            if($(this).hasClass('tel')){
                var text = jQuery.grep($(this).val().split('-'), function(value) {
                  return value;
                });
                row_data[$(this).attr('refer-id')]=text.join('');
            }else
                row_data[$(this).attr('refer-id')]=$(this).val();
        })
        temp = $(this).find('[refer-id=word]').val();
        data.push(row_data);
    })
    if(data.length==0){
        return [];
    }else{
        return $.extend({}, data);
    }
}