var slider,rating;
$(function(){
	try{
		initSocial();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initSocial(){
	var comment_content=$('.new-comment').html();
	initListener();
	rating=$('input[name="rating"]').ratemate();
	for (var i = 0; i < 6; i++) {
		$('#chemgio').find('.commentList:first').append(comment_content);
	}
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextSocial();
		}
		if($(this).attr("id")=='btn_prev'){
			previousSocial();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberSocial($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetSocial($(this));
		}
	});
	$(document ).on("change","#rating-value",function(){
		if($(this).val()!="0"){
			$(this).parent().prev("button").find("span").text(" Bạn đánh giá "+$(this).val()+" sao");
			$(this).parent().prev("button").addClass("btn-success"); 
		}else{
			$(this).parent().prev("button").find("span").text(" Đánh giá bài viết !");
		}
		
	});
	$(document ).on("click",".focusable table tbody tr",function(){
		selectSocial($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabSocial($(this));
	});

	$(document ).on("click",".social-tab li",function(){
		switchTabMain($(this));
	});

	$(window).resize(function(){
		slidePositionController();
	});

	$(document).on('keydown',function(e){
        switch(e.which){
            case 37 :
                previousSocial();
                break;
            case 39 :
                nextSocial();
                break;
            default:
                break;
        }
    })
}

function nextSocial(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousSocial(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectSocial(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabSocial(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectSocial($(selectedTab+" table tbody tr" ).first());
}

function getSocialData(){
	var data = getDataCommon(1,"Social/getData");
}

function rememberSocial(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectSocial(rememberItem(currentItem,"Đã quên"));
}

function forgetSocial(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectSocial(forgetItem(currentItem,"Đã thuộc"));
}

function switchTabMain(current_li_tag){
	selectedPracticeTab = current_li_tag.find("a").attr("href");
	if(selectedPracticeTab=="#example"){
		$(".list-panel").show();
	}else{
		$(".list-panel").hide();
	}
}