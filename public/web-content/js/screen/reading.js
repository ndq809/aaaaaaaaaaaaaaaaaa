var slider;
$(function(){
	try{
		initReading();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initReading(){
	initListener();
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextReading();
		}
		if($(this).attr("id")=='btn_prev'){
			previousReading();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberReading($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetReading($(this));
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectReading($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabVocabulary($(this));
	});
	$(window).resize(function(){
		slidePositionController();
	});
	$(document).on('keydown',function(e){
        switch(e.which){
            case 37 :
                previousReading();
                break;
            case 39 :
                nextReading();
                break;
            default:
                break;
        }
    })
}


function nextReading(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousReading(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectReading(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabVocabulary(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectReading($(selectedTab+" table tbody tr" ).first());
}

function getReadingData(){
	var data = getDataCommon(1,"Reading/getData");
}

function rememberReading(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectReading(rememberItem(currentItem,"Đã quên"));
}

function forgetReading(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectReading(forgetItem(currentItem,"Đã thuộc"));
}