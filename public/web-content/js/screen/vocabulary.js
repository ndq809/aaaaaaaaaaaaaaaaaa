var slider;
$(function(){
	try{
		initVocabulary();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initVocabulary(){
	initListener();
	installSlide();
	slidePositionController();
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextVocalbulary();
		}
		if($(this).attr("id")=='btn_prev'){
			previousVocalbulary();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberVocabulary($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetVocabulary($(this));
		}
	});

	$(document ).on("change",":checkbox",function(){
		if(this.checked){
			$("."+$(this).attr("id")).show();
		}else{
			$("."+$(this).attr("id")).hide();
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectVocabulary($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabVocalbulary($(this));
	});
	$(window).resize(function(){
		slidePositionController();
	});

	$(document).on('keydown',function(e){
        switch(e.which){
            case 37 :
                previousVocalbulary();
                break;
            case 39 :
                nextVocalbulary();
                break;
            default:
                break;
        }
    })
}

function installSlide(){
	$("#mySlider1").AnimatedSlider({
		visibleItems : 3,
		infiniteScroll : true,
		willChangeCallback : function(obj, item) {
			$("#statusText").text("Will change to " + item);
		},
		changedCallback : function(obj, item) {
			$("#statusText").text("Changed to " + item);
		}
	});
	slider = $("#mySlider1").data("AnimatedSlider");
	slider.setItem(0);
}

function slidePositionController(){
	var coverWidth=$("#mySlider1").width()/2;
	$(".choose_slider_items .current_item").css("left",coverWidth-135);
	$(".choose_slider_items .previous_item").css("left",coverWidth-300);
	$(".choose_slider_items .next_item").css("left",coverWidth+15);
}

function nextVocalbulary(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousVocalbulary(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectVocabulary(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabVocalbulary(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectVocabulary($(selectedTab+" table tbody tr" ).first());
}

function getVocabularyData(){
	var data = getDataCommon(1,"vocabulary/getData");
}

function rememberVocabulary(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectVocabulary(rememberItem(currentItem,"Đã quên"));
}

function forgetVocabulary(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectVocabulary(forgetItem(currentItem,"Đã thuộc"));
}