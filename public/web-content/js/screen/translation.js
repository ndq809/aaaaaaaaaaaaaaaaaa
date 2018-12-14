var slider;
var TranslationArray;
var post;
var En_Array,Vi_Array, sentenceIndex = 0;
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
    slidePositionController();
    if ($('.table-click tbody tr').first().hasClass('no-data')) {
        if ($('#catalogue-tranfer').attr('value') != '') {
            var selectize_temp = $('#catalogue_nm')[0].selectize;
            selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')), true);
            updateGroup($('#catalogue_nm'), $('#group-transfer').attr('value'));
        } else {
            $('#catalogue_nm').trigger('change');
        }
    } else {
        if ($('.table-click tbody tr.selected-row').length == 0) {
            if ($('#catalogue-tranfer').attr('value') != '') {
                var selectize_temp = $('#catalogue_nm')[0].selectize;
                selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')), true);
                updateGroup($('#catalogue_nm'), $('#group-transfer').attr('value'));
            } else {
                $('.table-click tbody tr:first-child').trigger('dblclick');
            }
        } else {
            $('.table-click tbody tr.selected-row').trigger('dblclick');
        }
    }
    if(storage.getItem('en_text')!=null){
        $('#en_text').val(storage.getItem('en_text'));
        $('#vi_text').val(storage.getItem('vi_text'));
    }

    $('#en_text').trigger('change');
    $('#vi_text').trigger('change');

    setInterval(function(){
        storage.setItem('en_text',$('#en_text').val());
        storage.setItem('vi_text',$('#vi_text').val());
    },10000)
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
                addExample(voc_infor, function() {
                    $('#exam-order').val(1);
                    $('#exam-order').trigger('change');
                });
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
    $(window).resize(function() {
        slidePositionController();
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
            // $('#btn-next').click();
        }
    }, 20))

    $(document).on('mouseup', throttle(function(e) {
        if($('#en_text').is(':focus')||$('#vi_text').is(':focus')){
            if($('textarea:focus').val()!=''){
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

function installSlide() {
    $("#mySlider1").AnimatedSlider({
        visibleItems: 3,
        infiniteScroll: true,
    });
    slider = $("#mySlider1").data("AnimatedSlider");
    slider.setItem($('#tab1 table tbody tr').first().attr('id') - 1);
    setContentBox($('#tab1 table tbody tr').first().attr('id'));
}

function slidePositionController() {
    var coverWidth = $(".slider-wrap").width() / 2;
    $(".choose_slider_items .current_item").css("left", coverWidth - 150);
    $(".choose_slider_items .previous_item").css("left", coverWidth - 320);
    $(".choose_slider_items .next_item").css("left", coverWidth + 20);
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
    $('#en_sentence').focus();
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
    $('#en_sentence').focus();
}

function selectTranslation(sentenceIndex) {
    $('#en_sentence').val(En_Array[sentenceIndex]);
    $('#vi_sentence').val(Vi_Array[sentenceIndex]);
    $('#en_sentence').trigger('change');
    scrollTextarea(En_Array[sentenceIndex],$('#en_text')[0]);
    scrollTextarea(Vi_Array[sentenceIndex],$('#vi_text')[0]);
    if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#en_sentence').focus();
    }
}

function switchTabTranslation(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if ($(selectedTab + ' .activeItem').length == 0) {
        selectTranslation($(selectedTab + " table tbody tr").first());
    } else {
        selectTranslation($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberTranslation(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(1);
    voc_infor.push(2);
    voc_infor.push(post[0]['row_id']);
    voc_infor.push(post[0]['id']);
    rememberItem(currentItem, "Đã quên", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextTranslation();
        }
    })
}

function forgetTranslation(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(post[0]['row_id']);
    voc_infor.push(post[0]['id']);
    voc_infor.push(2);
    forgetItem(currentItem, "Đã thuộc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextTranslation();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/Translation/getData',
        dataType: 'json',
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    TranslationArray = res.voca_array;
                    installSlide();
                    slidePositionController();
                    if ($('#target-id').attr('value') != '') {
                        $('.table-right tbody tr[id=' + getRowId($('#target-id').attr('value')) + ']').trigger('click');
                    } else {
                        $('#tab1 .table-right tbody tr:first').trigger('click');
                    }
                    if ($('.activeItem').parents('.tab-pane').attr('id') == 'tab2') {
                        switchTab(2);
                    } else {
                        switchTab(1);
                    }
                    $('#target-id').attr('value', '')
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

function updateGroup(change_item, sub_item_text) {
    var data = $(change_item).val();
    var selectize_sub = $('#group_nm')[0].selectize;
    $('.group_nm .selectize-dropdown-content :not([data-parent-id=' + data + '])').addClass('hidden');
    $('.group_nm .selectize-dropdown-content [data-parent-id=' + data + ']').removeClass('hidden');
    if (typeof sub_item_text == 'undefined') {
        selectize_sub.setValue($('.group_nm .selectize-dropdown-content :not(".hidden")').first().attr('data-value'));
    } else {
        selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
    }
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
    $('.analysis[type='+type+'] .list').html(array.join(','));
}