var slider;
$(function(){
	try{
		initRelax();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initRelax(){
	initListener();
	rating=$('input[name="rating"]').ratemate();
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextRelax();
		}
		if($(this).attr("id")=='btn_prev'){
			previousRelax();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberRelax($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetRelax($(this));
		}
	});

	$(document ).on("click",".focusable table tbody",function(){
		selectRelax($(this));
	});

	$(document ).on("change","#rating-value",function(){
		if($(this).val()!="0"){
			$(this).parent().prev("button").find("span").text(" Bạn đánh giá "+$(this).val()+" sao");
			$(this).parent().prev("button").addClass("btn-success"); 
		}else{
			$(this).parent().prev("button").find("span").text(" Đánh giá bài viết !");
		}
		
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabRelax($(this));
	});

	$(document ).on("click",".Relax-tab li",function(){
		switchTabPractice($(this));
	});

	$(window).resize(function(){
		slidePositionController();
	});
}



function nextRelax(){
	var currentItemId=setNextItem("");
	image_link=$(".activeItem tr td:nth-child(1)").find("img").attr("src");
	$(".main-content").first().find("img").attr("src",image_link);
	
}

function previousRelax(){
	var currentItemId=setPreviousItem("");
	image_link=$(".activeItem tr td:nth-child(1)").find("a img").attr("src");
	$(".main-content").first().find("img").attr("src",image_link);
}

function selectRelax(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	image_link=$(".activeItem tr td:nth-child(1)").find("a img").attr("src");
	$(".main-content").first().find("img").attr("src",image_link);
}

function switchTabRelax(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	if(selectedTab =="#tab1"){
		selectRelax($(selectedTab+" table tbody" ).first());
	}else{
		selectRelax($(selectedTab+" table tbody tr" ).first());
	}
	
}

function getRelaxData(){
	var data = getDataCommon(1,"Relax/getData");
}

function rememberRelax(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectRelax(rememberItem(currentItem,"Đã quên"));
}

function forgetRelax(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectRelax(forgetItem(currentItem,"Đã thuộc"));
}

function switchTabPractice(current_li_tag){
	selectedPracticeTab = current_li_tag.find("a").attr("href");
	if(selectedPracticeTab=="#example"){
		$(".commentbox,.control-btn").show();
		$(".rate-bar").show();
		$(".router-btn").show();
	}else{
		$(".commentbox,.control-btn").hide();
		$(".rate-bar").hide();
		$(".router-btn").hide();
	}
}