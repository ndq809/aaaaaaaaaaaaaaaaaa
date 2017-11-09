var player;
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
	installplayer();
	if($( window ).width()>680)
		playerPositionController(210);
	else{
		playerPositionController(150);
	}
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextListening();
		}
		if($(this).attr("id")=='btn_prev'){
			previousListening();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberListening($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetListening($(this));
		}
	});

	$(document).on('click', '.btn-popup', function(e) {
        e.preventDefault();
        var popupId=$(this).attr('popup-id');
        if(popupId=='popup-box3'){
        	$('.listen_result').text('100%')
        }
    })

	$(document ).on("click",".focusable table tbody tr",function(){
		selectListening($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabListening($(this));
	});
	$(window).resize(function(){
		if($( window ).width()>680)
			playerPositionController(210);
		else{
			playerPositionController(150);
		}
	});
	$(document).on('click','#check-listen-btn',function(e){
        e.preventDefault();
        $('#popup-box3 .listen_result').text("100%");
        $('#popup-box3').modal('show')
    })
}

function installplayer(){
	player = new jPlayerPlaylist(
		{
			jPlayer : "#jquery_jplayer_2",
			cssSelectorAncestor : "#jp_container_2"
		},
		[
          {
	          title : "Em Gái Mưa",
	          mp3 : "web-content/audio/listeningAudio/Em Gái Mưa (Cover) Anh Khang Lyric Loi bai hat _ cogmVVx0q0As.mp3"
	       }
				 ], {
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

function nextListening(){
	try{
		var currentItemId=setNextItem();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
	
	playerr.setItem(currentItemId - 1);
	playerPositionController();
}

function previousListening(){
	var currentItemId=setPreviousItem();
	playerr.setItem(currentItemId - 1);
	playerPositionController();
}

function selectListening(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	playerr.setItem(currentItemId - 1);
	playerPositionController();
}

function switchTabListening(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectListening($(selectedTab+" table tbody tr" ).first());
}

function getListeningData(){
	var data = getDataCommon(1,"Listening/getData");
}

function rememberListening(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectListening(rememberItem(currentItem,"Đã quên"));
}

function forgetListening(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectListening(forgetItem(currentItem,"Đã thuộc"));
}