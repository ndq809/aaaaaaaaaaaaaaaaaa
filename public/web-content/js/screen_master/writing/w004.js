var word_array = [];
var index_array = [0];
var separate = 1,vi_content,en_content;
var En_Array=[],Vi_Array=[],Auto_Array=[], sentenceIndex = 0;
var postArray=[];
$(function(){
	try{
		init_w004();
	}catch(e){
		alert('エラーがあった :'+e);
	}
})

function init_w004(){
	initevent_w004();
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
    // w004_execute();
}

function initevent_w004(){
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
        w004_getPost();
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
            w004_save();
       });
    })

    $(document).on('click','#btn-execute',function(){
        showMessage(1,function(){
            readFile();
       });
    })

    $(document).on('click','.btn-edit',function(){
        if($(this).attr('mode')==0){
            $('#en_content').highlightWithinTextarea('destroy');
            $('#vi_content').highlightWithinTextarea('destroy');
            separate=0;
            $(this).text('Áp dụng');
            $(this).attr('mode',1);
        }else{
            doc = nlp($('#en_content').val());
            En_Array = doc.sentences().out('array');
            for (var i = 0; i < En_Array.length; i++) {
                if(En_Array[i].trim().substr(En_Array[i].trim().length-1)!='.'){
                    En_Array[i]=En_Array[i]+'. ';
                }else{
                    En_Array[i]=En_Array[i]+' ';
                }
            }
            en_content= En_Array.join('');
            $('#en_content').val(En_Array.join('\n'));
            scrollTextarea(En_Array[0],$('#en_content')[0]);

            doc = nlp($('#vi_content').val());
            Vi_Array = doc.sentences().out('array');
            for (var i = 0; i < Vi_Array.length; i++) {
                if(Vi_Array[i].trim().substr(Vi_Array[i].trim().length-1)!='.'){
                    Vi_Array[i]=Vi_Array[i]+'. ';
                }else{
                    Vi_Array[i]=Vi_Array[i]+' ';
                }
            }
            vi_content = Vi_Array.join('');
            $('#vi_content').val(Vi_Array.join('\n'));
            scrollTextarea(Vi_Array[0],$('#vi_content')[0]);
            $(this).text('Chỉnh sửa');
            $(this).attr('mode',0);
            separate=1;
        }
    })

    $(document).on('focus','#import-data tbody input',function(){
        $(this).select();
    })

    $(document).on('mouseup', throttle(function(e) {
        if(separate==1){
            if($('#en_content').is(':focus')||$('#vi_content').is(':focus')){
                if($('textarea:focus').val()!=''&&window.getSelection()==''){
                    sentenceIndex = $('textarea:focus')[0].value.substr(0, $('textarea:focus')[0].selectionStart).split("\n").length-1;
                    selectText(sentenceIndex);
                }
            }
        }
    }, 20))

    // $(document).on('change', '#en_content', function() {
    //     doc = nlp($('#en_content').val());
    //     En_Array = doc.sentences().out('array');
    //     scrollTextarea(En_Array[sentenceIndex],$('#en_content')[0]);
    // })

    // $(document).on('change', '#vi_content', function() {
    //     doc = nlp($('#vi_content').val());
    //     En_Array = doc.sentences().out('array');
    //     scrollTextarea(Vi_Array[sentenceIndex],$('#vi_content')[0]);
    // })

    $(document).on('addrow','.btn-add',function(){
        var tr = $(this).parents('table').find('tbody tr:last-child');
        createAutocomplete(tr.find('.auto-fill'),function(event, ui,target){
            event.preventDefault();
            var temp = $(target).closest('tr');
            temp.find('.auto-fill:visible').val(ui.item.vocabulary_nm);
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
        url: '/master/writing/w004/getcatalogue',
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

function w004_save(){
    var data = {};
    data['en_title']=$('#en_title').val();
    data['vi_title']=$('#vi_title').val();
    data['en_content']=en_content;
    data['vi_content']=vi_content;
    data['detail']=getWordTableData($('#import-data'));
    data['catalogue_nm'] = $('#catalogue_nm').val();
    data['group_nm'] = $('#group_nm').val();
	$.ajax({
        type: 'POST',
        url: '/master/writing/w004/save',
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

function w004_getPost(){
    var data = {};
    data['index']=$('#block_no').val();
    data['data'] = postArray[Number(data['index'])-1];
    $.ajax({
        type: 'POST',
        url: '/master/writing/w004/getPost',
        dataType: 'html',
        loading:true,
        data: data,
        success: function (res) {
            clearFailedValidate();
            $('#result').html(res);
            setData();
            if($('#vi_content').val()==''){
                autoTranslate();
            }
        },
        // Ajax error
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function readFile(index){
    var data_addnew=new FormData($("#upload_form")[0]);
    $.ajax({
        type: 'POST',
        url: '/master/writing/w004/readFile',
        dataType: 'json',
        loading:true,
        processData: false,
        contentType : false,
        data: data_addnew,
        success: function (res) {
            switch(res.status){
                case 200:
                    clearFailedValidate();
                    $('#result').html(res.view);
                    postArray=res.data;
                    setData();
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
                url: "/master/writing/w004/getAutocomplete",
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

function scrollTextarea(text,textarea){
    var parola_cercata = text; // the searched word
    var posi = separate==0?-1:jQuery(textarea).val().indexOf(parola_cercata); // take the position of the word in the text
    if (posi != -1) {
        var target = textarea;
            // select the textarea and the word
        target.focus();
            if (target.setSelectionRange)
                // target.setSelectionRange(posi, posi+parola_cercata.length);
                $(textarea).highlightWithinTextarea({
                    highlight: text // string, regexp, array, function, or custom object
                });
            else {
                var r = target.createTextRange();
                r.collapse(true);
                r.moveEnd('character',  posi+parola_cercata);
                r.moveStart('character', posi);
                r.select();
            }
        var objDiv = textarea;
        var sh = objDiv.scrollHeight; //height in pixel of the textarea (n_rows*line_height)
        var line_ht = jQuery(textarea).css('line-height').replace('px',''); //height in pixel of each row
        var n_lines = sh/line_ht; // the total amount of lines
        var char_in_line = jQuery(textarea).val().length / n_lines; // amount of chars for each line
        var height = Math.floor(posi/char_in_line); // amount of lines in the textarea
        jQuery(textarea).scrollTop(height*line_ht - 100); // scroll to the selected line
    } else {
        $(textarea).highlightWithinTextarea({
            highlight: '' // string, regexp, array, function, or custom object
        });
        // console.log('Không tìm thấy : '+text); // alert word not found@
    }
}

function selectText(sentenceIndex) {
    scrollTextarea(En_Array[sentenceIndex],$('#en_content')[0]);
    scrollTextarea(Vi_Array[sentenceIndex],$('#vi_content')[0]);
}

function setData(){
    // var doc = nlp($('#en_content').val());
    // En_Array = doc.sentences().out('array');
    // en_content=En_Array.join('');
    // $('#en_content').val(En_Array.join('\n'));
    // scrollTextarea(En_Array[0],$('#en_content')[0]);

    // doc = nlp($('#vi_content').val());
    // Vi_Array = doc.sentences().out('array');
    // vi_content=Vi_Array.join('');
    // $('#vi_content').val(Vi_Array.join('\n'));
    // scrollTextarea(Vi_Array[0],$('#vi_content')[0]);

    doc = nlp($('#en_content').val());
    En_Array = doc.sentences().out('array');
    for (var i = 0; i < En_Array.length; i++) {
        if(En_Array[i].trim().substr(En_Array[i].trim().length-1)!='.'){
            En_Array[i]=En_Array[i]+'. ';
        }else{
            En_Array[i]=En_Array[i]+' ';
        }
    }
    en_content= En_Array.join('');
    $('#en_content').val(En_Array.join('\n'));
    scrollTextarea(En_Array[0],$('#en_content')[0]);

    doc = nlp($('#vi_content').val());
    Vi_Array = doc.sentences().out('array');
    for (var i = 0; i < Vi_Array.length; i++) {
        if(Vi_Array[i].trim().substr(Vi_Array[i].trim().length-1)!='.'){
            Vi_Array[i]=Vi_Array[i]+'. ';
        }else{
            Vi_Array[i]=Vi_Array[i]+' ';
        }
    }
    vi_content = Vi_Array.join('');
    $('#vi_content').val(Vi_Array.join('\n'));
    scrollTextarea(Vi_Array[0],$('#vi_content')[0]);

    createAutocomplete($('.auto-fill'),function(event, ui,target){
        var temp = $(target).closest('tr');
        setTimeout(function function_name(argument) {
            temp.find('.auto-fill:visible').val(ui.item.vocabulary_nm);
            // body...
        },100)
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
}

function autoTranslate() {
    var data = {};
    data['title'] = $('#en_title').val();
    data['text'] = $('#en_content').val();
    $.ajax({
        type: 'POST',
        url: '/master/writing/w004/autoTranslate',
        dataType: 'json',
        loading:true,
        container:'#vi_content',
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#vi_title').val(res.title);
                    $('#vi_content').val(res.text);
                    doc = nlp($('#vi_content').val());
                    Vi_Array = doc.sentences().out('array');
                    vi_content=Vi_Array.join('');
                    $('#vi_content').val(Vi_Array.join('\n'));
                    scrollTextarea(Vi_Array[0],$('#vi_content')[0]);
                    break;
                case 210:
                    $('#auto_trans').val(res.data);
                    break;
                case 211:
                    $('#auto_trans').val(res.data);
                    break;
                default:
                    break;
            }
        },
        // Ajax error
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}