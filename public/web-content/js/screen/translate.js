var slider;
var vocabularyArray;
$(function() {
    try {
        initTranslate();
    } catch (e) {
        console.log("some thing went wrong :" + e);
    }
})

function initTranslate() {
    initListener();
    installSlide();
    slidePositionController();
     $( "#key-word" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          type: 'POST', 
          url: "/translate/getAutocomplete",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            var temp = [];
            if(data[0]['vocabulary_nm']!=''){
                for (var i = 0; i < data.length; i++) {
                    temp.push(data[i]['vocabulary_nm']);
                }
            }
            response( temp );
          }
        });
      },
      select: function( event, ui ) {
        getData(ui.item.value);
      },
      minLength: 3,
      delay: 500,
      autoFocus: true
    });
    if($( "#key-word" ).val()!=''){
        getData($( "#key-word" ).val());
    }else{
        $( "#key-word" ).focus();
    }

}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).attr("id") == 'btn_next') {
            nextVocabulary();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousVocabulary();
        }
        if ($(this).hasClass('btn-remember')) {
            rememberVocabulary($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetVocabulary($(this));
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(1, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-contribute-exa')) {
            if ($('#eng-clause').val().trim() != '' && $('#vi-clause').val().trim() != '') {
                current_id = $('.activeItem').attr('id');
                voc_infor = [];
                voc_infor.push(vocabularyArray[current_id - 1]['row_id']);
                voc_infor.push(vocabularyArray[current_id - 1]['id']);
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
    $(document).on("focus", "#key-word", function() {
        $(this).autocomplete("search",$( this ).val());
    });

    $(document).on("click", ".btn-filter", function() {
        getData($( "#key-word" ).val());
    });
    $(document).on("click", ".focusable table tbody tr", function() {
        selectVocabulary($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabVocabulary($(this));
    });
    $(document).on("click", ".history-item", function() {
        if($(this).find('.bookmark_nm').text()!=''){
            $( "#key-word" ).val($(this).find('.bookmark_nm').text());
            getData($( "#key-word" ).val());
        }
    });
    $(window).resize(function() {
        slidePositionController();
    });
    $(document).on('keydown', function(e) {
        if (!(e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA') && $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 37:
                    previousVocabulary();
                    break;
                case 39:
                    nextVocabulary();
                    break;
                default:
                    break;
            }
        }
        // if ($(e.target).attr('id') == 'key-word'&&e.which==13&&$(e.target).val()!=''){
        //     getData($( "#key-word" ).val());
        // }
    })
    $(document).on('change', '#exam-order', function() {
        var page = 1;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(vocabularyArray[current_id - 1]['row_id']);
        item_infor.push(vocabularyArray[current_id - 1]['id']);
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
            $('.vocabulary-box:visible').find('audio')[0].play();
        }
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(vocabularyArray[current_id - 1]['row_id']);
        item_infor.push(vocabularyArray[current_id - 1]['id']);
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
        item_infor.push(vocabularyArray[current_id - 1]['row_id']);
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

function nextVocabulary() {
    var currentItemId = setNextItem();
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
}

function previousVocabulary() {
    var currentItemId = setPreviousItem();
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
}

function selectVocabulary(selectTrTag) {
    currentItemId = selectItem(selectTrTag);
    slider.setItem(currentItemId - 1);
    slidePositionController();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof vocabularyArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + vocabularyArray[currentItemId - 1]['id']);
}

function switchTabVocabulary(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    $('.activeItem').removeClass('activeItem');
    selectVocabulary($(selectedTab + " table tbody tr").first());
}

function rememberVocabulary(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(1);
    voc_infor.push(2);
    voc_infor.push(vocabularyArray[current_id - 1]['row_id']);
    voc_infor.push(vocabularyArray[current_id - 1]['id']);
    rememberItem(currentItem, "Đã quên", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextVocabulary();
        }
    })
}

function forgetVocabulary(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(vocabularyArray[current_id - 1]['row_id']);
    voc_infor.push(vocabularyArray[current_id - 1]['id']);
    voc_infor.push(2);
    forgetItem(currentItem, "Đã thuộc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextVocabulary();
        }
    })
}

function getData(value) {
    if(value=='')
        return;
    var data = [];
    data.push(value);
    $.ajax({
        type: 'POST',
        url: '/translate/getData',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('.result-box').removeClass('hidden');
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    $('.bookmark').html(res.view3);
                    vocabularyArray = res.voca_array;
                    installSlide();
                    slidePositionController();
                    $('.table-right tbody tr[id='+getRowId(res.selected_id.id)+']').trigger('click');
                    if($('.activeItem').parents('.tab-pane').attr('id')=='tab2'){
                        switchTab(2);
                    }else{
                        switchTab(1);
                    }
                    $('#target-id').attr('value','')
                    $('#key-word').blur();
                    break;
                case 207:
                    $('.result-box').addClass('hidden');
                    showMessage(16,function(){
                        $('#key-word').focus();
                    });
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
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.example-item:not(.hidden)').addClass('hidden');
    $('.example-item[target-id=' + (word_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (word_id) + ']').removeClass('hidden');
    if($('#mySlider1 li').length==1){
        $('.choose_slider').height('235');
    }
}

function getRowId(id){
    for (var i = 0; i < vocabularyArray.length; i++) {
        if(vocabularyArray[i]['id'] == id){
            return vocabularyArray[i]['row_id'];
        }
    }
}