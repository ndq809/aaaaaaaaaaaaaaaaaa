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
	if($('#show_login').val()==1){
		$('.btn-popup[popup-id=popup-box0]').trigger('click');
	}
}

function initListener(){
	$(window).resize(function(){
		meniItemController();
	});

	$(document).on("click",".option-body",function(){
		window.location.href=$(this).attr("option-link");
	})

	$(document).on("click",".right-header",function(){
		meniItemController();
	})
}

function meniItemController(){
	item_size=$(".option-header:first").width()/10;
	$(".option-item").css("font-size",item_size);
}