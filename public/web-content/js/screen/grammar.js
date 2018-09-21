var slider;
var GrammarArray;
var AnswerArray;
$(function() {
    try {
        initGrammar();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initGrammar() {
    initListener();
    if ($('.table-click tbody tr').first().hasClass('no-data')) {
        if($('#catalogue-tranfer').attr('value')!=''){
            var selectize_temp= $('#catalogue_nm')[0].selectize;
            selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')),true);
            updateGroup($('#catalogue_nm'),$('#group-transfer').attr('value'));
        }else{
            $('#catalogue_nm').trigger('change');
        }
    } else {
        if ($('.table-click tbody tr.selected-row').length == 0) {
            if($('#catalogue-tranfer').attr('value')!=''){
                var selectize_temp= $('#catalogue_nm')[0].selectize;
                selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')),true);
                updateGroup($('#catalogue_nm'),$('#group-transfer').attr('value'));
            }else{
                $('.table-click tbody tr:first-child').trigger('dblclick');
            }
        } else {
            $('.table-click tbody tr.selected-row').trigger('dblclick');
        }
    }
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).attr("id") == 'btn_next') {
            nextGrammar();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousGrammar();
        }
        if ($(this).hasClass('btn-check-answer')) {
            checkAnswer();
        }
        if ($(this).hasClass('btn-refresh')) {
            getQuestion();
        }
        if ($(this).hasClass('btn-remember')) {
            rememberGrammar($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetGrammar($(this));
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(2, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-contribute-exa')) {
            if ($('#eng-clause').val().trim() != '' && $('#vi-clause').val().trim() != '') {
                current_id = $('.activeItem').attr('id');
                voc_infor = [];
                voc_infor.push(GrammarArray[current_id - 1]['row_id']);
                voc_infor.push(GrammarArray[current_id - 1]['post_id']);
                voc_infor.push(2);
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
        selectGrammar($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabGrammar($(this));
    });
    $(window).resize(function() {
        
    });
    $(document).on('keydown', function(e) {
        if (!(e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA')&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 37:
                    previousGrammar();
                    break;
                case 39:
                    nextGrammar();
                    break;
                default:
                    break;
            }
        }
    })
    $(document).on('change', '#catalogue_nm', function() {
        if ($('#catalogue_nm').val() != '') updateGroup(this);
    })

    $(document).on('click', '#btn-relationship', function() {
        var current_id = $('.activeItem').attr('id');
        window.open('/translate?v='+GrammarArray[current_id - 1]['id'], '_blank');
    })

    $(document).on('change', '#group_nm', function() {
        $('.table-click tbody tr').removeClass('selected-row');
        $('.table-click tbody tr').each(function() {
            if ($(this).find('td').eq(1).text().trim() == $("#catalogue_nm option:selected").text() && $(this).find('td').eq(2).text().trim() == $("#group_nm option:selected").text()) {
                $(this).addClass('selected-row');
            }
        })
        if($('.table-click tbody tr.selected-row').length!=0){
            $('.btn-add-lesson').prop('disabled','disabled');
        }else{
            $('.btn-add-lesson').removeAttr('disabled');
        }
        getData();
    })
    $(document).on('change', '#exam-order', function() {
        var page = 1;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(GrammarArray[current_id - 1]['row_id']);
        item_infor.push(GrammarArray[current_id - 1]['post_id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        getExample(parseInt(page, 10), item_infor, function() {
            setContentBox(current_id);
        });
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(GrammarArray[current_id - 1]['row_id']);
        item_infor.push(GrammarArray[current_id - 1]['post_id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        getExample(parseInt(page, 10), item_infor, function() {
            setContentBox(current_id);
        });
    })
    $(document).on('click', '.btn-effect', function(e) {
        e.stopPropagation();
        var _this = this;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(GrammarArray[current_id - 1]['row_id']);
        item_infor.push($(this).attr('id'));
        item_infor.push(1);
        item_infor.push(1);
        if ($(_this).hasClass('claped')) {
            item_infor.push(1);
        } else {
            item_infor.push(0);
        }
        toggleEffect(item_infor, function(effected_count) {
            $(_this).toggleClass('claped tada');
            $(_this).prev('.number-clap').text(effected_count);
        });
    })

    $('#popup-box1').on('show.bs.modal', function (e) {
        getQuestion();
    });
}

function nextGrammar() {
    var currentItemId = setNextItem();
    
    
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof GrammarArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + GrammarArray[currentItemId - 1]['post_id']);
}

function previousGrammar() {
    var currentItemId = setPreviousItem();
    
    
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof GrammarArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + GrammarArray[currentItemId - 1]['post_id']);
}

function selectGrammar(selectTrTag) {
    currentItemId = selectItem(selectTrTag);
    
    
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof GrammarArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + GrammarArray[currentItemId - 1]['post_id']);
}

function switchTabGrammar(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    $('.activeItem').removeClass('activeItem');
    selectGrammar($(selectedTab + " table tbody tr").first());
}

function rememberGrammar(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(2);//screen div
    voc_infor.push(1);
    voc_infor.push(GrammarArray[current_id - 1]['row_id']);
    voc_infor.push(GrammarArray[current_id - 1]['post_id']);
    rememberItem(currentItem, "Đã quên", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextGrammar();
        }
    })
}

function forgetGrammar(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(GrammarArray[current_id - 1]['row_id']);
    voc_infor.push(GrammarArray[current_id - 1]['post_id']);
    voc_infor.push(1);
    forgetItem(currentItem, "Đã học", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextGrammar();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/grammar/getData',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    GrammarArray = res.voca_array;
                    
                    if($('#target-id').attr('value')!=''){
                        $('.table-right tbody tr[id='+getRowId($('#target-id').attr('value'))+']').trigger('click');
                    }else{
                        $('#tab1 .table-right tbody tr:first').trigger('click');
                    }
                    if($('.activeItem').parents('.tab-pane').attr('id')=='tab2'){
                        switchTab(2);
                    }else{
                        switchTab(1);
                    }
                    $('#target-id').attr('value','')
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
    $('.group_nm .selectize-dropdown-content :not([data-parent-id='+data+'])').addClass('hidden');
    $('.group_nm .selectize-dropdown-content [data-parent-id='+data+']').removeClass('hidden');
    if (typeof sub_item_text == 'undefined') {
        selectize_sub.setValue($('.group_nm .selectize-dropdown-content :not(".hidden")').first().attr('data-value'));
    } else {
        selectize_sub.setValue(selectize_sub.getValueByText(sub_item_text));
    }
}

function setContentBox(word_id) {
    $('.grammar-box:not(.hidden)').addClass('hidden');
    $('.grammar-box[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.example-item:not(.hidden)').addClass('hidden');
    $('.example-item[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (word_id) + ']').removeClass('hidden');
    if($('#mySlider1 li').length==1){
        $('.choose_slider').height('235');
    }
}

function getRowId(id){
    for (var i = 0; i < GrammarArray.length; i++) {
        if(GrammarArray[i]['post_id'] == id){
            return GrammarArray[i]['row_id'];
        }
    }
}

function getQuestion() {
    var current_id = $('.activeItem').attr('id');
    var item_infor = [];
    item_infor.push(GrammarArray[current_id - 1]['post_id']);
    $.ajax({
        type: 'POST',
        url: '/common/getQuestion',
        dataType: 'json',
        loading:true,
        container:'#popup-box1 .modal-body',
        data: $.extend({}, item_infor), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#popup-box1 .modal-body').html(res.view1);
                    AnswerArray = res.data;
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

function checkAnswer(){
    $('.answer-box').removeClass('wrong-answer');
    $('.answer-box').removeClass('right-answer');
    $('.answer-box').each(function(i){
        check = -1;
        if($(this).find('input:checked').length != 0){
            $(this).find('input').each(function(j){
                var temp = $(this).is(':checked')?1:0;
                if(AnswerArray[(i*4)+j]['verify']!=temp){
                    check = 1;
                }
            })
            if(check==-1){
                check = 0;
            }
        }
        if(check == 1){
            $(this).addClass('wrong-answer');
            $(this).find('.result-icon').removeClass().addClass('result-icon fa fa-close');
        }else if(check == 0){
            $(this).addClass('right-answer');
            $(this).find('.result-icon').removeClass().addClass('result-icon fa fa-check');
        }
    })
}