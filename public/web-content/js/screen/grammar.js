var slider;
$(function(){
	try{
		initGrammar();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initGrammar(){
	initListener();
}

function initListener(){
	$(document).on("click","button",function(){
		if($(this).attr("id")=='btn_next'){
			nextGrammar();
		}
		if($(this).attr("id")=='btn_prev'){
			previousGrammar();
		}
		if($(this).attr("type-btn")=='btn-remember'){
			rememberGrammar($(this));
		}
		if($(this).attr("type-btn")=='btn-forget'){
			forgetGrammar($(this));
		}
	});

	$(document ).on("click",".focusable table tbody tr",function(){
		selectGrammar($(this));
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
                previousGrammar();
                break;
            case 39 :
                nextGrammar();
                break;
            default:
                break;
        }
    })
}


function nextGrammar(){
	var currentItemId=setNextItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function previousGrammar(){
	var currentItemId=setPreviousItem();
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function selectGrammar(selectTrTag){
	currentItemId = selectItem(selectTrTag);
	slider.setItem(currentItemId - 1);
	slidePositionController();
}

function switchTabVocabulary(current_li_tag){
	selectedTab = current_li_tag.find("a").attr("href");
	selectGrammar($(selectedTab+" table tbody tr" ).first());
}

function getGrammarData(){
	var data = getDataCommon(1,"Grammar/getData");
}

function rememberGrammar(remember_btn){
	currentItem = remember_btn.parents("tr");
	selectGrammar(rememberItem(currentItem,"Đã quên"));
}

function forgetGrammar(forget_btn){
	currentItem = forget_btn.parents("tr");
	selectGrammar(forgetItem(currentItem,"Đã thuộc"));
}