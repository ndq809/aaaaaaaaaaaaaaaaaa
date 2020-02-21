var slider, rating, DiscussArray, TagMyPostArray, post,loadtime=1,data_search = [];
$(function() {
    try {
        initDiscuss();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initDiscuss() {
    initListener();
    // if ($('.table-click tbody tr').first().hasClass('no-data')) {
    //     if($('#catalogue-tranfer').attr('value')!=''){
    //         var selectize_temp= $('#catalogue_nm')[0].selectize;
    //         selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')),true);
    //         updateGroup($('#catalogue_nm'),$('#group-transfer').attr('value'));
    //     }else{
    //         $('#catalogue_nm').trigger('change');
    //     }
    // } else {
    //     if ($('.table-click tbody tr.selected-row').length == 0) {
    //         if($('#catalogue-tranfer').attr('value')!=''){
    //             var selectize_temp= $('#catalogue_nm')[0].selectize;
    //             selectize_temp.setValue(selectize_temp.getValueByText($('#catalogue-tranfer').attr('value')),true);
    //             updateGroup($('#catalogue_nm'),$('#group-transfer').attr('value'));
    //         }else{
    //             $('.table-click tbody tr:first-child').trigger('dblclick');
    //         }
    //     } else {
    //         $('.table-click tbody tr.selected-row').trigger('dblclick');
    //     }
    // }
    $("select.tag-custom").each(function() {
        var select = $(this).selectize({
            delimiter: ',',
            persist: false,
            create: false,
            plugins: ['restore_on_backspace','remove_button'],
            
        });
    });
    if($('.post-not-found').length==0){
        getData(1);
    }
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).attr('id')=='btn-load-more') {
            getData(2);
        }
        if ($(this).hasClass('btn-reload')) {
            getData(1);
        }
        if ($(this).hasClass('btn-remember')) {
            rememberDiscuss($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetDiscuss($(this));
        }
        if ($(this).attr("id") == 'find-by-tag') {
            loadtime = 1;
            getData(1);
        }
        if ($(this).attr("id") == 'btn-clear') {
            clearData();
        }
        if ($(this).hasClass('btn-show-answer')) {
            var current_id = $('.activeItem').attr('id');
            $('.listen-answer[target-id=' + current_id + ']').removeClass('hidden');
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled', 'disabled');
            addLesson(5, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-comment')) {
            _this= $(this);
            if($(this).parent().prev().val().trim()!=''){
                var current_id = $('.activeItem').attr('id');
                var item_infor = [];
                item_infor.push(post[0]['row_id']);
                item_infor.push(8);
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

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            var data={};
            data['post_id'] = $('#new-question-id').val();
            deletePost(data,function(){
                showMessage(2,function(){
                    $('a[question_id='+data['post_id']+']').closest('tr').remove();
                    $('#btn-clear').trigger('click');
                    getData(1);
                });
            });
       });
    })

    $(document).on('click', 'h5', function() {
        if ($(this).attr("id") == 'btn_next') {
            nextDiscuss();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousDiscuss();
        }
    })

    $(document).on('click', '.btn-popup', function(e) {
        e.preventDefault();
        var popupId = $(this).attr('popup-id');
        if (popupId == 'popup-box3') {
            $('.result-text').html(checkAnswer());
        }
    })
    $(document).on('click', '.load-more', function(e) {
        e.preventDefault();
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push($(this).closest('.commentItem').attr('id'));
        item_infor.push($(this).attr('page'));
        item_infor.push(8);
        loadMoreComment($(this), item_infor);
    })
    $(document).on("click", ".focusable table tbody tr", function() {
        selectDiscuss($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabDiscuss($(this));
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey && $('.sweet-modal-overlay').length == 0) {
            switch (e.which) {
                case 38:
                    e.preventDefault();
                    previousDiscuss();
                    break;
                case 40:
                    e.preventDefault();
                    nextDiscuss();
                    break;
                default:
                    break;
            }
        }
    }, 33))
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
        if ($('.table-click tbody tr.selected-row').length != 0) {
            $('.btn-add-lesson').prop('disabled', 'disabled');
        } else {
            $('.btn-add-lesson').removeAttr('disabled');
        }
        getData(1);
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
        item_infor.push(8);
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
                $(_this).html(' <span class="like_count">'+effected_count+'</span> Đã thích');
            }else{
                $(_this).html(' <span class="like_count">'+effected_count+'</span> Thích');
            }
        });
    })

    $(document).on('click', '.btn-cmt-vote', throttle( function(e) {
        e.stopPropagation();
        my_button = $(this);
        if(my_button.hasClass('active')){
            return;
        }
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push($(this).closest('li').attr('id'));
        if (my_button.hasClass('vote-up')) {
            item_infor.push(1);
        } else {
            item_infor.push(-1);
        }
        vote_cmt(item_infor, function(data) {
            my_button.find('i').addClass(my_button.hasClass('vote-up')?'rotateInRight':'rotateInLeft');
            my_button.closest('.vote-comment').find('.rating-value:visible').text(data.rating);
            if(data.mode==0){
                my_button.find('i').removeClass(my_button.hasClass('vote-up')?'rotateInRight':'rotateInLeft');
                my_button.closest('.vote-comment').find('.btn-cmt-vote:visible').removeClass('active');
                my_button.closest('.vote-comment').find('.vote-up:visible i').removeClass('rotateInRight');
                my_button.closest('.vote-comment').find('.vote-down:visible i').removeClass('rotateInLeft');
            }else{
                my_button.closest('.vote-comment').find('.btn-cmt-vote:visible').removeClass('active');
                my_button.addClass('active');
            }
        });
    },200))

    $(document).on('click', '.tag-list', function() {
        var temp = $('#post_tag').val();
        if ($.inArray($(this).attr('value'), temp) == -1) {
            temp.push($(this).attr('value'));
        }
        $('#post_tag').selectize()[0].selectize.refreshItems();
        $('#post_tag').selectize()[0].selectize.setValue(temp);
    })

    $(document ).on("rated",".rateit",function(){
        $(this).parent().prev("button").find("span").text("Click để vote "+$(this).rateit('value')+" sao");
        $(this).parent().prev("button").addClass("btn-success"); 
        $(this).parent().prev("button").removeAttr('disabled');
    });

    $(document).on('click', '.my-post-link', function(e) {
        _this = $(this);
        if($('.discuss-tab li.active a').attr('href')=='#tab-custom1'){
            location.href='/discuss?v='+_this.attr('question_id');
        }else{
            showEditPost(_this);
        }
    })

    $(document).on('click', '.discuss-tab li a', function(e) {
        if($(this).attr('href')=='#tab-custom1'){
            setTimeout(function(){
                $('.example-content').show();
            },200)
        }else{
            $('.example-content').hide();
        }
    })

    $(document).on('click','.btn-vote-question', throttle(function(){
        my_button = $(this);
        if(my_button.hasClass('active')){
            return;
        }
        if($(this).hasClass('vote-up')){
            vote(1,function(data){
                my_button.find('i').addClass('rotateInRight');
                $('.vote .rating-value:visible').text(data.rating);
                if(data.mode==0){
                    my_button.find('i').removeClass('rotateInRight');
                    $('.btn-vote-question:visible').removeClass('active');
                    $('.vote .vote-up:visible').attr('data-original-title','Câu hỏi rõ ràng/ dễ hiểu/ thú vị/ hữu ích!');
                    $('.vote .vote-down:visible').attr('data-original-title','Câu hỏi KHÔNG rõ ràng/ dễ hiểu/ thú vị/ hữu ích!');
                    $('.vote .vote-up:visible i').removeClass('rotateInRight');
                    $('.vote .vote-down:visible i').removeClass('rotateInLeft');
                }else{
                    $('.btn-vote-question:visible').removeClass('active');
                    my_button.addClass('active');
                    my_button.attr('data-original-title','Bạn đã vote up cho bài viết này!');
                }
            });
        }else{
            vote(-1,function(data){
                my_button.find('i').addClass('rotateInLeft');
                $('.vote .rating-value:visible').text(data.rating);
                if(data.mode==0){
                    my_button.find('i').removeClass('rotateInLeft');
                    $('.btn-vote-question:visible').removeClass('active');
                    $('.vote .vote-up:visible').attr('data-original-title','Câu hỏi rõ ràng/ dễ hiểu/ thú vị/ hữu ích!');
                    $('.vote .vote-down:visible').attr('data-original-title','Câu hỏi KHÔNG rõ ràng/ dễ hiểu/ thú vị/ hữu ích!');
                    $('.vote .vote-up:visible i').removeClass('rotateInRight');
                    $('.vote .vote-down:visible i').removeClass('rotateInLeft');
                }else{
                    $('.btn-vote-question:visible').removeClass('active');
                    my_button.addClass('active');
                    my_button.attr('data-original-title','Bạn đã vote down cho bài viết này!');
                }
            });
        }
        
    },200))
}

function nextDiscuss() {
    var currentItemId = setNextItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function previousDiscuss() {
    var currentItemId = setPreviousItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function selectDiscuss(selectTrTag) {
    currentItemId = selectItem(selectTrTag, selectedTab);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function switchTabDiscuss(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if ($(selectedTab + ' .activeItem').length == 0) {
        selectDiscuss($(selectedTab + " table tbody tr").first());
    } else {
        selectDiscuss($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberDiscuss(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = DiscussArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(8);
    voc_infor.push(3);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    rememberItem(currentItem, "Bỏ theo dõi", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextDiscuss();
        }
    })
}

function forgetDiscuss(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = DiscussArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Theo dõi", voc_infor, function(id) {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextDiscuss();
        }
    })
}

function getData(mode) {
    var data = {};
    var temp = $('#post_tag').val();
    data['post_id'] = $('#target-id').val();
    data['load_time'] = loadtime;
    if(mode == 1){
        data['post_tag'] = [];
        if ($.isArray(temp)) {
            for (var i = 0; i < temp.length; i++) {
                data['post_tag'].push({
                    'tag_id': temp[i]
                });
            }
        }
        data_search = data['post_tag'];
    }else{
        data['post_tag'] = data_search;
    }
    $.ajax({
        type: 'POST',
        url: '/discuss/getData',
        dataType: 'json',
        process:true,
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#tab-custom1').html(res.view2);
                    // $('#tab-custom2').html(res.view3);
                    $('.example-content').html(res.view4);
                    DiscussArray = res.voca_array;
                    AnswerArray = res.answer_array;
                    TagMyPostArray = res.mytag_array;
                    if ($('#target-id').attr('value') != '') {
                        $('.table-right tbody tr[id=' + getRowId($('#target-id').attr('value')) + ']').trigger('click');
                    } else {
                        if($('.table-right tbody tr:not(.no-row)').length!=0){
                        $('.table-right tbody tr:not(.no-row)').first().trigger('click');
                        }else{
                            $('.table-right tbody tr').first().trigger('click');
                        }
                    }
                    if ($('.activeItem').parents('.tab-pane').attr('id') == 'tab2') {
                        switchTab(2);
                    } else {
                        switchTab(1);
                    }
                    $('#target-id').attr('value', '')
                    loadtime ++;
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

function setContentBox(target_id) {
    $('.discuss-box:not(.hidden)').addClass('hidden');
    $('.discuss-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if($('.discuss-box[target-id=' + (target_id) + ']').hasClass('post-not-found')||$(selectedTab+' .activeItem').hasClass('no-row')){
        $('.example-content').addClass('hidden');
    }else{
        $('.example-content').removeClass('hidden');
    }
    $('.question-box:not(.hidden)').addClass('hidden');
    $('.question-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.listen-answer').addClass('hidden');
    $('#check-listen-data').val('');
    $('.comment-box:not(.hidden)').addClass('hidden');
    $('.comment-box[target-id=' + (target_id) + ']').removeClass('hidden');
    $('#collapse6 .panel-body>.form-group .no-data').remove();
    if ($('.question-box[target-id=' + (target_id) + ']').length == 0) {
        $('#collapse6 .panel-body>.form-group').append('<h5 class="text-center no-data">Hiện chưa có bài tập nào trong hệ thống!</h5>');
    }
    $('#collapse1 .no-data').remove();
    if ($('.vocabulary-box[target-id=' + (target_id) + ']').length == 0) {
        $('#collapse1').append('<span class="text-center no-data block margin-bottom">Không có từ mới nào cho bài viết này!</span>');
    }
    if (typeof DiscussArray != 'undefined') {
        post = DiscussArray.filter(function(val) {
            return val['row_id'] == Number(target_id);
        });
    }
    if(typeof post[0]!='undefined'){
        var post_temp = DiscussArray.filter(function(val) {
            return val['row_id'] == post[0]['row_id'];
        });
        var postTagArray = TagMyPostArray.filter(function(val) {
            return val['row_id'] == post[0]['row_id'];
        });
        var thisposttag = [];
        for (var i = 0; i < postTagArray.length; i++) {
            thisposttag.push(postTagArray[i]['tag_id']);
        }
        $('#post_tag').selectize()[0].selectize.refreshItems();
        $('#post_tag').selectize()[0].selectize.setValue(thisposttag);
    }
    $.when($('.rateit:visible').rateit()).done(function(){
        $('.average-rating .rateit-empty').each(function(){
            $(this).parents('.average-rating').next().css('margin-left',$(this).width()+10);
        })
    });
    var text = '';
    if($('.my-vote:visible').rateit('value')!=0){
        if($('.my-vote:visible').parent().prev("button").hasClass('btn-success')){
            text ='Click để vote '+ $('.my-vote:visible').rateit('value')+' sao';
        }else{
            text ='Bạn đã vote '+ $('.my-vote:visible').rateit('value')+' sao';
        }
    }else{
        text = 'Đánh giá của bạn';
    }
    $('.my-vote:visible').parent().prev("button").find("span").text(text);
    $('[data-toggle="tooltip"]:visible').tooltip();
    if(typeof myVar != 'undefined'){
        clearTimeout(myVar);
    }
    if(typeof post[0]!='undefined'){
        timer = ($('.main-content:visible').text().trim().split(' ').length/2)*500;
        if(timer < 5000){
            timer = 5000;
        }
        myVar = setTimeout(function(){
            view();
        },timer);
    }
}

function getRowId(id) {
    for (var i = 0; i < DiscussArray.length; i++) {
        if (DiscussArray[i]['post_id'] == id) {
            return DiscussArray[i]['row_id'];
        }
    }
}

function vote(value,callback){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    data['my_vote'] = value;
    $.ajax({
        type: 'POST',
        url: '/discuss/vote',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    callback(res.data);
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

function vote_cmt(item_infor,callback){
    var data =item_infor;
    $.ajax({
        type: 'POST',
        url: '/discuss/vote-cmt',
        dataType: 'json',
        // loading:true,
        data: $.extend({}, data),
        success: function(res) {
            switch (res.status) {
                case 200:
                    callback(res.data);
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

function view(){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    $.ajax({
        type: 'POST',
        url: '/discuss/view',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('.post-view:visible').html('<i class="fa fa-leanpub"></i> '+res.post_view);
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

function loadmore(){
    var data ={};
    data['max_row'] = Math.max.apply(Math, DiscussArray.map(function(o) { return o.row_id; }));
    $.ajax({
        type: 'POST',
        url: '/discuss/view',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('.post-view:visible').html('<i class="fa fa-leanpub"></i> '+res.post_view);
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

function showEditPost(question){
    var item = question.attr('question_id');
    var temp = [];
    var post_temp = DiscussArray.filter(function(val){
        return val['post_id']==item;
    });
    var postTagArray = TagMyPostArray.filter(function(val){
        return val['row_id']==post_temp[0]['row_id'];
    });
    var thisposttag=[];
    for (var i = 0; i < postTagArray.length; i++) {
        thisposttag.push(postTagArray[i]['tag_id']);
    }
    for (var i = 0; i < postTagArray.length; i++) {
        $.each($('#new-question-tag').selectize()[0].selectize.options,(function(key,val){
            if(key.indexOf(postTagArray[i]['tag_nm'])!=-1){
                val['value'] =postTagArray[i]['tag_id'];
                $('#new-question-tag').selectize()[0].selectize.options[postTagArray[i]['tag_id']]= $(this)[0];
                temp.push(key);
            } 
        }))
    }
    $('#new-question-id').val(post_temp[0]['post_id']);
    $('#new-question-tag').selectize()[0].selectize.refreshItems();
    for (var i = 0; i < temp.length; i++) {
        delete $('#post_tag').selectize()[0].selectize.options[temp[i]];
    }
    $('#new-question-tag').selectize()[0].selectize.setValue(thisposttag);
    $('#new-question-title').val(post_temp[0]['post_title']);
    CKEDITOR.instances['new-question-content'].setData(post_temp[0]['post_content']);
    $('#btn-question').text('Chỉnh Sửa');
    $('#btn-delete').removeClass('hidden');
}

function clearData(){
    $('#new-question-id').val('');
    $('#new-question-tag').selectize()[0].selectize.refreshItems();
    $('#new-question-tag').selectize()[0].selectize.setValue('');
    $('#new-question-title').val('');
    CKEDITOR.instances['new-question-content'].setData('');
    $('#btn-question').text('Đặt Câu Hỏi');
    $('#btn-delete').addClass('hidden');
}