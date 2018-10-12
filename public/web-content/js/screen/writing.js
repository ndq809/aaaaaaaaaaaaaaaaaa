var player;
var WritingArray;
var AnswerArray;
$(function(){
	try{
		initWriting();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initWriting(){
	initListener();
	// installplayer();
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
            nextWriting();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousWriting();
        }
        if ($(this).hasClass('btn-check-answer')) {
            checkAnswer();
        }
        if ($(this).hasClass('btn-refresh')) {
            getQuestion();
        }
        if ($(this).hasClass('btn-remember')) {
            rememberWriting($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetWriting($(this));
        }
        if ($(this).hasClass('btn-show-answer')) {
            var current_id = $('.activeItem').attr('id');
        	$('.listen-answer[target-id='+current_id+']').removeClass('hidden');
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(4, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-comment')) {
            _this= $(this);
            if($(this).parent().prev().val().trim()!=''){
                var current_id = $('.activeItem').attr('id');
                var item_infor = [];
                item_infor.push(WritingArray[current_id - 1]['row_id']);
                item_infor.push(4);
                item_infor.push(WritingArray[current_id - 1]['post_id']);
                item_infor.push($(this).parent().prev().val());
                if($(this).closest('.input-group').hasClass('comment-input')){
                    item_infor.push($(this).closest('.commentItem').attr('id'));
                }else{
                    item_infor.push('');
                }
                addComment($(this),item_infor);
            }
        }
    });
    $(document).on('click', '.btn-popup', function(e) {
        e.preventDefault();
        var popupId=$(this).attr('popup-id');
        if(popupId=='popup-box3'){
        	$('.result-text').html(checkAnswer());
        }
    })

    $(document).on('click', '.load-more', function(e) {
        e.preventDefault();
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push($(this).closest('.commentItem').attr('id'));
        item_infor.push($(this).attr('page'));
        loadMoreComment($(this),item_infor);
    })

    $(document).on("click", ".focusable table tbody tr", function() {
        selectWriting($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabWriting($(this));
    });
    $(document).on('keydown', function(e) {
        if (!(e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA')&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    previousWriting();
                    break;
                case 39:
                    e.preventDefault();    
                    nextWriting();
                    break;
                default:
                    break;
            }
        }
    })
    $(document).on('change', '#catalogue_nm', function() {
        if ($('#catalogue_nm').val() != '') updateGroup(this);
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
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(WritingArray[current_id - 1]['row_id']);
        item_infor.push(4);
        item_infor.push(WritingArray[current_id - 1]['post_id']);
        item_infor.push(page);
        getComment(item_infor, function() {
            setContentBox(current_id);
        });
    })

    $(document).on('click', '.btn-like', function(e) {
        e.stopPropagation();
        var _this = this;
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(WritingArray[current_id - 1]['row_id']);
        item_infor.push($(this).closest('li').attr('id'));
        item_infor.push(3);
        item_infor.push(3);
        if ($(_this).hasClass('liked')) {
            item_infor.push(1);
        } else {
            item_infor.push(0);
        }
        toggleEffect(item_infor, function(effected_count) {
            $(_this).toggleClass('liked bounceIn');
            if($(_this).hasClass('liked')){
                $(_this).text(' '+effected_count+' Đã Thích');
            }else{
                $(_this).text(' '+effected_count+' Thích');
            }
        });
    })
}

function nextWriting() {
    var currentItemId = setNextItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof WritingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + WritingArray[currentItemId - 1]['post_id']);
}

function previousWriting() {
    var currentItemId = setPreviousItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof WritingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + WritingArray[currentItemId - 1]['post_id']);
}

function selectWriting(selectTrTag) {
    currentItemId = selectItem(selectTrTag);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof WritingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + WritingArray[currentItemId - 1]['post_id']);
}

function switchTabWriting(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    $('.activeItem').removeClass('activeItem');
    selectWriting($(selectedTab + " table tbody tr").first());
}

function rememberWriting(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(4);
    voc_infor.push(1);
    voc_infor.push(WritingArray[current_id - 1]['row_id']);
    voc_infor.push(WritingArray[current_id - 1]['post_id']);
    rememberItem(currentItem, "Đọc lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextWriting();
        }
    })
}

function forgetWriting(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(WritingArray[current_id - 1]['row_id']);
    voc_infor.push(WritingArray[current_id - 1]['post_id']);
    voc_infor.push(1);
    forgetItem(currentItem, "Đã đọc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextWriting();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/writing/getData',
        dataType: 'json',
        loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    WritingArray = res.voca_array;
                    AnswerArray = res.answer_array;
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

function setContentBox(target_id) {
    $('.writing-box:not(.hidden)').addClass('hidden');
    $('.writing-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.listen-answer').addClass('hidden');
    $('.comment-box:not(.hidden)').addClass('hidden');
    $('.comment-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('#collapse6 .panel-body>.form-group .no-data').remove();
    $('#collapse1 .no-data').remove();
    if($('.question-box[target-id=' + (target_id) + ']').length==0){
        $('#collapse6 .panel-body>.form-group').append('<h5 class="text-center no-data">Hiện chưa có bài tập nào trong hệ thống!</h5>');
    }
    if($('.vocabulary-box[target-id=' + (target_id) + ']').length==0){
        $('#collapse1').append('<h5 class="text-center no-data">Không có từ mới nào cho bài viết này!</h5>');
    }
}

function getRowId(id){
    for (var i = 0; i < WritingArray.length; i++) {
        if(WritingArray[i]['post_id'] == id){
            return WritingArray[i]['row_id'];
        }
    }
}




