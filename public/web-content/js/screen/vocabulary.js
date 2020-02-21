var slider;
var vocabularyArray;
var post;
var runtime = 0;
$(function() {
    try {
        initVocabulary();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initVocabulary() {
    initListener();
    installSlide();
    slidePositionController();
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
                if($('#catalogue_nm').is(':disabled')){
                    getData();
                }else{
                    $('.table-click tbody tr:first-child').trigger('dblclick');
                }
            }
        } else {
            $('.table-click tbody tr.selected-row').trigger('dblclick');
        }
    }
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).hasClass('btn-remember')) {
            rememberVocabulary($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetVocabulary($(this));
        }
        if ($(this).hasClass('btn-reload')) {
            getData();
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
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

     $(document).on('click','h5',function(){
        if ($(this).attr("id") == 'btn_next') {
            nextVocabulary();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousVocabulary();
        }
    })

    $(document).on("change", ":checkbox", function() {
        if (this.checked) {
            $("." + $(this).attr("id")).show();
            if($(this).attr('id')=='vocal-engword'){
                $('.input-wrap').addClass('hidden');
                $('.voc_nm').removeClass('hidden');
                $('.voc_pass').addClass('hidden');
            }
        } else {
            $("." + $(this).attr("id")).hide();
            if($(this).attr('id')=='vocal-audio'){
                $('.vocabulary-box').find('audio').each(function() {
                    if (!$(this)[0].paused) {
                        $(this)[0].pause();
                        $(this)[0].currentTime = 0;
                    }
                });
            }
            if($(this).attr('id')=='vocal-engword'){
                $('.input-wrap').removeClass('hidden');
                $('.vocal-engword-input:visible').val('').focus();
                $('.voc_nm').addClass('hidden');
                $('.voc_pass').removeClass('hidden');
            }
        }
    });
    $(document).on("click", ".focusable table tbody tr", function() {
        selectVocabulary($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabVocabulary($(this));
    });
    $(window).resize(function() {
        slidePositionController();
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 38:
                    previousVocabulary();
                    break;
                case 40:
                    nextVocabulary();
                    break;
                default:
                    break;
            }
        }
    },33))
    
    $(document).on('change', '#catalogue_nm', function() {
        if ($('#catalogue_nm').val() != '') updateGroup(this);
    })

    $(document).on('click', '#btn-relationship', function() {
        var current_id = $('.activeItem').attr('id');
        window.open('/dictionary?v='+post[0]['id'], '_blank');
    })

     $(document).on('keyup', '.vocal-engword-input:visible', function() {
        //remove all special charracter and unless space in string to compare
        var value = $(this).val().substring(0,$(this).val().length-1).replace(/[^a-z0-9\s]/gi, ' ').replace(/[_\s]/g, ' ').replace(/\s\s+/g, ' ').toLowerCase().trim();
        var root_value = $('.vocabulary-box:visible .vocal-engword').val().replace(/[^a-z0-9\s]/gi, ' ').replace(/[_\s]/g, ' ').replace(/\s\s+/g, ' ').toLowerCase().trim();
        var temp = $(this).val().substring($(this).val().length-1);
        if(temp == "#"){
            if(value == root_value){
                $('.input-icon').removeClass().addClass('fa fa-check input-icon text-success');
            }else{
                $('.input-icon').removeClass().addClass('fa fa-close input-icon text-danger');
            }
        }else{
            $('.input-icon').addClass('hidden');
        }
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
        if(runtime==0){
           if($('.post-not-found').length==0){
                getData();
            }     
        }else{
            getData();
        }
        runtime ++;
    })
    $(document).on('change', '#exam-order', function() {
        var page = 1;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
        item_infor.push(post[0]['id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        item_infor.push(1);
        getExample(parseInt(page, 10), item_infor, function() {
            setContentBox(current_id);
        });
    })
    $(document).on('click', '.current_item', function() {
        if ($('#vocal-audio').prop('checked')) {
            $('.vocabulary-box').find('audio').each(function() {
                if (!$(this)[0].paused) {
                    $(this)[0].pause();
                    $(this)[0].currentTime = 0;
                }
            });
            if($('.vocabulary-box:visible').find('audio').attr('src')!=''){
                $('.vocabulary-box:visible').find('audio')[0].play();
            }
        }
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
        item_infor.push(post[0]['id']);
        item_infor.push($('#exam-order').val());
        item_infor.push(page);
        item_infor.push(1);
        getExample(parseInt(page, 10), item_infor, function() {
            setContentBox(current_id);
        });
    })
    $(document).on('click', '.btn-effect', function(e) {
        e.stopPropagation();
        var _this = this;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
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
    $('.btn-do-exam').on('click', function(e) {
        $.fancybox({
            'width'         : $(window).width()>1024?'70%':'100%',
            'height'        : 'auto',
            'minHeight'     : $(window).height()/2,
            'autoScale'     : true,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'type'          : 'iframe',
            'margin'        : 6,
            'fixed'         : false,
            'href'          : '/popup/p002',
            'closeBtn'      : true,
            beforeLoad      : function() {
                _popup_transfer_array['voc_array']=vocabularyArray.map(function (value,index){return {'from':value['vocabulary_nm'],'to':value['mean']};});
                _popup_transfer_array['voc'] = shuffle(_popup_transfer_array['voc_array']);
                _popup_transfer_array['mean'] = shuffle(JSON.parse(JSON.stringify(_popup_transfer_array['voc'])));
                _popup_transfer_array['parent_width'] = $(window).width();
            },
        });
    });
}

function installSlide() {
    if($("#mySlider1").length!=0){
        $("#mySlider1").AnimatedSlider({
            visibleItems: 3,
            infiniteScroll: true,
        });
        slider = $("#mySlider1").data("AnimatedSlider");
        slider.setItem($('#tab1 table tbody tr').first().attr('id') - 1);
        setContentBox($('#tab1 table tbody tr').first().attr('id'));
    }
}

function slidePositionController() {
    var coverWidth = $(".slider-wrap").width() / 2;
    $(".choose_slider_items .current_item").css("left", coverWidth - 150);
    $(".choose_slider_items .previous_item").css("left", coverWidth - 320);
    $(".choose_slider_items .next_item").css("left", coverWidth + 20);
}

function nextVocabulary() {
    var currentItemId = setNextItem();
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
    $('.vocal-engword-input:visible').val('').focus();
}

function previousVocabulary() {
    var currentItemId = setPreviousItem();
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
    $('.vocal-engword-input:visible').val('').focus();
}

function selectVocabulary(selectTrTag) {
    currentItemId = selectItem(selectTrTag,selectedTab);
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
    $('.vocal-engword-input:visible').val('').focus();
}

function switchTabVocabulary(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if($(selectedTab+' .activeItem').length==0){
        selectVocabulary($(selectedTab + " table tbody tr").first());
    }else{
        selectVocabulary($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberVocabulary(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = vocabularyArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(1);
    voc_infor.push(2);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['id']);
    rememberItem(currentItem, "Đã quên", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextVocabulary();
        }
    })
}

function forgetVocabulary(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = vocabularyArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['id']);
    voc_infor.push(2);
    forgetItem(currentItem, "Đã thuộc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextVocabulary();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/vocabulary/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    vocabularyArray = res.voca_array;
                    installSlide();
                    slidePositionController();
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
                    $('.relationship').filter(function() { 
                        return  $(this).find('a').length==0; 
                    }).remove();
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
    var data = $(change_item).val()==''?'-1':$(change_item).val()==''?'-1':$(change_item).val();
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
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (word_id) + ']').removeClass('hidden');
    if($('.vocabulary-box[target-id=' + (word_id) + ']').hasClass('post-not-found')){
        $('.example-content').addClass('hidden');
        $('.hint-text').addClass('hidden');
    }else{
        $('.example-content').removeClass('hidden');
        $('.hint-text').removeClass('hidden');
    }
    $('.example-item:not(.hidden)').addClass('hidden');
    $('.example-item[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (word_id) + ']').removeClass('hidden');
    if($('#mySlider1 li').length==1){
        $('.choose_slider').height('235');
    }
    if(typeof vocabularyArray!='undefined'){
        post = vocabularyArray.filter(function(val){
            return val['row_id']==Number(word_id);
        });
    }
    $('.vocabulary-box:visible input:text').filter(function() { return this.value == ""; }).addClass('hidden');
    $('.vocabulary-box:visible input:text').filter(function() { return this.value != ""; }).removeClass('hidden');
    $('.title-bar input:checkbox').filter(function() { 
        return  $('.vocabulary-box:visible .hidden.'+$(this).attr('id')).length!=0; 
    }).parent().addClass('hidden');
    $('.title-bar input:checkbox').filter(function() { 
        return  $('.vocabulary-box:visible .hidden.'+$(this).attr('id')).length==0; 
    }).parent().removeClass('hidden');
    if($('.vocabulary-box:visible .vocal-audio').attr('src')==''){
        $('.hint').text('Không có âm thanh cho từ vựng này');
    }else{
        $('.hint').text('Bạn có thể click vào hình ảnh để nghe đọc lại từ vựng');
    }
}

function getRowId(id){
    for (var i = 0; i < vocabularyArray.length; i++) {
        if(vocabularyArray[i]['id'] == id){
            return vocabularyArray[i]['row_id'];
        }
    }
}

function getQuestion() {
    var input = {
        "localization":{
        },
        "options":{
            "associationMode":"manyToMany", // oneToOne,manyToMany
            "lineStyle":"square-ends",
            // "buttonErase":"Erase Links",
        },
            "Lists":[
                {
                    "name":"Columns in files",
                    "list" : [
                        "firstName",
                        "lastName",
                        "phone",
                        "email",
                        "role",
                        "Birthday",
                        "Adress",
                        "Sales",
                        "City"
                    ]
                },
                {
                    "name":"Available Fields",
                    "list" : [
                        "Company",
                        "jobTitle",
                        "adress",   
                        "adress",
                        "adress",                               
                        "first_name",
                        "last_name",
                        "email_adress",
                        "Phone number"
                    ],
                    "mandatories" :[
                        "last_name",
                        "email_adress"
                    ]
                }
                ],

            "existingLinks" : [{"from":"lastName","to":"last_name"},{"from":"firstName","to":"first_name"},{"from":"role","to":"jobTitle"}]
    };
    
    fieldLinks=$("#bonds").fieldsLinker("init",input);
}

function checkAnswer() {
    $('.answer-box').removeClass('wrong-answer');
    $('.answer-box').removeClass('right-answer');
    $('.answer-box').each(function(i) {
        check = -1;
        if ($(this).find('input:checked').length != 0) {
            $(this).find('input').each(function(j) {
                var temp = $(this).is(':checked') ? 1 : 0;
                if (AnswerArray[(i * 4) + j]['verify'] != temp) {
                    check = 1;
                }
            })
            if (check == -1) {
                check = 0;
            }
        }
        if (check == 1) {
            $(this).addClass('wrong-answer');
            $(this).find('.result-icon').removeClass().addClass('result-icon fa fa-close');
            $(this).find('.result-icon').css('top', ($(this).height() / 2) - 25);
        } else if (check == 0) {
            $(this).addClass('right-answer');
            $(this).find('.result-icon').removeClass().addClass('result-icon fa fa-check');
            $(this).find('.result-icon').css('top', ($(this).height() / 2) - 25);
        }
    })
}