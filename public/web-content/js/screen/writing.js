var slider;
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
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextWriting();
		}
		if($(this).attr("id")=='btn_prev'){
			previousWriting();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberWriting($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetWriting($(this));
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectWriting($(this));
	});

	$(document ).on("click",".right-tab ul li",function(){
		switchTabWriting($(this));
	});

	$(document ).on("click",".writing-tab li",function(){
		switchTabPractice($(this));
	});

	$(window).resize(function(){
		slidePositionController();
	});

	$(document).on('keydown',function(e){
        switch(e.which){
            case 37 :
                previousWriting();
                break;
            case 39 :
                nextWriting();
                break;
            default:
                break;
        }
    })
}



function nextWriting(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousWriting(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectWriting(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabWriting(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectWriting($(selectedTab+" table tbody tr" ).first());
}

function getWritingData(){
	var data = getDataCommon(1,"Writing/getData");
}

function rememberWriting(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectWriting(rememberItem(currentItem,"Đã quên"));
}

function forgetWriting(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectWriting(forgetItem(currentItem,"Đã thuộc"));
}

function switchTabPractice(current_li_tag){
	selectedPracticeTab = current_li_tag.find("a").attr("href");
	if(selectedPracticeTab=="#example"){
		$(".commentbox,.control-btn").show();
		$(".list-panel").show();
		$(".add-panel").hide();
	}else{
		$(".commentbox,.control-btn").hide();
		$(".list-panel").hide();
		$(".add-panel").show();
	}
}