var slider;
var TranslationArray,TagMyPostArray,post;
var post;
var En_Array=[],Vi_Array=[],Auto_Array=[], sentenceIndex = 0;
var storage = window.localStorage;
$(function() {
    try {
        initTranslation();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initTranslation() {
    initListener();
    getData();
    // if(storage.getItem('en_text')!=null){
    //     $('#en_text').val(storage.getItem('en_text'));
    //     $('#vi_text').val(storage.getItem('vi_text'));
    // }
    // $('#en_text').trigger('change');
    // $('#vi_text').trigger('change');

    // setInterval(function(){
    //     storage.setItem('en_text',$('#en_text').val());
    //     storage.setItem('vi_text',$('#vi_text').val());
    // },10000)
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).attr("id") == 'btn-next') {
            nextSentence();
        }
        if ($(this).attr("id") == 'btn-prev') {
            previousSentence();
        }
        if ($(this).attr("id") == 'btn-clear') {
            $('post_id').val('');
            $('post_title').val('');
            $('#post_tag').selectize()[0].selectize.setValue('');
            $('.analysis .list').html('');
            $('textarea').val('');
            $('#en_text').highlightWithinTextarea({
                highlight: '' // string, regexp, array, function, or custom object
            });
            $('#vi_text').highlightWithinTextarea({
                highlight: '' // string, regexp, array, function, or custom object
            });
            Vi_Array =[];
            En_Array =[];
            $('#en_text').focus();
        }
        if ($(this).hasClass('btn-delete')) {
            deleteSentence($(this).parent().find('textarea'));
        }
        if ($(this).hasClass('btn-merge')) {
            if(sentenceIndex!=0){
                mergeSentence($(this).parent().find('textarea'));
            }
        }
        if ($(this).hasClass('btn-extend')) {
            $(this).parent().find('textarea').attr('rows', function(index, attr){
                return attr == 20 ? 10 : 20;
            });
            $(this).text(function(index,text){
                return text == 'Mở rộng' ? 'Thu nhỏ' : 'Mở rộng';
            });
        }
        if ($(this).hasClass('btn-save')) {
            save();
        }
        if ($(this).hasClass('btn-forget')) {
            forgetTranslation($(this));
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled', 'disabled');
            addLesson(1, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-contribute-exa')) {
            if ($('#eng-clause').val().trim() != '' && $('#vi-clause').val().trim() != '') {
                current_id = $('.activeItem').attr('id');
                voc_infor = [];
                voc_infor.push(post[0]['row_id']);
                voc_infor.push(post[0]['id']);
                voc_infor.push(1);
                voc_infor.push($('#eng-clause').val());
                voc_infor.push($('#vi-clause').val());
                addExample(voc_infor);
            }
        }
    });
    $(document).on("change", ":checkbox", function() {
        if (this.checked) {
            $("." + $(this).attr("id")).show();
        } else {
            $("." + $(this).attr("id")).hide();
        }
    });
    $(document).on("click", ".focusable table tbody tr", function() {
        selectTranslation($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabTranslation($(this));
    });

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            deletePost();
       });
    })

    $(document).on("click", ".left-tab .table tbody tr:not(.no-data)", function() {
        $('.left-tab .table tbody tr:not(.no-data)').removeClass('selected-row');
        $('.left-tab .table tbody tr:not(.no-data)[row_id='+$(this).attr('row_id')+']').addClass('selected-row');
        showEditPost($(this));
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey) {
            switch (e.which) {
                case 37:
                    previousSentence();
                    break;
                case 39:
                    nextSentence();
                    break;
                default:
                    break;
            }
        }
        if(e.which == 13 && $('#en_sentence').is(':focus')){
            En_Array[sentenceIndex] = $('#en_sentence').val().indexOf('\n')==0?$('#en_sentence').val().replace('\n','<<MISS CONTENT_'+(sentenceIndex+1)+'>>\n'):$('#en_sentence').val();
            for (var i = 0; i < En_Array.length; i++) {
                if(En_Array[i]==undefined || (En_Array[i]!=undefined && (En_Array[i].trim() =='' || En_Array[i].trim() =='\n') || En_Array[i].indexOf('<<MISS CONTENT_') != -1)){
                    En_Array[i] = '<<MISS CONTENT_'+(i+1)+'>>';
                }
            }

            $('#en_text').val(En_Array.join('\n'));
            $('#en_text').trigger('change');
            $('#btn-next').trigger('click');
        }
        if(e.which == 13 && $('#vi_sentence').is(':focus')){
            Vi_Array[sentenceIndex] = $('#vi_sentence').val().indexOf('\n')==0?$('#vi_sentence').val().replace('\n','<<CHƯA DỊCH_'+(sentenceIndex+1)+'>>\n'):$('#vi_sentence').val();
            for (var i = 0; i < Vi_Array.length; i++) {
                if(Vi_Array[i]==undefined || (Vi_Array[i]!=undefined && Vi_Array[i].trim() =='') || (Vi_Array[i]!=undefined && Vi_Array[i].indexOf('<<CHƯA DỊCH_') != -1)){
                    Vi_Array[i] = '<<CHƯA DỊCH_'+(i+1)+'>>';
                }
            }
            $('#vi_text').val(Vi_Array.join('\n'));
            $('#vi_text').trigger('change');
            $('#btn-next').click();
        }
    }, 20))

    $(document).on('mouseup', throttle(function(e) {
        if($('#en_text').is(':focus')||$('#vi_text').is(':focus')){
            if($('textarea:focus').val()!=''&&window.getSelection()==''){
                sentenceIndex = $('textarea:focus')[0].value.substr(0, $('textarea:focus')[0].selectionStart).split("\n").length-1;
                selectTranslation(sentenceIndex);
            }
        }
    }, 20))

    $(document).on('change', '#en_text', function() {
        var doc = nlp($(this).val());
        En_Array = doc.sentences().out('array');
        $(this).val(En_Array.join('\n'));
        $('#en_sentence').val(En_Array[sentenceIndex]);
        $('#en_sentence').trigger('change');
        scrollTextarea(En_Array[sentenceIndex],this);
        $('#en_sentence').focus();
        // sentenceIndex = 0;
    })

    $(document).on('change', '#vi_text', function() {
        var doc = nlp($(this).val());
        Vi_Array = doc.sentences().out('array');
        $(this).val(Vi_Array.join('\n'));
        $('#vi_sentence').val(Vi_Array[sentenceIndex]);
        scrollTextarea(Vi_Array[sentenceIndex],this);
        $('#en_sentence').focus();
    })

    $(document).on('change', '#en_sentence', throttle(function(e) {
        var temp =nlp($(this).val());
        listWord(temp.nouns().out('array'),1);
        listWord(temp.verbs().out('array'),2);
        listWord(temp.adjectives().out('array'),3);
        if(temp.sentences().out('normal')!=''){
            autoTranslate();
        }
        // sentenceIndex = 0;
    },500))
}

function nextSentence() {
    if(sentenceIndex==En_Array.length-1){
        sentenceIndex = 0;
    }else{
        sentenceIndex++;
    }
    $('#en_sentence').val(En_Array[sentenceIndex]);
    $('#vi_sentence').val(Vi_Array[sentenceIndex]);
    $('#en_sentence').trigger('change');
    scrollTextarea(En_Array[sentenceIndex],$('#en_text')[0]);
    scrollTextarea(Vi_Array[sentenceIndex],$('#vi_text')[0]);
    $('#vi_sentence').focus();
}

function previousSentence() {
    if(sentenceIndex==0){
        sentenceIndex = En_Array.length-1;
    }else{
        sentenceIndex--;
    }
    $('#en_sentence').val(En_Array[sentenceIndex]);
    $('#vi_sentence').val(Vi_Array[sentenceIndex]);
    $('#en_sentence').trigger('change');
    scrollTextarea(En_Array[sentenceIndex],$('#en_text')[0]);
    scrollTextarea(Vi_Array[sentenceIndex],$('#vi_text')[0]);
    $('#vi_sentence').focus();
}

function selectTranslation(sentenceIndex) {
    $('#en_sentence').val(En_Array[sentenceIndex]);
    $('#vi_sentence').val(Vi_Array[sentenceIndex]);
    $('#en_sentence').trigger('change');
    scrollTextarea(En_Array[sentenceIndex],$('#en_text')[0]);
    scrollTextarea(Vi_Array[sentenceIndex],$('#vi_text')[0]);
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#vi_sentence').focus();
    }
}

function getData() {
    var data = {};
    data.post_id = location.href.split('?v=')[1]!=undefined?location.href.split('?v=')[1]:'';
    $.ajax({
        type: 'POST',
        url: '/translation/getData',
        dataType: 'json',
        // loading:true,
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('.middle-content').html('');
                    $('.middle-content').append(res.view1);
                    $('.middle-content').append(res.view2);
                    TranslationArray = res.data[0];
                    TagMyPostArray = res.data[1];
                    // if ($('#target-id').attr('value') != '') {
                    //     $('.table-right tbody tr[id=' + getRowId($('#target-id').attr('value')) + ']').trigger('click');
                    // } else {
                    //     $('#tab1 .table-right tbody tr:first').trigger('click');
                    // }
                    // if ($('.activeItem').parents('.tab-pane').attr('id') == 'tab2') {
                    //     switchTab(2);
                    // } else {
                    //     switchTab(1);
                    // }
                    // $('#target-id').attr('value', '')
                    $('#post_tag').selectize({
                        delimiter: ',',
                        persist: false,
                        plugins: ['restore_on_backspace','remove_button'],
                        create: function(input) {
                            return {
                                value: input+'**++**eplus',
                                text: input
                            }
                        }
                    });
                    setCollapse();
                    break;
                case 201:
                    clearFailedValidate();
                    showFailedValidate(res.error);
                    break;
                case 208:
                    clearFailedValidate();
                    showMessage(4);
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

function setContentBox(word_id) {
    $('.Translation-box:not(.hidden)').addClass('hidden');
    $('.Translation-box[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.example-item:not(.hidden)').addClass('hidden');
    $('.example-item[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (word_id) + ']').removeClass('hidden');
    if ($('#mySlider1 li').length == 1) {
        $('.choose_slider').height('235');
    }
    if (typeof TranslationArray != 'undefined') {
        post = TranslationArray.filter(function(val) {
            return val['row_id'] == Number(word_id);
        });
    }
}

function getRowId(id) {
    for (var i = 0; i < TranslationArray.length; i++) {
        if (TranslationArray[i]['id'] == id) {
            return TranslationArray[i]['row_id'];
        }
    }
}

function scrollTextarea(text,textarea){
    var parola_cercata = text; // the searched word
    var posi = jQuery(textarea).val().indexOf(parola_cercata); // take the position of the word in the text
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

function deleteSentence(textarea){
    textAll = textarea.attr('id')== 'en_sentence'?'#en_text':'#vi_text';
    sentenceArray = textarea.attr('id')== 'en_sentence'?En_Array:Vi_Array;
    sentenceArray.splice(sentenceIndex,1);
    $(textAll).val(sentenceArray.join('\n'));
    $(textAll).trigger('change');
}

function mergeSentence(textarea){
    textAll = textarea.attr('id')== 'en_sentence'?'#en_text':'#vi_text';
    sentenceArray = textarea.attr('id')== 'en_sentence'?En_Array:Vi_Array;
    temp = sentenceArray[sentenceIndex];
    sentenceArray.splice(sentenceIndex,1);
    sentenceArray[sentenceIndex-1] = sentenceArray[sentenceIndex-1]+temp;
    $(textAll).val(sentenceArray.join('\n'));
    $(textAll).trigger('change');
}

function autoTranslate() {
    var data = {};
    data['text'] = $('#en_sentence').val();
    $.ajax({
        type: 'POST',
        url: '/translation/autoTranslate',
        dataType: 'json',
        loading:true,
        container:'#auto_trans',
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#auto_trans').val(res.data);
                    if($('#auto-fill').is(':checked') && nlp($('#vi_sentence').val()).sentences().out('normal')==''){
                        $('#vi_sentence').val(res.data);
                    }
                    Auto_Array[sentenceIndex] = res.data;
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

function listWord(array,type){
    for (var i = 0; i < array.length; i++) {
        array[i] = array[i].trim().replace(/[.?:,_!]/g, '');
        if(array[i]==''){
            array.splice(i,1);
        }
        array[i] = '<a target="_blank" href="/dictionary?v='+array[i]+'">'+array[i]+'</a>';
    }
    $('.analysis[type='+type+'] .list').html(array.join(', '));
}

function save() {
    var data = getInputData();
    data.en_text = $('#en_text').val();
    data.vi_text = $('#vi_text').val();
    for (var i = 0; i < En_Array.length; i++) {
        if(En_Array[i]==undefined || (En_Array[i]!=undefined && (En_Array[i].trim() =='' || En_Array[i].trim() =='\n') || En_Array[i].indexOf('<<MISS CONTENT_') != -1)){
            En_Array[i] = '';
        }
        if(Vi_Array[i]==undefined || (Vi_Array[i]!=undefined && Vi_Array[i].trim() =='') || (Vi_Array[i]!=undefined && Vi_Array[i].indexOf('<<CHƯA DỊCH_') != -1)){
            Vi_Array[i] = '';
        }
        if(Auto_Array[i]==undefined || (Auto_Array[i]!=undefined && Auto_Array[i].trim() =='')){
            Auto_Array[i] = '';
        }
    }
    data.en_array = convertObject(En_Array)
    data.vi_array = convertObject(Vi_Array)
    data.auto_array = convertObject(Auto_Array)
    data.save_mode = $('input[name=save-mode]').length!=0?$('input[name=save-mode]:checked').val():1;
    if(data.save_mode==1){
        data.post_id = '';
    }
    $.ajax({
        type: 'POST',
        url: '/translation/save',
        dataType: 'json',
        loading:true,
        // container:'#auto_trans',
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#popup-box5').modal('hide');
                    showMessage(2,function(){
                        TranslationArray = res.data[0];
                        TagMyPostArray = res.data[1];
                        $('.left-tab').remove();
                        $('.middle-content').prepend(res.view);
                        $('#post_tag').selectize()[0].selectize.destroy();
                        $('#post_tag').html('');
                        for (var i = 0; i < res.data[1].length; i++) {
                            if(res.data[1][i]['selected']==1){
                                $('#post_tag').append('<option value="'+res.data[1][i]['tag_id']+'" selected = "selected">'+res.data[1][i]['tag_nm']+'</option>');
                            }else{
                                $('#post_tag').append('<option value="'+res.data[1][i]['tag_id']+'">'+res.data[1][i]['tag_nm']+'</option>');
                            }
                        }
                        $('#post_tag').selectize({
                            delimiter: ',',
                            persist: false,
                            plugins: ['restore_on_backspace','remove_button'],
                            create: function(input) {
                                return {
                                    value: input+'**++**eplus',
                                    text: input
                                }
                            }
                        });
                        $('.selected-row').first().trigger('click');
                    });
                    break;
                case 201:
                    $('#popup-box5').modal('hide');
                    if(res.error.title!=undefined){
                        $('#post_title').addClass('input-error');
                        $('#post_title').attr('data-toggle','tooltip');
                        $('#post_title').attr('data-placement','top');
                        $('#post_title').attr('data-original-title','Tiêu đề không được rỗng');
                        $('[data-toggle="tooltip"]').tooltip();
                    }
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

function convertObject(single_array){
    var temp = $.map(single_array, function(val,index){
        return {'id':index,'value':val};
    });

    return temp;
}

function showEditPost(tr_tag){
    var item = Number(tr_tag.attr('row_id'));
    var temp = [];
    post = TranslationArray.filter(function(val){
        return val['row_id']==item;
    });
    var postTagArray = TagMyPostArray.filter(function(val){
        return val['row_id']==item;
    });

    var thisposttag=[];
    for (var i = 0; i < postTagArray.length; i++) {
        thisposttag.push(postTagArray[i]['tag_id']);
    }
    $('#post_tag').selectize()[0].selectize.setValue(thisposttag);
    $('#post_id').val(post[0]['post_id']);
    $('#post_title').val(post[0]['post_title']);
    $('#en_text').val(post[0]['en_text']);
    $('#vi_text').val(post[0]['vi_text']);
    $('#en_text').trigger('change');
    $('#vi_text').trigger('change');
}

function deletePost(){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    $.ajax({
        type: 'POST',
        url: '/translation/delete',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    showMessage(2,function(){
                        var temp = $('.left-tab .selected-row');
                        $('#btn-clear').trigger('click');
                        temp.remove();
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