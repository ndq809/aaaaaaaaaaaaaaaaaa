var player;
var ListeningArray;
var runtime = 0;

$(function(){
	try{
		initListening();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initListening(){
	initListener();
	// installplayer();
	if($( window ).width()>680)
		playerPositionController(210);
	else{
		playerPositionController(150);
	}
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
            rememberListening($(this));
        }
        if ($(this).hasClass('btn-forget')) {
            forgetListening($(this));
        }
        if ($(this).hasClass('btn-add-lesson')) {
            $('.btn-add-lesson').prop('disabled','disabled');
            addLesson(3, $('#catalogue_nm').val(), $('#group_nm').val());
        }
        if ($(this).hasClass('btn-reload')) {
            getData();
        }
        if ($(this).hasClass('btn-comment')) {
            _this= $(this);
            if($(this).parent().prev().val().trim()!=''){
                var current_id = $('.activeItem').attr('id');
                var item_infor = [];
                item_infor.push(post[0]['row_id']);
                item_infor.push(3);
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
            nextListening();
        }
        if ($(this).attr("id") == 'btn_prev') {
            previousListening();
        }
    })

    $(document).on('click', '.btn-check-answer', function(e) {
        e.preventDefault();
        checkAnswer();
    })

    $(document).on('click', '.load-more', function(e) {
        e.preventDefault();
        var current_id = $('.activeItem').attr('id');
        var item_infor = [];
        item_infor.push($(this).closest('.commentItem').attr('id'));
        item_infor.push($(this).attr('page'));
        loadMoreComment($(this),item_infor);
    })

	$(window).resize(function(){
		if($( window ).width()>680)
			playerPositionController(210);
		else{
			playerPositionController(150);
		}
	});
    $(document).on("click", ".focusable table tbody tr", function() {
        selectListening($(this));
    });
    $(document).on("click", ".right-tab ul li", function() {
        switchTabListening($(this));
    });
    $(document).on('keydown', throttle(function(e) {
        if (e.ctrlKey&& $('.sweet-modal-overlay').length==0) {
            switch (e.which) {
                case 37:
                    e.preventDefault();
                    previousListening();
                    break;
                case 39:
                    e.preventDefault();    
                    nextListening();
                    break;
                case 49:
                    e.preventDefault();
                    var current_per = parseFloat($("#jquery_jplayer_2").jPlayer()[0].childNodes[1].currentTime)
                    $("#jquery_jplayer_2").jPlayer( "play", current_per-5);
                    break;
                case 50:
                    e.preventDefault();
                    var current_per = parseFloat($("#jquery_jplayer_2").jPlayer()[0].childNodes[1].currentTime)
                    $("#jquery_jplayer_2").jPlayer( "play", current_per+5);
                    break;
                case 32:
                    e.preventDefault();
                    if($("#jquery_jplayer_2").jPlayer()[0].childNodes[1].paused){
                        $("#jquery_jplayer_2").jPlayer( "play");
                    }else{
                        $("#jquery_jplayer_2").jPlayer( "pause");
                    }
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
        item_infor.push(3);
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

function installplayer(){
	var playlist =[];
	for (var i = 0; i < ListeningArray.length; i++) {
		playlist.push({title:ListeningArray[i]['del_flg']==0?ListeningArray[i]['post_media_nm']:'Bài nghe đã bị xóa!',mp3:ListeningArray[i]['del_flg']==0?ListeningArray[i]['post_media']:'/web-content/audio/guitar.mp3'});
	}
	player = new jPlayerPlaylist(
		{
			jPlayer : "#jquery_jplayer_2",
			cssSelectorAncestor : "#jp_container_2"
		},
		playlist
		, {
			swfPath : "js",
			supplied : "oga, mp3",
			wmode : "window",
			useStateClassSkin : true,
			autoBlur : false,
			smoothPlayBar : true,
			keyEnabled : true
	});
	$('.jp-playlist').hide();
}

function playerPositionController(item_size){
	var coverWidth=$("#jp_container_2").parent().width();
	$("#jp_container_2").css("margin-left",(coverWidth/2)-item_size);
}

function nextListening() {
    var currentItemId = setNextItem();
    player.select(currentItemId - 1);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ListeningArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ListeningArray[currentItemId - 1]['post_id']);
}

function previousListening() {
    var currentItemId = setPreviousItem();
    player.select(currentItemId - 1);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ListeningArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ListeningArray[currentItemId - 1]['post_id']);
}

function selectListening(selectTrTag) {
    currentItemId = selectItem(selectTrTag,selectedTab);
    player.select(currentItemId - 1);
    setContentBox(currentItemId);
    $('.current_item').trigger('click');
    if(typeof ListeningArray[currentItemId - 1] != 'undefined')
    history.pushState({}, null, window.location.href.split('?')[0] + '?v=' + ListeningArray[currentItemId - 1]['post_id']);
}

function switchTabListening(current_li_tag) {
    selectedTab = current_li_tag.find("a").attr("href");
    if($(selectedTab+' .activeItem').length==0){
        selectListening($(selectedTab + " table tbody tr").first());
    }else{
        selectListening($(selectedTab + " table tbody tr.activeItem"));
    }
}

function rememberListening(remember_btn) {
    currentItem = remember_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = ListeningArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(3);
    voc_infor.push(3);
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    rememberItem(currentItem, "Nghe lại", voc_infor, function() {
        if (remember_btn.parents("tr").hasClass('activeItem')) {
            nextListening();
        }
    })
}

function forgetListening(forget_btn) {
    currentItem = forget_btn.parents("tr");
    current_id = currentItem.attr('id');
    temp = ListeningArray.filter(function(val){
        return val['row_id']==Number(current_id);
    });
    voc_infor = [];
    voc_infor.push(temp[0]['row_id']);
    voc_infor.push(temp[0]['post_id']);
    voc_infor.push(3);
    forgetItem(currentItem, "Đã nghe", voc_infor, function() {
        if (forget_btn.parents("tr").hasClass('activeItem')) {
            nextListening();
        }
    })
}

function getData() {
    var data = [];
    data.push($('#catalogue_nm').val());
    data.push($('#group_nm').val());
    $.ajax({
        type: 'POST',
        url: '/listening/getData',
        dataType: 'json',
        process:true,
        // loading:true,
        data: $.extend({}, data), //convert to object
        success: function(res) {
            switch (res.status) {
                case 200:
                    $('#result1').html(res.view1);
                    $('#result2').html(res.view2);
                    ListeningArray = res.voca_array;
                    installplayer();
                    if($( window ).width()>680)
						playerPositionController(210);
					else{
						playerPositionController(150);
					}
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
    $('.vocabulary-box:not(.hidden)').addClass('hidden');
    $('.vocabulary-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if($('.listen-answer[target-id=' + (target_id) + ']').hasClass('post-not-found')||$(selectedTab+' .activeItem').hasClass('no-row')){
        $('.example-content').addClass('hidden');
        $('.listen-check-box').addClass('hidden');
        $('#result2 .jp-audio').addClass('hidden');
    }else{
        $('.example-content').removeClass('hidden');
        $('.listen-check-box').removeClass('hidden');
        $('#result2 .jp-audio').removeClass('hidden');
    }
    $('.example-item:not(.hidden)').addClass('hidden');
    $('.example-item[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.paging-item:not(.hidden)').addClass('hidden');
    $('.paging-item[target-id=' + (target_id) + ']').removeClass('hidden');
    $('.listen-answer').addClass('hidden');
    $('#check-listen-data').val('');
    $('.comment-box:not(.hidden)').addClass('hidden');
    $('.comment-box[target-id=' + (target_id) + ']').removeClass('hidden');
    if(typeof ListeningArray!='undefined'){
        post = ListeningArray.filter(function(val){
            return val['row_id']==Number(target_id);
        });
    }
}

function getRowId(id){
    for (var i = 0; i < ListeningArray.length; i++) {
        if(ListeningArray[i]['post_id'] == id){
            return ListeningArray[i]['row_id'];
        }
    }
}

function checkAnswer(){
	var current_id = $('.activeItem').attr('id');
	var similarity_percent = similarity($('.listen-answer[target-id='+current_id+']').text().trim(),$('#check-listen-data').val().trim()).toFixed(0);
	var text = '';
	switch(true){
		case parseInt(similarity_percent)<10 :
			text = '<span>Bạn chỉ mới nghe được <span class ="listen_result" >'+similarity_percent+'%</span></br>Kết quả còn quá thấp hãy nghe lại thật kỹ!</span>';
			break;
		case parseInt(similarity_percent)<30 :
			text = '<span>Bạn chỉ đạt được <span class ="listen_result" >'+similarity_percent+'%</span> của bài nghe</br>Hãy cố gắng chinh phục nó!</span>';
			break;
		case parseInt(similarity_percent)<60 :
			text = '<span>Kết quả nghe của bạn chỉ đạt <span class ="listen_result" >'+similarity_percent+'%</span></br>Vẫn còn 1 chặng đường dài để hoàn thành!</span>';
			break;
		case parseInt(similarity_percent)<80 :
			text = '<span>Bạn đã nghe được <span class ="listen_result" >'+similarity_percent+'%</span></br>Chỉ cần cố gắng 1 chút nữa bạn sẽ vượt qua!</span>';
			break;
		case parseInt(similarity_percent)<99 :
			text = '<span>Bạn đã vượt qua bài nghe ở mức <span class ="listen_result" >'+similarity_percent+'%</span></br>Nhưng thành công thực sự chỉ khi bạn đạt số điểm tuyệt đối!</span>';
			break;
		case parseInt(similarity_percent)==100 :
			text = '<span>Kết quả nghe tuyệt đối <span class ="listen_result" >'+similarity_percent+'%</span></br>Bạn thật tuyệt vời!</span>';
			break;
	}
    if($('#do-mission').val()==1){
        if(parseInt(similarity_percent)>=80){
            $('.activeItem i').removeClass().addClass('fa fa-check-circle test-done');
            if(ListeningArray.length == $('.test-done').length){
                completeMission(function(res){
                    var param = {};
                    param['value'] = [res.data.exp,res.data.ctp];
                    showMessage(30,function(){
                        if(res.rank['account_div']!=res.rank['account_prev_div']){
                            var param1 = {};
                            param1['value'] = [res.rank['account_prev_div_nm'],res.rank['account_div_nm']];
                            showMessage(39,function(){
                                location.reload();
                            },function(){},param1);
                        }else{
                            location.reload();
                        }
                    },function(){
                    },param);
                })
            }else{
                var param = {};
                param['buttons'] = [
                    {
                        label: 'Ải tiếp theo ➡',
                        classes: 'btn btn-sm btn-success float-right',
                        action: function(){
                            nextListening();
                        }
                    },
                    {
                        label: 'Xem đáp án',
                        classes: 'btn btn-sm btn-default float-left',
                        action: function(){
                            var current_id = $(selectedTab +' .activeItem').attr('id');
                            $('.listen-answer[target-id='+current_id+']').removeClass('hidden');
                        },
                    }
                ];
                showMessage(28,function(){},function(){},param);
            }
        }else{
            var param = {};
            param['value'] = [text];
            param['label'] = ['Tiếp tục nghe'];
            showMessage(37,function(){},function(){},param);
        }
    }else{
        var param = {};
        param['value'] = [text];
        param['buttons'] = [
            {
                label: 'Tiếp tục nghe',
                classes: 'btn btn-sm btn-success float-right',
            },
            {
                label: 'Xem đáp án',
                classes: 'btn btn-sm btn-default float-left',
                action: function(){
                    var current_id = $(selectedTab +' .activeItem').attr('id');
                    $('.listen-answer[target-id='+current_id+']').removeClass('hidden');
                },
            }
        ];
        showMessage(37,function(){},function(){},param);
    }
}

function similarity(s1, s2) {
  var longer = s1;
  var shorter = s2;
  if (s1.length < s2.length) {
    longer = s2;
    shorter = s1;
  }
  var longerLength = longer.length;
  if (longerLength == 0) {
    return 1.0;
  }
  return (longerLength - editDistance(longer, shorter)) / parseFloat(longerLength)*100;
}

function editDistance(s1, s2) {
  s1 = s1.toLowerCase();
  s2 = s2.toLowerCase();

  var costs = new Array();
  for (var i = 0; i <= s1.length; i++) {
    var lastValue = i;
    for (var j = 0; j <= s2.length; j++) {
      if (i == 0)
        costs[j] = j;
      else {
        if (j > 0) {
          var newValue = costs[j - 1];
          if (s1.charAt(i - 1) != s2.charAt(j - 1))
            newValue = Math.min(Math.min(newValue, lastValue),
              costs[j]) + 1;
          costs[j - 1] = lastValue;
          lastValue = newValue;
        }
      }
    }
    if (i > 0)
      costs[s2.length] = lastValue;
  }
  return costs[s2.length];
}