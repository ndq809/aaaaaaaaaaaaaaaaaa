var player;
var ReadingArray;
var AnswerArray;
var runtime = 0;
$(function(){
	try{
		initReading();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initReading(){
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
       
        if ($(this).hasClass('btn-check-answer')) {
            checkAnswer();
        }
        if ($(this).hasClass('btn-refresh')) {
            getQuestion();
        }
        if ($(this).hasClass('btn-reload')) {
            getData();
        }
        if ($(this).hasClass('btn-remember')) {
            rememberReading($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetReading($(this));
        }
        if ($(this).hasClass('btn-show-answer')) {
            var current_id = $('.activeItem').attr('id');
        	$('.listen-answer[target-id='+current_id+']').removeClass('hidden');
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(5, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-comment')) {
            _this= $(this);
            if($(this).parent().prev().val().trim()!=''){
                var current_id = $('.activeItem').attr('id');
                var item_infor = [];
                item_infor.push(post[0]['row_id']);
                item_infor.push(5);
                item_infor.push(post[0]['post_id']);
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

    $(document).on('click', 'h5', function() {
         if ($(this).attr("id") == 'btn_next') {
            nextReading();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousReading();
        }
    })

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
        selectReading($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabReading($(this));
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    previousReading();
                    break;
                case 39:
                    e.preventDefault();    
                    nextReading();
                    break;
                default:
                    break;
            }
        }
    },33))
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
        if(runtime==0){
           if($('.post-not-found').length==0){
                getData();
            }     
        }else{
            getData();
        }
        runtime ++;
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
        item_infor.push(5);
        item_infor.push(post[0]['post_id']);
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
        item_infor.push(post[0]['row_id']);
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
                $(_this).html('<span class="like_count">'+effected_count+'</span> Đã thích');
            }else{
                $(_this).html('<span class="like_count">'+effected_count+'</span> Thích');
            }
        });
    })
}

function nextReading() {
    var currentItemId = setNextItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ReadingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ReadingArray[currentItemId - 1]['post_id']);
}

function previousReading() {
    var currentItemId = setPreviousItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ReadingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ReadingArray[currentItemId - 1]['post_id']);
}

function selectReading(selectTrTag) {
    currentItemId = selectItem(selectTrTag,selectedTab);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ReadingArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ReadingArray[currentItemId - 1]['post_id']);
}

function switchTabReading(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if($(selectedTab+' .activeItem').length==0){
        selectReading($(selectedTab + " table tbody tr").first());
    }else{
        selectReading($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberReading(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = ReadingArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(5);
    voc_infor.push(3);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    rememberItem(currentItem, "Đọc lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextReading();
        }
    })
}

function forgetReading(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = ReadingArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Đã đọc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextReading();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/reading/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    ReadingArray = res.voca_array;
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
            showMessage(4);
        }
    });
}

function updateGroup(change_item, sub_item_text) {
    var data = $(change_item).val()==''?'-1':$(change_item).val();
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
    $('.reading-box:not(.hidden)').addClass('hidden');
    $('.reading-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if($('.reading-box[target-id=' + (target_id) + ']').hasClass('post-not-found')||$(selectedTab+' .activeItem').hasClass('no-row')){
        $('.example-content').addClass('hidden');
    }else{
        $('.example-content').removeClass('hidden');
    }
    $('.question-list .question-box:not(.hidden)').addClass('hidden');
    $('.question-list .question-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.listen-answer').addClass('hidden');
    $('#check-listen-data').val('');
    $('.comment-box:not(.hidden)').addClass('hidden');
    $('.comment-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('#collapse6 .panel-body>.form-group .no-data').remove();
    if($('.question-box[target-id=' + (target_id) + ']').length==0){
        $('#collapse6 .panel-body>.form-group').append('<h5 class="text-center no-data">Hiện chưa có bài tập nào trong hệ thống!</h5>');
    }
    $('#collapse1 .no-data').remove();
    if($('.vocabulary-box[target-id=' + (target_id) + ']').length==0){
        $('#collapse1').append('<span class="text-center no-data block margin-bottom">Không có từ mới nào cho bài viết này!</span>');
    }
    if(typeof ReadingArray!='undefined'){
        post = ReadingArray.filter(function(val){
            return val['row_id']==Number(target_id);
        });
    }
}

function getRowId(id){
    for (var i = 0; i < ReadingArray.length; i++) {
        if(ReadingArray[i]['post_id'] == id){
            return ReadingArray[i]['row_id'];
        }
    }
}

function getQuestion() {
    var current_id = $('.activeItem').attr('id');
    var item_infor = [];
    item_infor.push(post[0]['post_id']);
    item_infor.push(current_id);
    $.ajax({
        type: 'POST',
        url: '/common/getQuestion',
        dataType: 'json',
        loading:true,
        container:'#collapse6 .panel-body>.form-group',
        data: $.extend({}, item_infor), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                if(res.data[0]['question_id']!=''){
                    var temp = 0;
                    $('#collapse6 .panel-body>.form-group .no-data').remove();
                    $('#collapse6 .panel-body>.form-group .question-box[target-id='+current_id+']').remove();
                    $('#collapse6 .panel-body>.form-group').append(res.view1);
                    for (var i = 0; i < AnswerArray.length; i++) {
                        if(AnswerArray[i]['row_id'] == res.data[0]['row_id']){
                            temp = i;
                            break;
                        }
                    }
                    AnswerArray.splice(temp,res.data.length);
                    $.merge(AnswerArray,res.data);
                }else{
                    $('#collapse6 .panel-body>.form-group .no-data').remove();
                    $('#collapse6 .panel-body>.form-group').append('<h5 class="text-center no-data">Hiện chưa có bài tập nào trong hệ thống!</h5>');
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
    $('.question-list .answer-box').removeClass('wrong-answer');
    $('.question-list .answer-box').removeClass('right-answer');
    $('.question-list .answer-box').each(function(i){
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
            $(this).find('.result-icon').css('top',($(this).height()/2)-25);
        }else if(check == 0){
            $(this).addClass('right-answer');
            $(this).find('.result-icon').removeClass().addClass('result-icon fa fa-check');
            $(this).find('.result-icon').css('top',($(this).height()/2)-25);
        }
    })
}

function insertArrayAt(array, index, arrayToInsert) {
    Array.prototype.splice.apply(array, [index, 0].concat(arrayToInsert));
    return array;
}



