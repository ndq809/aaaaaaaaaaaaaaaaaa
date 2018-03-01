var slider;
$(function(){
	try{
		initAdvertisement();
	}
	catch(e){
		alert("some thing went wrong :"+e);
	}
})

function initAdvertisement(){
	initListener();
}

function initListener(){
	$(window).resize(function(){
	});

	$(document).on("click",".option-body",function(){
		window.location.href=$(this).attr("option-link");
	})
}

