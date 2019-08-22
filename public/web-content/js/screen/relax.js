var slider, rating, RelaxArray, TagMyPostArray, post,loadtime=1,loadtime1=1,loadtime2=1,data_search = [],player;
$(function() {
    try {
        initRelax();
    } catch (e) {
        alert("some thing went wrong :" + e);
    }
})

function initRelax() {
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
    $(".input-image-custom").fileinput({
        browseIcon : "<i class=\"glyphicon glyphicon-picture\"></i> ",
        browseLabel : "Duyệt ảnh",
        allowedFileTypes:['image'],
        showFileFooterCaption:false,
        previewClass: 'no-footer-caption',
        defaultPreviewContent: "<img src='/web-content/images/background/tuchoitruycap.jpg' class='kv-preview-data file-preview-image'>",
        overwriteInitial: true,
        showRemove: true,
        showUpload: false,
        removeLabel: 'Xóa',
    });
    if($('.post-not-found').length==0){
        getData(1);
    }
    $('#post_div').trigger('change');
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        if ($(this).hasClass('btn-load-more')) {
            getData(2);
        }
        if ($(this).hasClass('btn-reload')) {
            getData(1);
        }
        if ($(this).hasClass('btn-remember')) {
            rememberRelax($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetRelax($(this));
        }
        if ($(this).attr("id") == 'btn-clear') {
            clearData();
        }
        if ($(this).attr("id") == 'find-by-tag') {
            loadtime = 1;
            loadtime1 = 1;
            loadtime2 = 1;
            getData(1);
        }

        if ($(this).attr("id") == 'btn-share') {
            showMessage(1,function(){
                save();
           });
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
                item_infor.push(7);
                item_infor.push(post[0]['post_id']);
                item_infor.push($(this).parent().prev().val());
                if ($(this).closest('.input-group').hasClass('comment-input')) {
                    item_infor.push($(this).closest('.commentItem').attr('id'));
                } else {
                    item_infor.push('');
                }
                item_infor.push(1);//cmt div
                addComment($(this), item_infor);
            }
        }
    });

    $(document).on('click', '.my-post-link', function(e) {
        _this = $(this);
        if($('.relax-tab li.active a').attr('href')=='#tab-custom1'){
            location.href='/relax?v='+_this.attr('post_id');
        }else{
            showEditPost(_this);
        }
    })

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            var data={};
            data['post_id'] = $('#new-post-id').val();
            deletePost(data,function(){
                showMessage(2,function(){
                    $('a[post_id='+data['post_id']+']').closest('tr').remove();
                    $('#btn-clear').trigger('click');
                    getData(1);
                });
            });
       });
    })

    $(document).on('click', 'h5', function() {
        if ($(this).attr("id") == 'btn_next') {
            nextRelax();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousRelax();
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
    $(document).on("click", ".focusable table tbody", function() {
        selectRelax($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabRelax($(this));
    });

    $(document).on('click', '.relax-tab li a', function(e) {
        if($(this).attr('href')=='#tab-custom1'){
            setTimeout(function(){
                $('.example-content').show();
            },200)
        }else{
            $('.example-content').hide();
        }
    })

    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey && $('.sweet-modal-overlay').length == 0) {
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    previousRelax();
                    break;
                case 39:
                    e.preventDefault();
                    nextRelax();
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
        item_infor.push(7);
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

    $(document).on('change','#post_div',function(){
        $('.post_tag_new .selectize-dropdown-content>div[type='+$(this).val()+']').removeClass('hidden');
        $('.post_tag_new .selectize-dropdown-content>div:not([type='+$(this).val()+'])').addClass('hidden');
        $('.change-box[type='+$(this).val()+']').removeClass('hidden');
        $('.change-box[type='+$(this).val()+']').find('input').attr('id','post_media').addClass('submit-item');
        $('.change-box:not([type='+$(this).val()+'])').addClass('hidden ');
        $('.change-box:not([type='+$(this).val()+'])').find('input').removeAttr('id').removeClass('submit-item');
    })

    $(window).resize(function(){
        setTimeout(function(){
            var temp = $('.fb-video:visible').find('iframe');
            if(typeof temp !='undefined' && temp.height()> temp.width()){
                temp.css('min-width','0px');
                temp1 =$('.mejs__mediaelement').height() / temp.parent().height() ; 
                temp.parents('.fb-video').css('width',temp.parents('.fb-video').width()*temp1);
                temp.parents('.fb-video').css('height',temp.parents('.fb-video').height()*temp1);
            }
        },200)
    })

    $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e)
    {
         setTimeout(function(){
            var temp = $('.fb-video:visible').find('iframe');
            if(typeof temp !='undefined' && temp.height()> temp.width()){
                temp.css('min-width','0px');
                temp1 =$('.mejs__mediaelement').height() / temp.parent().height() ; 
                temp.parents('.fb-video').css('width',temp.parents('.fb-video').width()*temp1);
                temp.parents('.fb-video').css('height',temp.parents('.fb-video').height()*temp1);
            }
        },200)
    });

}

function nextRelax() {
    var currentItemId = setNextItem('tbody');
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function previousRelax() {
    var currentItemId = setPreviousItem('tbody');
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function selectRelax(selectTrTag) {
    currentItemId = selectItem(selectTrTag, selectedTab);
    if($('.activeItem').length==1){
        selectedTab = '#'+ $('.activeItem').parents('.tab-pane').attr('id');
    }
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if (typeof post[0] != 'undefined') history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
}

function switchTabRelax(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if ($(selectedTab + ' .activeItem').length == 0) {
        selectRelax($(selectedTab + " table tbody").first());
    } else {
        selectRelax($(selectedTab + " table tbody.activeItem"));
    }
}

function rememberRelax(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(6);
    voc_infor.push(3);
    voc_infor.push(post[0]['row_id']);
    voc_infor.push(post[0]['post_id']);
    rememberItem(currentItem, "Đọc lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextRelax();
        }
    })
}

function forgetRelax(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    voc_infor = [];
    voc_infor.push(post[0]['row_id']);
    voc_infor.push(post[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Đã đọc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextRelax();
        }
    })
}

function getData(mode) {
    var data = {};
    var temp = $('#post_tag').val();
    data['post_id'] = $('#target-id').val();
    data['load_time'] = loadtime;
    data['load_time1'] = loadtime1;
    data['load_time2'] = loadtime2;
    if(mode == 1){
        data['post_type'] = 0;
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
        switch(selectedTab){
            case '#tab1' :
                data['post_type'] = 4;
                data['load_time'] = loadtime+1;
                break;
            case '#tab2' :
                data['post_type'] = 5;
                data['load_time1'] = loadtime1+1;
                break;
            case '#tab3' :
                data['post_type'] = 6;
                data['load_time2'] = loadtime2+1;
                break;
        }
        data['post_tag'] = data_search;
    }
    $.ajax({
        type: 'POST',
        url: '/relax/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: data, //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#tab-custom1').html(res.view2);
                    // $('#tab-custom2').html(res.view3);
                    $('.example-content').html(res.view4);
                    RelaxArray = res.voca_array;
                    AnswerArray = res.answer_array;
                    TagMyPostArray = res.mytag_array;
                    if ($('#target-id').attr('value') != '') {
                        $('.table-right tbody[id=' + getRowId($('#target-id').attr('value')) + ']').trigger('click');
                    } else {
                        if(typeof location.href.split('?v=')[1] != 'undefined' && getRowId(location.href.split('?v=')[1])!=''){
                            $('.table-right tbody[id=' + getRowId(location.href.split('?v=')[1]) + ']').trigger('click');
                        }else{
                            if($('.table-right tbody:not(.no-row)').length!=0){
                            $('.table-right tbody:not(.no-row)').first().trigger('click');
                            }else{
                                $('.table-right tbody').first().trigger('click');
                            }
                        }
                    }
                    switch($('.activeItem').parents('.tab-pane').attr('id')){
                        case 'tab1' :
                             switchTab(1);
                             break;
                        case 'tab2' :
                            switchTab(2)
                             break;
                        case 'tab3' :
                            switchTab(3);
                             break;
                    }
                    // if ($('.activeItem').parents('.tab-pane').attr('id') == 'tab2') {
                    //     switchTab(2);
                    // } else {
                    //     switchTab(1);
                    // }
                    $('#target-id').attr('value', '');
                    if(mode==2){
                        switch(selectedTab){
                            case '#tab1' :
                                loadtime ++;
                                break;
                            case '#tab2' :
                                loadtime1 ++;
                                break;
                            case '#tab3' :
                                loadtime2 ++;
                                break;
                        }
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

function setContentBox(target_id) {
    $('.relax-box:not(.hidden)').addClass('hidden');
    $('.relax-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if($('.relax-box[target-id=' + (target_id) + ']').hasClass('post-not-found')||$(selectedTab+' .activeItem').hasClass('no-row')){
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
    if (typeof RelaxArray != 'undefined') {
        post = RelaxArray.filter(function(val) {
            return val['row_id'] == Number(target_id);
        });
    }
    if(typeof post[0]!='undefined'){
        var post_temp = RelaxArray.filter(function(val) {
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
    $('.main-content:visible #video-player').remove();
    if(typeof player !='undefined'){
        player.pause();
        player.remove();
        $('.mejs__container').remove();
        $('.mejs__offscreen').remove();
    }
    if(selectedTab=='#tab2'){
        $('.main-content:visible').append('<video id="video-player" width="640" height="360" style="max-width:100%;" preload="none"><source src="'+$('.video-source .video-item[source-id='+post[0]['row_id']+']').text()+'" type= "'+post[0]['post_media_div']+'"></video>');
        $('#video-player').mediaelementplayer({
            success: function(mediaElement, domObject) {
                player = mediaElement;
                mediaElement.removeEventListener('loadedmetadata');
                mediaElement.addEventListener('loadedmetadata', function(e) {
                    var temp = $(mediaElement).find('iframe');
                    if(typeof temp !='undefined' && temp.parent().height()> temp.parent().width()){
                        temp.css('min-width','0px');
                        temp1 =$('.mejs__mediaelement').height() / temp.parent().height() ; 
                        temp.parents('.fb-video').css('width',temp.parents('.fb-video').width()*temp1);
                        temp.parents('.fb-video').css('height',temp.parents('.fb-video').height()*temp1);
                    }
                }, false);
            },
        });
        player.load();
    }
}

function getRowId(id) {
    for (var i = 0; i < RelaxArray.length; i++) {
        if (RelaxArray[i]['post_id'] == id) {
            return RelaxArray[i]['row_id'];
        }
    }
    return '';
}

function vote(callback){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    data['my_vote'] = $('.my-vote:visible').rateit('value');
    $.ajax({
        type: 'POST',
        url: '/relax/vote',
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
        url: '/relax/view',
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
    data['max_row'] = Math.max.apply(Math, RelaxArray.map(function(o) { return o.row_id; }));
    $.ajax({
        type: 'POST',
        url: '/relax/view',
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

function save(){
    var data = getInputData('#tab-custom2');
    // console.log(data);
    // $.each(data,function(key,value){
    //     if(!$.isArray(value) && value.trim()=='' && key!='new-post-id'){
    //         if($('#'+key).attr('type') != 'file'){
    //             $('#'+key).addClass('input-error');
    //             $('#'+key).attr('data-toggle','tooltip');
    //             $('#'+key).attr('data-placement','bottom');
    //             $('#'+key).attr('data-original-title','Mục này không được trống');
    //         }else{
    //             $('#'+key).closest('.input-group').find('.file-caption').addClass('input-error');
    //             $('#'+key).closest('.input-group').find('.file-caption').attr('data-toggle','tooltip');
    //             $('#'+key).closest('.input-group').find('.file-caption').attr('data-placement','bottom');
    //             $('#'+key).closest('.input-group').find('.file-caption').attr('data-original-title','Mục này không được trống');
    //         }
            
    //     }
    // })
    // if($('.input-error').length!=0){
    //     $('[data-toggle="tooltip"]').tooltip();
    //     return;
    // }
    if(data['post_tag_edit'].length==0){
        data['post_tag_edit'] = null;
    }
    var data_addnew=new FormData($("#upload_form")[0]);
    data_addnew.append('header_data',JSON.stringify(data));
    $.ajax({
        type: 'POST',
        url: '/relax/save',
        dataType: 'json',
        loading:true,
        processData: false,
        contentType : false,
        data: data_addnew,
        success: function(res) {
            switch (res.status) {
                case 200:
                    clearFailedValidate();
                    showMessage(2,function(){
                        getData(1);
                        if(data['new-post-id']==''){
                            $('.your-post table tbody').append('<tr> <td> <a href="/relax?v='+res.post_info['post_id']+'">'
                        +'<i class="glyphicon glyphicon-hand-right"> </i> '+res.post_info['post_title']+'</a> </td> '
                        +'<td width="100px" class="text-center tag-style"> <span>'+res.post_info['catalogue_div']+'</span> </td> </tr>');
                        }
                    });
                    break;
                case 201:
                    clearFailedValidate();
                    if(res.error.title!=undefined){
                        $('#post_title').addClass('input-error');
                        $('#post_title').attr('data-toggle','tooltip');
                        $('#post_title').attr('data-placement','top');
                        $('#post_title').attr('data-original-title','Mục này không được trống');
                    }
                    if(res.error.post_media!=undefined){
                         if(data['post_div']!=4){
                            $('#post_media').addClass('input-error');
                            $('#post_media').attr('data-toggle','tooltip');
                            $('#post_media').attr('data-placement','top');
                            $('#post_media').attr('data-original-title','Mục này không được trống');
                        }else{
                            $('#post_media').closest('.input-group').find('.file-caption').addClass('input-error');
                            $('#post_media').closest('.input-group').find('.file-caption').attr('data-toggle','tooltip');
                            $('#post_media').closest('.input-group').find('.file-caption').attr('data-placement','top');
                            $('#post_media').closest('.input-group').find('.file-caption').attr('data-original-title','Mục này không được trống');
                        }
                    }
                    if(res.error.content!=undefined){
                        $('.cke_inner').addClass('input-error');
                        $('#cke_1_bottom').addClass('input-error');
                        $('.cke_inner').attr('data-toggle','tooltip');
                        $('.cke_inner').attr('data-placement','top');
                        $('.cke_inner').attr('data-original-title','Mục này không được trống');
                    }
                    $('[data-toggle="tooltip"]').tooltip();
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
    var item = question.attr('post_id');
    var temp = [];
    var post_temp = RelaxArray.filter(function(val){
        return val['post_id']==item && val['post_div']==1;
    });
    var postTagArray = TagMyPostArray.filter(function(val){
        return val['row_id']==post_temp[0]['row_id'];
    });
    var thisposttag=[];
    for (var i = 0; i < postTagArray.length; i++) {
        thisposttag.push(postTagArray[i]['tag_id']);
    }
    for (var i = 0; i < postTagArray.length; i++) {
        $.each($('#post_tag_edit').selectize()[0].selectize.options,(function(key,val){
            if(key.indexOf(postTagArray[i]['tag_nm'])!=-1){
                val['value'] =postTagArray[i]['tag_id'];
                $('#post_tag_edit').selectize()[0].selectize.options[postTagArray[i]['tag_id']]= $(this)[0];
                temp.push(key);
            } 
        }))
    }
    $('#new-post-id').val(post_temp[0]['post_id']);
    $('#post_div').val(post_temp[0]['post_type']).trigger('change');
    if(post_temp[0]['post_type']==4){
        $("#post_media:visible").fileinput('refresh',{
            showCaption: true,
            showPreview: true,
            showRemove: true,
            showUpload: false,
            showCancel: false,
            showBrowse : false,
            showUploadedThumbs: false,
            initialCaption : post_temp[0]['post_media_nm'],
            initialPreview: [
                "<img src='"+post_temp[0]['post_media']+"' class='kv-preview-data file-preview-image'>"
            ],
        }).trigger('previewloaded');
    }else{
        $('#post_media:visible').val(post_temp[0]['post_media']);
    }
    $('#post_tag_edit').selectize()[0].selectize.refreshItems();
    for (var i = 0; i < temp.length; i++) {
        delete $('#post_tag_edit').selectize()[0].selectize.options[temp[i]];
    }
    $('#post_tag_edit').selectize()[0].selectize.setValue(thisposttag);
    $('#post_title').val(post_temp[0]['post_title']);
    CKEDITOR.instances['post_content'].setData(post_temp[0]['post_content']);
    $('#btn-share').text('Chỉnh Sửa');
    $('#btn-delete').removeClass('hidden');
}

function clearData(){
    $('#new-post-id').val('');
    $('#post_tag_edit').selectize()[0].selectize.refreshItems();
    $('#post_tag_edit').selectize()[0].selectize.setValue('');
    $('#post_title').val('');
    if($('#post_div').val()==4){
        $("#post_media:visible").fileinput('clear');
    }else{
        $("#post_media:visible").val('');
    }
    CKEDITOR.instances['post_content'].setData('');
    $('#btn-share').text('Đăng Bài');
    $('#btn-delete').addClass('hidden');
}