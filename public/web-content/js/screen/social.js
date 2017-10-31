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
	initListener();
	rating=$('input[name="rating"]').ratemate();
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
}