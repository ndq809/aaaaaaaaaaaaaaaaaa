var slider;
$(function(){
	try{
		initHomepage();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initHomepage(){
	initListener();
	meniItemController();
}

function initListener(){
	$(window).resize(function(){
		meniItemController();
	});

	$(document).on("click",".option-body",function(){
		window.location.href=$(this).attr("option-link");
	})
}

function meniItemController(){
	item_size=$(".option-header:first").width()/10;
	$(".option-item").css("font-size",item_size);
}