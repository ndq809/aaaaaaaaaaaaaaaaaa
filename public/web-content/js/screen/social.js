var slider, rating, SocialArray, TagMyPostArray, post,loadtime=1,data_search = [];
$(function() {
    try {
        initSocial();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initSocial() {
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
            rememberSocial($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetSocial($(this));
        }
        if ($(this).attr("id") == 'find-by-tag') {
            loadtime = 1;
            getData(1);
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
            _this = $(this);
            if ($(this).parent().prev().val().trim() != '') {
                var current_id = $('.activeItem').attr('id');
                var item_infor = [];
                item_infor.push(post[0]['row_id']);
                item_infor.push(6);
                item_infor.push(post[0]['post_id']);
                item_infor.push($(this).parent().prev().val());
                if ($(this).closest('.input-group').hasClass('comment-input')) {
                    item_infor.push($(this).closest('.commentItem').attr('id'));
                } else {
                    item_infor.push('');
                }
                if(_this.parents('.tab-pane').attr('id')=='chemgio'){
                    item_infor.push(1);//cmt div
                }else{
                    item_infor.push(2);//cmt div
                }
                addComment($(this), item_infor);
            }
        }
    });
    $(document).on('click', 'h5', function() {
        if ($(this).attr("id") == 'btn_next') {
            nextSocial();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousSocial();
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
        loadMoreComment($(this), item_infor);
    })
    $(document).on("click", ".focusable table tbody tr", function() {
        selectSocial($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabSocial($(this));
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey && $('.sweet-modal-overlay').length == 0) {
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    previousSocial();
                    break;
                case 39:
                    e.preventDefault();
                    nextSocial();
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
        item_infor.push(6);
        item_infor.push(post[0]['post_id']);
        item_infor.push(page);
        if($('.comment-tabs li.active a').attr('href')=='#chemgio'){
            item_infor.push(1);
        }else{
            item_infor.push(2);
        }
        getComment(item_infor, function(res) {
            if($('.comment-tabs li.active a').attr('href')=='#chemgio'){
                $('#chemgio .commentList:first .commentItem:visible').remove();
                $('#chemgio .commentList:first').prepend(res.view1);
                $('#chemgio .paging-list .paging-item:visible').remove();
                $('#chemgio .paging-list').prepend(res.view2);
            }else{
                $('#gopy .commentList:first .commentItem:visible').remove();
                $('#gopy .commentList:first').prepend(res.view1);
                $('#gopy .paging-list .paging-item:visible').remove();
                $('#gopy .paging-list').prepend(res.view2);
            }
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

    $(document ).on("reset",".rateit",function(){
        if($('.btn-vote').length!=0){
            vote(function(){
                // showMessage(2,function(){
                    $('.my-vote:visible').parent().prev("button").removeClass('btn-success');
                    $('.my-vote:visible').parent().prev("button").attr('disabled','disabled');
                    $('.my-vote:visible').parent().prev("button").find("span").text("Đánh giá của bạn");
                // });
            });
        }else{
            $('.my-vote:visible').parent().prev("button").removeClass('btn-success');
            $('.my-vote:visible').parent().prev("button").attr('disabled','disabled');
            $('.my-vote:visible').parent().prev("button").find("span").text("Đánh giá của bạn");
        }
    });

    $(document).on('click','.btn-vote',function(){
        vote(function(){
            // showMessage(2,function(){
                $('.my-vote:visible').parent().prev("button").removeClass('btn-success');
                $('.my-vote:visible').parent().prev("button").attr('disabled','disabled');
                $('.my-vote:visible').parent().prev("button").find("span").text("Bạn đã vote "+$('.my-vote:visible').rateit('value')+" sao");
            // });
        });
    })
}

function nextSocial() {
    var currentItemId = setNextItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function previousSocial() {
    var currentItemId = setPreviousItem();
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function selectSocial(selectTrTag) {
    currentItemId = selectItem(selectTrTag, selectedTab);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function switchTabSocial(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if ($(selectedTab + ' .activeItem').length == 0) {
        selectSocial($(selectedTab + " table tbody tr").first());
    } else {
        selectSocial($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberSocial(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = SocialArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(6);
    voc_infor.push(3);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    rememberItem(currentItem, "Đọc lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextSocial();
        }
    })
}

function forgetSocial(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = SocialArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Đã đọc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextSocial();
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
        url: '/social/getData',
        dataType: 'json',
        process:true,
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    SocialArray = res.voca_array;
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
    $('.social-box:not(.hidden)').addClass('hidden');
    $('.social-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if($('.social-box[target-id=' + (target_id) + ']').hasClass('post-not-found')||$(selectedTab+' .activeItem').hasClass('no-row')){
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
    if (typeof SocialArray != 'undefined') {
        post = SocialArray.filter(function(val) {
            return val['row_id'] == Number(target_id);
        });
    }
    if(typeof post[0]!='undefined'){
        var post_temp = SocialArray.filter(function(val) {
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
    for (var i = 0; i < SocialArray.length; i++) {
        if (SocialArray[i]['post_id'] == id) {
            return SocialArray[i]['row_id'];
        }
    }
}

function vote(callback){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    data['my_vote'] = $('.my-vote:visible').rateit('value');
    $.ajax({
        type: 'POST',
        url: '/social/vote',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('.average-rating:visible').rateit('value',res.average_rating);
                    $('.average-rating:visible').attr('data-original-title','Đánh giá chung '+Number(Number(res.average_rating).toFixed(2))+' sao');
                    callback();
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
        url: '/social/view',
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
    data['max_row'] = Math.max.apply(Math, SocialArray.map(function(o) { return o.row_id; }));
    $.ajax({
        type: 'POST',
        url: '/social/view',
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