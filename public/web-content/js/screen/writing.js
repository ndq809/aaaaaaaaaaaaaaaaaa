var player;
var WritingArray=[];
var AnswerArray=[];
var SuggestArrayFull=[];
var SuggestArraySpecial=[];
var TagPostArray=[];
var TagMyPostArray=[];
var editor;
var _vocabularyArray = [];
var post=[];
var change_time = 0;
var runtime = 0;

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
    getGrammarSuggest(function(){
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
    });

    editor = CKEDITOR.instances['post_content'];
    editor.on('key', function(e) {
        if(e.data.keyCode == 32&&$('#is_suggest').is(':checked')){
            var text_all = this.document.getBody().getText().trim();
            showSuggest(text_all);
        }

        if((e.data.keyCode == 8||e.data.keyCode == 46)&&$('#is_suggest').is(':checked')){
            var text_all = this.document.getBody().getText();
            var is_blank_text = text_all[text_all.length-1].trim();
            if(is_blank_text==''){
                showSuggest(text_all);
            }
        }

        //sử dụng index of + length
    }); 

    $(".btn-add-vocabulary").fancybox({
        'width'         : '100%',
        'height'        : '100%',
        'autoScale'     : true,
        'transitionIn'  : 'none',
        'transitionOut' : 'none',
        'type'          : 'iframe',
        'margin'        : 6,
        'fixed'         : false,
        beforeLoad      : function() {
            _popup_transfer_array['voc_array']=getVocabularyList(); 
            _popup_transfer_array['row_id']=$('.activeItem:visible').attr('id'); 
          },
    });
}

function initListener() {
    $(document).on("click", "button", function(e) {
        e.stopPropagation();
        
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(4, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-reload')) {
            if(change_time==0){
                getData();
            }else{
                getDataCustom();
            }
        }
        if ($(this).hasClass('btn-comment')) {
            _this= $(this);
            if($(this).parent().prev().val().trim()!=''){
                var current_id = $(selectedTab+' .activeItem').attr('id');
                var item_infor = [];
                item_infor.push(post[0]['row_id']);
                item_infor.push(4);
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
            nextWriting();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousWriting();
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
        var current_id = $(selectedTab+' .activeItem').attr('id');
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
        if($(this).find('a').attr('href')=='#tab1'){
            switchTabCustom(1);
        }else{
            switchTabCustom(2);
        }
    });

    // $(document).on("click", ".writing-tab li", function() {
    //     switchTabWriting($(this));
    // });
    
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 38:
                    e.preventDefault();
                    previousWriting();
                    break;
                case 40:
                    e.preventDefault();    
                    nextWriting();
                    break;
                default:
                    break;
            }
        }
    },33))
    $(document).on('change', '#catalogue_nm', function() {
        if ($('#catalogue_nm').val() != '') updateGroup(this);
    })

    $(document).on('change', '#is_suggest', function() {
        $('.suggest-box').toggleClass('hidden');
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
                if(change_time==0){
                    getData();
                }else{
                    getDataCustom();
                }
            }     
        }else{
            if(change_time==0){
                getData();
            }else{
                getDataCustom();
            }
        }
        runtime ++;
        
    })
    $(document).on('click', '.pager li a', function(e) {
        e.stopPropagation();
        var page = $(this).attr('page');
        var current_id = $(selectedTab+' .activeItem').attr('id');
        var item_infor = [];
        item_infor.push(post[0]['row_id']);
        item_infor.push(4);
        item_infor.push(post[0]['post_id']);
        item_infor.push(page);
        getComment(item_infor, function() {
            setContentBox(current_id);
        });
    })

    $(document).on('click', '.btn-like', function(e) {
        e.stopPropagation();
        var _this = this;
        var current_id = $(selectedTab+' .activeItem').attr('id');
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

    $(document).on('click', '.writing-tab li a', function(e) {
        if($(this).attr('href')=='#tab-custom1'){
            $('.example-content').show();
            switchTab(1);
            switchTabWriting($('a[href='+selectedTab+']').parent());
        }else{
            $('.example-content').hide();
            switchTab(2);
            switchTabWriting($('a[href='+selectedTab+']').parent());
        }
    })

    $(document).on('click','#btn-save',function(){
        showMessage(1,function(){
            save(1);
       });
    })

    $(document).on('click','#btn-save-new',function(){
        showMessage(1,function(){
            save(0);
       });
    })

    $(document).on('click','#btn-delete',function(){
        showMessage(3,function(){
            var data={};
            data['post_id'] = post[0]['post_id'];
            deletePost(data,function(){
                showMessage(2,function(){
                    var temp = $(selectedTab+' .activeItem');
                    nextWriting();
                    temp.remove();
                });
            });
       });
    })

    $(document).on('click','#btn-share',function(){
        showMessage(1,function(){
            share();
       });
    })

    $(document).on('click','#btn-clear',function(){
        clearData();
    })
}

function nextWriting() {
    var currentItemId = setNextItem();
    if(selectedTab == '#tab1'){
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }else{
        showEditPost($(selectedTab+' .activeItem'));
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }
}

function previousWriting() {
    var currentItemId = setPreviousItem();
    if(selectedTab == '#tab1'){
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }else{
        showEditPost($(selectedTab+' .activeItem'));
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }
}

function selectWriting(selectTrTag) {
    currentItemId = selectItem(selectTrTag,selectedTab);
    if(selectedTab == '#tab1'){
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }else{
        showEditPost(selectTrTag);
        setContentBox(currentItemId);
        $('.current_item').trigger('click');
    }
}

function switchTabWriting(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if($('.activeItem').length==0 && selectedTab =='#tab1'){
        selectWriting($(selectedTab + " table tbody tr").first());
    }else{
        if($(selectedTab + " table tbody tr.activeItem").length!=0){
            selectWriting($(selectedTab + " table tbody tr.activeItem"));
        }else{
            selectWriting($(selectedTab + " table tbody tr").first());
        }
    }
    if(selectedTab =='#tab2'){
        $('#catalogue_nm')[0].selectize.disable();
        $('#group_nm')[0].selectize.disable();
    }else{
        $('#catalogue_nm')[0].selectize.enable();
        $('#group_nm')[0].selectize.enable();
    }
}

function rememberWriting(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = WritingArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(4);
    voc_infor.push(3);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    rememberItem(currentItem, "Đọc lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextWriting();
        }
    })
}

function forgetWriting(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = WritingArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Đã đọc", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextWriting();
        }
    })
}

function getData() {
    change_time ++;
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/writing/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#tab1').html(res.view1);
                    $('#tab2').html(res.view2);
                    $('#tab-custom1').html(res.view3);
                    $('#tab-custom2').html(res.view4);
                    $('.example-content').html(res.view5);
                    WritingArray = res.writing_array;
                    _vocabularyArray = res.voc_array;
                    AnswerArray = res.answer_array;
                    TagMyPostArray = res.mytag_array;
                    editor = CKEDITOR.replace('post_content',{language:"vi"});
                    $('#post_tag').html('');
                    for (var i = 0; i < TagPostArray.length; i++) {
                        $('#post_tag').append('<option value="'+TagPostArray[i]['tag_id']+'">'+TagPostArray[i]['tag_nm']+'</option>');
                    }
                    $("select.tag-selectize").each(function() {
                        var select = $(this).selectize({
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
                    });
                    if($('.table-right tbody tr[id='+getRowId($('#target-id').attr('value'))+']').parents('.tab-pane').attr('id')=='tab2'){
                        switchTabCustom(2);
                        switchTab(2);
                    }else{
                        switchTabCustom(1);
                        switchTab(1);
                    }
                    if($('#target-id').attr('value')!='' && $('.table-right tbody tr[id='+getRowId($('#target-id').attr('value'))+']').length!=0){
                        $('.table-right tbody tr[id='+getRowId($('#target-id').attr('value'))+']').trigger('click');
                    }else{
                        $('#tab1 .table-right tbody tr:first').trigger('click');
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
            editor.on('key', function(e) {
                if(e.data.keyCode == 32&&$('#is_suggest').is(':checked')){
                    var text_all = this.document.getBody().getText().trim();
                    showSuggest(text_all);
                }

                if((e.data.keyCode == 8||e.data.keyCode == 46)&&$('#is_suggest').is(':checked')){
                    var text_all = this.document.getBody().getText();
                    var is_blank_text = text_all[text_all.length-1].trim();
                    if(is_blank_text==''){
                        showSuggest(text_all);
                    }
                }

                //sử dụng index of + length
            });

            $('a.btn-disabled').click(function(e){
                e.stopPropagation();
            });
            
            $(".btn-add-vocabulary").fancybox({
                'width'         : '100%',
                'height'        : '100%',
                'autoScale'     : true,
                'transitionIn'  : 'none',
                'transitionOut' : 'none',
                'type'          : 'iframe',
                'margin'        : 6,
                'fixed'         : false,
                beforeLoad      : function() {
                    _popup_transfer_array['voc_array']=getVocabularyList(); 
                    _popup_transfer_array['row_id']=$('.activeItem:visible').attr('id'); 
                  },
            });
        },
        // Ajax error
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function getDataCustom() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/writing/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#tab1').html(res.view1);
                    $('#tab-custom1').html(res.view3);
                    $('.example-content').html(res.view5);
                    WritingArray = res.writing_array;
                    _vocabularyArray = res.voc_array;
                    AnswerArray = res.answer_array;
                    TagMyPostArray = res.mytag_array;
                    $('#tab1 .table-right tbody tr:first').trigger('click');
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
    target_id = Number(target_id);
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
        $('#collapse6 .panel-body>.form-group').append('<span class="text-center no-data">Hiện chưa có bài tập nào trong hệ thống!</span>');
    }
    if($('.vocabulary-box[target-id=' + (target_id) + ']').length==0){
        $('#collapse1').append('<span class="text-center no-data block margin-bottom">Không có từ mới nào cho bài viết này!</span>');
    }
    reIndex($('.table-input'));
    post = WritingArray.filter(function(val){
        return val['row_id']==Number(target_id);
    });
    if(typeof post[0] != 'undefined'){
        history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + post[0]['post_id']);
        if(post[0]['my_post']==1){
            if(post[0]['shared']==1){
                $('#btn-share').remove();
            }else{
                if($('#btn-share').length==0){
                    $('#btn-save').after('<button class="btn btn-sm btn-success" id="btn-share">Chia Sẻ</button>');
                }
            }
        }
    }
}

function getRowId(id){
    for (var i = 0; i < WritingArray.length; i++) {
        if(WritingArray[i]['post_id'] == id){
            return WritingArray[i]['row_id'];
        }
    }
}

function getGrammarSuggest(callback){
     $.ajax({
        type: 'POST',
        url: '/common/getGrammarSuggest',
        dataType: 'json',
        // loading:true,
        success: function(res) {
            switch (res.status) {
                case 200:
                    SuggestArrayFull = res.data[0].filter(function(val){
                        return val['tag_nm'].indexOf('_')==-1;
                    });
                    SuggestArraySpecial = res.data[0].filter(function(val){
                        return val['tag_nm'].indexOf('_')!=-1;
                    });
                    TagPostArray = res.data[1];
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
            callback();
        },
        // Ajax error
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status);
        }
    });
}

function showSuggest(text_all){
    var postion;
    var tag_nm;
    var text;
    var check = 0;
    var rootpostion = 0;
    $('.suggest-grammar').html('');
    for (var i = 0; i < SuggestArrayFull.length; i++) {
        tag_nm = SuggestArrayFull[i]['tag_nm'];
        if(tag_nm.indexOf(' ')==-1){
            text = text_all.split(' ')[text_all.split(' ').length-1].trim();
            rootpostion = 0;
        }else{
            text = text_all.trim();
            rootpostion = text.lastIndexOf(tag_nm);
        }
        text_length = text.length;
        postion = text.lastIndexOf(tag_nm);
        if(postion!=-1 && text_length==(tag_nm.length+postion) && postion == rootpostion){
            $('.suggest-grammar').append('<li><a target="_blank" href="/grammar?v='+SuggestArrayFull[i]['post_id']+'">'+SuggestArrayFull[i]['post_title']+'</a></li>');
            check = 1;
        }
    }
    if(check == 0){
        for (var i = 0; i < SuggestArraySpecial.length; i++) {
            tag_nm = SuggestArraySpecial[i]['tag_nm'].replace('_', '');
            if(tag_nm.indexOf(' ')==-1){
                text = text_all.split(' ')[text_all.split(' ').length-1].trim();
            }else{
                text = text_all.trim();
            }
            text_length = text.length;
            postion = text.lastIndexOf(tag_nm);
            if(postion!=-1 && text_length==(tag_nm.length+postion)){
                $('.suggest-grammar').append('<li><a target="_blank" href="/grammar?v='+SuggestArraySpecial[i]['post_id']+'">'+SuggestArraySpecial[i]['post_title']+'</a></li>');
            }
        }
    }
}

function switchTabCustom(tab_number){
    $('.writing-tab ul li').removeClass('active');
    $('.writing-tab ul li a').attr('aria-expanded',false);
    $('.writing-tab .tab-content .tab-pane').removeClass('active in');
    $('.writing-tab ul li:nth-child('+tab_number+')').addClass('active');
    $('.writing-tab ul li:nth-child('+tab_number+') a').attr('aria-expanded',true);
    $('.writing-tab .tab-content #tab-custom'+tab_number).addClass('active in');
    if(tab_number==1){
        $('.example-content').show();
    }else{
        $('.example-content').hide();
    }
}

function showEditPost(tr_tag){
    var item = Number(tr_tag.attr('id'));
    var temp = [];
    var post_temp = WritingArray.filter(function(val){
        return val['row_id']==item;
    });
    if(post_temp[0]==undefined){
        return;
    }
    var postTagArray = TagMyPostArray.filter(function(val){
        return val['row_id']==item;
    });
    var thisposttag=[];
    for (var i = 0; i < postTagArray.length; i++) {
        thisposttag.push(postTagArray[i]['tag_id']);
    }
    for (var i = 0; i < postTagArray.length; i++) {
        $.each($('#post_tag').selectize()[0].selectize.options,(function(key,val){
            if(key.indexOf(postTagArray[i]['tag_nm'])!=-1){
                val['value'] =postTagArray[i]['tag_id'];
                $('#post_tag').selectize()[0].selectize.options[postTagArray[i]['tag_id']]= $(this)[0];
                temp.push(key);
            } 
        }))
    }
    $('#post_tag').selectize()[0].selectize.refreshItems();
    for (var i = 0; i < temp.length; i++) {
        delete $('#post_tag').selectize()[0].selectize.options[temp[i]];
    }
    $('#post_tag').selectize()[0].selectize.setValue(thisposttag);
    $('#post_title').val(post_temp[0]['post_title']);
    editor.setData(post_temp[0]['post_content']);
}

function getVocabularyList(){
    var data =[];
    $('.table-input tbody tr:visible').each(function(){
        data.push({'row_id':$('.activeItem:visible').attr('id'),'id':$(this).find('td[refer_id=id]').text()});
    })
    if(data.length==0){
        return {};
    }
    return $.extend({}, data);
}
function save(mode){
    var data = getInputData('#tab-custom2');
    if(data['post_title'].trim()==''){
        $('#post_title').addClass('input-error');
        $('#post_title').attr('data-toggle','tooltip');
        $('#post_title').attr('data-placement','top');
        $('#post_title').attr('data-original-title','Tiêu đề không được rỗng');
        $('[data-toggle="tooltip"]').tooltip();
        return;
    }
    if(mode == 1){
        var current_id = $(selectedTab+' .activeItem').attr('id');
        data['row_id'] = post[0]['row_id'];
        data['post_id'] = post[0]['post_id'];
    }else{
        data['row_id'] = '';
        data['post_id'] = '';
    }
    if(data['post_tag'].length==0){
        data['post_tag'] = null;
    }
    data['voc_array'] = getVocabularyList();
    $.ajax({
        type: 'POST',
        url: '/writing/save',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    clearFailedValidate();
                    var temp = WritingArray.filter(function(val){
                        return val['row_id']!=res.row_id;
                    });
                    temp.push(res.writing_array[0]);
                    WritingArray = temp;

                    temp = _vocabularyArray.filter(function(val){
                        return val['row_id']!=res.row_id;
                    });
                    _vocabularyArray = $.merge(res.voc_array, temp);
                    $('.table-input tbody tr[target-id = '+res.row_id+']').remove();
                    $('.table-input tbody').append(res.view);

                    temp = TagMyPostArray.filter(function(val){
                        return val['row_id']!=res.row_id;
                    });
                    TagMyPostArray = $.merge(res.mytag_array, temp);
                    if($(selectedTab+ ' .table-right tbody tr[id='+res.row_id+']').length==0){
                        $(selectedTab+ ' .table-right tbody').append('<tr id="'+res.row_id+'"></tr>');
                        $(selectedTab+ ' .table-right tbody tr').last().append('<td> <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span>'+res.writing_array[0]['post_title']+'</span> </a> </td>');
                        $('.old-content').removeClass('old-content').addClass('vocabulary-box');
                        $('.new-content').remove();
                    }else{
                        $(selectedTab+ ' .table-right tbody tr[id='+res.row_id+'] span').text(res.writing_array[0]['post_title']);
                    }
                    $(selectedTab+ ' .table-right tbody tr[id='+res.row_id+']').trigger('click');
                    showMessage(2);
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

function share(){
    var data ={};
    data['post_id'] = post[0]['post_id'];
    $.ajax({
        type: 'POST',
        url: '/writing/share',
        dataType: 'json',
        // loading:true,
        data: data,
        success: function(res) {
            switch (res.status) {
                case 200:
                    showMessage(2,function(){
                        var temp = $(selectedTab+' .activeItem');
                        // nextWriting();
                        temp.find('td:nth-child(2)').append('<a>[ Đã chia sẻ ]</a>');
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

function clearData(){
    $('#post_tag').selectize()[0].selectize.refreshItems();
    $('#post_tag').selectize()[0].selectize.setValue('');
    $('#post_title').val('');
    editor.setData('');
    $('#voc-content tr:visible').addClass('hidden');
}


